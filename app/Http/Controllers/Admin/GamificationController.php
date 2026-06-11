<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Challenge;
use App\Models\DailyReward;
use App\Models\User;
use App\Models\UserBadge;
use App\Models\UserChallenge;
use App\Models\UserGamification;

class GamificationController extends Controller
{
    /**
     * Admin Gamification Overview Dashboard
     * Route: GET /admin/gamification
     */
    public function index()
    {
        // Platform-wide stats
        $totalUsers        = User::count();
        $totalXpEarned     = UserGamification::sum('xp');
        $totalBadgesGiven  = UserBadge::count();
        $totalChallengesDone = UserChallenge::where('is_completed', true)->count();

        // Top 10 users by XP
        $topUsers = UserGamification::with('user')
            ->orderByDesc('xp')
            ->take(10)
            ->get();

        // All badges (with count of users who unlocked them)
        $badges = Badge::withCount('users')->latest()->paginate(12, ['*'], 'badges_page');

        // All challenges (with count of users who joined/completed)
        $challenges = Challenge::withCount([
            'users',
            'users as completed_count' => function ($q) {
                $q->where('user_challenges.is_completed', 1);
            },
        ])->latest()->paginate(12);

        // Daily rewards
        $dailyRewards = DailyReward::orderBy('day_number')->get();

        return view('admin.gamification.index', compact(
            'totalUsers',
            'totalXpEarned',
            'totalBadgesGiven',
            'totalChallengesDone',
            'topUsers',
            'badges',
            'challenges',
            'dailyRewards'
        ));
    }
}