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
            ->latest()
            ->paginate(10);

        return view('user.habits.index', compact('habits'));
    }

    public function create()
    {
        $categories = HabitCategory::where('user_id', auth()->id())->get();

        return view('user.habits.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'habit_category_id' => 'nullable|exists:habit_categories,id',
            'type' => 'required|in:positive,negative',
            'frequency' => 'required|in:daily,weekly',
            'days' => 'nullable|array',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
        ]);

        $habit = Habit::create([
            'user_id' => auth()->id(),
            'habit_category_id' => $request->habit_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'frequency' => $request->frequency,
            'days' => $request->frequency === 'weekly' ? $request->days : null,
            'start_date' => $request->start_date ?? now(),
            'status' => true,
        ]);

        HabitStreak::create([
            'habit_id' => $habit->id,
            'user_id' => auth()->id(),
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

        $habit->load(['category', 'logs' => fn ($q) => $q->latest(), 'streak']);

        return view('user.habits.show', compact('habit'));
    }

    public function board()
    {
        $habits = Habit::with(['category', 'todayLog', 'streak'])
            ->where('user_id', auth()->id())
            ->get()
            ->groupBy('frequency');

        return view('user.habits.board', compact('habits'));
    }

    public function update(Request $request, Habit $habit)
    {
        abort_if($habit->user_id !== auth()->id(), 403);

        $request->validate([
            'title' => 'required|string|max:255',
            'habit_category_id' => 'nullable|exists:habit_categories,id',
            'type' => 'required|in:positive,negative',
            'frequency' => 'required|in:daily,weekly',
            'days' => 'nullable|array',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $habit->update([
            'habit_category_id' => $request->habit_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'frequency' => $request->frequency,
            'days' => $request->frequency === 'weekly' ? $request->days : null,
            'status' => $request->boolean('status'),
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