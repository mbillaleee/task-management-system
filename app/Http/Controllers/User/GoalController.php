<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use App\Models\GoalCategory;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index(Request $request)
    {
        $query = Goal::with(['category', 'milestones'])
            ->where('user_id', auth()->id());

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->goal_category_id) {
            $query->where('goal_category_id', $request->goal_category_id);
        }

        $goals = $query->latest()->paginate(10)->withQueryString();

        $categories = GoalCategory::where('user_id', auth()->id())->latest()->get();

        $totalGoals = Goal::where('user_id', auth()->id())->count();
        $completedGoals = Goal::where('user_id', auth()->id())->where('status', 'completed')->count();
        $activeGoals = Goal::where('user_id', auth()->id())->where('status', 'in_progress')->count();
        $totalXp = Goal::where('user_id', auth()->id())->sum('xp_earned');

        return view('user.goals.index', compact(
            'goals',
            'categories',
            'totalGoals',
            'completedGoals',
            'activeGoals',
            'totalXp'
        ));
    }

    public function create()
    {
        $categories = GoalCategory::where('user_id', auth()->id())->latest()->get();

        return view('user.goals.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'goal_category_id' => 'nullable|exists:goal_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:short_term,long_term',
            'status' => 'required|in:not_started,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date|after_or_equal:start_date',
        ]);

        $goal = Goal::create([
            'user_id' => auth()->id(),
            'goal_category_id' => $request->goal_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'status' => $request->status,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'progress' => $request->status === 'completed' ? 100 : 0,
            'completed_at' => $request->status === 'completed' ? now() : null,
            'xp_earned' => $request->status === 'completed' ? 50 : 0,
        ]);

        return redirect()->route('user.goals.show', $goal)->with('success', 'Goal created successfully.');
    }

    public function show(Goal $goal)
    {
        abort_if($goal->user_id !== auth()->id(), 403);

        $goal->load(['category', 'milestones']);

        return view('user.goals.show', compact('goal'));
    }

    public function edit(Goal $goal)
    {
        abort_if($goal->user_id !== auth()->id(), 403);

        $categories = GoalCategory::where('user_id', auth()->id())->latest()->get();

        return view('user.goals.edit', compact('goal', 'categories'));
    }

    public function update(Request $request, Goal $goal)
    {
        abort_if($goal->user_id !== auth()->id(), 403);

        $request->validate([
            'goal_category_id' => 'nullable|exists:goal_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:short_term,long_term',
            'status' => 'required|in:not_started,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date|after_or_equal:start_date',
        ]);

        $xp = $goal->xp_earned;
        $completedAt = $goal->completed_at;

        if ($request->status === 'completed' && $goal->status !== 'completed') {
            $xp += 50;
            $completedAt = now();
        }

        if ($request->status !== 'completed') {
            $completedAt = null;
        }

        $goal->update([
            'goal_category_id' => $request->goal_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'status' => $request->status,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'completed_at' => $completedAt,
            'xp_earned' => $xp,
        ]);

        $this->syncProgress($goal);

        return redirect()->route('user.goals.show', $goal)->with('success', 'Goal updated successfully.');
    }

    public function destroy(Goal $goal)
    {
        abort_if($goal->user_id !== auth()->id(), 403);

        $goal->delete();

        return redirect()->route('user.goals.index')->with('success', 'Goal deleted successfully.');
    }

    private function syncProgress(Goal $goal): void
    {
        $total = $goal->milestones()->count();
        $completed = $goal->milestones()->where('is_completed', true)->count();

        $progress = $total > 0 ? round(($completed / $total) * 100) : $goal->progress;

        if ($goal->status === 'completed') {
            $progress = 100;
        }

        $goal->update([
            'progress' => $progress,
        ]);
    }
}