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
    public function index()
    {
        $tasks = Task::with(['category', 'labels', 'subtasks'])
            ->where('user_id', auth()->id())
            ->whereDate('due_date', today())
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderBy('position', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.tasks.index', compact('tasks'));
    }

    public function allTasks()
    {
        $tasks = Task::with(['category', 'labels', 'subtasks'])
            ->where('user_id', auth()->id())
            ->orderBy('position', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('user.tasks.all_tasks', compact('tasks'));
    }

    public function create()
    {
        $categories = TaskCategory::where('user_id', auth()->id())->get();
        $labels     = TaskLabel::where('user_id', auth()->id())->get();

        return view('user.tasks.create', compact('categories', 'labels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'nullable|string',
            'task_category_id'    => 'nullable|exists:task_categories,id',
            'priority'            => 'required|in:low,medium,high',
            'status'              => 'required|in:pending,in_progress,completed',
            'due_date'            => 'nullable|date',
            'due_time'            => 'nullable|date_format:H:i',
            'is_recurring'        => 'nullable|boolean',
            'recurring_type'      => 'nullable|in:daily,weekly,monthly',
            'recurring_end_date'  => 'nullable|date|after_or_equal:due_date',
            'reminder_enabled'    => 'nullable|boolean',
            'remind_at'           => 'nullable|date',
            'labels'              => 'nullable|array',
        ]);

        $task = Task::create([
            'user_id'             => auth()->id(),
            'task_category_id'    => $request->task_category_id,
            'title'               => $request->title,
            'description'         => $request->description,
            'priority'            => $request->priority,
            'status'              => $request->status,
            'due_date'            => $request->due_date,
            'due_time'            => $request->due_time,
            'is_recurring'        => $request->boolean('is_recurring'),
            'recurring_type'      => $request->boolean('is_recurring') ? $request->recurring_type : null,
            'recurring_end_date'  => $request->boolean('is_recurring') ? $request->recurring_end_date : null,
            'reminder_enabled'    => $request->boolean('reminder_enabled'),
            'remind_at'           => $request->boolean('reminder_enabled') ? $request->remind_at : null,
            'position'            => Task::where('user_id', auth()->id())->max('position') + 1,
        ]);

        if ($request->has('labels')) {
            $task->labels()->sync($request->labels);
        }

        TaskHistory::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'action'  => 'Task Created',
            'changes' => 'New task created',
        ]);

        return redirect()->route('user.tasks.show', $task)->with('success', 'Task created successfully.');
    }

    public function show(string $id)
    {
        $task = Task::with(['category', 'labels', 'subtasks', 'comments.user', 'histories'])->findOrFail($id);
        abort_if($task->user_id !== auth()->id(), 403);

        return view('user.tasks.show', compact('task'));
    }

    public function edit(string $id)
    {
        $task       = Task::with('labels')->findOrFail($id);
        abort_if($task->user_id !== auth()->id(), 403);

        $categories = TaskCategory::where('user_id', auth()->id())->get();
        $labels     = TaskLabel::where('user_id', auth()->id())->get();

        return view('user.tasks.edit', compact('task', 'categories', 'labels'));
    }

    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);
        abort_if($task->user_id !== auth()->id(), 403);

        $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'nullable|string',
            'task_category_id'    => 'nullable|exists:task_categories,id',
            'priority'            => 'required|in:low,medium,high',
            'status'              => 'required|in:pending,in_progress,completed',
            'due_date'            => 'nullable|date',
            'due_time'            => 'nullable|date_format:H:i',
            'is_recurring'        => 'nullable|boolean',
            'recurring_type'      => 'nullable|in:daily,weekly,monthly',
            'recurring_end_date'  => 'nullable|date|after_or_equal:due_date',
            'reminder_enabled'    => 'nullable|boolean',
            'remind_at'           => 'nullable|date',
            'labels'              => 'nullable|array',
        ]);

        $originalData = $task->getOriginal();

        $task->update([
            'task_category_id'    => $request->task_category_id,
            'title'               => $request->title,
            'description'         => $request->description,
            'priority'            => $request->priority,
            'status'              => $request->status,
            'due_date'            => $request->due_date,
            'due_time'            => $request->due_time,
            'is_recurring'        => $request->boolean('is_recurring'),
            'recurring_type'      => $request->boolean('is_recurring') ? $request->recurring_type : null,
            'recurring_end_date'  => $request->boolean('is_recurring') ? $request->recurring_end_date : null,
            'reminder_enabled'    => $request->boolean('reminder_enabled'),
            'remind_at'           => $request->boolean('reminder_enabled') ? $request->remind_at : null,
            'reminder_sent_at'    => $request->boolean('reminder_enabled') ? null : $task->reminder_sent_at,
        ]);

        if ($request->has('labels')) {
            $task->labels()->sync($request->labels);
        } else {
            $task->labels()->detach();
        }

        // Track meaningful changes for history
        $changes = [];
        foreach (['title', 'status', 'priority', 'due_date', 'is_recurring', 'recurring_type'] as $field) {
            if ($task->wasChanged($field)) {
                $changes[$field] = [
                    'old' => $originalData[$field] ?? null,
                    'new' => $task->$field,
                ];
            }
        }

        if (!empty($changes)) {
            TaskHistory::create([
                'task_id' => $task->id,
                'user_id' => auth()->id(),
                'action'  => 'Task Updated',
                'changes' => json_encode($changes),
            ]);
        }

        return redirect()->route('user.tasks.show', $task)->with('success', 'Task updated successfully.');
    }

    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        abort_if($task->user_id !== auth()->id(), 403);

        $task->delete();

        return redirect()->route('user.tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function kanban()
    {
        $tasks = Task::with(['category', 'labels', 'subtasks'])
            ->where('user_id', auth()->id())
            ->orderBy('position', 'asc')
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
        $task->update(['status' => $request->status]);

        TaskHistory::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'action'  => 'Status Updated',
            'changes' => "Status changed from {$oldStatus} to {$request->status}",
        ]);

        // Auto-create next recurring task when completed
        if ($request->status === 'completed' && $task->is_recurring && $task->due_date) {
            $nextDueDate = match ($task->recurring_type) {
                'daily'   => $task->due_date->copy()->addDay(),
                'weekly'  => $task->due_date->copy()->addWeek(),
                'monthly' => $task->due_date->copy()->addMonth(),
                default   => null,
            };

            if ($nextDueDate && (! $task->recurring_end_date || $nextDueDate->lte($task->recurring_end_date))) {
                $newTask = $task->replicate();
                $newTask->status       = 'pending';
                $newTask->due_date     = $nextDueDate;
                $newTask->remind_at    = null;
                $newTask->reminder_sent_at = null;
                $newTask->position     = Task::where('user_id', auth()->id())->max('position') + 1;
                $newTask->created_at   = now();
                $newTask->updated_at   = now();
                $newTask->save();

                $newTask->labels()->sync($task->labels->pluck('id')->toArray());

                TaskHistory::create([
                    'task_id' => $newTask->id,
                    'user_id' => auth()->id(),
                    'action'  => 'Recurring Task Created',
                    'changes' => 'Auto-created from completed recurring task: ' . $task->title,
                ]);
            }
        }

        return back()->with('success', 'Task status updated.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'tasks'            => 'required|array',
            'tasks.*.id'       => 'required|exists:tasks,id',
            'tasks.*.position' => 'required|integer|min:0',
        ]);

        foreach ($request->tasks as $item) {
            Task::where('id', $item['id'])
                ->where('user_id', auth()->id())
                ->update(['position' => $item['position']]);
        }

        return response()->json(['success' => true, 'message' => 'Task order updated.']);
    }
}
