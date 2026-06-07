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
            'users as completed_count' => fn($q) => $q->wherePivot('is_completed', true),
        ])->latest()->paginate(12);

        return view('admin.gamification.challenges', compact('challenges'));
    }

    /**
     * Route: POST /admin/challenges
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'type'         => 'required|in:daily,weekly,monthly',
            'target_value' => 'required|integer|min:1',
            'xp_reward'    => 'required|integer|min:1',
            'reward_title' => 'nullable|string|max:255',
            'is_active'    => 'nullable|boolean',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
        ]);

        Challenge::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'type'         => $request->type,
            'target_value' => $request->target_value,
            'xp_reward'    => $request->xp_reward,
            'reward_title' => $request->reward_title,
            'is_active'    => $request->boolean('is_active'),
            'start_date'   => $request->start_date,
            'end_date'     => $request->end_date,
        ]);

        return back()->with('success', 'Challenge created successfully.');
    }

    /**
     * Route: PUT /admin/challenges/{challenge}
     */
    public function update(Request $request, Challenge $challenge)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'type'         => 'required|in:daily,weekly,monthly',
            'target_value' => 'required|integer|min:1',
            'xp_reward'    => 'required|integer|min:1',
            'reward_title' => 'nullable|string|max:255',
            'is_active'    => 'nullable|boolean',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
        ]);

        $challenge->update([
            'title'        => $request->title,
            'description'  => $request->description,
            'type'         => $request->type,
            'target_value' => $request->target_value,
            'xp_reward'    => $request->xp_reward,
            'reward_title' => $request->reward_title,
            'is_active'    => $request->boolean('is_active'),
            'start_date'   => $request->start_date,
            'end_date'     => $request->end_date,
        ]);

        return back()->with('success', 'Challenge updated successfully.');
    }

    /**
     * Route: DELETE /admin/challenges/{challenge}
     */
    public function destroy(Challenge $challenge)
    {
        $challenge->delete();

        return back()->with('success', 'Challenge deleted successfully.');
    }
}