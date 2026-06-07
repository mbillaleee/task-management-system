<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * List all badges (admin manages ALL badges globally)
     * Route: GET /admin/badges
     */
    public function index()
    {
        $badges = Badge::withCount('users')->latest()->paginate(12);

        return view('admin.gamification.badges', compact('badges'));
    }

    /**
     * Route: POST /admin/badges
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'icon'         => 'nullable|string|max:50',
            'color'        => 'nullable|string|max:20',
            'xp_required'  => 'required|integer|min:0',
            'is_active'    => 'nullable|boolean',
        ]);

        Badge::create([
            'name'        => $request->name,
            'description' => $request->description,
            'icon'        => $request->icon,
            'color'       => $request->color ?? '#f97316',
            'xp_required' => $request->xp_required,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Badge created successfully.');
    }

    /**
     * Route: PUT /admin/badges/{badge}
     */
    public function update(Request $request, Badge $badge)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:50',
            'color'       => 'nullable|string|max:20',
            'xp_required' => 'required|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        $badge->update([
            'name'        => $request->name,
            'description' => $request->description,
            'icon'        => $request->icon,
            'color'       => $request->color ?? '#f97316',
            'xp_required' => $request->xp_required,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Badge updated successfully.');
    }

    /**
     * Route: DELETE /admin/badges/{badge}
     */
    public function destroy(Badge $badge)
    {
        $badge->delete();

        return back()->with('success', 'Badge deleted successfully.');
    }
}