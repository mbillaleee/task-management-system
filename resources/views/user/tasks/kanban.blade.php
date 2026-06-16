@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-th-large mr-2"></i> Task Kanban
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    Manage tasks by status using a clean board view.
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('user.tasks.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-white text-gray-800">
                    <i class="fas fa-list mr-2"></i> List View
                </a>

                <a href="{{ route('user.tasks.create') }}"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-plus mr-2"></i> Add Task
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            @foreach (['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $status => $title)
                <div
                    class="dark:border-pink-500/15 bg-[#f7e4c3]/75
            dark:bg-[#080612]  backdrop-blur-xl  p-6  space-y-6
            shadow-[inset_0_1px_0_rgba(255,255,255,.65),0_20px_50px_rgba(180,95,20,.12),0_8px_20px_rgba(255,140,20,.08)]
            dark:shadow-[inset_0_1px_0_rgba(255,255,255,.03)] rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-[16px] font-bold dark:text-white text-gray-900">{{ $title }}</h3>
                        <span
                            class="px-2 py-[3px] rounded-md text-[12px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-white text-gray-800">
                            {{ isset($tasks[$status]) ? count($tasks[$status]) : 0 }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        @forelse (($tasks[$status] ?? []) as $task)
                            <div class=" veroa-card rounded-xl p-3">
                                <h4 class="text-[14px] font-bold dark:text-white text-gray-900">
                                    <i class="fas fa-tasks mr-2"></i> {{ $task->title }}
                                </h4>

                                <p class="text-[12px] dark:text-white text-gray-800 mt-1">
                                    {{ \Illuminate\Support\Str::limit($task->description, 55) }}
                                </p>

                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    @foreach ($task->labels as $label)
                                        <span
                                            class="px-2 py-[3px] rounded-md text-[11px] font-semibold dark:bg-white/[0.06] bg-white dark:text-white text-gray-800">
                                            <i class="fas fa-tag mr-1"></i> {{ $label->name }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-[12px] font-bold text-orange-400">
                                        {{ ucfirst($task->priority) }}
                                    </span>

                                    <a href="{{ route('user.tasks.show', $task) }}"
                                        class="text-[12px] font-bold text-pink-500">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                </div>

                                <form action="{{ route('user.tasks.updateStatus', $task) }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status" onchange="this.form.submit()"
                                        class="w-full px-3 py-2 rounded-[9px] text-[14px] outline-none cursor-pointer
                                        dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
                                        dark:border dark:border-white/[0.1] border border-black/[0.1]">
                                        <option value="pending" @selected($task->status == 'pending')>
                                            <i class="fas fa-clock mr-1"></i> Pending
                                        </option>
                                        <option value="in_progress" @selected($task->status == 'in_progress')>
                                            <i class="fas fa-spinner mr-1"></i> In Progress
                                        </option>
                                        <option value="completed" @selected($task->status == 'completed')>
                                            <i class="fas fa-check-circle mr-1"></i> Completed
                                        </option>
                                    </select>
                                </form>
                            </div>
                        @empty
                            <div
                                class="border border-dashed dark:border-white/[0.08] border-black/[0.08] rounded-xl p-5 text-center">
                                <p class="tex8-[14px] dark:text-white text-gray-900"> <i class="fas fa-inbox mr-2"></i>
                                    No tasks</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
