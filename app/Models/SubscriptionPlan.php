<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    protected $guarded = [];

    protected $casts = [
        'features'           => 'array',
        'price_monthly'      => 'decimal:2',
        'price_yearly'       => 'decimal:2',
        'has_analytics'      => 'boolean',
        'has_calendar'       => 'boolean',
        'has_gamification'   => 'boolean',
        'has_themes'         => 'boolean',
        'has_ai_tools'       => 'boolean',
        'has_team_workspace' => 'boolean',
        'has_priority_support' => 'boolean',
        'is_active'          => 'boolean',
        'is_featured'        => 'boolean',
    ];

    public function userSubscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    // public function activeSubscribers(): HasMany
    // {
    //     return $this->hasMany(UserSubscription::class)->where('status', 'active');
    // }

    /** Human-readable limit or "Unlimited" */
    public function limitLabel(string $field): string
    {
        $val = $this->$field ?? -1;
        return $val === -1 ? 'Unlimited' : (string) $val;
    }

    /** Monthly price formatted */
    public function formattedMonthlyPrice(): string
    {
        if ($this->price_monthly == 0) return 'Free';
        return '$' . number_format($this->price_monthly, 2) . '/mo';
    }

    /** Yearly price formatted */
    public function formattedYearlyPrice(): string
    {
        if ($this->price_yearly == 0) return 'Free';
        return '$' . number_format($this->price_yearly, 2) . '/yr';
    }

    /** Yearly savings vs monthly × 12 */
    public function yearlySavings(): float
    {
        $monthly12 = $this->price_monthly * 12;
        return max(0, $monthly12 - $this->price_yearly);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price_monthly');
    }
}
