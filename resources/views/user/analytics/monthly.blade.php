@extends('user.layouts.master')

@section('user')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[22px] font-extrabold dark:text-white text-gray-900">📅 Monthly Report</h2>
                <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-0.5">{{ $monthLabel }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('user.analytics.index') }}"
                    class="px-3 py-2 rounded-xl text-[13px] dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600 font-bold">←
                    Overview</a>
                @if ($monthOffset > 0)
                    <a href="{{ route('user.analytics.monthly', ['month' => $monthOffset - 1]) }}"
                        class="px-3 py-2 rounded-xl text-[13px] dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600 font-bold">Newer
                        →</a>
                @endif
                <a href="{{ route('user.analytics.monthly', ['month' => $monthOffset + 1]) }}"
                    class="px-3 py-2 rounded-xl text-[13px] dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600 font-bold">←
                    Older</a>
            </div>
        </div>

        {{-- Month Totals --}}
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
            @php $totals = [['v' => $monthTasks, 'l' => 'Tasks Done', 'c' => $taskChange, 'icon' => '✅', 'color' => 'text-emerald-400'], ['v' => $monthHabits, 'l' => 'Habit Logs', 'c' => null, 'icon' => '🔥', 'color' => 'text-orange-400'], ['v' => round($monthFocus / 60, 1) . 'h', 'l' => 'Focus Time', 'c' => $focusChange, 'icon' => '⏱', 'color' => 'text-blue-400'], ['v' => $monthJournal, 'l' => 'Journals', 'c' => null, 'icon' => '✍️', 'color' => 'text-purple-400'], ['v' => $monthGoals, 'l' => 'Goals Done', 'c' => null, 'icon' => '🎯', 'color' => 'text-pink-400']]; @endphp
            @foreach ($totals as $t)
                <div class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xl">{{ $t['icon'] }}</span>
                        @if ($t['c'] !== null)
                            <span
                                class="text-[11px] font-bold px-2 py-0.5 rounded-full
                    {{ $t['c'] >= 0 ? 'dark:bg-emerald-500/10 bg-emerald-50 text-emerald-500' : 'dark:bg-red-500/10 bg-red-50 text-red-500' }}">
                                {{ $t['c'] >= 0 ? '+' : '' }}{{ $t['c'] }}%
                            </span>
                        @endif
                    </div>
                    <p class="text-[26px] font-black {{ $t['color'] }}">{{ $t['v'] }}</p>
                    <p class="text-[12px] font-bold dark:text-gray-400 text-gray-500 mt-0.5">{{ $t['l'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Top Habit --}}
        @if ($topHabit && $topHabit->month_completions > 0)
            <div
                class="dark:bg-gradient-to-r dark:from-orange-500/10 dark:to-pink-500/10 bg-orange-50 rounded-2xl border dark:border-orange-500/20 border-orange-200 p-5 flex items-center gap-4">
                <div class="text-3xl">🏅</div>
                <div>
                    <p class="text-[12px] font-bold dark:text-gray-400 text-gray-500">Top Habit This Month</p>
                    <p class="text-[18px] font-extrabold dark:text-white text-gray-900">{{ $topHabit->title }}</p>
                    <p class="text-[13px] text-orange-400 font-bold">{{ $topHabit->month_completions }} completions in
                        {{ $monthLabel }}</p>
                </div>
            </div>
        @endif

        {{-- Calendar Heatmap --}}
        <div class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] p-5">
            <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900 mb-4">Daily Activity — {{ $monthLabel }}
            </h3>
            @php
                $maxActivity = max(1, collect($days)->max(fn($d) => $d['tasks'] + $d['habits']));
                $startDow = $start->dayOfWeek; // 0=Sun
            @endphp
            <div class="grid grid-cols-7 gap-1.5">
                {{-- DOW Labels --}}
                @foreach (['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $dow)
                    <div class="text-center text-[10px] dark:text-gray-600 text-gray-400 font-bold pb-1">
                        {{ $dow }}</div>
                @endforeach
                {{-- Empty cells before month start --}}
                @for ($e = 0; $e < $startDow; $e++)
                    <div></div>
                @endfor
                {{-- Day cells --}}
                @foreach ($days as $day)
                    @php
                        $activity = $day['tasks'] + $day['habits'];
                        $opacity = $activity > 0 ? max(20, round(($activity / $maxActivity) * 100)) : 0;
                        $isToday = $day['date'] === now()->format('Y-m-d');
                    @endphp
                    <div title="{{ $day['date'] }}: ✅{{ $day['tasks'] }} 🔥{{ $day['habits'] }} ⏱{{ $day['focus'] }}m"
                        class="aspect-square rounded-lg flex items-center justify-center text-[10px] font-bold cursor-default
                {{ $isToday ? 'ring-2 ring-orange-400' : '' }}
                {{ $activity === 0 ? 'dark:bg-white/[0.04] bg-gray-100 dark:text-gray-700 text-gray-300' : 'text-white' }}"
                        @if ($activity > 0) style="background:rgba(249,115,22,{{ $opacity / 100 }})" @endif>
                        {{ $day['day'] }}
                    </div>
                @endforeach
            </div>
            <div class="flex items-center gap-2 mt-3 text-[11px] dark:text-gray-500 text-gray-400">
                <span>Less active</span>
                @foreach ([10, 30, 50, 70, 100] as $op)
                    <div class="w-4 h-4 rounded" style="background:rgba(249,115,22,{{ $op / 100 }})"></div>
                @endforeach
                <span>More active</span>
            </div>
        </div>

        {{-- Daily Focus Bar Chart --}}
        <div class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] p-5">
            <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900 mb-4">Focus Time Per Day —
                {{ $monthLabel }}</h3>
            @php $maxFocusDay = max(1, collect($days)->max('focus')); @endphp
            <div class="flex items-end gap-1" style="height:80px">
                @foreach ($days as $day)
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full rounded-t {{ $day['focus'] > 0 ? 'bg-blue-500/60' : 'dark:bg-white/[0.04] bg-gray-100' }}"
                            style="height:{{ max(2, round(($day['focus'] / $maxFocusDay) * 70)) }}px"></div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between text-[10px] dark:text-gray-600 text-gray-400 mt-1">
                <span>1</span><span>{{ round($daysInMonth / 2) }}</span><span>{{ $daysInMonth }}</span>
            </div>
        </div>

    </div>
@endsection
