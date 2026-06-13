<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Habit;
use App\Models\HabitLog;
use App\Models\Note;
use App\Models\Goal;
use App\Models\Journal;
use App\Models\FocusSession;
use App\Models\Language;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\UserGamification;
use App\Models\UserBadge;
use App\Services\GamificationService;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function userDashboard(Request $request)
    {
        $userId = auth()->id();

        $period = $request->input('period', 'today');

        if (!in_array($period, ['today', 'week', 'month'], true)) {
            $period = 'today';
        }

        if ($period === 'week') {
            $rangeStart  = now()->copy()->startOfWeek();
            $rangeEnd    = now()->copy()->endOfWeek();
            $periodLabel = 'This Week';
        } elseif ($period === 'month') {
            $rangeStart  = now()->copy()->startOfMonth();
            $rangeEnd    = now()->copy()->endOfMonth();
            $periodLabel = 'This Month';
        } else {
            $rangeStart  = today()->copy()->startOfDay();
            $rangeEnd    = today()->copy()->endOfDay();
            $periodLabel = 'Today';
        }

        $todayTasks = Task::with(['category', 'labels'])
            ->where('user_id', $userId)
            ->whereBetween('due_date', [
                $rangeStart->toDateString(),
                $rangeEnd->toDateString()
            ])
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->get();

        $topPriorities = Task::with('category')
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderBy('due_date')
            ->limit(6)
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
            ->whereBetween('due_date', [
                $rangeStart->toDateString(),
                $rangeEnd->toDateString()
            ])
            ->where('status', 'completed')
            ->count();

        $dailyProgress = $todayTotal > 0
            ? round(($todayCompleted / $todayTotal) * 100)
            : 0;

        $todayHabits = Habit::with('todayLog')
            ->where('user_id', $userId)
            ->where('status', true)
            ->get();

        $totalHabits = $todayHabits->count();

        if ($period === 'today') {
            $completedToday = $todayHabits->filter(function ($habit) {
                return optional($habit->todayLog)->is_completed;
            })->count();

            $habitDenominator = max(1, $totalHabits);
        } else {
            $habitIds = $todayHabits->pluck('id');

            $completedToday = HabitLog::whereIn('habit_id', $habitIds)
                ->where('is_completed', true)
                ->whereBetween('log_date', [
                    $rangeStart->toDateString(),
                    $rangeEnd->toDateString()
                ])
                ->count();

            $daysInRange = $rangeStart->copy()->diffInDays($rangeEnd) + 1;

            $actualEnd = today()->lt($rangeEnd) ? today() : $rangeEnd;

            $elapsedDays = $rangeStart->gt(today())
                ? 0
                : ($rangeStart->copy()->diffInDays($actualEnd) + 1);

            $habitDenominator = max(1, $totalHabits * $elapsedDays);
        }

        $habitCompletionRate = $habitDenominator > 0
            ? round(($completedToday / $habitDenominator) * 100)
            : 0;

        $circleDash = 314.16;
        $circleOffset = $circleDash - ($circleDash * $habitCompletionRate / 100);

        if ($habitCompletionRate >= 90) {
            $habitScoreLabel = 'Excellent';
        } elseif ($habitCompletionRate >= 70) {
            $habitScoreLabel = 'Good';
        } elseif ($habitCompletionRate >= 40) {
            $habitScoreLabel = 'Average';
        } else {
            $habitScoreLabel = 'Low';
        }

        $gamification = UserGamification::firstOrCreate(
            ['user_id' => $userId],
            ['xp' => 0, 'level' => 1, 'streak_days' => 0]
        );

        $levelLabel = GamificationService::getLevelLabel($gamification->level);
        $levelProgress = GamificationService::getLevelProgress($gamification);
        $userBadgesCount = UserBadge::where('user_id', $userId)->count();

        $streakDays = $gamification->streak_days;

        if ($streakDays >= 30) {
            $streakMessage = 'Unstoppable!';
        } elseif ($streakDays >= 7) {
            $streakMessage = 'Keep it hot!';
        } elseif ($streakDays >= 1) {
            $streakMessage = 'Great start!';
        } else {
            $streakMessage = 'Start your streak today!';
        }

        $periodFocusMinutes = (int) FocusSession::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereBetween('completed_at', [
                $rangeStart->copy()->startOfDay(),
                $rangeEnd->copy()->endOfDay()
            ])
            ->sum('completed_minutes');

        $focusMinutesToday = $periodFocusMinutes;
        $focusTimeFormatted = $this->formatMinutes($focusMinutesToday);

        $focusSparkline = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = today()->copy()->subDays($i);

            $focusSparkline[] = (int) FocusSession::where('user_id', $userId)
                ->where('status', 'completed')
                ->whereDate('completed_at', $date)
                ->sum('completed_minutes');
        }

        $thisWeekData = [];
        $lastWeekData = [];
        $chartLabels = [];

        $startOfThisWeek = now()->copy()->startOfWeek();
        $startOfLastWeek = now()->copy()->subWeek()->startOfWeek();

        for ($i = 0; $i < 7; $i++) {
            $thisDay = $startOfThisWeek->copy()->addDays($i);
            $lastDay = $startOfLastWeek->copy()->addDays($i);

            $chartLabels[] = $thisDay->format('D');

            $thisWeekData[] = Task::where('user_id', $userId)
                ->where('status', 'completed')
                ->whereDate('updated_at', $thisDay)
                ->count();

            $lastWeekData[] = Task::where('user_id', $userId)
                ->where('status', 'completed')
                ->whereDate('updated_at', $lastDay)
                ->count();
        }

        $activities = $this->buildActivityFeed($userId);

        return view('user.dashboard', compact(
            'period',
            'periodLabel',
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
            'userBadgesCount',
            'streakDays',
            'streakMessage',
            'focusMinutesToday',
            'focusTimeFormatted',
            'focusSparkline',
            'chartLabels',
            'thisWeekData',
            'lastWeekData',
            'activities'
        ));
    }

    public function pricing()
    {
        $plans = SubscriptionPlan::active()->ordered()->get();

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
        session(['locale' => $language->language_code]);
        \Illuminate\Support\Facades\App::setLocale($language->language_code);
        session()->flash('success', 'Language changed successfully');

        return back();
    }


    // ─────────────────────────────────────────────────────────────
    //  Helpers
    // ─────────────────────────────────────────────────────────────

    /**
     * Format minutes as "Xh Ym".
     */
    private function formatMinutes(int $minutes): string
    {
        $h = intdiv($minutes, 60);
        $m = $minutes % 60;

        if ($h > 0 && $m > 0) return "{$h}h {$m}m";
        if ($h > 0)           return "{$h}h";
        return "{$m}m";
    }

    /**
     * Build a unified activity feed from Tasks, Habits, Focus Sessions,
     * Notes, Goals, and Journals — sorted by recency, limited to 6.
     */
    private function buildActivityFeed(int $userId, int $limit = 6): array
    {
        $items = collect();

        // Completed tasks
        Task::where('user_id', $userId)
            ->where('status', 'completed')
            ->where('updated_at', '>=', now()->subDays(7))
            ->latest('updated_at')
            ->limit(5)
            ->get()
            ->each(function ($task) use (&$items) {
                $items->push([
                    'type'  => 'task',
                    'title' => 'You completed a task',
                    'desc'  => $task->title,
                    'time'  => $task->updated_at,
                    'bg'    => '#22c55e',
                    'svg'   => '<polyline points="20 6 9 17 4 12"/>',
                    'svgProps' => 'fill="none" stroke="#fff" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"',
                ]);
            });

        // Habit logs (completed)
        HabitLog::with('habit')
            ->where('is_completed', true)
            ->where('created_at', '>=', now()->subDays(7))
            ->whereHas('habit', fn($q) => $q->where('user_id', $userId))
            ->latest('created_at')
            ->limit(5)
            ->get()
            ->each(function ($log) use (&$items) {
                $items->push([
                    'type'  => 'habit',
                    'title' => 'Habit completed',
                    'desc'  => $log->habit?->title ?? 'Habit',
                    'time'  => $log->created_at,
                    'bg'    => '#f97316',
                    'svg'   => '<path d="M12 2C9 7 6 9.5 6 13a6 6 0 0 0 12 0c0-3.5-3-6-6-11zm0 17a3 3 0 0 1-3-3c0-1.8 1.2-3.2 3-5 1.8 1.8 3 3.2 3 5a3 3 0 0 1-3 3z"/>',
                    'svgProps' => 'fill="#fff" stroke="none"',
                ]);
            });

        // Focus sessions completed
        FocusSession::where('user_id', $userId)
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->subDays(7))
            ->latest('completed_at')
            ->limit(5)
            ->get()
            ->each(function ($session) use (&$items) {
                $items->push([
                    'type'  => 'focus',
                    'title' => 'Focus session completed',
                    'desc'  => $session->title ?? ucfirst(str_replace('_', ' ', $session->type)),
                    'time'  => $session->completed_at,
                    'bg'    => 'linear-gradient(135deg,#e11d48,#9333ea)',
                    'svg'   => '<circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M4.22 4.22l2.12 2.12M17.66 17.66l2.12 2.12M2 12h3M19 12h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12"/>',
                    'svgProps' => 'fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"',
                ]);
            });

        // New notes
        Note::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(7))
            ->latest('created_at')
            ->limit(5)
            ->get()
            ->each(function ($note) use (&$items) {
                $items->push([
                    'type'  => 'note',
                    'title' => 'New note created',
                    'desc'  => $note->title,
                    'time'  => $note->created_at,
                    'bg'    => '#7c3aed',
                    'svg'   => '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>',
                    'svgProps' => 'fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"',
                ]);
            });

        // Completed goals
        Goal::where('user_id', $userId)
            ->where('status', 'completed')
            ->where('updated_at', '>=', now()->subDays(7))
            ->latest('updated_at')
            ->limit(5)
            ->get()
            ->each(function ($goal) use (&$items) {
                $items->push([
                    'type'  => 'goal',
                    'title' => 'Goal achieved! 🎯',
                    'desc'  => $goal->title,
                    'time'  => $goal->updated_at,
                    'bg'    => '#0ea5e9',
                    'svg'   => '<path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M12 1v6M12 17v6M4.93 4.93l4.24 4.24M14.83 14.83l4.24 4.24M1 12h6M17 12h6M4.93 19.07l4.24-4.24M14.83 9.17l4.24-4.24"/>',
                    'svgProps' => 'fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"',
                ]);
            });

        // New journal entries
        Journal::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(7))
            ->latest('created_at')
            ->limit(5)
            ->get()
            ->each(function ($journal) use (&$items) {
                $items->push([
                    'type'  => 'journal',
                    'title' => 'New journal entry',
                    'desc'  => $journal->title,
                    'time'  => $journal->created_at,
                    'bg'    => '#d946ef',
                    'svg'   => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>',
                    'svgProps' => 'fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"',
                ]);
            });

        // Sort by time desc, take top N, format time
        return $items
            ->sortByDesc(fn($item) => $item['time'])
            ->take($limit)
            ->map(function ($item) {
                $item['time'] = $item['time']->diffForHumans();
                return $item;
            })
            ->values()
            ->toArray();
    }
}
