<?php

namespace App\Services;

use App\Models\UserGamification;
use App\Models\Badge;
use App\Models\UserBadge;

class GamificationService
{
    // ─── XP Constants ──────────────────────────────────────────
    // এই values গুলো সব জায়গা থেকে call করো — hardcode করো না
    const XP_TASK_COMPLETED    = 10;
    const XP_HABIT_COMPLETED   = 5;
    const XP_FOCUS_SESSION     = 15;
    const XP_GOAL_COMPLETED    = 50;
    const XP_JOURNAL_WRITTEN   = 8;
    const XP_DAILY_LOGIN       = 10; // base, daily reward override করতে পারে
    const XP_STREAK_7_DAYS     = 30;
    const XP_STREAK_30_DAYS    = 75;
    const XP_STREAK_100_DAYS   = 200;
    const XP_CHALLENGE_BASE    = 10; // challenge নিজেই xp_reward define করে

    // ─── Core: XP Award ────────────────────────────────────────
    /**
     * সব জায়গা থেকে শুধু এই method call করো।
     * XP দেয়, level update করে, badge check করে।
     */
    public static function awardXp(int $userId, int $xp, string $reason = ''): UserGamification
    {
        $g = self::getOrCreate($userId);

        $g->xp    += $xp;
        $g->level  = self::calculateLevel($g->xp);
        $g->save();

        self::checkAndUnlockBadges($g);

        return $g;
    }

    // ─── Stat Increment + XP ───────────────────────────────────
    /**
     * Task complete হলে call করো:
     * GamificationService::taskCompleted(auth()->id());
     */
    public static function taskCompleted(int $userId): void
    {
        $g = self::getOrCreate($userId);
        $g->increment('total_tasks_completed');
        $g->refresh();
        self::awardXp($userId, self::XP_TASK_COMPLETED, 'Task completed');
    }

    /**
     * Habit log করলে call করো:
     * GamificationService::habitCompleted(auth()->id());
     */
    public static function habitCompleted(int $userId): void
    {
        $g = self::getOrCreate($userId);
        $g->increment('total_habits_completed');
        $g->refresh();
        self::awardXp($userId, self::XP_HABIT_COMPLETED, 'Habit completed');
    }

    /**
     * Focus session complete হলে call করো:
     * GamificationService::focusSessionCompleted(auth()->id());
     */
    public static function focusSessionCompleted(int $userId): void
    {
        $g = self::getOrCreate($userId);
        $g->increment('total_focus_sessions');
        $g->refresh();
        self::awardXp($userId, self::XP_FOCUS_SESSION, 'Focus session completed');
    }

    /**
     * Goal complete হলে call করো:
     * GamificationService::goalCompleted(auth()->id());
     */
    public static function goalCompleted(int $userId): void
    {
        $g = self::getOrCreate($userId);
        $g->increment('total_goals_completed');
        $g->refresh();
        self::awardXp($userId, self::XP_GOAL_COMPLETED, 'Goal completed');
    }

    /**
     * Journal লেখলে call করো:
     * GamificationService::journalWritten(auth()->id());
     */
    public static function journalWritten(int $userId): void
    {
        $g = self::getOrCreate($userId);
        $g->increment('total_journals_written');
        $g->refresh();
        self::awardXp($userId, self::XP_JOURNAL_WRITTEN, 'Journal written');
    }

    // ─── Streak Bonus ──────────────────────────────────────────
    /**
     * Daily claim বা habit streak update হলে call করো
     */
    public static function updateStreakBonus(int $userId, int $currentStreak): void
    {
        $g = self::getOrCreate($userId);

        // max streak update
        if ($currentStreak > $g->max_streak_days) {
            $g->max_streak_days = $currentStreak;
            $g->save();
        }

        // Milestone bonuses — শুধু exact milestone-এ দাও
        $bonuses = [
            7   => self::XP_STREAK_7_DAYS,
            30  => self::XP_STREAK_30_DAYS,
            100 => self::XP_STREAK_100_DAYS,
        ];

        if (isset($bonuses[$currentStreak])) {
            self::awardXp($userId, $bonuses[$currentStreak], "Streak {$currentStreak}-day bonus");
        }
    }

