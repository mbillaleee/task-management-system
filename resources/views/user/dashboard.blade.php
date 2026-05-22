@extends('user.layouts.master')

@section('user')
    <div class="space-y-5">

        <!-- HERO -->
        <section
            class="relative overflow-hidden rounded-2xl border dark:border-orange-500/[0.18] border-orange-200/70
            dark:bg-[#100b18] bg-orange-50/70 px-7 py-9 min-h-[240px]">

            <div class="absolute inset-0 opacity-40 pointer-events-none"
                style="background:
                radial-gradient(circle at 75% 45%, rgba(236,72,153,.35), transparent 35%),
                radial-gradient(circle at 65% 70%, rgba(249,115,22,.35), transparent 30%);">
            </div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
                <div>
                    <h1 class="text-[38px] sm:text-[42px] font-extrabold leading-[1.1] dark:text-white text-gray-900">
                        One system.
                    </h1>

                    <h1 class="text-[38px] sm:text-[42px] font-extrabold leading-[1.1] mb-4">
                        <span
                            class="bg-gradient-to-r from-pink-500 via-orange-500 to-amber-400 bg-clip-text text-transparent">
                            Infinite potential.
                        </span>
                    </h1>

                    <p class="text-[16px] leading-[1.7] dark:text-gray-400 text-gray-600 mb-6">
                        Veroa is your all-in-one productivity hub.<br>
                        Tasks, habits, notes, focus timers, tools & analytics –<br>
                        everything you need to become your best self.
                    </p>

                    <div class="flex flex-wrap items-center gap-3 mb-5">
                        <a href="#"
                            class="px-6 py-3 rounded-xl text-white text-[16px] font-bold
                            bg-gradient-to-r from-orange-500 to-pink-500
                            shadow-[0_0_28px_rgba(249,115,22,.45)]">
                            Start for free →
                        </a>

                        <a href="#"
                            class="px-6 py-3 rounded-xl text-[16px] font-semibold
                            dark:text-white text-gray-800 border dark:border-white/[0.14] border-gray-300
                            dark:bg-white/[0.02] bg-white/40">
                            See how it works
                        </a>
                    </div>

                    <div class="flex flex-wrap gap-4 text-[16px] dark:text-gray-500 text-gray-500">
                        <span><b class="text-orange-400">✓</b> No credit card</span>
                        <span><b class="text-pink-400">✓</b> Free forever</span>
                        <span><b class="text-amber-400">✓</b> Cancel anytime</span>
                    </div>
                </div>

                <!-- Neon Logo Art -->
                <div class="relative flex items-center justify-center min-h-[220px]">
                    <div class="absolute bottom-3 w-[230px] h-[45px] rounded-full blur-xl bg-orange-500/40"></div>

                    <svg class="relative z-10 w-[260px] h-[230px]" viewBox="0 0 260 230" fill="none">
                        <defs>
                            <linearGradient id="logoGrad" x1="40" y1="30" x2="220" y2="190">
                                <stop stop-color="#f59e0b" />
                                <stop offset=".45" stop-color="#f97316" />
                                <stop offset="1" stop-color="#ec4899" />
                            </linearGradient>
                            <filter id="glow">
                                <feGaussianBlur stdDeviation="5" result="blur" />
                                <feMerge>
                                    <feMergeNode in="blur" />
                                    <feMergeNode in="SourceGraphic" />
                                </feMerge>
                            </filter>
                        </defs>

                        <ellipse cx="130" cy="190" rx="88" ry="17" fill="#f97316"
                            opacity=".20" />
                        <ellipse cx="130" cy="184" rx="70" ry="9" fill="#f97316"
                            opacity=".35" />

                        <path
                            d="M130 45 C83 45 50 76 50 112 C50 148 86 166 130 143 C174 166 210 148 210 112 C210 76 177 45 130 45Z"
                            stroke="url(#logoGrad)" stroke-width="12" stroke-linecap="round" filter="url(#glow)" />

                        <path d="M130 143 C103 174 92 194 130 198 C168 194 157 174 130 143" stroke="url(#logoGrad)"
                            stroke-width="10" stroke-linecap="round" filter="url(#glow)" />

                        <polygon points="40,45 48,60 40,75 32,60" fill="#f97316" />
                        <polygon points="215,35 223,50 215,65 207,50" fill="#ec4899" />
                        <polygon points="228,125 236,140 228,155 220,140" fill="#f59e0b" />
                        <polygon points="52,155 60,168 52,181 44,168" fill="#8b5cf6" />
                    </svg>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                <p class="text-[16px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Today Tasks</p>
                <h3 class="text-[38px] font-extrabold dark:text-white text-gray-900 leading-none">{{ $todayTotal }}</h3>
                <p class="text-[16px] text-orange-400 mt-2">Scheduled for today</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                <p class="text-[16px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Completed Tasks</p>
                <h3 class="text-[38px] font-extrabold text-emerald-500 leading-none">{{ $completedTaskCount }}</h3>
                <p class="text-[16px] text-emerald-500 mt-2">All completed</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                <p class="text-[16px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Pending Tasks</p>
                <h3 class="text-[38px] font-extrabold text-yellow-500 leading-none">{{ $pendingTaskCount }}</h3>
                <p class="text-[16px] text-yellow-500 mt-2">Need attention</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                <p class="text-[16px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Overdue Tasks</p>
                <h3 class="text-[38px] font-extrabold text-red-500 leading-none">{{ $overdueTasks }}</h3>
                <p class="text-[16px] text-red-500 mt-2">Past deadline</p>
            </div>

        </div>

        <!-- FEATURE CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $features = [
                    [
                        'icon' => '⚡',
                        'title' => 'All-in-One',
                        'desc' => 'Everything you need in one powerful workspace.',
                        'color' => 'orange',
                    ],
                    [
                        'icon' => '🎯',
                        'title' => 'Focus First',
                        'desc' => 'Built to eliminate distractions and help you go deep.',
                        'color' => 'amber',
                    ],
                    [
                        'icon' => '📊',
                        'title' => 'Data Driven',
                        'desc' => 'Analytics that help you improve every day.',
                        'color' => 'pink',
                    ],
                    [
                        'icon' => '🔒',
                        'title' => 'Privacy First',
                        'desc' => 'Your data is yours. Always.',
                        'color' => 'pink',
                    ],
                ];
            @endphp

            @foreach ($features as $feature)
                <div
                    class="group hover-lift relative overflow-hidden rounded-2xl p-5 min-h-[118px]
            dark:bg-[#100b18]/90 bg-white
            border dark:border-orange-500/[0.14] border-orange-200/70
            shadow-[0_0_25px_rgba(249,115,22,0.08)]
            hover:shadow-[0_0_35px_rgba(236,72,153,0.18)]
            transition-all duration-300">

                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none"
                        style="background: radial-gradient(circle at 20% 45%, rgba(249,115,22,.16), transparent 35%),
                       radial-gradient(circle at 85% 60%, rgba(236,72,153,.12), transparent 35%);">
                    </div>

                    <div class="relative z-10 flex items-center gap-4">
                        <div
                            class="w-14 h-14 flex items-center justify-center text-[40px] leading-none
                    drop-shadow-[0_0_14px_rgba(249,115,22,0.85)]">
                            {{ $feature['icon'] }}
                        </div>

                        <div>
                            <h4 class="text-[16px] font-extrabold dark:text-white text-gray-900 mb-2">
                                {{ $feature['title'] }}
                            </h4>

                            <p class="text-[12px] leading-[1.7] dark:text-gray-400 text-gray-500">
                                {{ $feature['desc'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- MAIN DASHBOARD PANEL -->
        <section
            class="rounded-2xl border dark:border-orange-500/[0.18] border-orange-200
            dark:bg-[#0f0b18] bg-orange-50/50 p-5 space-y-5 shadow-[0_0_35px_rgba(249,115,22,.12)]">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-[20px] font-extrabold dark:text-white text-gray-900">Dashboard</h2>
                    <p class="text-[14px] font-semibold dark:text-white text-gray-800 mt-1">
                        Welcome back, {{ auth()->user()->name ?? 'Leon' }}! 👋
                    </p>
                    <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-0.5">
                        Let's make today extraordinary.
                    </p>
                </div>

                <div class="flex items-center gap-2.5">
                    <select
                        class="px-4 py-2 rounded-xl text-[12.5px] outline-none
                        dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-600
                        border dark:border-white/[0.1] border-black/[0.12]">
                        <option>Today</option>
                        <option>This week</option>
                        <option>This month</option>
                    </select>

                    <a href="{{ route('user.tasks.create') }}"
                        class="px-5 py-2.5 rounded-xl text-white text-[16px] font-bold
                        bg-gradient-to-r from-orange-500 to-pink-500
                        shadow-[0_4px_18px_rgba(249,115,22,.45)]">
                        + Add Task
                    </a>
                </div>
            </div>

            <!-- Top Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">

                <!-- Daily Score -->
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                    <p class="text-[14px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Daily Score</p>

                    <div class="relative w-24 h-24 mx-auto">
                        <svg class="w-full h-full" viewBox="0 0 96 96">
                            <circle cx="48" cy="48" r="40" fill="none" stroke-width="8"
                                class="dark:stroke-[#21192c] stroke-orange-100" />
                            <circle cx="48" cy="48" r="40" fill="none" stroke-width="8"
                                stroke-linecap="round" stroke="url(#scoreGrad)" stroke-dasharray="251.3"
                                stroke-dashoffset="44" style="transform:rotate(-90deg);transform-origin:50% 50%;" />
                            <defs>
                                <linearGradient id="scoreGrad" x1="0" y1="0" x2="1"
                                    y2="0">
                                    <stop stop-color="#ec4899" />
                                    <stop offset="1" stop-color="#f97316" />
                                </linearGradient>
                            </defs>
                        </svg>

                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-[28px] font-extrabold dark:text-white text-gray-900 leading-none">87</span>
                            <span class="text-[11px] dark:text-gray-500 text-gray-400">/100</span>
                        </div>
                    </div>

                    <p class="text-center text-[14px] font-semibold text-pink-400 mt-2">Amazing work!</p>
                </div>

                <!-- Streak -->
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px] text-center">
                    <p class="text-left text-[14px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Streak</p>
                    <span class="text-[46px] leading-none">🔥</span>
                    <h3 class="text-[38px] font-extrabold dark:text-white text-gray-900 leading-none mt-1">12</h3>
                    <p class="text-[14px] dark:text-gray-500 text-gray-400">days</p>
                    <p class="text-[14px] font-semibold text-pink-400 mt-1">Keep it hot!</p>
                </div>

                <!-- XP -->
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                    <p class="text-[14px] font-semibold dark:text-gray-400 text-gray-500 mb-6">XP Progress</p>
                    <h3 class="text-[20px] font-bold text-orange-400 mb-2">Level 24</h3>
                    <p class="text-[14px] dark:text-gray-400 text-gray-500 mb-3">2,450 / 3,500 XP</p>
                    <div class="w-full h-[8px] rounded-full dark:bg-white/[0.08] bg-orange-100 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-pink-500 to-orange-500" style="width:70%">
                        </div>
                    </div>
                </div>

                <!-- Focus Time -->
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                    <p class="text-[14px] font-semibold dark:text-gray-400 text-gray-500 mb-5">Focus Time</p>
                    <h3 class="text-[28px] font-extrabold dark:text-white text-gray-900 leading-none">3h 24m</h3>
                    <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-1 mb-3">Today</p>

                    <svg viewBox="0 0 160 45" class="w-full h-[45px]">
                        <path
                            d="M0 35 C18 30, 18 10, 35 20 C52 30, 50 5, 70 14 C90 23, 88 38, 108 22 C128 5, 132 28, 160 12"
                            fill="none" stroke="url(#focusLine)" stroke-width="3" stroke-linecap="round" />
                        <defs>
                            <linearGradient id="focusLine" x1="0" y1="0" x2="1" y2="0">
                                <stop stop-color="#ec4899" />
                                <stop offset="1" stop-color="#f97316" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </div>

            <!-- Priorities + Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3.5">

                <!-- Priorities -->
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                    <h3 class="text-[20px] font-bold dark:text-white text-gray-900 mb-4">Top 3 Priorities</h3>

                    @php
                        $plans = [
                            ['title' => 'Launch new landing page', 'priority' => 'High', 'color' => 'red'],
                            ['title' => 'Workout & gym', 'priority' => 'Medium', 'color' => 'orange'],
                            ['title' => 'Read 20 pages', 'priority' => 'Low', 'color' => 'emerald'],
                        ];
                    @endphp

                    @foreach ($plans as $key => $plan)
                        <div
                            class="flex items-center gap-2.5 py-3 {{ !$loop->last ? 'border-b dark:border-white/[0.06] border-black/[0.05]' : '' }}">
                            <div
                                class="w-5 h-5 rounded-full border-2 dark:border-pink-500 border-transparent flex items-center justify-center
                                dark:bg-transparent bg-gradient-to-br from-orange-400 to-amber-500">
                                <span class="dark:hidden text-[10px] text-white font-bold">{{ $key + 1 }}</span>
                            </div>

                            <span class="flex-1 text-[13px] font-medium dark:text-gray-200 text-gray-700">
                                {{ $plan['title'] }}
                            </span>

                            <span
                                class="px-2.5 py-[3px] rounded-[7px] text-[14px] font-semibold
                                @if ($plan['color'] == 'red') dark:bg-red-500/[0.15] dark:text-red-400 bg-red-50 text-red-600 border border-red-200 dark:border-red-500/[0.25]
                                @elseif($plan['color'] == 'orange') dark:bg-orange-500/[0.15] dark:text-orange-400 bg-orange-50 text-orange-600 border border-orange-200 dark:border-orange-500/[0.25]
                                @else dark:bg-emerald-500/[0.15] dark:text-emerald-400 bg-emerald-50 text-emerald-600 border border-emerald-200 dark:border-emerald-500/[0.25] @endif">
                                {{ $plan['priority'] }}
                            </span>

                            <span class="text-[14px] dark:text-gray-600 text-gray-300">⋮⋮</span>
                        </div>
                    @endforeach
                </div>

                <!-- Activity -->
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                    <h3 class="text-[20px] font-bold dark:text-white text-gray-900 mb-4">Activity Feed</h3>

                    @php
                        $activities = [
                            [
                                'icon' => '✓',
                                'title' => 'You completed a task',
                                'desc' => 'Build new habit system',
                                'time' => '2m ago',
                                'bg' => 'emerald',
                            ],
                            [
                                'icon' => '🔥',
                                'title' => 'You reached a 12 day streak! 🔥',
                                'desc' => '',
                                'time' => '1h ago',
                                'bg' => 'orange',
                            ],
                            [
                                'icon' => '🎯',
                                'title' => 'Focus session completed',
                                'desc' => 'Deep Work Session',
                                'time' => '2h ago',
                                'bg' => 'pink',
                            ],
                            [
                                'icon' => '📝',
                                'title' => 'New note created',
                                'desc' => 'Project Ideas',
                                'time' => '3h ago',
                                'bg' => 'purple',
                            ],
                        ];
                    @endphp

                    @foreach ($activities as $activity)
                        <div
                            class="flex items-start gap-2.5 py-2 {{ !$loop->last ? 'border-b dark:border-white/[0.06] border-black/[0.05]' : '' }}">
                            <div
                                class="w-8 h-8 rounded-[9px] flex items-center justify-center flex-shrink-0 text-[14px]
                                bg-{{ $activity['bg'] }}-500/[0.18] text-{{ $activity['bg'] }}-400">
                                {{ $activity['icon'] }}
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-[12.5px] font-semibold dark:text-gray-200 text-gray-800">
                                    {{ $activity['title'] }}
                                </p>

                                @if ($activity['desc'])
                                    <p class="text-[11.5px] dark:text-gray-500 text-gray-400">
                                        {{ $activity['desc'] }}
                                    </p>
                                @endif
                            </div>

                            <span class="text-[14px] dark:text-gray-600 text-gray-400 flex-shrink-0 mt-0.5">
                                {{ $activity['time'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Analytics -->
            <!-- ══ ANALYTICS ROW ══ -->
            <div class="grid grid-cols-1 xl:grid-cols-[1fr_300px] gap-3.5">

                <!-- Productivity Chart -->
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-[20px] font-bold dark:text-white text-gray-900">Productivity Overview</h3>
                        <div class="flex items-center gap-3.5">
                            <div class="flex items-center gap-1.5 text-[14px] dark:text-gray-400 text-gray-500">
                                <div class="w-2.5 h-1 rounded-full bg-orange-400"></div>This week
                            </div>
                            <div class="flex items-center gap-1.5 text-[14px] dark:text-gray-400 text-gray-500">
                                <div class="w-2.5 h-1 rounded-full bg-amber-400/60"></div>Last week
                            </div>
                        </div>
                    </div>
                    <div class="relative h-[130px]">
                        <canvas id="productivityChart"></canvas>
                    </div>
                </div>


                <!-- Habit Score -->
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px] flex flex-col items-center">

                    <h3 class="text-[20px] font-bold dark:text-white text-gray-900 self-start mb-3.5">
                        Habit Score
                    </h3>

                    <!-- Ring -->
                    <div class="relative w-[120px] h-[120px] mb-4">
                        <svg class="w-full h-full" viewBox="0 0 120 120">

                            <circle cx="60" cy="60" r="50" fill="none" stroke-width="10"
                                class="dark:stroke-[#1e1a2e] stroke-gray-100" />

                            <circle cx="60" cy="60" r="50" fill="none" stroke-width="10"
                                stroke-linecap="round" stroke="url(#focusGrad)" stroke-dasharray="314.16"
                                stroke-dashoffset="{{ $circleOffset }}"
                                style="transform:rotate(-90deg);transform-origin:50% 50%;" class="progress-circle" />

                            <defs>
                                <linearGradient id="focusGrad" x1="0" y1="0" x2="1"
                                    y2="0">
                                    <stop stop-color="#f97316" />
                                    <stop offset="1" stop-color="#f59e0b" />
                                </linearGradient>
                            </defs>
                        </svg>

                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span
                                class="text-[28px] font-extrabold tracking-[-0.5px] dark:text-white text-gray-900 leading-none">
                                {{ $habitCompletionRate }}<sup class="text-[15px] align-super">%</sup>
                            </span>

                            <span class="text-[14px] dark:text-gray-400 text-gray-500 mt-0.5">
                                {{ $habitScoreLabel }}
                            </span>
                        </div>
                    </div>

                    <!-- Goal bar -->
                    <div class="w-full">

                        <div class="flex justify-between text-[16px] mb-1.5">
                            <span class="dark:text-gray-400 text-gray-500">
                                Today Completed
                            </span>

                            <span class="font-bold dark:text-white text-gray-800">
                                {{ $completedToday }}/{{ $totalHabits }}
                            </span>
                        </div>

                        <div class="w-full h-[7px] rounded-full dark:bg-white/[0.08] bg-gray-100 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-amber-400"
                                style="width:{{ $habitCompletionRate }}%">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
