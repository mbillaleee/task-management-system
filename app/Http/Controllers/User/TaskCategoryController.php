<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskCategory;

class TaskCategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);

        TaskCategory::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'color' => $request->color,
        ]);

        return back()->with('success', 'Category created.');
    }
}
