<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskSubtask;
use App\Models\TaskHistory;


class TaskSubtaskController extends Controller
{
public function store(Request $request, Task $task)
{
    abort_if($task->user_id !== auth()->id(), 403);

    $request->validate([
        'title' => 'required|string|max:255',
    ]);

    $subtask = $task->subtasks()->create([
        'title' => $request->title,
    ]);

    TaskHistory::create([
        'task_id' => $task->id,
        'user_id' => auth()->id(),
        'action' => 'Subtask Added',
        'changes' => 'Added subtask: ' . $subtask->title,
    ]);

    return back()->with('success', 'Subtask added.');
}

public function toggle(TaskSubtask $subtask)
{
    abort_if($subtask->task->user_id !== auth()->id(), 403);

    $oldStatus = $subtask->is_completed ? 'Completed' : 'Incomplete';
    $newStatus = !$subtask->is_completed ? 'Completed' : 'Incomplete';

    $subtask->update([
        'is_completed' => !$subtask->is_completed,
    ]);

    TaskHistory::create([
        'task_id' => $subtask->task_id,
        'user_id' => auth()->id(),
        'action' => 'Subtask ' . $newStatus,
        'changes' => $subtask->title . ' changed from ' . $oldStatus . ' to ' . $newStatus,
    ]);

    return back()->with('success', 'Subtask status updated.');
}

public function destroy(TaskSubtask $subtask)
{
    abort_if($subtask->task->user_id !== auth()->id(), 403);

    $taskId = $subtask->task_id;
    $title = $subtask->title;

    TaskHistory::create([
        'task_id' => $taskId,
        'user_id' => auth()->id(),
        'action' => 'Subtask Deleted',
        'changes' => 'Deleted subtask: ' . $title,
    ]);

    $subtask->delete();

    return back()->with('success', 'Subtask deleted.');
}
}
