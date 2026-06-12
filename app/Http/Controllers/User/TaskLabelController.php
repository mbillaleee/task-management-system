<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskLabel;

class TaskLabelController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);

        TaskLabel::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'color'   => $request->color,
        ]);

        return back()->with('success', 'Label created.');
    }

    public function update(Request $request, TaskLabel $taskLabel)
    {
        abort_if($taskLabel->user_id !== auth()->id(), 403);

        $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);

        $taskLabel->update([
            'name'  => $request->name,
            'color' => $request->color,
        ]);

        return back()->with('success', 'Label updated.');
    }

    public function destroy(TaskLabel $taskLabel)
    {
        
        abort_if($taskLabel->user_id !== auth()->id(), 403);

        $taskLabel->delete();

        return back()->with('success', 'Label deleted.');
    }
}
