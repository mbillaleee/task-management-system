<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
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

        return view('user.dashboard', compact(
            'todayTasks',
            'topPriorities',
            'completedTaskCount',
            'pendingTaskCount',
            'overdueTasks',
            'dailyProgress',
            'todayTotal',
            'todayCompleted'
        ));
    }
}
