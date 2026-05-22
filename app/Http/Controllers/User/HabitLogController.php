<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Habit;
use App\Models\HabitLog;
use App\Models\HabitStreak;

class HabitLogController extends Controller
{
    public function toggle(Habit $habit)
    {
        abort_if($habit->user_id !== auth()->id(), 403);

        $today = today();

        $log = HabitLog::updateOrCreate(
            [
                'habit_id' => $habit->id,
                'log_date' => $today,
            ],
            [
                'user_id' => auth()->id(),
                'is_completed' => true,
            ]
        );

        $streak = HabitStreak::firstOrCreate([
            'habit_id' => $habit->id,
            'user_id' => auth()->id(),
        ]);

        if (!$streak->last_completed_date) {
            $streak->current_streak = 1;
        } elseif ($streak->last_completed_date->isYesterday()) {
            $streak->current_streak += 1;
        } elseif (!$streak->last_completed_date->isToday()) {
            $streak->current_streak = 1;
        }

        $streak->best_streak = max($streak->best_streak, $streak->current_streak);
        $streak->last_completed_date = $today;
        $streak->save();

        return back()->with('success', 'Habit completed for today.');
    }
}