<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskCategory;
use App\Models\TaskLabel;

class TaskCategoryController extends Controller
{

    public function index()
    {
        $labels = TaskLabel::where('user_id', auth()->id())->get();
        $categories = TaskCategory::where('user_id', auth()->id())->get();
        return view('user.tasks.labels_categories', compact('labels', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);

        TaskCategory::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'color'   => $request->color,
        ]);

        return back()->with('success', 'Category created.');
    }

    public function update(Request $request, TaskCategory $taskCategory)
    {
        abort_if($taskCategory->user_id !== auth()->id(), 403);

        $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);

        $taskCategory->update([
            'name'  => $request->name,
            'color' => $request->color,
        ]);

        return back()->with('success', 'Category updated.');
    }

    public function destroy(TaskCategory $taskCategory)
    {
        abort_if($taskCategory->user_id !== auth()->id(), 403);

        $taskCategory->delete();

        return back()->with('success', 'Category deleted.');
    }
}
