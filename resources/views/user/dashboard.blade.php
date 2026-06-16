@extends('user.layouts.master')

@section('user')
    <div class="space-y-5">


        <section
            class="relative overflow-hidden rounded-[18px] px-10 py-12 min-h-[360px]
                    border border-white/45 bg-[#E1C8AE]/70
                    shadow-[0_20px_60px_rgba(0,0,0,0.25)]
                    transition-colors duration-500
                    dark:border-orange-500/20 dark:bg-[#030108]
                    dark:shadow-[inset_0_1px_0_rgba(255,255,255,.04),0_0_45px_rgba(255,47,168,.08)]">



            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-[0.9fr_1.1fr] gap-8 items-center">

                {{-- LEFT: Text --}}
                <div>
                    <h1
                        class="text-[100px] sm:text-[80px] font-bold leading-[1.05] tracking-[-1.8px] dark:text-white text-[#070707]">
                        One system.
                    </h1>
                    <h1
                        class="text-[100px] sm:text-[80px] font-bold leading-[1.05] tracking-[-1.8px] mb-6 bg-gradient-to-r from-[#E73CBF] to-[#EC730D]  bg-clip-text text-transparent">
                        Infinite potential.
                    </h1>

                    <p class="text-[22px] leading-[1.9] dark:text-white text-[#333333] mb-7">
                        Veroa is your all-in-one productivity hub.<br>
                        Tasks, habits, notes, focus timers, tools &amp; analytics –<br>
                        everything you need to become your best self.
                    </p>

                    <div class="flex flex-wrap items-center gap-4 mb-5">

                        <!-- Primary Button -->
                        <a href="#"
                            class="relative px-7 py-[13px] rounded-[14px] text-white text-[15px] font-bold
                            bg-gradient-to-r from-[#ff8a12] via-[#ff5b2e] to-[#ff2f91]
                            shadow-[0_0_30px_rgba(255,106,26,.55)]
                            transition-all duration-300 hover:scale-105 hover:shadow-[0_0_45px_rgba(255,106,26,.75)]">

                            Start for free
                            <span class="ml-2">→</span>
                        </a>

                        <!-- Secondary Button -->
                        <a href="#"
                            class="flex items-center gap-2 px-7 py-[13px] rounded-[14px] text-[15px] font-bold
                            text-[#222] dark:text-white
                            border border-black/10 dark:border-[#FFFAAA]/15
                            bg-white/30 dark:bg-white/[0.03]
                            backdrop-blur-xl
                            transition-all duration-300 hover:scale-105 hover:bg-white/50 dark:hover:bg-white/[0.06]">

                            <!-- Play Icon -->
                            <span
                                class="w-7 h-7 flex items-center justify-center rounded-full
                                bg-white/60 dark:bg-white/10 border border-black/10 dark:border-white/10">
                                <svg class="w-3.5 h-3.5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 4l12 6-12 6V4z" />
                                </svg>
                            </span>

                            See how it works
                        </a>

                    </div>

                    <div class="flex flex-wrap gap-6 text-[13px] dark:text-white text-gray-800">
                        <span><b class="text-orange-400 mr-1"><i class="fas fa-times"></i></b>No credit card</span>
                        <span><b class="text-pink-400 mr-1"><i class="fas fa-check"></i></b>Free forever</span>
                        <span><b class="text-amber-400 mr-1"><i class="fas fa-check"></i></b>Cancel anytime</span>
                    </div>
                </div>

                <div class="relative flex items-center justify-center min-h-[310px]">
                    <img id="heroImage" src="{{ asset('images/image.png') }}"
                        data-light="{{ asset('images/image_light.png') }}" data-dark="{{ asset('images/image.png') }}"
                        alt="">
                </div>

            </div>
        </section>


        <!-- FEATURE CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $features = [
                    [
                        'title' => 'All-in-One',
                        'desc' => 'Everything you need in one powerful workspace.',
                        'svg_path' => '<path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>',
                        'stroke' => '#ff8a12',
                    ],
                    [
                        'title' => 'Focus First',
                        'desc' => 'Built to eliminate distractions and help you go deep.',
                        'svg_path' =>
                            '<circle cx="12" cy="12" r="3"/><circle cx="12" cy="12" r="7" stroke-dasharray="2 1"/><circle cx="12" cy="12" r="11"/>',
                        'stroke' => '#ff8a12',
                    ],
                    [
                        'title' => 'Data Driven',
                        'desc' => 'Analytics that help you improve every day.',
                        'svg_path' =>
                            '<rect x="3" y="14" width="4" height="7" rx="1"/><rect x="9.5" y="9" width="4" height="12" rx="1"/><rect x="16" y="4" width="4" height="17" rx="1"/><polyline points="3 7 9 4 15 7 21 3" stroke-width="1.6"/>',
                        'stroke' => '#ff2fa8',
                    ],
                    [
                        'title' => 'Privacy First',
                        'desc' => 'Your data is yours. Always.',
                        'svg_path' =>
                            '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/><circle cx="12" cy="16" r="1.2" fill="currentColor"/>',
                        'stroke' => '#ff2fa8',
                    ],
                ];
            @endphp

            @foreach ($features as $feature)
                <div
                    class="group relative overflow-hidden rounded-[16px] p-5 min-h-[118px]
                    border border-white/50 bg-[#f4dfbd]/55
                    shadow-[0_20px_60px_rgba(0,0,0,0.25)]
                    transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_18px_45px_rgba(180,95,20,.16)]
                    dark:border-pink-500/15 dark:bg-[#0f0a1c]
                    dark:shadow-none dark:hover:border-orange-500/25">

                    <div
                        class="absolute inset-0 pointer-events-none opacity-70
                        bg-[radial-gradient(circle_at_20%_20%,rgba(255,138,18,.16),transparent_35%)]
                        dark:bg-[radial-gradient(circle_at_20%_20%,rgba(255,47,168,.12),transparent_38%)]">
                    </div>

                    <div class="relative z-10 flex items-center gap-4">
                        <div
                            class="w-14 h-14 flex items-center justify-center flex-shrink-0
                            rounded-2xl bg-white/25 dark:bg-white/[0.03]
                            border border-white/35 dark:border-white/[0.06]">

                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                stroke="{{ $feature['stroke'] }}" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" style="filter: drop-shadow(0 0 7px {{ $feature['stroke'] }});">
                                {!! $feature['svg_path'] !!}
                            </svg>
                        </div>

                        <div>
                            <h4 class="text-[15px] font-bold dark:text-white text-[#151515] mb-1">
                                {{ $feature['title'] }}
                            </h4>

                            <p class="text-[12px] leading-[1.7] dark:text-white text-[#5f5242]">
                                {{ $feature['desc'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- MAIN DASHBOARD PANEL -->
        <section
            class="rounded-[18px]
            border  border-orange-300/40
            dark:border-pink-500/15 bg-[#f7e4c3]/75
            dark:bg-[#080612]  backdrop-blur-xl  p-6  space-y-6
            shadow-[0_20px_60px_rgba(0,0,0,0.25)]
            dark:shadow-[inset_0_1px_0_rgba(255,255,255,.03)]
            transition-all duration-300">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-[40px] font-extrabold dark:text-white text-gray-800"><i class="fas fa-home"></i>
                        Dashboard</h2>
                    <p class="text-[20px] font-semibold dark:text-white text-gray-800 mt-1">
                        Welcome to, {{ auth()->user()->name ?? 'Leon' }}! 👋
                    </p>
                    <p class="text-[20px] dark:text-white text-gray-800 mt-0.5">
                        Let's make today extraordinary.
                    </p>
                </div>

                <div class="flex items-center gap-2.5">
                    <select id="periodFilter"
                        onchange="window.location.href = '{{ route('user.dashboard') }}?period=' + this.value"
                        class="px-4 py-3 rounded-xl text-[12.5px] outline-none
                        dark:bg-[#1a1625] bg-white dark:text-white text-gray-600
                        border dark:border-white/[0.1] border-black/[0.12]">
                        <option value="today" @selected($period === 'today')> <i class="fas fa-calendar-day"></i> Today
                        </option>
                        <option value="week" @selected($period === 'week')> <i class="fas fa-calendar-week"></i> This
                            week</option>
                        <option value="month" @selected($period === 'month')> <i class="fas fa-calendar-month"></i> This
                            month</option>
                    </select>

                    <a href="{{ route('user.tasks.create') }}"
                        class="px-5 py-2.5 rounded-xl text-white text-[16px] font-bold
                        bg-gradient-to-r from-orange-500 to-pink-500
                        shadow-[0_4px_18px_rgba(249,115,22,.45)]">
                        <i class="fas fa-plus"></i> Add Task
                    </a>
                </div>
            </div>

            <!-- Top Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">

                <!-- Daily Score -->
                <div class="hover-lift veroa-card rounded-2xl p-[18px] flex flex-col items-center">

                    <p class="text-[14px] font-semibold dark:text-white text-[#5f5242] mb-3">
                        <i class="fas fa-chart-line text-orange-500 dark:text-pink-800"></i>
                        Daily Score
                    </p>

                    {{-- Ring --}}
                    <div class="relative w-[120px] h-[120px]">
                        <svg class="w-full h-full" viewBox="0 0 120 120">
                            <defs>
                                <linearGradient id="scoreGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#ff2fa8" />
                                    <stop offset="100%" stop-color="#ff8a12" />
                                </linearGradient>
                            </defs>

                            {{-- Track: dark=deep purple | light=warm orange --}}
                            <circle cx="60" cy="60" r="50" fill="none" stroke-width="9"
                                class="dark:[stroke:#23152f] [stroke:#f8cfa0]" />

                            {{-- Progress --}}
                            <circle cx="60" cy="60" r="50" fill="none" stroke="url(#scoreGrad)"
                                stroke-width="9" stroke-linecap="round" stroke-dasharray="314.16"
                                stroke-dashoffset="{{ 314.16 * (1 - $dailyProgress / 100) }}"
                                style="transform:rotate(-90deg);transform-origin:50% 50%;" />
                        </svg>

                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-[32px] font-extrabold dark:text-white text-gray-900 leading-none">
                                {{ $dailyProgress }}
                            </span>
                            <span class="text-[16px] dark:text-white text-gray-900 mt-0.5">/100</span>
                        </div>
                    </div>

                    {{-- Label --}}
                    <p class="text-[13px] font-semibold dark:text-pink-400 text-orange-500 mt-3">
                        @if ($dailyProgress >= 90)
                            <i class="fas fa-star"></i> Amazing work!
                        @elseif($dailyProgress >= 70)
                            <i class="fas fa-thumbs-up"></i> Great job!
                        @elseif($dailyProgress >= 40)
                            <i class="fas fa-clock"></i> Keep going!
                        @else
                            <i class="fas fa-play"></i> Let's start!
                        @endif
                    </p>
                </div>

                <!-- Streak -->
                <div class="hover-lift veroa-card rounded-2xl p-[18px] text-center">
                    <p class="text-[14px] font-semibold dark:text-white text-gray-900 mb-3 self-center"><i
                            class="fas fa-fire text-orange-500 dark:text-orange-400"></i> Streak
                    </p>
                    <span class="text-[46px] leading-none"><i
                            class="fas fa-fire text-orange-500 dark:text-orange-400"></i></span>
                    <h3 class="text-[38px] font-extrabold dark:text-white text-gray-900 leading-none mt-1">
                        {{ $streakDays }}</h3>
                    <p class="text-[14px] dark:text-white text-gray-900">days</p>
                    <p class="text-[13px] font-semibold dark:text-pink-400 text-orange-500 mt-1">{{ $streakMessage }}</p>
                </div>

                <!-- XP -->
                <div class="hover-lift veroa-card rounded-2xl p-[18px] text-center">

                    <p class="text-[14px] font-semibold dark:text-white text-gray-900 mb-6 self-center"><i
                            class="fas fa-star text-orange-500 dark:text-orange-400"></i> XP Progress
                    </p>

                    <h3 class="text-[20px] font-bold text-orange-400 mb-2">
                        Level {{ $gamification->level ?? 1 }}
                    </h3>

                    <p class="text-[14px] dark:text-white text-gray-900 mb-3">
                        {{ number_format($gamification->xp ?? 0) }} /
                        {{ number_format($levelProgress['next_level_xp'] ?? 100) }} XP
                    </p>

                    <div
                        class="w-full h-[10px] rounded-full overflow-hidden
                        bg-[#f9d9b1]  border border-orange-300/40  dark:bg-[#1a1325]  dark:border-pink-500/10">
                        <div class="h-full rounded-full
                            bg-gradient-to-r
                            from-[#ff2fa8]
                            via-[#ff7b22]
                            to-[#ffd54a]

                            shadow-[0_2px_10px_rgba(255,138,18,.30)]
                            dark:shadow-[0_0_15px_rgba(255,47,168,.30)]"
                            style="width: {{ $levelProgress['progress_pct'] ?? 0 }}%">
                        </div>

                    </div>
                </div>

                <!-- Focus Time -->
                <div class="hover-lift veroa-card rounded-2xl p-[18px] text-center">
                    <p class="text-[14px] font-semibold dark:text-white text-gray-900 mb-5 self-center"><i
                            class="fas fa-clock text-orange-500 dark:text-orange-400"></i> Focus Time</p>
                    <h3 class="text-[28px] font-extrabold dark:text-white text-gray-900 leading-none">
                        {{ $focusTimeFormatted }}</h3>
                    <p class="text-[14px] dark:text-white text-gray-900 mt-1 mb-3">{{ $periodLabel }}</p>

                    <svg viewBox="0 0 160 45" class="w-full h-[45px]" preserveAspectRatio="none">

                        <defs>
                            <linearGradient id="focusLine" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0%" stop-color="#ec4899" />
                                <stop offset="100%" stop-color="#f97316" />
                            </linearGradient>
                        </defs>

                        @php
                            $data = $focusSparkline ?? [];
                            $count = count($data);

                            if ($count < 2) {
                                $path = '';
                            } else {
                                $maxVal = max($data);

                                // normalize points
                                $points = collect($data)
                                    ->map(function ($v, $i) use ($maxVal, $count) {
                                        $x = $i * (160 / ($count - 1));
                                        $y = 40 - ($v / ($maxVal ?: 1)) * 32;
                                        return [$x, $y];
                                    })
                                    ->toArray();

                                // smooth curve using Bezier
                                $path = 'M ' . $points[0][0] . ' ' . $points[0][1];

                                for ($i = 1; $i < count($points); $i++) {
                                    $prev = $points[$i - 1];
                                    $curr = $points[$i];

                                    $midX = ($prev[0] + $curr[0]) / 2;

                                    $path .=
                                        ' C ' .
                                        $midX .
                                        ' ' .
                                        $prev[1] .
                                        ', ' .
                                        $midX .
                                        ' ' .
                                        $curr[1] .
                                        ', ' .
                                        $curr[0] .
                                        ' ' .
                                        $curr[1];
                                }
                            }
                        @endphp

                        @if ($count > 1)
                            {{-- soft glow line --}}
                            <path d="{{ $path }}" fill="none" stroke="url(#focusLine)" stroke-width="6"
                                opacity="0.15" />

                            {{-- main smooth curve --}}
                            <path d="{{ $path }}" fill="none" stroke="url(#focusLine)" stroke-width="2.8"
                                stroke-linecap="round" stroke-linejoin="round" />
                        @endif

                    </svg>
                </div>
            </div>

            <!-- Priorities + Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3.5">

                <!-- Priorities -->
                <div class="hover:-translate-y-1 transition-transform duration-200 veroa-card rounded-2xl p-[18px]">

                    <h3 class="text-[17px] font-bold dark:text-white text-gray-900 mb-1"> <i class="fas fa-tasks"></i> Top
                        6 Priorities</h3>

                    @php
                        $colorMap = ['high' => 'pink', 'medium' => 'orange', 'low' => 'green'];
                        $plans = $topPriorities->map(function ($task, $i) use ($colorMap) {
                            return [
                                'title' => $task->title,
                                'priority' => ucfirst($task->priority),
                                'color' => $colorMap[$task->priority] ?? 'orange',
                                'num' => $i + 1,
                                'url' => route('user.tasks.show', $task),
                            ];
                        });
                    @endphp

                    @forelse ($plans as $plan)
                        <a href="{{ $plan['url'] }}" class="block">
                            <div
                                class="flex items-center gap-3 py-[13px]
                            {{ !$loop->last ? 'border-b dark:border-white/[0.07] border-orange-100' : '' }}">

                                {{-- Dark mode: hollow pink ring | Light mode: numbered gradient circle --}}
                                <div
                                    class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center  dark:bg-transparent dark:border-2
                                        @if ($plan['color'] === 'pink') bg-gradient-to-br from-orange-400 to-pink-500  dark:border-pink-500
                                        @elseif($plan['color'] === 'orange')
                                            bg-gradient-to-br from-orange-400 to-amber-500  dark:border-orange-400
                                        @else
                                            bg-gradient-to-br from-green-400 to-emerald-500  dark:border-green-400 @endif">
                                    <spanb class="text-[12px] font-bold leading-none text-white dark:text-white">
                                        {{ $plan['num'] }}
                                        </span>

                                </div>

                                {{-- Title --}}
                                <span class="flex-1 text-[13.5px] dark:text-white text-gray-800 font-medium truncate">
                                    {{ $plan['title'] }}
                                </span>

                                {{-- Priority Badge --}}
                                <span
                                    class="px-[11px] py-[2px] rounded-[6px] text-[12px] font-semibold border-[1.5px]
                                @if ($plan['color'] === 'pink') dark:text-pink-400 dark:border-pink-400 text-pink-500 border-pink-400
                                @elseif($plan['color'] === 'orange')
                                    dark:text-orange-400 dark:border-orange-400 text-orange-500 border-orange-400
                                @else
                                    dark:text-green-400 dark:border-green-400 text-green-500 border-green-400 @endif">
                                    {{ $plan['priority'] }}
                                </span>

                                {{-- Drag handle dots --}}
                                <div class="grid grid-cols-2 gap-[3.5px] opacity-40 flex-shrink-0">
                                    @for ($i = 0; $i < 6; $i++)
                                        <span
                                            class="w-[3px] h-[3px] rounded-full dark:bg-gray-500 bg-gray-400 block"></span>
                                    @endfor
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="py-8 text-center">
                            <p class="text-[13px] dark:text-white text-gray-800">No pending tasks. You're all caught up!
                                🎉</p>
                            <a href="{{ route('user.tasks.create') }}"
                                class="inline-block mt-3 px-4 py-2 rounded-lg text-[12px] font-bold text-white
                                bg-gradient-to-r from-orange-500 to-pink-500">
                                <i class="fas fa-plus"></i> Add Task
                            </a>
                        </div>
                    @endforelse
                </div>

                <div class="hover-lift veroa-card rounded-2xl p-[18px]">
                    <h3 class="text-[17px] font-bold dark:text-white text-gray-900 mb-1"> <i class="fas fa-history"></i>
                        Activity Feed</h3>

                    @forelse ($activities as $activity)
                        <div
                            class="flex items-start gap-3 py-[11px] {{ !$loop->last ? 'border-b dark:border-white/[0.07] border-black/[0.05]' : '' }}">

                            {{-- Colored square icon --}}
                            <div class="w-9 h-9 rounded-[9px] flex items-center justify-center flex-shrink-0"
                                style="background: {{ $activity['bg'] }}">
                                <svg width="18" height="18" viewBox="0 0 24 24" {!! $activity['svgProps'] !!}>
                                    {!! $activity['svg'] !!}
                                </svg>
                            </div>

                            {{-- Text --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-[13px] font-semibold dark:text-white text-gray-800 leading-[1.35] mb-0">
                                    {{ $activity['title'] }}
                                </p>
                                @if ($activity['desc'])
                                    <p class="text-[12px] dark:text-white text-gray-800 mt-0.5 truncate">
                                        {{ $activity['desc'] }}
                                    </p>
                                @endif
                            </div>

                            {{-- Time --}}
                            <span class="text-[12.5px] dark:text-gray-600 text-gray-800 flex-shrink-0 pt-[2px]">
                                {{ $activity['time'] }}
                            </span>
                        </div>
                    @empty
                        <div class="py-8 text-center">
                            <p class="text-[13px] dark:text-white text-gray-800">
                                No recent activity yet. Start by completing a task or habit!
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Analytics -->
            <!-- ══ ANALYTICS ROW ══ -->
            <div class="grid grid-cols-1 xl:grid-cols-[1fr_300px] gap-3.5">

                <!-- Productivity Chart -->
                <div class="hover:-translate-y-1 transition-transform duration-200 veroa-card rounded-2xl p-[18px]">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-[17px] font-bold dark:text-white text-gray-900">
                            Productivity Overview
                        </h3>

                        <div class="flex items-center gap-4 text-[12px] font-bold dark:text-white text-gray-700">
                            <span class="flex items-center gap-1.5">
                                <span
                                    class="w-2.5 h-2.5 rounded-full bg-yellow-400 shadow-[0_0_12px_rgba(250,204,21,.8)]"></span>
                                This week
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span
                                    class="w-2.5 h-2.5 rounded-full bg-orange-500 shadow-[0_0_12px_rgba(249,115,22,.8)]"></span>
                                Last week
                            </span>
                        </div>
                    </div>

                    <div class="relative h-[210px]">
                        <canvas id="productivityChart"></canvas>
                    </div>
                </div>

                <!-- Habit Score -->
                <div class="hover-lift veroa-card rounded-2xl p-[18px] flex flex-col items-center">
                    <h3 class="text-[20px] font-bold dark:text-white text-[#151515] self-start mb-3.5">
                        <i class="fas fa-star text-[#ff8a12] dark:text-[#ffb52b]"></i>
                        Habit Score
                    </h3>

                    <div class="relative w-[120px] h-[120px] mb-4">
                        <svg class="w-full h-full" viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="50" fill="none" stroke-width="10"
                                class="dark:stroke-[#23152f] stroke-[#f8cfa0]" />

                            <circle cx="60" cy="60" r="50" fill="none" stroke-width="10"
                                stroke-linecap="round" stroke="url(#habitGrad)" stroke-dasharray="314.16"
                                stroke-dashoffset="{{ $circleOffset }}"
                                style="transform:rotate(-90deg);transform-origin:50% 50%;" />

                            <defs>
                                <linearGradient id="habitGrad" x1="0" y1="0" x2="1"
                                    y2="0">
                                    <stop stop-color="#ff2fa8" />
                                    <stop offset="0.55" stop-color="#ff7b22" />
                                    <stop offset="1" stop-color="#ffd54a" />
                                </linearGradient>
                            </defs>
                        </svg>

                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span
                                class="text-[30px] font-extrabold tracking-[-0.5px] dark:text-white text-[#151515] leading-none">
                                {{ $habitCompletionRate }}<sup class="text-[15px] align-super">%</sup>
                            </span>

                            <span class="text-[13px] font-semibold dark:text-white text-[#7a6045] mt-1">
                                {{ $habitScoreLabel }}
                            </span>
                        </div>
                    </div>

                    <div class="w-full">
                        <div class="flex justify-between text-[14px] mb-2">
                            <span class="dark:text-white text-[#6b5b4a]">
                                {{ $periodLabel }} Completed
                            </span>

                            <span class="font-bold dark:text-white text-[#151515]">
                                {{ $completedToday }}/{{ $totalHabits }}
                            </span>
                        </div>

                        <div
                            class="w-full h-[10px] rounded-full overflow-hidden
            bg-[#f9d9b1] border border-orange-300/40
            dark:bg-[#1a1325] dark:border-pink-500/10">

                            <div class="h-full rounded-full
                bg-gradient-to-r from-[#ff2fa8] via-[#ff7b22] to-[#ffd54a]
                shadow-[0_2px_10px_rgba(255,138,18,.30)]
                dark:shadow-[0_0_15px_rgba(255,47,168,.30)]
                transition-all duration-500"
                                style="width:{{ $habitCompletionRate }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
        let productivityChartInstance = null;

        const labels = @json($chartLabels);
        const thisWeek = @json($thisWeekData);
        const lastWeek = @json($lastWeekData);

        function renderProductivityChart() {

            const canvas = document.getElementById('productivityChart');
            if (!canvas) return;

            if (productivityChartInstance) {
                productivityChartInstance.destroy();
            }

            const ctx = canvas.getContext('2d');
            const isDark = document.documentElement.classList.contains('dark');

            // =========================
            // IMAGE STYLE GRADIENTS
            // =========================
            const thisWeekGradient = ctx.createLinearGradient(0, 0, 0, 220);
            thisWeekGradient.addColorStop(0, isDark ? 'rgba(236,72,153,0.30)' : 'rgba(250,204,21,0.40)');
            thisWeekGradient.addColorStop(1, 'rgba(249,115,22,0.00)');

            const lastWeekGradient = ctx.createLinearGradient(0, 0, 0, 220);
            lastWeekGradient.addColorStop(0, isDark ? 'rgba(249,115,22,0.25)' : 'rgba(249,115,22,0.30)');
            lastWeekGradient.addColorStop(1, 'rgba(249,115,22,0.00)');

            // =========================
            // CHART
            // =========================
            productivityChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [

                        // THIS WEEK (MAIN LINE)
                        {
                            label: 'This Week',
                            data: thisWeek,
                            borderColor: isDark ? '#ff4ecd' : '#facc15',
                            backgroundColor: thisWeekGradient,
                            fill: true,
                            tension: 0.45,
                            borderWidth: 3,

                            pointRadius: 5,
                            pointHoverRadius: 7,

                            pointBackgroundColor: isDark ? '#ff4ecd' : '#facc15',
                            pointBorderColor: isDark ? '#ff4ecd' : '#facc15',
                        },

                        // LAST WEEK (SECOND LINE)
                        {
                            label: 'Last Week',
                            data: lastWeek,
                            borderColor: '#f97316',
                            backgroundColor: lastWeekGradient,
                            fill: true,
                            tension: 0.45,
                            borderWidth: 3,

                            pointRadius: 4,
                            pointHoverRadius: 6,

                            pointBackgroundColor: '#f97316',
                            pointBorderColor: '#f97316',
                        }
                    ]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },

                    plugins: {
                        legend: {
                            display: false
                        },

                        tooltip: {
                            backgroundColor: isDark ? '#0b0614' : '#ffffff',
                            titleColor: isDark ? '#ffffff' : '#111827',
                            bodyColor: isDark ? '#ffffff' : '#111827',
                            borderColor: 'rgba(249,115,22,.3)',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 12,
                        }
                    },

                    scales: {

                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: isDark ? 'rgba(255,255,255,.70)' : 'rgba(17,24,39,.70)',
                                font: {
                                    size: 13,
                                    weight: 600
                                }
                            }
                        },

                        y: {
                            beginAtZero: true,
                            grid: {
                                color: isDark ?
                                    'rgba(255,255,255,.06)' : 'rgba(0,0,0,.05)',
                            },
                            ticks: {
                                stepSize: 25,
                                color: isDark ? 'rgba(255,255,255,.60)' : 'rgba(17,24,39,.60)',
                                font: {
                                    size: 12,
                                    weight: 600
                                }
                            }
                        }
                    }
                }
            });
        }

        // INIT
        document.addEventListener('DOMContentLoaded', renderProductivityChart);

        // DARK MODE LIVE UPDATE SUPPORT
        const observer = new MutationObserver(() => renderProductivityChart());
        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    </script>
@endsection
