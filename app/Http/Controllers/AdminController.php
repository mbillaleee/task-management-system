<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Habit;
use App\Models\HabitLog;
use App\Models\Note;
use App\Models\FocusSession;
use App\Models\Goal;
use App\Models\Journal;
use App\Models\UserGamification;
use App\Models\UserBadge;
use App\Models\UserChallenge;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ── 1. USER STATS ────────────────────────────────────────
        $totalUsers     = User::count();
        $activeToday    = User::whereDate('updated_at', today())->count();
        $activeThisWeek = User::where('updated_at', '>=', now()->startOfWeek())->count();
        $newThisMonth   = User::where('created_at', '>=', now()->startOfMonth())->count();

        // New registrations — last 30 days (for chart)
        $registrationChart = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $registrationChart[] = [
                'date'  => now()->subDays($i)->format('d M'),
                'count' => User::whereDate('created_at', $date)->count(),
            ];
        }

        // ── 2. REVENUE ───────────────────────────────────────────
        $totalRevenue      = UserSubscription::where('status', 'active')
                                ->sum('amount_paid');
        $revenueThisMonth  = UserSubscription::where('status', 'active')
                                ->where('starts_at', '>=', now()->startOfMonth())
                                ->sum('amount_paid');
        $activeSubscribers = UserSubscription::where('status', 'active')->count();
        $proSubscribers    = UserSubscription::where('status', 'active')
                                ->whereHas('plan', fn($q) => $q->where('price_monthly', '>', 0))
                                ->count();

        // Revenue per plan
        $revenueByPlan = SubscriptionPlan::withSum(
            ['userSubscriptions as total_revenue' => fn($q) => $q->where('status', 'active')],
            'amount_paid'
        )->withCount(['userSubscriptions as subscribers' => fn($q) => $q->where('status', 'active')])
         ->where('is_active', true)
         ->get();

        // ── 3. MODULE USAGE ──────────────────────────────────────
        $totalTasks        = Task::count();
        $completedTasks    = Task::where('status', 'completed')->count();
        $totalHabits       = Habit::count();
        $totalHabitLogs    = HabitLog::where('is_completed', true)->count();
        $totalNotes        = Note::count();
        $totalFocusSessions = FocusSession::where('status', 'completed')->count();
        $totalFocusMinutes  = FocusSession::where('status', 'completed')->sum('completed_minutes');
        $totalGoals        = Goal::count();
        $completedGoals    = Goal::where('status', 'completed')->count();
        $totalJournals     = Journal::count();

        // Module activity — this week vs last week
        $thisWeekStart = now()->startOfWeek();
        $lastWeekStart = now()->subWeek()->startOfWeek();
        $lastWeekEnd   = now()->subWeek()->endOfWeek();

        $weeklyModuleStats = [
            'tasks_this'   => Task::where('created_at', '>=', $thisWeekStart)->count(),
            'tasks_last'   => Task::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count(),
            'habits_this'  => HabitLog::where('is_completed', true)->where('created_at', '>=', $thisWeekStart)->count(),
            'habits_last'  => HabitLog::where('is_completed', true)->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count(),
            'focus_this'   => FocusSession::where('status', 'completed')->where('completed_at', '>=', $thisWeekStart)->count(),
            'focus_last'   => FocusSession::where('status', 'completed')->whereBetween('completed_at', [$lastWeekStart, $lastWeekEnd])->count(),
            'notes_this'   => Note::where('created_at', '>=', $thisWeekStart)->count(),
            'notes_last'   => Note::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count(),
        ];

        // ── 4. GAMIFICATION STATS ────────────────────────────────
        $totalXpEarned       = UserGamification::sum('xp');
        $totalBadgesGiven    = UserBadge::count();
        $totalChallengesDone = UserChallenge::where('is_completed', true)->count();
        $avgXpPerUser        = $totalUsers > 0 ? round($totalXpEarned / $totalUsers) : 0;

        // Top 10 users by XP
        $topUsers = UserGamification::with('user')
            ->orderByDesc('xp')
            ->take(10)
            ->get();

        // ── 5. RECENT REGISTRATIONS ──────────────────────────────
        $recentUsers = User::with('activeSubscription.plan')
            ->latest()
            ->take(8)
            ->get();

        // ── 6. MODULE USAGE CHART (last 7 days per module) ───────
        $moduleChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $moduleChart[] = [
                'label'  => now()->subDays($i)->format('D'),
                'tasks'  => Task::whereDate('created_at', $date)->count(),
                'habits' => HabitLog::where('is_completed', true)->whereDate('created_at', $date)->count(),
                'focus'  => FocusSession::where('status', 'completed')->whereDate('completed_at', $date)->count(),
                'notes'  => Note::whereDate('created_at', $date)->count(),
            ];
        }

        return view('admin.dashboard', compact(
            // Users
            'totalUsers', 'activeToday', 'activeThisWeek', 'newThisMonth',
            'registrationChart', 'recentUsers',
            // Revenue
            'totalRevenue', 'revenueThisMonth', 'activeSubscribers', 'proSubscribers',
            'revenueByPlan',
            // Module usage
            'totalTasks', 'completedTasks',
            'totalHabits', 'totalHabitLogs',
            'totalNotes',
            'totalFocusSessions', 'totalFocusMinutes',
            'totalGoals', 'completedGoals',
            'totalJournals',
            'weeklyModuleStats', 'moduleChart',
            // Gamification
            'totalXpEarned', 'totalBadgesGiven', 'totalChallengesDone',
            'avgXpPerUser', 'topUsers'
        ));
    }
}
