<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    protected $guarded = [];

    protected $casts = [
        'days' => 'array',
        'status' => 'boolean',
        'start_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(HabitCategory::class, 'habit_category_id');
    }

    public function logs()
    {
        return $this->hasMany(HabitLog::class);
    }

    public function streak()
    {
        return $this->hasOne(HabitStreak::class);
    }

    public function todayLog()
    {
        return $this->hasOne(HabitLog::class)->whereDate('log_date', today());
    }
}
