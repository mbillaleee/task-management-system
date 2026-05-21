<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\TaskLabel;
use App\Models\TaskHistory;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $tasks = Task::with(['category', 'labels', 'subtasks'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

         $categories = TaskCategory::where('user_id', auth()->id())->get();
        $labels = TaskLabel::where('user_id', auth()->id())->get();

        return view('user.tasks.create', compact('categories', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_category_id' => 'nullable|exists:task_categories,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'labels' => 'nullable|array',
        ]);

        $task = Task::create([
            'user_id' => auth()->id(),
            'task_category_id' => $request->task_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

        if ($request->has('labels')) {
            $task->labels()->sync($request->labels);
        }

        TaskHistory::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'action' => 'Task Created',
            'changes' => 'New task created',
        ]);

        return redirect()->route('user.tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with(['category', 'labels', 'subtasks', 'comments.user', 'histories'])->findOrFail($id);
        abort_if($task->user_id !== auth()->id(), 403);

        return view('user.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        abort_if($task->user_id !== auth()->id(), 403);

        $categories = TaskCategory::where('user_id', auth()->id())->get();
        $labels = TaskLabel::where('user_id', auth()->id())->get();


        return view('user.tasks.edit', compact('task', 'categories', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);
        abort_if($task->user_id !== auth()->id(), 403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_category_id' => 'nullable|exists:task_categories,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'labels' => 'nullable|array',
        ]);

        $originalData = $task->getOriginal();

        $task->update([
            'task_category_id' => $request->task_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
            'due_date' => $request->due_date,
        ]);

        if ($request->has('labels')) {
            $task->labels()->sync($request->labels);
        } else {
            $task->labels()->detach();
        }

        // Log changes
        $changes = [];
        foreach ($task->getChanges() as $field => $newValue) {
            $changes[$field] = [
                'old' => $originalData[$field] ?? null,
                'new' => $newValue,
            ];
        }

        if (!empty($changes)) {
            TaskHistory::create([
                'task_id' => $task->id,
                'user_id' => auth()->id(),
                'action' => 'Task Updated',
                'changes' => json_encode($changes),
            ]);
        }

        return redirect()->route('user.tasks.show', $task)->with('success', 'Task updated successfully.');

        // dd($request->all());

        $task = Task::findOrFail($id);

        abort_if($task->user_id !== auth()->id(), 403);

        $oldStatus = $task->status;

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_category_id' => 'nullable|exists:task_categories,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'labels' => 'nullable|array',
        ]);

        $task->update($request->only([
            'title',
            'description',
            'task_category_id',
            'priority',
            'status',
            'due_date',
        ]));

        $task->labels()->sync($request->labels ?? []);

        if ($oldStatus !== $request->status) {
            TaskHistory::create([
                'task_id' => $task->id,
                'user_id' => auth()->id(),
                'action' => 'Status Changed',
                'changes' => "Status changed from {$oldStatus} to {$request->status}",
            ]);
        }

        return redirect()->route('user.tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        abort_if($task->user_id !== auth()->id(), 403);

        $task->delete();
        return redirect()->route('user.tasks.index')->with('success', 'Task deleted successfully.');

        // abort_if($task->user_id !== auth()->id(), 403);
        // $task->delete();
        // return redirect()->route('user.tasks.index')->with('success', 'Task deleted successfully.');
    }



    public function kanban()
    {
        $tasks = Task::with(['category', 'labels'])
            ->where('user_id', auth()->id())
            ->get()
            ->groupBy('status');

        return view('user.tasks.kanban', compact('tasks'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $oldStatus = $task->status;

        $task->update([
            'status' => $request->status,
        ]);

        TaskHistory::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'action' => 'Status Updated',
            'changes' => "Status changed from {$oldStatus} to {$request->status}",
        ]);

        return back()->with('success', 'Task status updated.');
    }
}
