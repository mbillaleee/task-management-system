<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    /**
     * List all challenges
     * Route: GET /admin/challenges
     */
    public function index()
    {
        $challenges = Challenge::withCount([
            'users',
            'users as completed_count' => fn($q) => $q->where('user_challenges.is_completed', 1),
        ])->latest()->paginate(12);

        return view('admin.gamification.challenges', compact('challenges'));
    }

    /**
     * Route: POST /admin/challenges
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'type'             => 'required|in:daily,weekly,monthly',
            'challenge_action' => 'required|in:manual,complete_task,log_habit,finish_focus,complete_goal,write_journal,login_streak',
            'target_value'     => 'required|integer|min:1',
            'xp_reward'        => 'required|integer|min:1',
            'reward_title'     => 'nullable|string|max:255',
            'is_active'        => 'nullable|boolean',
            'start_date'       => 'nullable|date',
            'end_date'         => 'nullable|date|after_or_equal:start_date',
        ]);

        Challenge::create($request->only([
            'title', 'description', 'type', 'challenge_action',
            'target_value', 'xp_reward', 'reward_title',
            'start_date', 'end_date',
        ]) + ['is_active' => $request->boolean('is_active')]);

        return back()->with('success', 'Challenge created successfully.');
    }

    /**
     * Route: PUT /admin/challenges/{challenge}
     */
    public function update(Request $request, Challenge $challenge)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'type'             => 'required|in:daily,weekly,monthly',
            'challenge_action' => 'required|in:manual,complete_task,log_habit,finish_focus,complete_goal,write_journal,login_streak',
            'target_value'     => 'required|integer|min:1',
            'xp_reward'        => 'required|integer|min:1',
            'reward_title'     => 'nullable|string|max:255',
            'is_active'        => 'nullable|boolean',
            'start_date'       => 'nullable|date',
            'end_date'         => 'nullable|date|after_or_equal:start_date',
        ]);

        $challenge->update($request->only([
            'title', 'description', 'type', 'challenge_action',
            'target_value', 'xp_reward', 'reward_title',
            'start_date', 'end_date',
        ]) + ['is_active' => $request->boolean('is_active')]);

        return back()->with('success', 'Challenge updated successfully.');
    }

    /**
     * Route: DELETE /admin/challenges/{challenge}
     */
    public function destroy(Challenge $challenge)
    {
        $challenge->delete();
        return back()->with('success', 'Challenge deleted.');
    }
}