<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(GoalCategory::class, 'goal_category_id');
    }

    public function milestones()
    {
        return $this->hasMany(GoalMilestone::class);
    }

    public function completedMilestones()
    {
        return $this->hasMany(GoalMilestone::class)->where('is_completed', true);
    }
}