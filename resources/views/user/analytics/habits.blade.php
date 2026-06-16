@extends('user.layouts.master')

@section('user')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[22px] font-extrabold dark:text-white text-gray-800"><i
                        class="fas fa-fire text-orange-400 dark:text-orange-400"></i> Habit Analytics</h2>
                <p class="text-[13px] dark:text-white text-gray-800 mt-0.5">Streaks, completion rates and daily heatmap.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('user.analytics.index') }}"
                    class="px-3 py-2 rounded-xl text-[13px] dark:bg-white/[0.06] bg-gray-100 dark:text-white text-gray-800 font-bold">
                    <i class="fas fa-arrow-left"></i> Overview</a>
                @foreach ([7, 30, 90] as $p)
                    <a href="{{ route('user.analytics.habits', ['period' => $p]) }}"
                        class="px-3 py-2 rounded-xl text-[13px] font-bold transition
                {{ $period == $p ? 'bg-gradient-to-r from-orange-500 to-pink-500 text-white' : 'dark:bg-white/[0.06] bg-gray-100 dark:text-white text-gray-800' }}">
                        <i class="fas fa-calendar-alt"></i> {{ $p }}d
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @php $cards = [['v' => $totalHabits, 'l' => 'Active Habits', 's' => 'currently tracking', 'c' => 'text-orange-400'], ['v' => round($avgRate) . '%', 'l' => 'Avg Completion', 's' => "last {$period} days", 'c' => 'text-emerald-400'], ['v' => $currentStreak . 'd', 'l' => 'Best Streak Now', 's' => 'current active streak', 'c' => 'text-pink-400'], ['v' => $bestStreak . 'd', 'l' => 'All-Time Best', 's' => 'longest streak ever', 'c' => 'text-purple-400']]; @endphp
            @foreach ($cards as $c)
                <div class="veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl border p-4">
                    <p class="text-[26px] font-black {{ $c['c'] }}">{{ $c['v'] }}</p>
                    <p class="text-[13px] font-bold dark:text-white text-gray-900">{{ $c['l'] }}</p>
                    <p class="text-[11px] dark:text-white text-gray-800">{{ $c['s'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Daily Completions Chart --}}
        <div class="veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl border p-5">
            <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900 mb-4">Daily Habit Completions — Last
                {{ $period }} Days</h3>
            @php $maxH = max(1, collect($habitChart)->max('count')); @endphp
            <div class="flex items-end gap-1 overflow-x-auto pb-2" style="height:100px">
                @foreach ($habitChart as $day)
                    <div class="flex flex-col items-center flex-shrink-0"
                        style="min-width:{{ $period <= 14 ? '32px' : '10px' }}">
                        <div class="w-full rounded-t {{ $day['count'] > 0 ? 'bg-gradient-to-t from-orange-500 to-pink-400' : 'dark:bg-gray-400 bg-gray-600' }}"
                            style="height:{{ max(3, round(($day['count'] / $maxH) * 80)) }}px"></div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Per-Habit Table --}}
        <div class="veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl border overflow-hidden">
            <div class="px-5 py-4 border-b dark:border-white/[0.06] border-black/[0.05]">
                <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900">Habit Performance (Last
                    {{ $period }} Days)</h3>
            </div>
            <div class="divide-y dark:divide-white/[0.05] divide-black/[0.04]">
                @forelse($habits as $h)
                    <div class="px-5 py-3 flex items-center gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span
                                    class="text-[13px] font-bold dark:text-white text-gray-900 truncate">{{ $h['title'] }}</span>
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded-full {{ $h['type'] === 'positive' ? 'dark:bg-emerald-500/10 bg-emerald-50 text-emerald-500' : 'dark:bg-red-500/10 bg-red-50 text-red-500' }}">
                                    {{ $h['type'] }}
                                </span>
                            </div>
                            <div class="h-2 rounded-full dark:bg-white/10 bg-gray-400 overflow-hidden">
                                <div class="h-full rounded-full {{ $h['rate'] >= 70 ? 'bg-emerald-500' : ($h['rate'] >= 40 ? 'bg-orange-400' : 'bg-red-400') }}"
                                    style="width:{{ $h['rate'] }}%"></div>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p
                                class="text-[15px] font-black {{ $h['rate'] >= 70 ? 'text-emerald-400' : ($h['rate'] >= 40 ? 'text-orange-400' : 'text-red-400') }}">
                                {{ $h['rate'] }}%</p>
                            <p class="text-[10px] dark:text-gray-600 text-gray-400">{{ $h['done'] }} done</p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-[14px] font-black text-orange-400">🔥 {{ $h['streak'] }}d</p>
                            <p class="text-[10px] dark:text-gray-600 text-gray-400">best: {{ $h['best'] }}d</p>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-8 text-center text-[14px] dark:text-white text-gray-800">No active habits found.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Heatmap (last 90 days) --}}
        <div class="veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl border p-5">
            <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900 mb-4">Activity Heatmap — Last 90 Days</h3>
            <div class="flex flex-wrap gap-1">
                @php
                    $heatMax = max(1, $heatmap->max());
                @endphp
                @for ($i = 89; $i >= 0; $i--)
                    @php
                        $d = now()->subDays($i)->format('Y-m-d');
                        $cnt = $heatmap[$d] ?? 0;
                        $alpha = $cnt > 0 ? max(20, round(($cnt / $heatMax) * 100)) : 0;
                    @endphp
                    <div title="{{ $d }}: {{ $cnt }} completions"
                        class="w-3.5 h-3.5 rounded-sm cursor-default {{ $cnt === 0 ? 'dark:bg-white/[0.05] bg-gray-400' : '' }}"
                        @if ($cnt > 0) style="background:rgba(249,115,22,{{ $alpha / 100 }})" @endif>
                    </div>
                @endfor
            </div>
            <div class="flex items-center gap-2 mt-3 text-[11px] dark:text-white text-gray-800">
                <span>Less</span>
                @foreach ([5, 20, 40, 70, 100] as $op)
                    <div class="w-3.5 h-3.5 rounded-sm" style="background:rgba(249,115,22,{{ $op / 100 }})"></div>
                @endforeach
                <span>More</span>
            </div>
        </div>

    </div>
@endsection
