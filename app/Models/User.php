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
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
    
}
