<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $casts = [
        'due_date' => 'date',
        'reminder_enabled' => 'boolean',
        'remind_at' => 'datetime',
        'reminder_sent_at' => 'datetime',
        'is_recurring' => 'boolean',
        'recurring_end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(TaskCategory::class, 'task_category_id');
    }

    public function labels()
    {
        return $this->belongsToMany(TaskLabel::class, 'task_label_task');
    }

    public function subtasks()
    {
        return $this->hasMany(TaskSubtask::class);
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    public function histories()
    {
        return $this->hasMany(TaskHistory::class);
    }

    // Helper: is this task overdue?
    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'completed';
    }

    // Helper: subtask completion percentage
    public function getSubtaskProgressAttribute(): int
    {
        $total = $this->subtasks->count();
        if ($total === 0) return 0;
        return (int) round($this->subtasks->where('is_completed', true)->count() / $total * 100);
    }
}
