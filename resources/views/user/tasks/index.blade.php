@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[28px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    My Tasks
                </h2>
                <p class="text-[18px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Organize your workflow with priority based task cards.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('user.tasks.kanban') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                    Kanban View
                </a>

                <a href="{{ route('user.tasks.create') }}"
                    class="flex items-center justify-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    + Add Task
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse ($tasks as $task)
                @php
                    $completedSubtasks = $task->subtasks->where('is_completed', true)->count();
                    $totalSubtasks = $task->subtasks->count();
                    $progress = $totalSubtasks > 0 ? round(($completedSubtasks / $totalSubtasks) * 100) : 0;

                    $priorityClass =
                        [
                            'high' => 'dark:bg-red-500/[0.15] bg-red-50 text-red-500 border-red-500/20',
                            'medium' => 'dark:bg-orange-500/[0.15] bg-orange-50 text-orange-500 border-orange-500/20',
                            'low' => 'dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500 border-emerald-500/20',
                        ][$task->priority] ?? 'bg-gray-100 text-gray-500';

                    $statusClass =
                        [
                            'pending' => 'dark:bg-yellow-500/[0.15] bg-yellow-50 text-yellow-500',
                            'in_progress' => 'dark:bg-blue-500/[0.15] bg-blue-50 text-blue-500',
                            'completed' => 'dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500',
                        ][$task->status] ?? 'bg-gray-100 text-gray-500';
                @endphp

                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-orange-500 blur-3xl opacity-20"></div>

                    <div class="relative z-10 flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-[18px] font-bold dark:text-white text-gray-900 leading-snug">
                                {{ $task->title }}
                            </h3>
                            <p class="text-[16px] dark:text-gray-500 text-gray-400 mt-1">
                                {{ $task->category?->name ?? 'Uncategorized' }}
                            </p>
                        </div>

                        <span class="px-2.5 py-[4px] rounded-lg text-[15px] font-bold border {{ $priorityClass }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>

                    <p class="relative z-10 text-[16px] dark:text-gray-400 text-gray-500 leading-relaxed mt-3">
                        {{ \Illuminate\Support\Str::limit($task->description, 120) ?? 'No description added.' }}
                    </p>

                    <div class="relative z-10 flex flex-wrap gap-1.5 mt-3">

                        @forelse ($task->labels as $label)
                            @php
                                $colors = [
                                    'red' =>
                                        'bg-red-100 text-red-600 dark:bg-red-500/15 dark:text-red-400 border border-red-500/20',
                                    'green' =>
                                        'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 border border-emerald-500/20',
                                    'blue' =>
                                        'bg-blue-100 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400 border border-blue-500/20',
                                    'yellow' =>
                                        'bg-yellow-100 text-yellow-600 dark:bg-yellow-500/15 dark:text-yellow-400 border border-yellow-500/20',
                                    'purple' =>
                                        'bg-purple-100 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400 border border-purple-500/20',
                                    'pink' =>
                                        'bg-pink-100 text-pink-600 dark:bg-pink-500/15 dark:text-pink-400 border border-pink-500/20',
                                    'orange' =>
                                        'bg-orange-100 text-orange-600 dark:bg-orange-500/15 dark:text-orange-400 border border-orange-500/20',
                                ];

                                $colorClass =
                                    $colors[$label->color] ??
                                    'bg-gray-100 text-gray-600 dark:bg-white/10 dark:text-gray-300 border border-white/10';
                            @endphp

                            <span class="px-2.5 py-[4px] rounded-md text-[15px] font-semibold {{ $colorClass }}">
                                #{{ strtolower($label->name) }}
                            </span>

                        @empty

                            <span
                                class="px-2.5 py-[4px] rounded-md text-[15px] font-semibold
            bg-gray-100 text-gray-500 dark:bg-white/10 dark:text-gray-400 border border-white/10">
                                No Label
                            </span>
                        @endforelse

                    </div>

                    <div
                        class="relative z-10 flex items-center justify-between mt-4 pt-3 border-t dark:border-white/[0.06] border-black/[0.05]">
                        <div>
                            <p class="text-[16px] dark:text-gray-500 text-gray-400">Due Date</p>
                            <p class="text-[14px] font-semibold dark:text-gray-300 text-gray-700">
                                {{ $task->due_date ? $task->due_date->format('d M, Y') : 'No deadline' }}
                            </p>
                        </div>

                        <span class="px-2.5 py-[4px] rounded-lg text-[15px] font-bold {{ $statusClass }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>

                    <div class="relative z-10 mt-4">
                        <div class="flex justify-between text-[16px] mb-1.5">
                            <span class="dark:text-gray-400 text-gray-500">Subtasks</span>
                            <span class="font-bold dark:text-white text-gray-800">
                                {{ $completedSubtasks }}/{{ $totalSubtasks }}
                            </span>
                        </div>

                        <div class="w-full h-[7px] rounded-full dark:bg-white/[0.08] bg-gray-100 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500"
                                style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                    <div class="relative z-10 flex items-center justify-between gap-2 mt-4">
                        <a href="{{ route('user.tasks.show', $task) }}"
                            class="px-3 py-2 rounded-lg text-[14px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                            View
                        </a>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('user.tasks.edit', $task) }}"
                                class="px-3 py-2 rounded-lg text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                                Edit
                            </a>

                            <form action="{{ route('user.tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this task?')"
                                    class="px-3 py-2 rounded-lg text-[14px] font-bold dark:bg-red-500/[0.15] bg-red-50 text-red-500">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-8 text-center">
                    <h3 class="text-[16px] font-bold dark:text-white text-gray-900">No tasks found</h3>
                    <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-1">Create your first task to get started.</p>
                </div>
            @endforelse
        </div>

        <div>
            {{ $tasks->links() }}
        </div>

    </section>
@endsection
