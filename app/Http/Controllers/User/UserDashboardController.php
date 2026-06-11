<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Habit;
use App\Models\Language;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\UserGamification;
use App\Services\GamificationService;
use Carbon\Carbon;

class UserDashboardController extends Controller
{ 
    public function userDashboard()
    {
        $userId = auth()->id();

        $todayTasks = Task::with(['category', 'labels'])
            ->where('user_id', $userId)
            ->whereDate('due_date', today())
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->get();

        $topPriorities = Task::with('category')
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->limit(3)
            ->get();

        $completedTaskCount = Task::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        $pendingTaskCount = Task::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $overdueTasks = Task::where('user_id', $userId)
            ->whereDate('due_date', '<', today())
            ->where('status', '!=', 'completed')
            ->count();

        $todayTotal = $todayTasks->count();

        $todayCompleted = Task::where('user_id', $userId)
            ->whereDate('due_date', today())
            ->where('status', 'completed')
            ->count();

        $dailyProgress = $todayTotal > 0 ? round(($todayCompleted / $todayTotal) * 100) : 0;




        $todayHabits = Habit::with('todayLog')
            ->where('user_id', auth()->id())
            ->where('status', true)
            ->get();

        $totalHabits = $todayHabits->count();

        $completedToday = $todayHabits->filter(function ($habit) {
            return $habit->todayLog?->is_completed;
        })->count();

        $habitCompletionRate = $totalHabits > 0
            ? round(($completedToday / $totalHabits) * 100)
            : 0;

        $circleDash = 314.16;

        $circleOffset = $circleDash - ($circleDash * $habitCompletionRate / 100);

        $habitScoreLabel = match (true) {
            $habitCompletionRate >= 90 => 'Excellent',
            $habitCompletionRate >= 70 => 'Good',
            $habitCompletionRate >= 40 => 'Average',
            default => 'Low',
        };


        // Dashboard method-এর ভেতরে যোগ করুন
        $gamification = UserGamification::firstOrCreate(
            ['user_id' => $userId],
            ['xp' => 0, 'level' => 1, 'streak_days' => 0]
        );

        $levelLabel    = GamificationService::getLevelLabel($gamification->level);
        $levelProgress = GamificationService::getLevelProgress($gamification);
        $userBadgesCount = \App\Models\UserBadge::where('user_id', $userId)->count();


        return view('user.dashboard', compact(
            'todayTasks',
            'topPriorities',
            'completedTaskCount',
            'pendingTaskCount',
            'overdueTasks',
            'dailyProgress',
            'todayTotal',
            'todayCompleted',
            'todayHabits',
            'totalHabits',
            'completedToday',
            'habitCompletionRate',
            'circleDash',
            'circleOffset',
            'habitScoreLabel',
            'gamification',
            'levelLabel',
            'levelProgress',
            'userBadgesCount'

        ));
    }

    public function pricing()
    {
        // Load all active plans ordered by sort_order / price
        $plans = SubscriptionPlan::active()
            ->ordered()
            ->get();
 
        // Current user's active/trial subscription (latest one)
        $currentSubscription = UserSubscription::with('plan')
            ->where('user_id', auth()->id())
            ->whereIn('status', ['active', 'trial'])
            ->latest()
            ->first();
 
        $currentPlanId = $currentSubscription?->plan?->id;
 
        return view('user.pricing', compact('plans', 'currentSubscription', 'currentPlanId'));
    }

    public function updateStatus(Language $language)
    {
        // 1. Save selected language in session
        session(['locale' => $language->language_code]);

        // 2. Set Laravel locale immediately
        \Illuminate\Support\Facades\App::setLocale($language->language_code);

        // 3. Optional: flash a success message
        session()->flash('success', 'Language changed successfully');

        // 4. Redirect back
        return back();
    }
}
