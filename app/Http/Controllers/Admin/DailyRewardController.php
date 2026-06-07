<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReward;
use Illuminate\Http\Request;

class DailyRewardController extends Controller
{
    /**
     * List all daily rewards
     * Route: GET /admin/daily-rewards
     */
    public function index()
    {
        $rewards = DailyReward::orderBy('day_number')->get();

        return view('admin.gamification.daily-rewards', compact('rewards'));
    }

    /**
     * Route: POST /admin/daily-rewards
     */
    public function store(Request $request)
    {
        $request->validate([
            'day_number' => 'required|integer|min:1|max:365|unique:daily_rewards,day_number',
            'xp_reward'  => 'required|integer|min:1',
            'title'      => 'nullable|string|max:255',
            'icon'       => 'nullable|string|max:50',
        ]);

        DailyReward::create($request->only('day_number', 'xp_reward', 'title', 'icon'));

        return back()->with('success', 'Daily reward created.');
    }

    /**
     * Route: PUT /admin/daily-rewards/{dailyReward}
     */
    public function update(Request $request, DailyReward $dailyReward)
    {
        $request->validate([
            'day_number' => 'required|integer|min:1|max:365|unique:daily_rewards,day_number,' . $dailyReward->id,
            'xp_reward'  => 'required|integer|min:1',
            'title'      => 'nullable|string|max:255',
            'icon'       => 'nullable|string|max:50',
        ]);

        $dailyReward->update($request->only('day_number', 'xp_reward', 'title', 'icon'));

        return back()->with('success', 'Daily reward updated.');
    }

    /**
     * Route: DELETE /admin/daily-rewards/{dailyReward}
     */
    public function destroy(DailyReward $dailyReward)
    {
        $dailyReward->delete();

        return back()->with('success', 'Daily reward deleted.');
    }
}