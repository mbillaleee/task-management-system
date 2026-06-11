<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HabitCategory;

class HabitCategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);

        HabitCategory::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'color'   => $request->color,
        ]);

        return back()->with('success', 'Category created.');
    }

    public function update(Request $request, HabitCategory $habitCategory)
    {
        abort_if($habitCategory->user_id !== auth()->id(), 403);

        $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);

        $habitCategory->update([
            'name'  => $request->name,
            'color' => $request->color,
        ]);

        return back()->with('success', 'Category updated.');
    }

    public function destroy(HabitCategory $habitCategory)
    {
        abort_if($habitCategory->user_id !== auth()->id(), 403);

        $habitCategory->delete();

        return back()->with('success', 'Category deleted.');
    }
}
