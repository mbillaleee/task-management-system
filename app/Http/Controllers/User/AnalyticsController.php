<?php
 
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Habit;
use App\Models\HabitLog;
use App\Models\HabitStreak;
use App\Models\FocusSession;
use App\Models\Goal;
use App\Models\Journal;
use App\Models\UserGamification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    private function userId(): int
    {
        return Auth::id();
    }

    // ─────────────────────────────────────────────
    // OVERVIEW — /user/analytics
    // ─────────────────────────────────────────────
    public function index()
    {
        $uid = $this->userId();

        // ── Tasks ──
        $totalTasks     = Task::where('user_id', $uid)->count();
        $completedTasks = Task::where('user_id', $uid)->where('status', 'completed')->count();
        $overdueTasks   = Task::where('user_id', $uid)
            ->where('status', '!=', 'completed')
            ->whereNotNull('due_date')
            ->where('due_date', '<', today())
            ->count();
        $taskRate = $totalTasks > 0 ? round($completedTasks / $totalTasks * 100) : 0;

        // ── Habits ──
        $totalHabits     = Habit::where('user_id', $uid)->where('status', true)->count();
        $todayCompleted  = HabitLog::whereHas('habit', fn($q) => $q->where('user_id', $uid))
            ->whereDate('log_date', today())
            ->where('is_completed', true)
            ->count();
        $habitRate = $totalHabits > 0 ? round($todayCompleted / $totalHabits * 100) : 0;
        $bestStreak = HabitStreak::whereHas('habit', fn($q) => $q->where('user_id', $uid))
            ->max('best_streak') ?? 0;

        // ── Focus ──
        $totalFocusMin  = FocusSession::where('user_id', $uid)
            ->where('status', 'completed')
            ->sum('completed_minutes');
        $totalFocusSessions = FocusSession::where('user_id', $uid)
            ->where('status', 'completed')
            ->count();
        $focusHours = round($totalFocusMin / 60, 1);

        // ── Goals ──
        $totalGoals     = Goal::where('user_id', $uid)->count();
        $completedGoals = Goal::where('user_id', $uid)->where('status', 'completed')->count();
        $goalRate       = $totalGoals > 0 ? round($completedGoals / $totalGoals * 100) : 0;

        // ── Journals ──
        $totalJournals  = Journal::where('user_id', $uid)->count();
        $journalStreak  = $this->calcJournalStreak($uid);

        // ── XP / Level ──
        $gamification   = UserGamification::where('user_id', $uid)->first();
        $totalXp        = $gamification?->xp ?? 0;
        $level          = $gamification?->level ?? 1;

        // ── Weekly activity (last 7 days) ──
        $weeklyActivity = $this->weeklyActivity($uid);

        // ── Monthly task completion (last 30 days) ──
        $monthlyTasks   = $this->monthlyTaskCompletion($uid);

        // ── Top productive day ──
        $topDay = $this->topProductiveDay($uid);

        // ── Productivity score (0-100) ──
        $productivityScore = $this->productivityScore(
            $taskRate, $habitRate, $goalRate, $totalFocusMin
        );

        return view('user.analytics.index', compact(
            'totalTasks','completedTasks','overdueTasks','taskRate',
            'totalHabits','todayCompleted','habitRate','bestStreak',
            'focusHours','totalFocusSessions','totalFocusMin',
            'totalGoals','completedGoals','goalRate',
            'totalJournals','journalStreak',
            'totalXp','level',
            'weeklyActivity','monthlyTasks','topDay',
            'productivityScore'
        ));
    }

    // ─────────────────────────────────────────────
    // PRODUCTIVITY ANALYTICS — /user/analytics/productivity
    // ─────────────────────────────────────────────
    public function productivity(Request $request)
    {
        $uid    = $this->userId();
        $period = $request->get('period', '30'); // 7, 30, 90

        $from = now()->subDays((int)$period - 1)->startOfDay();

        // Tasks completed per day
        $tasksByDay = Task::where('user_id', $uid)
            ->where('status', 'completed')
            ->where('updated_at', '>=', $from)
            ->selectRaw('DATE(updated_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Fill all days in range
        $taskChart = [];
        for ($i = (int)$period - 1; $i >= 0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $taskChart[] = [
                'date'  => $d,
                'label' => Carbon::parse($d)->format('d M'),
                'count' => $tasksByDay[$d]?->count ?? 0,
            ];
        }

        // Priority breakdown
        $priorityBreakdown = Task::where('user_id', $uid)
            ->where('status', 'completed')
            ->selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority');

        // Status breakdown (all tasks)
        $statusBreakdown = Task::where('user_id', $uid)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Average tasks per day
        $completedInPeriod = Task::where('user_id', $uid)
            ->where('status', 'completed')
            ->where('updated_at', '>=', $from)
            ->count();
        $avgPerDay = round($completedInPeriod / max(1, (int)$period), 1);

        // Overdue rate
        $totalDue = Task::where('user_id', $uid)->whereNotNull('due_date')->count();
        $overdue  = Task::where('user_id', $uid)
            ->where('status', '!=', 'completed')
            ->whereNotNull('due_date')
            ->where('due_date', '<', today())
            ->count();
        $overdueRate = $totalDue > 0 ? round($overdue / $totalDue * 100) : 0;

        // Category breakdown
        $categoryBreakdown = Task::where('tasks.user_id', $uid)
            ->where('tasks.status', 'completed')
            ->leftJoin('task_categories', 'tasks.task_category_id', '=', 'task_categories.id')
            ->selectRaw('COALESCE(task_categories.name, "Uncategorized") as name, COUNT(*) as count')
            ->groupBy('task_categories.name')
            ->orderByDesc('count')
            ->take(6)
            ->get();

        // Completion streak (consecutive days with ≥1 task completed)
        $completionStreak = $this->taskCompletionStreak($uid);

        return view('user.analytics.productivity', compact(
            'period','taskChart','priorityBreakdown','statusBreakdown',
            'avgPerDay','overdueRate','categoryBreakdown',
            'completedInPeriod','completionStreak'
        ));
    }

    // ─────────────────────────────────────────────
    // HABIT ANALYTICS — /user/analytics/habits
    // ─────────────────────────────────────────────
    public function habits(Request $request)
    {
        $uid    = $this->userId();
        $period = $request->get('period', '30');
        $from   = now()->subDays((int)$period - 1)->startOfDay();

        // All active habits
        $habits = Habit::with(['logs', 'streak'])
            ->where('user_id', $uid)
            ->where('status', true)
            ->get()
            ->map(function ($habit) use ($period) {
                $done = $habit->logs()
                    ->where('is_completed', true)
                    ->where('log_date', '>=', now()->subDays((int)$period - 1))
                    ->count();
                $rate = round($done / max(1, (int)$period) * 100);
                return [
                    'id'      => $habit->id,
                    'title'   => $habit->title,
                    'type'    => $habit->type,
                    'streak'  => $habit->streak?->current_streak ?? 0,
                    'best'    => $habit->streak?->best_streak ?? 0,
                    'done'    => $done,
                    'rate'    => $rate,
                ];
            })
            ->sortByDesc('rate')
            ->values();

        // Daily completions (habit logs per day, last N days)
        $dailyCompletions = HabitLog::whereHas('habit', fn($q) => $q->where('user_id', $uid))
            ->where('is_completed', true)
            ->where('log_date', '>=', $from)
            ->selectRaw('DATE(log_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $habitChart = [];
        for ($i = (int)$period - 1; $i >= 0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $habitChart[] = [
                'date'  => $d,
                'label' => Carbon::parse($d)->format('d M'),
                'count' => $dailyCompletions[$d]?->count ?? 0,
            ];
        }

        // Overall stats
        $totalLogs      = HabitLog::whereHas('habit', fn($q) => $q->where('user_id', $uid))
            ->where('is_completed', true)->count();
        $bestStreak     = HabitStreak::whereHas('habit', fn($q) => $q->where('user_id', $uid))
            ->max('best_streak') ?? 0;
        $currentStreak  = HabitStreak::whereHas('habit', fn($q) => $q->where('user_id', $uid))
            ->max('current_streak') ?? 0;
        $totalHabits    = Habit::where('user_id', $uid)->where('status', true)->count();
        $avgRate        = $habits->avg('rate') ?? 0;

        // Heatmap data (last 90 days)
        $heatmap = HabitLog::whereHas('habit', fn($q) => $q->where('user_id', $uid))
            ->where('is_completed', true)
            ->where('log_date', '>=', now()->subDays(89))
            ->selectRaw('DATE(log_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        return view('user.analytics.habits', compact(
            'period','habits','habitChart','totalLogs',
            'bestStreak','currentStreak','totalHabits',
            'avgRate','heatmap'
        ));
    }

    // ─────────────────────────────────────────────
    // FOCUS ANALYTICS — /user/analytics/focus
    // ─────────────────────────────────────────────
    public function focus(Request $request)
    {
        $uid    = $this->userId();
        $period = $request->get('period', '30');
        $from   = now()->subDays((int)$period - 1)->startOfDay();

        // Daily focus minutes
        $dailyFocus = FocusSession::where('user_id', $uid)
            ->where('status', 'completed')
            ->where('completed_at', '>=', $from)
            ->selectRaw('DATE(completed_at) as date, SUM(completed_minutes) as minutes, COUNT(*) as sessions')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $focusChart = [];
        for ($i = (int)$period - 1; $i >= 0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $focusChart[] = [
                'date'     => $d,
                'label'    => Carbon::parse($d)->format('d M'),
                'minutes'  => $dailyFocus[$d]?->minutes ?? 0,
                'sessions' => $dailyFocus[$d]?->sessions ?? 0,
            ];
        }

        // Summary stats
        $totalMin      = FocusSession::where('user_id', $uid)->where('status', 'completed')->sum('completed_minutes');
        $totalSessions = FocusSession::where('user_id', $uid)->where('status', 'completed')->count();
        $totalXp       = FocusSession::where('user_id', $uid)->where('status', 'completed')->sum('xp_earned');
        $avgPerSession = $totalSessions > 0 ? round($totalMin / $totalSessions) : 0;
        $totalHours    = round($totalMin / 60, 1);

        // Ambient sound breakdown
        $soundBreakdown = FocusSession::where('user_id', $uid)
            ->where('status', 'completed')
            ->selectRaw('COALESCE(ambient_sound, "none") as sound, COUNT(*) as count')
            ->groupBy('ambient_sound')
            ->pluck('count', 'sound');

        // Best focus day (most minutes in a single day)
        $bestDay = FocusSession::where('user_id', $uid)
            ->where('status', 'completed')
            ->selectRaw('DATE(completed_at) as date, SUM(completed_minutes) as minutes')
            ->groupBy('date')
            ->orderByDesc('minutes')
            ->first();

        // Period stats
        $periodMin = FocusSession::where('user_id', $uid)
            ->where('status', 'completed')
            ->where('completed_at', '>=', $from)
            ->sum('completed_minutes');
        $periodSessions = FocusSession::where('user_id', $uid)
            ->where('status', 'completed')
            ->where('completed_at', '>=', $from)
            ->count();

        return view('user.analytics.focus', compact(
            'period','focusChart','totalMin','totalSessions',
            'totalXp','avgPerSession','totalHours',
            'soundBreakdown','bestDay','periodMin','periodSessions'
        ));
    }

    // ─────────────────────────────────────────────
    // WEEKLY REPORT — /user/analytics/weekly
    // ─────────────────────────────────────────────
    public function weekly(Request $request)
    {
        $uid     = $this->userId();
        $weekOffset = (int)$request->get('week', 0); // 0 = this week, 1 = last week, etc.
        $start   = now()->startOfWeek()->subWeeks($weekOffset);
        $end     = (clone $start)->endOfWeek();

        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $day = (clone $start)->addDays($i);
            $date = $day->format('Y-m-d');
            $days[] = [
                'label'   => $day->format('D'),
                'date'    => $date,
                'tasks'   => Task::where('user_id', $uid)
                    ->where('status', 'completed')
                    ->whereDate('updated_at', $date)->count(),
                'habits'  => HabitLog::whereHas('habit', fn($q) => $q->where('user_id', $uid))
                    ->where('is_completed', true)
                    ->whereDate('log_date', $date)->count(),
                'focus'   => FocusSession::where('user_id', $uid)
                    ->where('status', 'completed')
                    ->whereDate('completed_at', $date)
                    ->sum('completed_minutes'),
                'journals'=> Journal::where('user_id', $uid)
                    ->whereDate('journal_date', $date)->count(),
            ];
        }

        $weekLabel = $weekOffset === 0
            ? 'This Week'
            : ($weekOffset === 1 ? 'Last Week' : $start->format('d M') . ' – ' . $end->format('d M Y'));

        // Week totals
        $weekTasks   = collect($days)->sum('tasks');
        $weekHabits  = collect($days)->sum('habits');
        $weekFocus   = collect($days)->sum('focus');
        $weekJournal = collect($days)->sum('journals');

        // Compare with previous week
        $prevStart = (clone $start)->subWeek();
        $prevEnd   = (clone $end)->subWeek();
        $prevTasks = Task::where('user_id', $uid)
            ->where('status', 'completed')
            ->whereBetween('updated_at', [$prevStart, $prevEnd])->count();
        $prevFocus = FocusSession::where('user_id', $uid)
            ->where('status', 'completed')
            ->whereBetween('completed_at', [$prevStart, $prevEnd])
            ->sum('completed_minutes');

        $taskChange  = $prevTasks > 0 ? round(($weekTasks - $prevTasks) / $prevTasks * 100) : 0;
        $focusChange = $prevFocus > 0 ? round(($weekFocus - $prevFocus) / $prevFocus * 100) : 0;

        // XP earned this week
        $weekXp = FocusSession::where('user_id', $uid)
            ->where('status', 'completed')
            ->whereBetween('completed_at', [$start, $end])
            ->sum('xp_earned');

        return view('user.analytics.weekly', compact(
            'days','weekLabel','weekOffset',
            'weekTasks','weekHabits','weekFocus','weekJournal',
            'taskChange','focusChange','weekXp',
            'start','end'
        ));
    }

    // ─────────────────────────────────────────────
    // MONTHLY REPORT — /user/analytics/monthly
    // ─────────────────────────────────────────────
    public function monthly(Request $request)
    {
        $uid         = $this->userId();
        $monthOffset = (int)$request->get('month', 0);
        $date        = now()->subMonths($monthOffset);
        $start       = $date->copy()->startOfMonth();
        $end         = $date->copy()->endOfMonth();
        $monthLabel  = $date->format('F Y');

        // Daily breakdown for the month
        $daysInMonth = $start->daysInMonth;
        $days = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $d = $start->copy()->addDays($i - 1)->format('Y-m-d');
            $days[] = [
                'day'     => $i,
                'date'    => $d,
                'tasks'   => Task::where('user_id', $uid)
                    ->where('status', 'completed')
                    ->whereDate('updated_at', $d)->count(),
                'habits'  => HabitLog::whereHas('habit', fn($q) => $q->where('user_id', $uid))
                    ->where('is_completed', true)
                    ->whereDate('log_date', $d)->count(),
                'focus'   => FocusSession::where('user_id', $uid)
                    ->where('status', 'completed')
                    ->whereDate('completed_at', $d)
                    ->sum('completed_minutes'),
            ];
        }

        // Month totals
        $monthTasks   = Task::where('user_id', $uid)
            ->where('status', 'completed')
            ->whereBetween('updated_at', [$start, $end])->count();
        $monthHabits  = HabitLog::whereHas('habit', fn($q) => $q->where('user_id', $uid))
            ->where('is_completed', true)
            ->whereBetween('log_date', [$start->toDateString(), $end->toDateString()])->count();
        $monthFocus   = FocusSession::where('user_id', $uid)
            ->where('status', 'completed')
            ->whereBetween('completed_at', [$start, $end])
            ->sum('completed_minutes');
        $monthJournal = Journal::where('user_id', $uid)
            ->whereBetween('journal_date', [$start->toDateString(), $end->toDateString()])->count();
        $monthGoals   = Goal::where('user_id', $uid)
            ->where('status', 'completed')
            ->whereBetween('completed_at', [$start, $end])->count();

        // Compare with previous month
        $prevStart    = $start->copy()->subMonth();
        $prevEnd      = $end->copy()->subMonth();
        $prevTasks    = Task::where('user_id', $uid)
            ->where('status', 'completed')
            ->whereBetween('updated_at', [$prevStart, $prevEnd])->count();
        $prevFocus    = FocusSession::where('user_id', $uid)
            ->where('status', 'completed')
            ->whereBetween('completed_at', [$prevStart, $prevEnd])
            ->sum('completed_minutes');
        $taskChange   = $prevTasks > 0 ? round(($monthTasks - $prevTasks) / $prevTasks * 100) : 0;
        $focusChange  = $prevFocus > 0 ? round(($monthFocus - $prevFocus) / $prevFocus * 100) : 0;

        // Top habit of the month
        $topHabit = Habit::where('user_id', $uid)
            ->withCount(['logs as month_completions' => fn($q) =>
                $q->where('is_completed', true)
                  ->whereBetween('log_date', [$start->toDateString(), $end->toDateString()])
            ])
            ->orderByDesc('month_completions')
            ->first();

        return view('user.analytics.monthly', compact(
            'monthLabel','monthOffset','days','daysInMonth',
            'monthTasks','monthHabits','monthFocus','monthJournal','monthGoals',
            'taskChange','focusChange','topHabit','start','end'
        ));
    }

    // ─────────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────────
    private function weeklyActivity(int $uid): array
    {
        $result = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $result[] = [
                'label'   => now()->subDays($i)->format('D'),
                'date'    => $d,
                'tasks'   => Task::where('user_id', $uid)->where('status', 'completed')->whereDate('updated_at', $d)->count(),
                'habits'  => HabitLog::whereHas('habit', fn($q) => $q->where('user_id', $uid))->where('is_completed', true)->whereDate('log_date', $d)->count(),
                'focus'   => FocusSession::where('user_id', $uid)->where('status', 'completed')->whereDate('completed_at', $d)->sum('completed_minutes'),
            ];
        }
        return $result;
    }

    private function monthlyTaskCompletion(int $uid): array
    {
        $result = [];
        for ($i = 29; $i >= 0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $result[] = [
                'date'  => $d,
                'label' => now()->subDays($i)->format('d'),
                'count' => Task::where('user_id', $uid)->where('status', 'completed')->whereDate('updated_at', $d)->count(),
            ];
        }
        return $result;
    }

    private function topProductiveDay(int $uid): ?string
    {
        $row = Task::where('user_id', $uid)
            ->where('status', 'completed')
            ->selectRaw('DAYNAME(updated_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderByDesc('count')
            ->first();
        return $row?->day;
    }

    private function productivityScore(int $taskRate, int $habitRate, int $goalRate, int $focusMin): int
    {
        $focusScore = min(100, round($focusMin / 3));
        return (int) round(($taskRate * 0.35) + ($habitRate * 0.30) + ($goalRate * 0.20) + ($focusScore * 0.15));
    }

    private function calcJournalStreak(int $uid): int
    {
        $streak = 0;
        $day    = today();
        while (true) {
            $exists = Journal::where('user_id', $uid)->whereDate('journal_date', $day)->exists();
            if (! $exists) break;
            $streak++;
            $day = $day->subDay();
        }
        return $streak;
    }

    private function taskCompletionStreak(int $uid): int
    {
        $streak = 0;
        $day    = today();
        while (true) {
            $done = Task::where('user_id', $uid)->where('status', 'completed')->whereDate('updated_at', $day)->count();
            if ($done === 0) break;
            $streak++;
            $day = $day->subDay();
        }
        return $streak;
    }
}
