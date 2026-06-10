<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\TaskHistory;

class TaskCommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $task->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        TaskHistory::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'action'  => 'Comment Added',
            'changes' => 'Added comment: ' . $request->comment,
        ]);

        return back()->with('success', 'Comment added.');
    }

    public function destroy(TaskComment $comment)
    {
        abort_if($comment->user_id !== auth()->id(), 403);

        TaskHistory::create([
            'task_id' => $comment->task_id,
            'user_id' => auth()->id(),
            'action'  => 'Comment Deleted',
            'changes' => 'Deleted comment: ' . $comment->comment,
        ]);

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
