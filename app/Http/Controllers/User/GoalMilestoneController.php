<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use App\Models\GoalMilestone;
use Illuminate\Http\Request;
use App\Services\GamificationService;

class GoalMilestoneController extends Controller
{
    public function store(Request $request, Goal $goal)
    {
        abort_if($goal->user_id !== auth()->id(), 403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $goal->milestones()->create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        $this->syncGoalProgress($goal);

        return back()->with('success', 'Milestone added.');
    }

    public function toggle(GoalMilestone $milestone)
    {
        abort_if($milestone->goal->user_id !== auth()->id(), 403);

        $wasCompleted = $milestone->is_completed;

        $milestone->update([
            'is_completed' => ! $milestone->is_completed,
        ]);

        $this->syncGoalProgress($milestone->goal);

        // ✅ XP Award: milestone complete হলে
        if (! $wasCompleted && $milestone->is_completed) {
            GamificationService::awardXp(
                auth()->id(),
                15,
                'Milestone completed: ' . $milestone->title
            );
        }

        return back()->with('success', 'Milestone updated.');
    }

    public function destroy(GoalMilestone $milestone)
    {
        abort_if($milestone->goal->user_id !== auth()->id(), 403);

        $goal = $milestone->goal;

        $milestone->delete();

        $this->syncGoalProgress($goal);

        return back()->with('success', 'Milestone deleted.');
    }

    private function syncGoalProgress(Goal $goal): void
    {
        $total = $goal->milestones()->count();
        $completed = $goal->milestones()->where('is_completed', true)->count();

        $progress = $total > 0 ? round(($completed / $total) * 100) : 0;

        $status = $progress === 100 ? 'completed' : ($progress > 0 ? 'in_progress' : 'not_started');

        $goal->update([
            'progress' => $progress,
            'status' => $status,
            'completed_at' => $progress === 100 ? now() : null,
            'xp_earned' => $progress === 100 && $goal->xp_earned == 0 ? 50 : $goal->xp_earned,
        ]);
    }
}