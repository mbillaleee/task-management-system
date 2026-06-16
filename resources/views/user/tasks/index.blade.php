@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-end sm:flex-wrap justify-between gap-3">
            <div class="flex-1 mb-2 sm:mb-0">
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-tasks"></i> Today's My Tasks
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    Organize your workflow with priority based task cards.
                </p>
            </div>

            <div class="flex flex-wrap gap-2 sm:gap-2.5 justify-start sm:justify-end">
                <a href="{{ route('user.tasks.kanban') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-white text-gray-800 border dark:border-white/[0.08] border-black/[0.08]">
                    <i class="fas fa-columns"></i> Kanban View
                </a>

                <a href="{{ route('user.allTasks') }}"
                    class="flex items-center justify-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    <i class="fas fa-list"></i> All Tasks
                </a>

                <a href="{{ route('user.task-categories.index') }}"
                    class="flex items-center justify-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    <i class="fas fa-tags"></i> Categories & Labels
                </a>

                <a href="{{ route('user.tasks.create') }}"
                    class="flex items-center justify-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    <i class="fas fa-plus"></i> Add Task
                </a>
            </div>
        </div>
        {{-- Task Cards --}}
        <div id="taskSortable" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
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

                <div data-id="{{ $task->id }}"
                    class="task-card hover-lift veroa-card rounded-2xl p-4 relative overflow-hidden cursor-move">
                    {{-- Title + Priority --}}
                    <div class="relative z-10 flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-[16px] font-bold dark:text-white text-[#151515] leading-snug">
                                {{ $task->title }}
                            </h3>
                            <p class="text-[14px] dark:text-white text-[#7a6045] mt-1">
                                {{ $task->category?->name ?? 'Uncategorized' }}
                            </p>
                        </div>
                        <span class="px-2.5 py-[4px] rounded-lg text-[13px] font-bold border {{ $priorityClass }}">
                            <i class="fas fa-flag mr-1"></i> {{ ucfirst($task->priority) }}
                        </span>
                    </div>

                    {{-- Description --}}
                    <p class="relative z-10 text-[14px] dark:text-white text-gray-500 leading-relaxed mt-3">
                        {{ \Illuminate\Support\Str::limit($task->description, 120) ?? 'No description added.' }}
                    </p>

                    {{-- Labels --}}
                    <div
                        class="relative z-10 flex items-center justify-between mt-4 pt-3 border-t dark:border-white/[0.06] border-orange-200/60">
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
                                    'bg-gray-100 text-gray-600 dark:bg-white/10 dark:text-white border border-white/10';
                            @endphp
                            <span class="px-2.5 py-[3px] rounded-md text-[12px] font-semibold {{ $colorClass }}">
                                <i class="fas fa-tag mr-1"></i> {{ strtolower($label->name) }}
                            </span>
                        @empty
                            <span
                                class="px-2.5 py-[3px] rounded-md text-[12px] font-semibold bg-gray-100 text-gray-500 dark:bg-white/10 dark:text-white border border-white/10">
                                No Label
                            </span>
                        @endforelse
                    </div>

                    {{-- Due Date + Recurring + Status --}}
                    <div
                        class="relative z-10 flex items-center justify-between mt-4 pt-3 border-t dark:border-white/[0.06] border-black/[0.05]">
                        <div>
                            <p class="text-[12px] dark:text-gray-500 text-gray-800"><i class="fas fa-calendar mr-1"></i> Due
                                Date</p>
                            <p class="text-[13px] font-semibold dark:text-white text-gray-800">
                                @if ($task->due_date)
                                    {{ $task->due_date->format('d M, Y') }}
                                    @if ($task->due_time)
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ \Carbon\Carbon::parse($task->due_time)->format('h:i A') }}
                                    @endif
                                @else
                                    No deadline
                                @endif
                            </p>
                            @if ($task->is_recurring)
                                <p class="text-[11px] text-pink-400 mt-0.5">
                                    <i class="fas fa-redo-alt mr-1"></i>Repeats {{ ucfirst($task->recurring_type) }}
                                </p>
                            @endif
                        </div>

                        <div class="flex flex-col items-end gap-1">
                            <span class="px-2.5 py-[4px] rounded-lg text-[12px] font-bold {{ $statusClass }}">
                                <i class="fas fa-circle mr-1"></i> {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                            @if ($task->is_overdue)
                                <span class="text-[11px] font-semibold text-red-400">
                                    <i class="fas fa-exclamation-circle mr-0.5"></i>Overdue
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Subtask Progress --}}
                    <div class="relative z-10 mt-4">
                        <div class="flex justify-between text-[12px] mb-1.5">
                            <span class="dark:text-white text-gray-500">Subtasks</span>
                            <span class="font-bold dark:text-white text-gray-800">
                                {{ $completedSubtasks }}/{{ $totalSubtasks }}
                            </span>
                        </div>
                        <div
                            class="w-full h-[8px] rounded-full overflow-hidden
                            bg-[#f9d9b1] border border-orange-300/40
                            dark:bg-[#1a1325] dark:border-pink-500/10">

                            <div class="h-full rounded-full
                                bg-gradient-to-r from-[#ff2fa8] via-[#ff7b22] to-[#ffd54a]
                                shadow-[0_2px_10px_rgba(255,138,18,.30)]
                                dark:shadow-[0_0_15px_rgba(255,47,168,.30)]
                                transition-all duration-300"
                                style="width: {{ $progress }}%">
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="relative z-10 flex items-center justify-between gap-2 mt-4">
                        <a href="{{ route('user.tasks.show', $task) }}"
                            class="px-3 py-2 rounded-lg text-[13px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('user.tasks.edit', $task) }}"
                                class="px-3 py-2 rounded-lg text-[13px] font-bold
                                bg-[#fff4df] text-[#5f5242] border border-orange-200/60
                                dark:bg-white/[0.06] dark:text-white dark:border-white/[0.06]">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('user.tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this task?')"
                                    class="px-3 py-2 rounded-lg text-[13px] font-bold dark:bg-red-500/[0.15] bg-red-50 text-red-500">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full hover-lift rounded-[18px] p-8 text-center
                        bg-[#fbefd9]/85 border border-orange-200/60
                        dark:bg-[#0f0a1c] dark:border-pink-500/15
                        shadow-[inset_0_1px_0_rgba(255,255,255,.65),0_15px_35px_rgba(180,95,20,.10)]
                        dark:shadow-none">
                    <i class="fas fa-tasks text-3xl text-gray-300 dark:text-white mb-3 block"></i>
                    <h3 class="text-[16px] font-bold dark:text-white text-gray-900"><i
                            class="fas fa-exclamation-circle mr-1"></i> No tasks for today</h3>
                    <p class="text-[13px] dark:text-white text-gray-800 mt-1">Create your first task to get started.</p>
                    <a href="{{ route('user.tasks.create') }}"
                        class="inline-block mt-4 px-5 py-2 rounded-[10px] text-white text-[13px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                        <i class="fas fa-plus mr-1"></i> Add Task
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div>{{ $tasks->links() }}</div>

    </section>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

    <script>
        const sortableEl = document.getElementById('taskSortable');
        if (sortableEl) {
            new Sortable(sortableEl, {
                animation: 180,
                ghostClass: 'opacity-40',
                handle: '.task-card',
                onEnd: function() {
                    const tasks = [];
                    document.querySelectorAll('#taskSortable .task-card').forEach((el, index) => {
                        tasks.push({
                            id: parseInt(el.dataset.id), // integer required
                            position: index + 1
                        });
                    });

                    fetch("{{ route('user.tasks.reorder') }}", {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                tasks
                            })
                        })
                        .then(res => res.json())
                        .then(data => console.log(data.message))
                        .catch(err => console.error(err));
                }
            });
        }
    </script>
@endsection
