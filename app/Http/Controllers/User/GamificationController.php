<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Challenge;
use App\Models\DailyReward;
use App\Models\UserBadge;
use App\Models\UserChallenge;
use App\Models\UserGamification;

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
                'xp'                   => 0,
                'level'                => 1,
                'streak_days'          => 0,
                'last_activity_date'   => null,
                'daily_reward_claimed' => 0,
            ]
        );

        // All active badges (to show locked/unlocked state)
        $badges = Badge::where('is_active', true)->latest()->get();

        // Badges this user has unlocked
        $userBadges = UserBadge::with('badge')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        // All active challenges
        $challenges = Challenge::where('is_active', true)->latest()->get();

        // Challenges this user has joined
        $userChallenges = UserChallenge::with('challenge')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        // Daily rewards (for reward calendar display)
        $dailyRewards = DailyReward::orderBy('day_number')->get();

        // Level progress calculation
        $nextLevelXp   = $gamification->level * 100;
        $levelProgress = $nextLevelXp > 0
            ? min(round(($gamification->xp / $nextLevelXp) * 100), 100)
            : 0;

        // Check if daily reward is claimable today
        $canClaimToday = ! ($gamification->last_activity_date && $gamification->last_activity_date->isToday());

        return view('user.gamification.index', compact(
            'gamification',
            'badges',
            'userBadges',
            'challenges',
            'userChallenges',
            'dailyRewards',
            'nextLevelXp',
            'levelProgress',
            'canClaimToday'
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

        // Find matching daily reward (cap at day 7)
        $reward    = DailyReward::where('day_number', min($gamification->streak_days, 7))->first();
        $xpReward  = $reward?->xp_reward ?? 10;

        $gamification->xp                  += $xpReward;
        $gamification->level               = floor($gamification->xp / 100) + 1;
        $gamification->last_activity_date  = today();
        $gamification->daily_reward_claimed += 1;
        $gamification->save(); 

        $this->unlockBadges($gamification);

        return back()->with('success', 'Daily reward claimed! You earned ' . $xpReward . ' XP 🎉');
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