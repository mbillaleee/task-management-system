<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitStreak extends Model
{
    protected $guarded = [];

    protected $casts = [
        'last_completed_date' => 'date',
    ];

    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }
}