    // ─── Badge Check ───────────────────────────────────────────
    /**
     * XP award হওয়ার পরে এটা auto call হয়।
     * badge_type অনুযায়ী সঠিক column check করে।
     */
    public static function checkAndUnlockBadges(UserGamification $g): void
    {
        $userId = $g->user_id;

        $badges = Badge::where('is_active', true)->get();

        foreach ($badges as $badge) {
            // Already unlocked? skip
            $alreadyUnlocked = UserBadge::where('user_id', $userId)
                ->where('badge_id', $badge->id)
                ->exists();

            if ($alreadyUnlocked) continue;

            $earned = match ($badge->badge_type ?? 'xp') {
                'xp'               => $g->xp                    >= ($badge->xp_required ?: $badge->trigger_value),
                'streak'           => $g->streak_days            >= $badge->trigger_value,
                'task_count'       => $g->total_tasks_completed  >= $badge->trigger_value,
                'habit_count'      => $g->total_habits_completed >= $badge->trigger_value,
                'focus_sessions'   => $g->total_focus_sessions   >= $badge->trigger_value,
                'goals_completed'  => $g->total_goals_completed  >= $badge->trigger_value,
                'journals_written' => $g->total_journals_written >= $badge->trigger_value,
                'manual'           => false, // admin manually দেয়
                default            => false,
            };

            if ($earned) {
                UserBadge::firstOrCreate(
                    ['user_id' => $userId, 'badge_id' => $badge->id],
                    ['unlocked_at' => now()]
                );
            }
        }
    }

    // ─── Level Helpers ─────────────────────────────────────────
    public static function calculateLevel(int $xp): int
    {
        return (int) floor($xp / 100) + 1;
    }

    public static function getLevelLabel(int $level): string
    {
        return match (true) {
            $level <= 3  => 'Beginner',
            $level <= 6  => 'Explorer',
            $level <= 10 => 'Achiever',
            $level <= 15 => 'Champion',
            $level <= 20 => 'Legend',
            default      => 'Master',
        };
    }

    public static function getLevelProgress(UserGamification $g): array
    {
        $currentBase  = ($g->level - 1) * 100;
        $progressXp   = $g->xp - $currentBase;
        $progressPct  = min(100, $progressXp);

        return [
            'next_level_xp' => $g->level * 100,
            'current_xp'    => $g->xp,
            'progress_xp'   => $progressXp,
            'progress_pct'  => $progressPct,
            'label'         => self::getLevelLabel($g->level),
        ];
    }

    // ─── Internal ──────────────────────────────────────────────
    private static function getOrCreate(int $userId): UserGamification
    {
        return UserGamification::firstOrCreate(
            ['user_id' => $userId],
            [
                'xp'                     => 0,
                'level'                  => 1,
                'streak_days'            => 0,
                'max_streak_days'        => 0,
                'last_activity_date'     => null,
                'daily_reward_claimed'   => 0,
                'total_tasks_completed'  => 0,
                'total_habits_completed' => 0,
                'total_focus_sessions'   => 0,
                'total_goals_completed'  => 0,
                'total_journals_written' => 0,
            ]
        );
    }

    public static function checkHabitStreakBonus(int $userId, int $habitId): void
    {
        $streak = HabitStreak::where('habit_id', $habitId)
            ->where('user_id', $userId)
            ->first();

        if (! $streak) {
            return;
        }

        if ($streak->current_streak === 7) {
            self::awardXp($userId, 30, 'Habit 7-day streak bonus');
        }

        if ($streak->current_streak === 30) {
            self::awardXp($userId, 75, 'Habit 30-day streak bonus');
        }
    }
}
