@extends('user.layouts.master')

@section('user')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[22px] font-extrabold dark:text-white text-gray-900">📆 Weekly Report</h2>
                <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-0.5">{{ $weekLabel }} ·
                    {{ $start->format('d M') }} – {{ $end->format('d M Y') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('user.analytics.index') }}"
                    class="px-3 py-2 rounded-xl text-[13px] dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600 font-bold">←
                    Overview</a>
                @if ($weekOffset > 0)
                    <a href="{{ route('user.analytics.weekly', ['week' => $weekOffset - 1]) }}"
                        class="px-3 py-2 rounded-xl text-[13px] dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600 font-bold">Newer
                        →</a>
                @endif
                <a href="{{ route('user.analytics.weekly', ['week' => $weekOffset + 1]) }}"
                    class="px-3 py-2 rounded-xl text-[13px] dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600 font-bold">←
                    Older</a>
            </div>
        </div>

        {{-- Week Totals --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @php $totals = [['v' => $weekTasks, 'l' => 'Tasks Completed', 'change' => $taskChange, 'c' => 'text-emerald-400', 'icon' => '✅'], ['v' => $weekHabits, 'l' => 'Habit Check-ins', 'change' => null, 'c' => 'text-orange-400', 'icon' => '🔥'], ['v' => $weekFocus . 'm', 'l' => 'Focus Minutes', 'change' => $focusChange, 'c' => 'text-blue-400', 'icon' => '⏱'], ['v' => $weekXp, 'l' => 'XP Earned', 'change' => null, 'c' => 'text-purple-400', 'icon' => '⚡']]; @endphp
            @foreach ($totals as $t)
                <div class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xl">{{ $t['icon'] }}</span>
                        @if ($t['change'] !== null)
                            <span
                                class="text-[11px] font-bold px-2 py-0.5 rounded-full
                    {{ $t['change'] >= 0 ? 'dark:bg-emerald-500/10 bg-emerald-50 text-emerald-500' : 'dark:bg-red-500/10 bg-red-50 text-red-500' }}">
                                {{ $t['change'] >= 0 ? '+' : '' }}{{ $t['change'] }}%
                            </span>
                        @endif
                    </div>
                    <p class="text-[26px] font-black {{ $t['c'] }}">{{ $t['v'] }}</p>
                    <p class="text-[12px] font-bold dark:text-gray-400 text-gray-500">{{ $t['l'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Day-by-Day Breakdown --}}
        <div
            class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] overflow-hidden">
            <div class="px-5 py-4 border-b dark:border-white/[0.06] border-black/[0.05]">
                <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900">Day-by-Day Breakdown</h3>
            </div>

            {{-- Chart --}}
            <div class="grid grid-cols-7 gap-px dark:bg-white/[0.05] bg-gray-100">
                @foreach ($days as $day)
                    @php
                        $total = $day['tasks'] + $day['habits'];
                        $isToday = $day['date'] === now()->format('Y-m-d');
                        $maxTotal = max(1, collect($days)->max(fn($d) => $d['tasks'] + $d['habits']));
                    @endphp
                    <div
                        class="dark:bg-[#17141f] bg-white p-3 flex flex-col items-center gap-2
                {{ $isToday ? 'dark:bg-orange-500/5 bg-orange-50' : '' }}">
                        <span
                            class="text-[12px] font-bold {{ $isToday ? 'text-orange-400' : 'dark:text-gray-400 text-gray-500' }}">{{ $day['label'] }}</span>

                        {{-- Stacked visual --}}
                        <div class="w-full space-y-1">
                            @if ($day['tasks'] > 0)
                                <div class="h-2 rounded-full bg-emerald-500"
                                    style="width:{{ round(($day['tasks'] / $maxTotal) * 100) }}%"></div>
                            @endif
                            @if ($day['habits'] > 0)
                                <div class="h-2 rounded-full bg-orange-400"
                                    style="width:{{ round(($day['habits'] / $maxTotal) * 100) }}%"></div>
                            @endif
                            @if ($day['focus'] > 0)
                                <div class="h-2 rounded-full bg-blue-400"
                                    style="width:{{ min(100, round(($day['focus'] / 120) * 100)) }}%"></div>
                            @endif
                        </div>

                        <div class="text-center">
                            <p class="text-[11px] dark:text-gray-400 text-gray-600">✅ {{ $day['tasks'] }}</p>
                            <p class="text-[11px] dark:text-gray-400 text-gray-600">🔥 {{ $day['habits'] }}</p>
                            <p class="text-[11px] dark:text-gray-400 text-gray-600">⏱ {{ $day['focus'] }}m</p>
                            @if ($day['journals'] > 0)
                                <p class="text-[11px] text-purple-400">✍️ {{ $day['journals'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div
                class="px-5 py-3 flex gap-4 text-[11px] dark:text-gray-500 text-gray-400 border-t dark:border-white/[0.05] border-black/[0.04]">
                <span><span class="inline-block w-2 h-2 rounded bg-emerald-500 mr-1"></span>Tasks</span>
                <span><span class="inline-block w-2 h-2 rounded bg-orange-400 mr-1"></span>Habits</span>
                <span><span class="inline-block w-2 h-2 rounded bg-blue-400 mr-1"></span>Focus</span>
            </div>
        </div>

    </div>
@endsection
