@extends('user.layouts.master')

@section('user')
    <div class="space-y-6">

        {{-- Header --}}
        <section
            class="relative overflow-hidden rounded-2xl border veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] px-6 py-6">

            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-[28px] font-extrabold dark:text-white text-gray-800"><i class="fas fa-chart-line"></i>
                        Analytics Overview</h1>
                    <p class="text-[14px] dark:text-white text-gray-800 mt-1">Your complete productivity at a glance.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('user.analytics.productivity') }}"
                        class="px-4 py-2 rounded-xl text-[13px] font-bold dark:bg-white/[0.07] bg-white border dark:border-white/[0.1] border-orange-200 dark:text-gray-300 text-gray-700">
                        <i class="fas fa-tasks"></i> Tasks</a>
                    <a href="{{ route('user.analytics.habits') }}"
                        class="px-4 py-2 rounded-xl text-[13px] font-bold dark:bg-white/[0.07] bg-white border dark:border-white/[0.1] border-orange-200 dark:text-gray-300 text-gray-700">
                        <i class="fas fa-hands-helping"></i> Habits</a>
                    <a href="{{ route('user.analytics.focus') }}"
                        class="px-4 py-2 rounded-xl text-[13px] font-bold dark:bg-white/[0.07] bg-white border dark:border-white/[0.1] border-orange-200 dark:text-gray-300 text-gray-700">
                        <i class="fas fa-clock"></i> Focus</a>
                    <a href="{{ route('user.analytics.weekly') }}"
                        class="px-4 py-2 rounded-xl text-[13px] font-bold dark:bg-white/[0.07] bg-white border dark:border-white/[0.1] border-orange-200 dark:text-gray-300 text-gray-700">
                        <i class="fas fa-calendar-week"></i> Weekly</a>
                    <a href="{{ route('user.analytics.monthly') }}"
                        class="px-4 py-2 rounded-xl text-[13px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                        <i class="fas fa-calendar-month"></i> Monthly</a>
                </div>
            </div>
        </section>

        {{-- Productivity Score --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div
                class="md:col-span-1 veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl border p-5 flex flex-col items-center justify-center text-center">
                <div class="relative w-28 h-28 mb-3">
                    <svg class="w-28 h-28 -rotate-90" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="50" fill="none" stroke-width="10"
                            class="dark:stroke-white/10 stroke-gray-400" />
                        <circle cx="60" cy="60" r="50" fill="none" stroke-width="10"
                            stroke-dasharray="{{ round($productivityScore * 3.14) }} 314" class="stroke-orange-500"
                            stroke-linecap="round" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-[26px] font-black dark:text-white text-gray-900">{{ $productivityScore }}</span>
                        <span class="text-[10px] dark:text-white text-gray-800 font-bold">/100</span>
                    </div>
                </div>
                <p class="text-[14px] font-extrabold dark:text-white text-gray-900"><i class="fas fa-chart-line"></i>
                    Productivity Score</p>
                <p class="text-[11px] dark:text-white text-gray-800 mt-1">Tasks · Habits · Goals · Focus</p>
            </div>

            <div class="md:col-span-3 grid grid-cols-2 sm:grid-cols-4 gap-4">
                @php
                    $stats = [
                        [
                            'label' => 'Tasks Done',
                            'value' => $completedTasks,
                            'sub' => "of {$totalTasks} · {$taskRate}%",
                            'color' => 'text-emerald-400',
                            'icon' => 'fas fa-circle-check',
                        ],
                        [
                            'label' => 'Habit Rate',
                            'value' => $habitRate . '%',
                            'sub' => "today · streak {$bestStreak}d",
                            'color' => 'text-orange-400',
                            'icon' => 'fas fa-fire',
                        ],
                        [
                            'label' => 'Focus Hours',
                            'value' => $focusHours . 'h',
                            'sub' => "{$totalFocusSessions} sessions total",
                            'color' => 'text-blue-400',
                            'icon' => 'fas fa-stopwatch',
                        ],
                        [
                            'label' => 'Goals Done',
                            'value' => $completedGoals,
                            'sub' => "of {$totalGoals} · {$goalRate}%",
                            'color' => 'text-pink-400',
                            'icon' => 'fas fa-bullseye',
                        ],
                    ];
                @endphp

                @foreach ($stats as $s)
                    <div
                        class="veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl border p-4 flex flex-col justify-between">

                        <div class="flex items-center justify-between mb-3">
                            <div
                                class="w-10 h-10 rounded-xl flex items-center justify-center bg-white/[0.04] dark:bg-white/[0.04]">
                                <i class="{{ $s['icon'] }} {{ $s['color'] }} text-lg"></i>
                            </div>

                            <span class="text-[11px] dark:text-gray-600 text-gray-400 font-bold">
                                {{ $s['sub'] }}
                            </span>
                        </div>

                        <div>
                            <p class="text-[26px] font-black {{ $s['color'] }}">
                                {{ $s['value'] }}
                            </p>

                            <p class="text-[12px] dark:text-white text-gray-500 font-bold mt-0.5">
                                {{ $s['label'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Weekly Activity Chart (bar) --}}
        <div
            class="veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl border p-5
            bg-[#fbefd9]/85 border-orange-200/60
            dark:bg-[#0f0a1c] dark:border-pink-500/15">

            <h3 class="text-[17px] font-extrabold dark:text-white text-[#151515] mb-5">
                <i class="fas fa-calendar-alt text-[#ff8a12] dark:text-[#ff2fa8]"></i>
                Last 7 Days Activity
            </h3>

            <div class="grid grid-cols-7 gap-2 items-end" style="height:140px">
                @php
                    $maxVal = max(1, collect($weeklyActivity)->max(fn($d) => $d['tasks'] + $d['habits']));
                @endphp

                @foreach ($weeklyActivity as $day)
                    @php
                        $total = $day['tasks'] + $day['habits'];
                        $pct = round(($total / $maxVal) * 100);
                        $isToday = $day['date'] === now()->format('Y-m-d');
                    @endphp

                    <div class="flex flex-col items-center gap-1">
                        <span class="text-[11px] dark:text-gray-500 text-[#8b7355]">
                            {{ $total > 0 ? $total : '' }}
                        </span>

                        <div class="w-full rounded-t-lg transition-all
                            {{ $isToday
                                ? 'bg-gradient-to-t from-[#ff8a12] via-[#ff6b2c] to-[#ff2fa8] shadow-[0_0_12px_rgba(255,138,18,.35)] dark:shadow-[0_0_14px_rgba(255,47,168,.30)]'
                                : 'dark:bg-[#21152f] bg-[#f9d9b1]' }}"
                            style="height:{{ max(6, $pct) }}%">
                        </div>

                        <span
                            class="text-[11px] font-bold
                            {{ $isToday ? 'text-[#ff8a12] dark:text-[#ff2fa8]' : 'dark:text-gray-500 text-[#8b7355]' }}">
                            {{ $day['label'] }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="flex gap-4 mt-4 text-[12px] dark:text-gray-500 text-[#8b7355]">
                <span class="flex items-center">
                    <span class="inline-block w-3 h-3 rounded bg-gradient-to-r from-[#ff8a12] to-[#ff2fa8] mr-1"></span>
                    Today
                </span>

                <span class="flex items-center">
                    <span class="inline-block w-3 h-3 rounded dark:bg-[#21152f] bg-[#f9d9b1] mr-1"></span>
                    Other days
                </span>

                <span class="ml-auto">Bar = tasks + habits combined</span>
            </div>
        </div>

        {{-- Bottom Stats Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl border p-5">
                <p class="text-[13px] dark:text-white text-gray-800 font-bold mb-1"><i class="fas fa-star"></i> XP Earned
                </p>
                <p class="text-[32px] font-black text-orange-400">{{ number_format($totalXp) }}</p>
                <p class="text-[12px] dark:text-white text-gray-800 mt-1">Level {{ $level }}</p>
            </div>
            <div class="veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl border p-5">
                <p class="text-[13px] dark:text-white text-gray-800 font-bold mb-1"><i class="fas fa-book"></i> Journals
                    Written</p>
                <p class="text-[32px] font-black text-purple-400">{{ $totalJournals }}</p>
                <p class="text-[12px] dark:text-white text-gray-800 mt-1">{{ $journalStreak }} day writing streak</p>
            </div>
            <div class="veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl border p-5">
                <p class="text-[13px] dark:text-white text-gray-800 font-bold mb-1"><i class="fas fa-trophy"></i> Most
                    Productive Day</p>
                <p class="text-[32px] font-black text-emerald-400">{{ $topDay ?? '–' }}</p>
                <p class="text-[12px] dark:text-white text-gray-800 mt-1">Based on task completions</p>
            </div>
        </div>

        {{-- Quick Links to sub-pages --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            @foreach ([
            [
                'route' => 'user.analytics.productivity',
                'icon' => 'fas fa-chart-line',
                'color' => 'text-emerald-400',
                'label' => 'Task Analytics',
                'sub' => 'Completion & trends',
            ],
            [
                'route' => 'user.analytics.habits',
                'icon' => 'fas fa-fire',
                'color' => 'text-orange-400',
                'label' => 'Habit Analytics',
                'sub' => 'Streaks & heatmap',
            ],
            [
                'route' => 'user.analytics.focus',
                'icon' => 'fas fa-stopwatch',
                'color' => 'text-blue-400',
                'label' => 'Focus Analytics',
                'sub' => 'Sessions & XP',
            ],
            [
                'route' => 'user.analytics.weekly',
                'icon' => 'fas fa-calendar-week',
                'color' => 'text-pink-400',
                'label' => 'Weekly Report',
                'sub' => 'This week overview',
            ],
        ] as $link)
                <a href="{{ route($link['route']) }}"
                    class="veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl border
                    p-4 hover:dark:border-orange-500/30 hover:border-orange-300 transition group">
                    <div
                        class="w-11 h-11 rounded-xl flex items-center justify-center
                        dark:bg-white/[0.04] bg-gray-100 mb-3">

                        <i class="{{ $link['icon'] }} {{ $link['color'] }} text-lg"></i>
                    </div>
                    <p
                        class="text-[13px] font-extrabold dark:text-white text-gray-900 group-hover:text-orange-500 transition">
                        {{ $link['label'] }}
                    </p>

                    <p class="text-[11px] dark:text-white text-gray-800 mt-0.5">
                        {{ $link['sub'] }}
                    </p>
                </a>
            @endforeach
        </div>
    </div>
@endsection
