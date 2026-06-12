@extends('user.layouts.master')

@section('user')
    <div class="space-y-6">

        {{-- Header + Period Filter --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[22px] font-extrabold dark:text-white text-gray-900">✅ Productivity Analytics</h2>
                <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-0.5">Task completion trends, priorities & streaks.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('user.analytics.index') }}"
                    class="px-3 py-2 rounded-xl text-[13px] dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600 font-bold">←
                    Overview</a>
                @foreach ([7, 30, 90] as $p)
                    <a href="{{ route('user.analytics.productivity', ['period' => $p]) }}"
                        class="px-3 py-2 rounded-xl text-[13px] font-bold transition
                {{ $period == $p ? 'bg-gradient-to-r from-orange-500 to-pink-500 text-white' : 'dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600' }}">
                        {{ $p }}d
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @php $cards = [['v' => $completedInPeriod, 'l' => 'Completed', 's' => "last {$period} days", 'c' => 'text-emerald-400'], ['v' => $avgPerDay, 'l' => 'Avg / Day', 's' => 'tasks completed', 'c' => 'text-orange-400'], ['v' => $overdueRate . '%', 'l' => 'Overdue Rate', 's' => 'of tasks with deadline', 'c' => 'text-red-400'], ['v' => $completionStreak . 'd', 'l' => 'Active Streak', 's' => 'consecutive days', 'c' => 'text-purple-400']]; @endphp
            @foreach ($cards as $c)
                <div class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] p-4">
                    <p class="text-[26px] font-black {{ $c['c'] }}">{{ $c['v'] }}</p>
                    <p class="text-[13px] font-bold dark:text-white text-gray-900">{{ $c['l'] }}</p>
                    <p class="text-[11px] dark:text-gray-500 text-gray-400">{{ $c['s'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Tasks Completed Per Day Chart --}}
        <div class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] p-5">
            <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900 mb-4">Tasks Completed — Last
                {{ $period }} Days</h3>
            @php
                $maxCount = max(1, collect($taskChart)->max('count'));
                $showEvery = $period <= 14 ? 1 : ($period <= 30 ? 3 : 7);
            @endphp
            <div class="flex items-end gap-1 overflow-x-auto pb-2" style="height:120px">
                @foreach ($taskChart as $i => $day)
                    <div class="flex flex-col items-center gap-0.5 flex-shrink-0"
                        style="min-width:{{ $period <= 14 ? '32px' : '14px' }}">
                        @if ($day['count'] > 0)
                            <span class="text-[9px] text-orange-400 font-bold">{{ $day['count'] }}</span>
                        @endif
                        <div class="w-full rounded-t transition-all {{ $day['date'] === now()->format('Y-m-d') ? 'bg-gradient-to-t from-orange-500 to-pink-500' : 'dark:bg-white/[0.12] bg-orange-100' }}"
                            style="height:{{ max(3, round(($day['count'] / $maxCount) * 90)) }}px"></div>
                        @if ($i % $showEvery === 0)
                            <span
                                class="text-[9px] dark:text-gray-600 text-gray-400">{{ $day['count'] > 0 ? substr($day['label'], 0, 5) : '' }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            {{-- Priority Breakdown --}}
            <div class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] p-5">
                <h3 class="text-[15px] font-extrabold dark:text-white text-gray-900 mb-4">Priority Breakdown</h3>
                @php
                    $priorityColors = ['high' => 'bg-red-500', 'medium' => 'bg-orange-400', 'low' => 'bg-emerald-500'];
                    $priorityTotal = max(1, $priorityBreakdown->sum());
                @endphp
                <div class="space-y-3">
                    @foreach (['high', 'medium', 'low'] as $p)
                        @php
                            $cnt = $priorityBreakdown[$p] ?? 0;
                            $pct = round(($cnt / $priorityTotal) * 100);
                        @endphp
                        <div>
                            <div class="flex justify-between text-[13px] mb-1">
                                <span
                                    class="font-bold dark:text-gray-300 text-gray-700 capitalize">{{ $p }}</span>
                                <span class="dark:text-gray-500 text-gray-400">{{ $cnt }}
                                    ({{ $pct }}%)</span>
                            </div>
                            <div class="h-2 rounded-full dark:bg-white/10 bg-gray-100 overflow-hidden">
                                <div class="{{ $priorityColors[$p] ?? 'bg-gray-400' }} h-full rounded-full"
                                    style="width:{{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Status Breakdown --}}
            <div class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] p-5">
                <h3 class="text-[15px] font-extrabold dark:text-white text-gray-900 mb-4">Status Overview</h3>
                @php
                    $statusColors = [
                        'completed' => 'bg-emerald-500',
                        'in_progress' => 'bg-blue-500',
                        'pending' => 'bg-orange-400',
                        'cancelled' => 'bg-gray-400',
                    ];
                    $statusTotal = max(1, $statusBreakdown->sum());
                @endphp
                <div class="space-y-3">
                    @foreach ($statusBreakdown as $status => $cnt)
                        @php $pct = round($cnt/$statusTotal*100); @endphp
                        <div>
                            <div class="flex justify-between text-[13px] mb-1">
                                <span
                                    class="font-bold dark:text-gray-300 text-gray-700 capitalize">{{ str_replace('_', ' ', $status) }}</span>
                                <span class="dark:text-gray-500 text-gray-400">{{ $cnt }}
                                    ({{ $pct }}%)</span>
                            </div>
                            <div class="h-2 rounded-full dark:bg-white/10 bg-gray-100 overflow-hidden">
                                <div class="{{ $statusColors[$status] ?? 'bg-orange-400' }} h-full rounded-full"
                                    style="width:{{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Category Breakdown --}}
            <div class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] p-5">
                <h3 class="text-[15px] font-extrabold dark:text-white text-gray-900 mb-4">Top Categories</h3>
                @php $catMax = max(1, $categoryBreakdown->max('count')); @endphp
                <div class="space-y-3">
                    @forelse($categoryBreakdown as $cat)
                        <div>
                            <div class="flex justify-between text-[13px] mb-1">
                                <span
                                    class="font-bold dark:text-gray-300 text-gray-700 truncate max-w-[130px]">{{ $cat->name }}</span>
                                <span class="dark:text-gray-500 text-gray-400">{{ $cat->count }}</span>
                            </div>
                            <div class="h-2 rounded-full dark:bg-white/10 bg-gray-100 overflow-hidden">
                                <div class="bg-gradient-to-r from-orange-500 to-pink-500 h-full rounded-full"
                                    style="width:{{ round(($cat->count / $catMax) * 100) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-[13px] dark:text-gray-500 text-gray-400">No category data yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endsection
