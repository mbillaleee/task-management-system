<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Habit;
use App\Models\HabitLog;
use App\Models\HabitStreak;
use App\Services\GamificationService;
use App\Http\Controllers\User\ChallengeController;

class HabitLogController extends Controller
{
    public function toggle(Habit $habit)
    {
        abort_if($habit->user_id !== auth()->id(), 403);

        $today = today();
        $userId = auth()->id();

        // আগে completed ছিল কিনা check করুন
        $existingLog = HabitLog::where([
            'habit_id' => $habit->id,
            'log_date' => $today,
        ])->first();

        $wasCompleted = $existingLog?->is_completed ?? false;

        $log = HabitLog::updateOrCreate(
            ['habit_id' => $habit->id, 'log_date' => $today],
            ['user_id' => $userId, 'is_completed' => true]
        );

        // Streak update
        $streak = HabitStreak::firstOrCreate([
            'habit_id' => $habit->id,
            'user_id'  => $userId,
        ]);

        if (! $streak->last_completed_date) {
            $streak->current_streak = 1;
        } elseif ($streak->last_completed_date->isYesterday()) {
            $streak->current_streak += 1;
        } elseif (! $streak->last_completed_date->isToday()) {
            $streak->current_streak = 1;
        }

        $streak->best_streak         = max($streak->best_streak, $streak->current_streak);
        $streak->last_completed_date = $today;
        $streak->save();

        // ✅ XP Award: আগে completed না থাকলেই XP দিন
        if (! $wasCompleted) {
            GamificationService::awardXp(
                $userId,
                10,
                'Habit completed: ' . $habit->title
            );

            GamificationService::updateStreakBonus($userId, $streak->current_streak);

            // Challenge Progress
            ChallengeController::autoProgress(
                auth()->id(),
                'log_habit'
            );
        }

        return back()->with('success', 'Habit completed for today! +10 XP 🔥');
    }
}