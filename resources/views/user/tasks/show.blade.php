@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    Task Details
                </h2>
                <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-0.5">
                    View subtasks, comments and activity history.
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('user.tasks.edit', $task) }}"
                    class="px-4 py-2 rounded-[10px] text-white text-[12.5px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    Edit Task
                </a>

                <a href="{{ route('user.tasks.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[12.5px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <div class="xl:col-span-2 space-y-4">
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900">{{ $task->title }}</h3>
                    <p class="text-[13px] dark:text-gray-400 text-gray-500 mt-3 leading-relaxed">
                        {{ $task->description }}
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-5">
                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[11px] dark:text-gray-500 text-gray-400">Status</p>
                            <p class="text-[12.5px] font-bold dark:text-white text-gray-800">
                                {{ ucwords(str_replace('_', ' ', $task->status)) }}</p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[11px] dark:text-gray-500 text-gray-400">Priority</p>
                            <p class="text-[12.5px] font-bold dark:text-white text-gray-800">{{ ucfirst($task->priority) }}
                            </p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[11px] dark:text-gray-500 text-gray-400">Category</p>
                            <p class="text-[12.5px] font-bold dark:text-white text-gray-800">
                                {{ $task->category?->name ?? 'N/A' }}</p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[11px] dark:text-gray-500 text-gray-400">Due Date</p>
                            <p class="text-[12.5px] font-bold dark:text-white text-gray-800">
                                {{ $task->due_date ? $task->due_date->format('d M, Y') : 'No deadline' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <h3 class="text-[14px] font-bold dark:text-white text-gray-900 mb-3.5">Subtasks</h3>

                    <form action="{{ route('user.tasks.subtasks.store', $task) }}" method="POST" class="flex gap-2 mb-4">
                        @csrf
                        <input name="title" placeholder="Add a subtask..."
                            class="flex-1 px-3.5 py-2 rounded-[10px] text-[13px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                        <button
                            class="px-4 py-2 rounded-[10px] text-white text-[12.5px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                            Add
                        </button>
                    </form>

                    @foreach ($task->subtasks as $subtask)
                        <div
                            class="flex items-center justify-between py-2.5 border-b dark:border-white/[0.06] border-black/[0.05]">
                            <form action="{{ route('user.subtasks.toggle', $subtask) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button
                                    class="text-[13px] font-medium {{ $subtask->is_completed ? 'line-through text-gray-400' : 'dark:text-gray-200 text-gray-700' }}">
                                    {{ $subtask->is_completed ? '✓' : '○' }} {{ $subtask->title }}
                                </button>
                            </form>

                            <form action="{{ route('user.subtasks.destroy', $subtask) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-[12px] font-bold text-red-500">Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <h3 class="text-[14px] font-bold dark:text-white text-gray-900 mb-3.5">Comments</h3>

                    <form action="{{ route('user.tasks.comments.store', $task) }}" method="POST" class="mb-4">
                        @csrf
                        <textarea name="comment" rows="3" placeholder="Write a comment..."
                            class="w-full px-3.5 py-2 rounded-[10px] text-[13px] outline-none resize-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]"></textarea>
                        <button
                            class="mt-2 px-4 py-2 rounded-[10px] text-white text-[12.5px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                            Post Comment
                        </button>
                    </form>

                    @foreach ($task->comments as $comment)
                        <div class="py-3 border-b dark:border-white/[0.06] border-black/[0.05]">
                            <p class="text-[12.5px] font-bold dark:text-gray-200 text-gray-800">{{ $comment->user->name }}
                            </p>
                            <p class="text-[12px] dark:text-gray-500 text-gray-500 mt-1">{{ $comment->comment }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07]  border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[14px] font-bold dark:text-white text-gray-900 mb-4">
                    Task History
                </h3>

                <div class="space-y-5">

                    @foreach ($task->histories as $history)
                        @php
                            $changes = json_decode($history->changes, true);
                        @endphp

                        <div class="relative pl-5">

                            <!-- Timeline Line -->
                            <div class="absolute left-[5px] top-1 bottom-0 w-[2px] bg-orange-500/70"></div>

                            <!-- Timeline Dot -->
                            <div
                                class="absolute left-0 top-1.5 w-[12px] h-[12px]  rounded-full bg-gradient-to-r from-orange-500 to-pink-500 shadow-lg">
                            </div>

                            <!-- Content -->
                            <div>
                                <h4 class="text-[13px] font-bold dark:text-white text-gray-900">
                                    {{ $history->action }}
                                </h4>

                                {{-- Changes --}}
                                @if ($changes && is_array($changes))
                                    <div class="mt-2 space-y-2">

                                        @foreach ($changes as $field => $value)
                                            @if (is_array($value) && isset($value['old']) && isset($value['new']))
                                                <div
                                                    class="dark:bg-white/[0.04] bg-gray-50
                                        rounded-xl p-2.5 border dark:border-white/[0.05]
                                        border-black/[0.04]">

                                                    <p class="text-[11px] font-semibold text-orange-400 mb-1">
                                                        {{ ucfirst(str_replace('_', ' ', $field)) }}
                                                    </p>

                                                    <div class="flex items-center gap-2 text-[11.5px]">

                                                        <span
                                                            class="px-2 py-1 rounded-md
                                                bg-red-500/[0.12] text-red-400 line-through">
                                                            {{ $value['old'] ?: 'Empty' }}
                                                        </span>

                                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none"
                                                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 5l7 7-7 7" />
                                                        </svg>

                                                        <span
                                                            class="px-2 py-1 rounded-md
                                                bg-emerald-500/[0.12] text-emerald-400">
                                                            {{ $value['new'] ?: 'Empty' }}
                                                        </span>

                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-[11.5px] dark:text-gray-400 text-gray-500">
                                                    {{ $value }}
                                                </p>
                                            @endif
                                        @endforeach

                                    </div>
                                @else
                                    <p class="text-[11.5px] dark:text-gray-500 text-gray-400 mt-1 leading-relaxed">
                                        {{ $history->changes }}
                                    </p>
                                @endif

                                <!-- Time -->
                                <div class="flex items-center gap-1.5 mt-2">
                                    <svg class="w-3.5 h-3.5 dark:text-gray-600 text-gray-400" fill="none"
                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                        <circle cx="12" cy="12" r="9" />
                                    </svg>

                                    <p class="text-[11px] dark:text-gray-600 text-gray-400">
                                        {{ $history->created_at->format('d M Y h:i A') }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endsection
