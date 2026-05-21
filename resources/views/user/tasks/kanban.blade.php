@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    Task Kanban
                </h2>
                <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Manage tasks by status using a clean board view.
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('user.tasks.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[12.5px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                    List View
                </a>

                <a href="{{ route('user.tasks.create') }}"
                    class="px-4 py-2 rounded-[10px] text-white text-[12.5px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    + Add Task
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            @foreach (['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $status => $title)
                <div class="dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-[14px] font-bold dark:text-white text-gray-900">{{ $title }}</h3>
                        <span
                            class="px-2 py-[3px] rounded-md text-[11px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-600">
                            {{ isset($tasks[$status]) ? count($tasks[$status]) : 0 }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        @forelse (($tasks[$status] ?? []) as $task)
                            <div
                                class="dark:bg-white/[0.05] bg-gray-50 border dark:border-white/[0.06] border-black/[0.05] rounded-xl p-3">
                                <h4 class="text-[13px] font-bold dark:text-white text-gray-900">
                                    {{ $task->title }}
                                </h4>

                                <p class="text-[11.5px] dark:text-gray-500 text-gray-500 mt-1">
                                    {{ \Illuminate\Support\Str::limit($task->description, 55) }}
                                </p>

                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    @foreach ($task->labels as $label)
                                        <span
                                            class="px-2 py-[3px] rounded-md text-[10.5px] font-semibold dark:bg-white/[0.06] bg-white dark:text-gray-300 text-gray-600">
                                            #{{ $label->name }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-[11px] font-bold text-orange-400">
                                        {{ ucfirst($task->priority) }}
                                    </span>

                                    <a href="{{ route('user.tasks.show', $task) }}"
                                        class="text-[11.5px] font-bold text-pink-500">
                                        View
                                    </a>
                                </div>

                                <form action="{{ route('user.tasks.updateStatus', $task) }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status" onchange="this.form.submit()"
                                        class="w-full px-3 py-2 rounded-[9px] text-[12px] outline-none cursor-pointer
                                        dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-600
                                        dark:border dark:border-white/[0.1] border border-black/[0.1]">
                                        <option value="pending" @selected($task->status == 'pending')>Pending</option>
                                        <option value="in_progress" @selected($task->status == 'in_progress')>In Progress</option>
                                        <option value="completed" @selected($task->status == 'completed')>Completed</option>
                                    </select>
                                </form>
                            </div>
                        @empty
                            <div
                                class="border border-dashed dark:border-white/[0.08] border-black/[0.08] rounded-xl p-5 text-center">
                                <p class="text-[12px] dark:text-gray-500 text-gray-400">No tasks</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
