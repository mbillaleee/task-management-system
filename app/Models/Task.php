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
}
