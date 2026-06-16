@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-tasks"></i> Task Details
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    View subtasks, comments and activity history.
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('user.tasks.edit', $task) }}"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-edit"></i> Edit Task
                </a>

                <a href="{{ route('user.tasks.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-white text-gray-700">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <div class="xl:col-span-2 space-y-4">
                <div class="hover-lift veroa-card rounded-2xl p-[18px]">
                    <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900">{{ $task->title }}</h3>
                    <p class="text-[14px] dark:text-white text-gray-800 mt-3 leading-relaxed">
                        {{ $task->description }}
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-5">
                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[14px] dark:text-white text-gray-800"> <i class="fas fa-tasks"></i> Status</p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                {{ ucwords(str_replace('_', ' ', $task->status)) }}</p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[14px] dark:text-white text-gray-800"> <i class="fas fa-flag"></i> Priority
                            </p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">{{ ucfirst($task->priority) }}
                            </p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[14px] dark:text-white text-gray-800"> <i class="fas fa-tag"></i> Category</p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                {{ $task->category?->name ?? 'N/A' }}</p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[14px] dark:text-white text-gray-800"> <i class="fas fa-calendar"></i> Due
                                Date</p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M, Y') : 'No deadline' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="hover-lift veroa-card rounded-2xl p-[18px]">
                    <h3 class="text-[16px] font-bold dark:text-white text-gray-900 mb-3.5">Subtasks</h3>

                    <form action="{{ route('user.tasks.subtasks.store', $task) }}" method="POST" class="flex gap-2 mb-4">
                        @csrf
                        <input name="title" placeholder="Add a subtask..."
                            class="flex-1 px-3.5 py-2 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                        <button
                            class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                            <i class="fas fa-plus"></i> Add
                        </button>
                    </form>

                    @foreach ($task->subtasks as $subtask)
                        <div
                            class="flex items-center justify-between py-2.5 border-b dark:border-white/[0.06] border-black/[0.05]">
                            <form action="{{ route('user.subtasks.toggle', $subtask) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button
                                    class="text-[14px] font-medium {{ $subtask->is_completed ? 'line-through text-gray-400' : 'dark:text-white text-gray-700' }}">
                                    {{ $subtask->is_completed ? '✓' : '○' }} {{ $subtask->title }}
                                </button>
                            </form>

                            <form action="{{ route('user.subtasks.destroy', $subtask) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-[14px] font-bold text-red-500"><i class="fas fa-trash"></i>
                                    Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="hover-lift veroa-card rounded-2xl p-[18px]">
                    <h3 class="text-[18px] font-bold dark:text-white text-gray-900 mb-3.5"> <i class="fas fa-comments"></i>
                        Comments</h3>

                    <form action="{{ route('user.tasks.comments.store', $task) }}" method="POST" class="mb-4">
                        @csrf
                        <textarea name="comment" rows="3" placeholder="Write a comment..."
                            class="w-full px-3.5 py-2 rounded-[10px] text-[14px] outline-none resize-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]"></textarea>
                        <button
                            class="mt-2 px-4 py-2 rounded-[10px] text-white text-[16px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                            <i class="fas fa-paper-plane"></i> Post Comment
                        </button>
                    </form>

                    @foreach ($task->comments as $comment)
                        <div class="py-3 border-b dark:border-white/[0.06] border-black/[0.05]">
                            <p class="text-[16px] font-bold dark:text-white text-gray-800">{{ $comment->user->name }}
                            </p>
                            <p class="text-[16px] dark:text-white text-gray-800 mt-1">{{ $comment->comment }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="hover-lift veroa-card rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-bold dark:text-white text-gray-900 mb-4">
                    <i class="fas fa-history"></i> Task History
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
                                <h4 class="text-[13px] font-bold dark:text-white text-gray-800">
                                    {{ $history->action }}
                                </h4>

                                {{-- Changes --}}
                                @if ($changes && is_array($changes))
                                    <div class="mt-2 space-y-2">

                                        @foreach ($changes as $field => $value)
                                            @if (is_array($value) && isset($value['old']) && isset($value['new']))
                                                <div
                                                    class="dark:bg-white/[0.04] bg-gray-50 mb-2
                                                        rounded-xl p-2.5 border dark:border-white/[0.05]
                                                        border-black/[0.04]">

                                                    <p class="text-[11px] font-semibold text-orange-400 mb-1">
                                                        <i class="fas fa-exclamation-circle"></i>
                                                        {{ ucfirst(str_replace('_', ' ', $field)) }}
                                                    </p>

                                                    <div class="flex items-center gap-2 text-[11.5px]">

                                                        <span
                                                            class="px-2 py-1 rounded-md
                                                bg-red-500/[0.12] text-red-400 line-through">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ !empty($value['old']) && strtotime($value['old'])
                                                                ? \Carbon\Carbon::parse($value['old'])->format('d M, Y')
                                                                : ($value['old'] ?:
                                                                    'Empty') }}
                                                        </span>

                                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none"
                                                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 5l7 7-7 7" />
                                                        </svg>

                                                        <span
                                                            class="px-2 py-1 rounded-md  bg-emerald-500/[0.12] text-emerald-400">
                                                            <i class="fas fa-exclamation-circle"></i>
                                                            {{ !empty($value['new']) && strtotime($value['new'])
                                                                ? \Carbon\Carbon::parse($value['new'])->format('d M, Y')
                                                                : ($value['new'] ?:
                                                                    'Empty') }}
                                                        </span>

                                                    </div>
                                                </div>
                                            @else
                                                @foreach ($value as $k => $v)
                                                    @php
                                                        $displayValue =
                                                            !empty($v) && strtotime($v)
                                                                ? \Carbon\Carbon::parse($v)->format('d M, Y')
                                                                : ($v ?:
                                                                'Empty');

                                                        $isOld = $k === 'old';

                                                        $badgeClass = $isOld
                                                            ? 'bg-red-500/[0.12] text-red-400'
                                                            : 'bg-emerald-500/[0.12] text-emerald-400';

                                                        $textClass = $isOld
                                                            ? 'text-red-400 line-through decoration-red-400/70'
                                                            : 'text-emerald-400';

                                                        $iconClass = $isOld
                                                            ? 'fa-solid fa-circle-exclamation'
                                                            : 'fa-solid fa-circle-check';
                                                    @endphp

                                                    <span
                                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $badgeClass }}">
                                                        <i class="{{ $iconClass }}"></i>
                                                        <span class="{{ $textClass }}">
                                                            {{ $displayValue }}
                                                        </span>
                                                    </span>

                                                    @if ($k === 'old')
                                                        <span class="mx-2 text-gray-500">
                                                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                                        </span>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach

                                    </div>
                                @else
                                    <p class="text-[11.5px] dark:text-white text-gray-800 mt-1 leading-relaxed">
                                        <i class="fas fa-exclamation-circle"></i> {{ $history->changes }}
                                    </p>
                                @endif

                                <!-- Time -->
                                <div class="flex items-center gap-1.5 mt-2">
                                    <svg class="w-3.5 h-3.5 dark:text-white text-gray-800" fill="none"
                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                        <circle cx="12" cy="12" r="9" />
                                    </svg>

                                    <p class="text-[11px] dark:text-white text-gray-800">
                                        <i class="fas fa-exclamation-circle"></i>
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
