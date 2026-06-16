<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Challenge;
use App\Models\DailyReward;
use App\Models\UserBadge;
use App\Models\UserChallenge;
use App\Models\UserGamification;
use App\Services\GamificationService;
use App\Http\Controllers\User\ChallengeController;

class GamificationController extends Controller
{
    /**
     * User Gamification Dashboard
     * Route: GET /user/gamification
     */
    public function index()
    {
        $gamification = UserGamification::firstOrCreate(
            ['user_id' => auth()->id()],
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

        

        $badges         = Badge::where('is_active', true)->orderBy('xp_required')->get();
        $userBadges     = UserBadge::with('badge')->where('user_id', auth()->id())->latest()->get();
        $challenges     = Challenge::where('is_active', true)->latest()->get();
        $userChallenges = UserChallenge::with('challenge')->where('user_id', auth()->id())->latest()->get();
        $dailyRewards   = DailyReward::orderBy('day_number')->get();

        $levelProgress = GamificationService::getLevelProgress($gamification);
        $levelLabel    = GamificationService::getLevelLabel($gamification->level);
        $nextLevelXp   = $gamification->level * 100;

        $canClaimToday = ! ($gamification->last_activity_date && $gamification->last_activity_date->isToday());

        // Next badge the user is working toward
        $unlockedBadgeIds = $userBadges->pluck('badge_id');
        $nextBadge = Badge::where('is_active', true)
            ->whereNotIn('id', $unlockedBadgeIds)
            ->where('badge_type', 'xp')
            ->where('xp_required', '>', $gamification->xp)
            ->orderBy('xp_required')
            ->first();

        return view('user.gamification.index', compact(
            'gamification',
            'badges',
            'userBadges',
            'challenges',
            'userChallenges',
            'dailyRewards',
            'nextLevelXp',
            'levelProgress',
            'levelLabel',
            'canClaimToday',
            'nextBadge'
        ));
    }

    /**
     * Claim daily login reward
     * Route: POST /user/gamification/claim-daily-reward
     */
    public function claimDailyReward()
    {
        $gamification = UserGamification::firstOrCreate(['user_id' => auth()->id()]);

        if ($gamification->last_activity_date && $gamification->last_activity_date->isToday()) {
            return back()->with('error', 'Daily reward already claimed today.');
        }

        // Streak logic
        if ($gamification->last_activity_date && $gamification->last_activity_date->isYesterday()) {
            $gamification->streak_days += 1;
        } else {
            $gamification->streak_days = 1;
        }

        // Update max streak
        if ($gamification->streak_days > ($gamification->max_streak_days ?? 0)) {
            $gamification->max_streak_days = $gamification->streak_days;
        }

        $reward   = DailyReward::where('day_number', min($gamification->streak_days, 7))->first();
        $xpReward = $reward?->xp_reward ?? 10;

        $gamification->last_activity_date   = today();
        $gamification->daily_reward_claimed += 1;
        $gamification->save();

        // Award XP via service (badge check included)
        GamificationService::awardXp(auth()->id(), $xpReward, 'Daily login reward');

        // Streak milestone bonus
        GamificationService::updateStreakBonus(auth()->id(), $gamification->streak_days);

        ChallengeController::autoProgress(auth()->id(), 'login_streak');

        return back()->with('success', 'Daily reward claimed! +' . $xpReward . ' XP 🎉');
    }

    /**
     * Unlock badges based on current XP (called internally)
     */
    private function unlockBadges(UserGamification $gamification): void
    {
        $badges = Badge::where('is_active', true)
            ->where('xp_required', '<=', $gamification->xp)
            ->get();

        foreach ($badges as $badge) {
            UserBadge::firstOrCreate(
                ['user_id' => auth()->id(), 'badge_id' => $badge->id],
                ['unlocked_at' => now()]
            );
        }
    }
}