<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class);
    }

    public function taskCategories()
    {
        return $this->hasMany(\App\Models\TaskCategory::class);
    }

    public function taskLabels()
    {
        return $this->hasMany(\App\Models\TaskLabel::class);
    }


    public function notes()
    {
        return $this->hasMany(\App\Models\Note::class);
    }

    public function noteFolders()
    {
        return $this->hasMany(\App\Models\NoteFolder::class);
    }

    public function noteCategories()
    {
        return $this->hasMany(\App\Models\NoteCategory::class);
    }

    public function noteTags()
    {
        return $this->hasMany(\App\Models\NoteTag::class);
    }

    public function focusSessions()
    {
        return $this->hasMany(\App\Models\FocusSession::class);
    }

    public function focusSessionHistories()
    {
        return $this->hasMany(\App\Models\FocusSessionHistory::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function goalCategories()
    {
        return $this->hasMany(GoalCategory::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    public function journalCategories()
    {
        return $this->hasMany(JournalCategory::class);
    }



    public function gamification()
    {
        return $this->hasOne(UserGamification::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('unlocked_at')
            ->withTimestamps();
    }

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class, 'user_challenges')
            ->withPivot(['progress', 'is_completed', 'completed_at'])
            ->withTimestamps();
    }


    // ─── Subscription relationships ───────────────────────────────────────────

    /** All subscriptions for this user */
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    /** Current active/trial subscription (latest) */
    public function activeSubscription()
    {
        return $this->hasOne(UserSubscription::class)
            ->whereIn('status', ['active', 'trial'])
            ->latest();
    }

    // ─── Subscription helpers ─────────────────────────────────────────────────

    /** Get the current active subscription with plan eager loaded */
    public function currentSubscription(): ?UserSubscription
    {
        return $this->activeSubscription()->with('plan')->first();
    }

    /** Get the current plan (or null) */
    public function currentPlan(): ?SubscriptionPlan
    {
        return $this->currentSubscription()?->plan;
    }

    /** Is the user on a free plan? */
    public function isOnFreePlan(): bool
    {
        $plan = $this->currentPlan();
        return $plan === null || $plan->price_monthly == 0;
    }

    /** Is the user subscribed to a specific plan slug? */
    public function isSubscribedTo(string $slug): bool
    {
        return $this->currentPlan()?->slug === $slug;
    }

    /** Does the user have access to a boolean feature? */
    public function canAccess(string $feature): bool
    {
        $plan = $this->currentPlan();
        if (!$plan) return false;
        return (bool) ($plan->$feature ?? false);
    }

    /** Check numeric limit; returns true if under limit or limit is -1 (unlimited) */
    public function withinLimit(string $limitField, int $currentCount): bool
    {
        $plan = $this->currentPlan();
        if (!$plan) return false;
        $limit = $plan->$limitField ?? -1;
        return $limit === -1 || $currentCount < $limit;
    }

    /**
     * Assign the free plan on registration.
     * Called from RegisteredUserController after user creation.
     */
    public function assignFreePlan(): void
    {
        // Find the free plan (price_monthly = 0, is_active = true)
        $freePlan = SubscriptionPlan::where('price_monthly', 0)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->first();

        if (!$freePlan) return; // No free plan seeded yet — skip silently

        // Avoid duplicate subscription
        $existing = $this->subscriptions()
            ->where('subscription_plan_id', $freePlan->id)
            ->where('status', 'active')
            ->exists();

        if ($existing) return;

        UserSubscription::create([
            'user_id'              => $this->id,
            'subscription_plan_id' => $freePlan->id,
            'billing_cycle'        => 'monthly',
            'status'               => 'active',
            'amount_paid'          => 0,
            'starts_at'            => now(),
            'ends_at'              => null, // Free = never expires
        ]);
    }
    
}
