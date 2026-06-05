<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GoalCategory;
use Illuminate\Http\Request;

class GoalCategoryController extends Controller
{
    public function index()
{
    $categories = GoalCategory::withCount('goals')
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(12);

    return view('user.goals.categories', compact('categories'));
}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'color' => 'nullable|string|max:30',
        ]);

        GoalCategory::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'color' => $request->color ?? 'orange',
        ]);

        return back()->with('success', 'Goal category created.');
    }

    public function update(Request $request, GoalCategory $category)
{
    abort_if($category->user_id !== auth()->id(), 403);

    $request->validate([
        'name' => 'required|string|max:100',
        'color' => 'nullable|string|max:30',
    ]);

    $category->update([
        'name' => $request->name,
        'color' => $request->color ?? 'orange',
    ]);

    return back()->with('success', 'Goal category updated.');
}

    public function destroy(GoalCategory $category)
    {
        abort_if($category->user_id !== auth()->id(), 403);

        $category->delete();

        return back()->with('success', 'Goal category deleted.');
    }
}