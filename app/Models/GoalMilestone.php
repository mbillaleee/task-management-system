<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalMilestone extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_completed' => 'boolean',
        'due_date' => 'date',
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}