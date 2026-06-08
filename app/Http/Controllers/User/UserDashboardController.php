<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Habit;
use App\Models\Language;
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
            'habitScoreLabel'
        ));
    }

    public function updateStatus(Request $request, $languageId)
    {
        // dd($languageId);
        $language = Language::findOrFail($languageId);
        request()->session()->put('locale', $language->language_code);
        $translate = 'Language Changed successfully';
        $success = 'success';
        // toast($translate, $success);
        return back();
    }
}
