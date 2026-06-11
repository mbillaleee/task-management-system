<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Habit;
use App\Models\HabitCategory;
use App\Models\HabitStreak;
use App\Models\HabitLog;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    public function index()
    {
        $habits = Habit::with(['category', 'todayLog', 'streak'])
            ->where('user_id', auth()->id())
            ->where('status', true)
            ->latest()
            ->paginate(12);

        $categories = HabitCategory::where('user_id', auth()->id())->get();

        $todayStats = [
            'total'     => $habits->total(),
            'completed' => Habit::where('user_id', auth()->id())
                ->where('status', true)
                ->whereHas('todayLog', fn($q) => $q->where('is_completed', true))
                ->count(),
        ];

        return view('user.habits.index', compact('habits', 'categories', 'todayStats'));
    }

    public function allHabits()
    {
        $habits = Habit::with(['category', 'todayLog', 'streak'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        $categories = HabitCategory::where('user_id', auth()->id())->get();

        return view('user.habits.all_habits', compact('habits', 'categories'));
    }

    public function create()
    {
        $categories = HabitCategory::where('user_id', auth()->id())->get();

        return view('user.habits.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'habit_category_id'=> 'nullable|exists:habit_categories,id',
            'type'             => 'required|in:positive,negative',
            'frequency'        => 'required|in:daily,weekly',
            'days'             => 'nullable|array',
            'description'      => 'nullable|string',
            'start_date'       => 'nullable|date',
            'reminder_enabled' => 'nullable|boolean',
            'remind_time'      => 'nullable|date_format:H:i',
        ]);

        $habit = Habit::create([
            'user_id'           => auth()->id(),
            'habit_category_id' => $request->habit_category_id,
            'title'             => $request->title,
            'description'       => $request->description,
            'type'              => $request->type,
            'frequency'         => $request->frequency,
            'days'              => $request->frequency === 'weekly' ? $request->days : null,
            'start_date'        => $request->start_date ?? today(),
            'status'            => true,
            'reminder_enabled'  => $request->boolean('reminder_enabled'),
            'remind_time'       => $request->boolean('reminder_enabled') ? $request->remind_time : null,
        ]);

        HabitStreak::create([
            'habit_id' => $habit->id,
            'user_id'  => auth()->id(),
        ]);

        return redirect()->route('user.habits.index')->with('success', 'Habit created successfully.');
    }

    public function edit(Habit $habit)
    {
        abort_if($habit->user_id !== auth()->id(), 403);

        $categories = HabitCategory::where('user_id', auth()->id())->get();

        return view('user.habits.edit', compact('habit', 'categories'));
    }

    public function show(Habit $habit)
    {
        abort_if($habit->user_id !== auth()->id(), 403);

        $habit->load(['category', 'streak', 'recentLogs']);

        // Build 90-day heatmap data: date => completed bool
        $heatmap = [];
        for ($i = 89; $i >= 0; $i--) {
            $date           = now()->subDays($i)->format('Y-m-d');
            $heatmap[$date] = false;
        }
        foreach ($habit->recentLogs as $log) {
            $heatmap[$log->log_date->format('Y-m-d')] = true;
        }

        // Last 30 logs for log list
        $logs = $habit->logs()->latest('log_date')->take(30)->get();

        return view('user.habits.show', compact('habit', 'heatmap', 'logs'));
    }

    public function board()
    {
        $habits = Habit::with(['category', 'todayLog', 'streak'])
            ->where('user_id', auth()->id())
            ->where('status', true)
            ->get()
            ->groupBy('frequency');

        return view('user.habits.board', compact('habits'));
    }

    public function update(Request $request, Habit $habit)
    {
        abort_if($habit->user_id !== auth()->id(), 403);

        $request->validate([
            'title'             => 'required|string|max:255',
            'habit_category_id' => 'nullable|exists:habit_categories,id',
            'type'              => 'required|in:positive,negative',
            'frequency'         => 'required|in:daily,weekly',
            'days'              => 'nullable|array',
            'description'       => 'nullable|string',
            'status'            => 'nullable|boolean',
            'reminder_enabled'  => 'nullable|boolean',
            'remind_time'       => 'nullable|date_format:H:i',
        ]);

        $habit->update([
            'habit_category_id' => $request->habit_category_id,
            'title'             => $request->title,
            'description'       => $request->description,
            'type'              => $request->type,
            'frequency'         => $request->frequency,
            'days'              => $request->frequency === 'weekly' ? $request->days : null,
            'status'            => $request->boolean('status'),
            'reminder_enabled'  => $request->boolean('reminder_enabled'),
            'remind_time'       => $request->boolean('reminder_enabled') ? $request->remind_time : null,
        ]);

        return redirect()->route('user.habits.index')->with('success', 'Habit updated successfully.');
    }

    public function destroy(Habit $habit)
    {
        abort_if($habit->user_id !== auth()->id(), 403);

        $habit->delete();

        return back()->with('success', 'Habit deleted successfully.');
    }
}
