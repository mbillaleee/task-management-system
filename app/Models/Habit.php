<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    protected $guarded = [];

    protected $casts = [
        'days'             => 'array',
        'status'           => 'boolean',
        'start_date'       => 'date',
        'reminder_enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    // Last 30 days log dates — used for heatmap
    public function recentLogs()
    {
        return $this->hasMany(HabitLog::class)
            ->where('is_completed', true)
            ->where('log_date', '>=', now()->subDays(89))
            ->orderBy('log_date');
    }

    // Completion rate (last 30 days)
    public function getCompletionRateAttribute(): int
    {
        $total = 30;
        $done  = $this->logs()
            ->where('is_completed', true)
            ->where('log_date', '>=', now()->subDays(29))
            ->count();
        return (int) round($done / $total * 100);
    }
}
