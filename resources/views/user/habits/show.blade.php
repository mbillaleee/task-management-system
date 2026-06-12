@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-info-circle mr-1"></i> Habit Details
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Streak, heatmap and completion history.
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('user.habits.edit', $habit) }}"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-edit mr-1"></i> Edit Habit
                </a>
                <a href="{{ route('user.habits.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

            {{-- Left: Info + Heatmap + Logs --}}
            <div class="xl:col-span-2 space-y-4">

                {{-- Habit Info --}}
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900">
                                {{ $habit->title }}
                            </h3>
                            <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-0.5">
                                <i class="fas fa-folder mr-1"></i> {{ $habit->category?->name ?? 'General' }}
                            </p>
                        </div>

                        @php
                            $typeClass =
                                $habit->type === 'positive'
                                    ? 'dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500 border-emerald-500/20'
                                    : 'dark:bg-red-500/[0.15] bg-red-50 text-red-500 border-red-500/20';
                        @endphp
                        <span class="px-2.5 py-1 rounded-lg text-[12px] font-bold border {{ $typeClass }}">
                            <i class="fas fa-arrow-up mr-1"></i> {{ ucfirst($habit->type) }}
                        </span>
                    </div>

                    <p class="text-[14px] dark:text-gray-400 text-gray-500 mt-3 leading-relaxed">
                        {{ $habit->description ?? 'No description added.' }}
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-5">
                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[12px] dark:text-gray-500 text-gray-400"> <i class="fas fa-sync-alt mr-1"></i>
                                Frequency</p>
                            <p class="text-[13px] font-bold dark:text-white text-gray-800">{{ ucfirst($habit->frequency) }}
                            </p>
                        </div>
                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[12px] dark:text-gray-500 text-gray-400"> <i class="fas fa-info-circle mr-1"></i>
                                Status</p>
                            <p class="text-[13px] font-bold {{ $habit->status ? 'text-emerald-500' : 'text-red-400' }}">
                                {{ $habit->status ? 'Active' : 'Inactive' }}
                            </p>
                        </div>
                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[12px] dark:text-gray-500 text-gray-400"> <i
                                    class="fas fa-calendar-alt mr-1"></i> Started</p>
                            <p class="text-[13px] font-bold dark:text-white text-gray-800">
                                {{ $habit->start_date ? $habit->start_date->format('d M Y') : '—' }}
                            </p>
                        </div>
                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[12px] dark:text-gray-500 text-gray-400"> <i class="fas fa-chart-line mr-1"></i>
                                30-day Rate</p>
                            <p class="text-[13px] font-bold text-orange-400">{{ $habit->completion_rate }}%</p>
                        </div>
                    </div>

                    {{-- Mark done button --}}
                    @unless (optional($habit->todayLog)->is_completed)
                        <form action="{{ route('user.habits.toggle', $habit) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="w-full py-2.5 rounded-[10px] text-[14px] font-bold text-white
                                bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.3)]">
                                <i class="fas fa-check mr-2"></i>Mark as Done Today
                            </button>
                        </form>
                    @else
                        <div
                            class="mt-4 py-2.5 rounded-[10px] text-[14px] font-bold text-center
                            dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500">
                            <i class="fas fa-check-circle mr-2"></i>Completed for today!
                        </div>
                    @endunless
                </div>

                {{-- ─── 90-Day Heatmap ─────────────────────────────── --}}
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-[15px] font-bold dark:text-white text-gray-900">
                            <i class="fas fa-fire-alt mr-1.5 text-orange-400"></i>90-Day Heatmap
                        </h3>
                        <div class="flex items-center gap-2 text-[11px] dark:text-gray-500 text-gray-400">
                            <span class="inline-block w-3 h-3 rounded-sm dark:bg-white/[0.08] bg-gray-100"></span> None
                            <span class="inline-block w-3 h-3 rounded-sm bg-orange-400"></span> Done
                        </div>
                    </div>

                    <div class="overflow-x-auto pb-1">
                        <div class="flex gap-1" style="min-width:max-content">
                            @php
                                $weeks = array_chunk(array_keys($heatmap), 7);
                            @endphp
                            @foreach ($weeks as $week)
                                <div class="flex flex-col gap-1">
                                    @foreach ($week as $date)
                                        @php
                                            $done = $heatmap[$date];
                                            $isToday = $date === today()->format('Y-m-d');
                                            $label = \Carbon\Carbon::parse($date)->format('d M Y');
                                            $bg = $done ? 'bg-orange-400' : 'dark:bg-white/[0.06] bg-gray-100';
                                            $ring = $isToday
                                                ? 'ring-1 ring-orange-400 ring-offset-1 dark:ring-offset-[#17141f] ring-offset-white'
                                                : '';
                                        @endphp
                                        <div title="{{ $label }} — {{ $done ? 'Completed' : 'Not done' }}"
                                            class="w-[14px] h-[14px] rounded-[3px] {{ $bg }} {{ $ring }} cursor-default transition-opacity hover:opacity-70">
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <p class="text-[11px] dark:text-gray-600 text-gray-400 mt-2">
                        Showing last 90 days · hover a cell to see the date
                    </p>
                </div>

                {{-- Completion Logs --}}
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <h3 class="text-[15px] font-bold dark:text-white text-gray-900 mb-3.5">
                        <i class="fas fa-history mr-1.5 text-orange-400"></i>Completion Logs
                        <span class="text-[12px] font-normal dark:text-gray-500 text-gray-400 ml-1">(last 30)</span>
                    </h3>

                    <div class="space-y-2">
                        @forelse ($logs as $log)
                            <div
                                class="flex items-center justify-between py-2.5 border-b dark:border-white/[0.06] border-black/[0.05]">
                                <div>
                                    <p class="text-[13px] font-bold dark:text-gray-200 text-gray-800">
                                        {{ $log->log_date->format('d M, Y') }}
                                        @if ($log->log_date->isToday())
                                            <span class="ml-1 text-[11px] font-normal text-orange-400">Today</span>
                                        @endif
                                    </p>
                                    <p class="text-[11px] dark:text-gray-500 text-gray-400">
                                        Logged at {{ $log->created_at->format('h:i A') }}
                                    </p>
                                </div>
                                <span
                                    class="px-2.5 py-1 rounded-lg text-[11px] font-bold
                                    dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500">
                                    <i class="fas fa-check mr-1"></i> Done
                                </span>
                            </div>
                        @empty
                            <div
                                class="border border-dashed dark:border-white/[0.08] border-black/[0.08] rounded-xl p-5 text-center">
                                <i class="fas fa-calendar-times text-2xl text-gray-300 dark:text-gray-600 mb-2 block"></i>
                                <p class="text-[12px] dark:text-gray-500 text-gray-400">No completions yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Right: Streak Summary + Reminder info --}}
            <div class="space-y-4">
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <h3 class="text-[15px] font-bold dark:text-white text-gray-900 mb-4">
                        <i class="fas fa-fire text-orange-400 mr-1.5"></i>Streak Summary
                    </h3>

                    <div class="space-y-3">
                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4 text-center">
                            <p class="text-[12px] dark:text-gray-500 text-gray-400 mb-1"> <i class="fas fa-fire mr-1"></i>
                                Current Streak</p>
                            <h4 class="text-[36px] font-extrabold dark:text-white text-gray-900 leading-none">
                                {{ $habit->streak?->current_streak ?? 0 }}
                            </h4>
                            <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-1">days</p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4 text-center">
                            <p class="text-[12px] dark:text-gray-500 text-gray-400 mb-1"> <i class="fas fa-trophy mr-1"></i>
                                Best Streak</p>
                            <h4 class="text-[36px] font-extrabold text-orange-400 leading-none">
                                {{ $habit->streak?->best_streak ?? 0 }}
                            </h4>
                            <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-1">days</p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[12px] dark:text-gray-500 text-gray-400"> <i
                                    class="fas fa-calendar-check mr-1"></i> Last Completed</p>
                            <p class="text-[13px] font-bold dark:text-white text-gray-800 mt-1">
                                {{ $habit->streak?->last_completed_date
                                    ? $habit->streak->last_completed_date->format('d M, Y')
                                    : 'Not completed yet' }}
                            </p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[12px] dark:text-gray-500 text-gray-400"> <i
                                    class="fas fa-check-circle mr-1"></i> Total Completions</p>
                            <p class="text-[13px] font-bold dark:text-white text-gray-800 mt-1">
                                {{ $logs->count() }} times
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Reminder info --}}
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <h3 class="text-[15px] font-bold dark:text-white text-gray-900 mb-3">
                        <i class="fas fa-bell text-orange-400 mr-1.5"></i>Reminder
                    </h3>

                    @if ($habit->reminder_enabled && $habit->remind_time)
                        <div class="flex items-center gap-2.5 dark:bg-orange-500/[0.08] bg-orange-50 rounded-xl p-3">
                            <i class="fas fa-clock text-orange-400"></i>
                            <div>
                                <p class="text-[13px] font-bold dark:text-gray-200 text-gray-700">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $habit->remind_time)->format('h:i A') }}
                                </p>
                                <p class="text-[11px] dark:text-gray-500 text-gray-400"> <i
                                        class="fas fa-sync-alt mr-1"></i> Every day</p>
                            </div>
                        </div>
                    @else
                        <p class="text-[12px] dark:text-gray-500 text-gray-400 italic">
                            No reminder set.
                            <a href="{{ route('user.habits.edit', $habit) }}" class="text-orange-400 underline ml-1">Add
                                one</a>
                        </p>
                    @endif
                </div>

                {{-- Weekly days (if weekly habit) --}}
                @if ($habit->frequency === 'weekly' && $habit->days)
                    <div
                        class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                        <h3 class="text-[15px] font-bold dark:text-white text-gray-900 mb-3">
                            <i class="fas fa-calendar-week text-orange-400 mr-1.5"></i>Repeat Days
                        </h3>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach (['mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 'thu' => 'Thu', 'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun'] as $key => $label)
                                <span
                                    class="px-2.5 py-1 rounded-lg text-[12px] font-bold
                                    {{ in_array($key, $habit->days)
                                        ? 'bg-orange-500 text-white'
                                        : 'dark:bg-white/[0.06] bg-gray-100 dark:text-gray-500 text-gray-400' }}">
                                    {{ $label }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </section>
@endsection
