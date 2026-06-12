@extends('user.layouts.master')

@section('user')
    <div class="space-y-5">

        <section
            class="relative overflow-hidden rounded-2xl border dark:border-orange-500/[0.18] border-orange-200/70
                    dark:bg-[#100b18] bg-orange-50/70 px-8 py-10 min-h-[260px] transition-colors duration-500">

            {{-- Background Gradients --}}
            <div class="absolute inset-0 opacity-100 pointer-events-none"
                style="background:
            radial-gradient(circle at 75% 45%, rgba(236,72,153,.28), transparent 35%),
            radial-gradient(circle at 65% 75%, rgba(249,115,22,.30), transparent 30%),
            radial-gradient(circle at 20% 30%, rgba(139,92,246,.12), transparent 40%);">
            </div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">

                {{-- LEFT: Text --}}
                <div>
                    <h1 class="text-[46px] sm:text-[52px] font-extrabold leading-[1.1] dark:text-white text-gray-900">
                        One system.
                    </h1>
                    <h1
                        class="text-[46px] sm:text-[52px] font-extrabold leading-[1.1] mb-5
                bg-gradient-to-r from-pink-500 via-orange-500 to-amber-400 bg-clip-text text-transparent">
                        Infinite potential.
                    </h1>

                    <p class="text-[14px] leading-[1.75] dark:text-gray-400 text-gray-600 mb-6">
                        Veroa is your all-in-one productivity hub.<br>
                        Tasks, habits, notes, focus timers, tools &amp; analytics –<br>
                        everything you need to become your best self.
                    </p>

                    <div class="flex flex-wrap items-center gap-3 mb-5">
                        <a href="#"
                            class="px-6 py-[11px] rounded-xl text-white text-[14px] font-bold
                    bg-gradient-to-r from-orange-500 to-pink-500
                    shadow-[0_0_24px_rgba(249,115,22,.45)]
                    transition-all duration-300 hover:scale-105">
                            Start for free →
                        </a>
                        <a href="#"
                            class="px-6 py-[11px] rounded-xl text-[14px] font-semibold
                    dark:text-white text-gray-800 border dark:border-white/[0.14] border-gray-300
                    dark:bg-white/[0.03] bg-white/60 transition-all duration-300 hover:scale-105">
                            See how it works
                        </a>
                    </div>

                    <div class="flex flex-wrap gap-4 text-[13px] dark:text-gray-500 text-gray-500">
                        <span><b class="text-orange-400 mr-1">✓</b>No credit card</span>
                        <span><b class="text-pink-400 mr-1">✓</b>Free forever</span>
                        <span><b class="text-amber-400 mr-1">✓</b>Cancel anytime</span>
                    </div>
                </div>

                {{-- RIGHT: Neon SVG Art --}}
                <div class="relative flex items-center justify-center min-h-[240px]">

                    {{-- Platform glow --}}
                    <div
                        class="absolute bottom-3 left-1/2 -translate-x-1/2 w-[200px] h-[40px] rounded-full blur-2xl bg-orange-500/40">
                    </div>

                    <svg width="280" height="240" viewBox="0 0 280 240" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="neonGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#f97316" />
                                <stop offset="50%" stop-color="#ec4899" />
                                <stop offset="100%" stop-color="#f59e0b" />
                            </linearGradient>
                            <filter id="neonGlow" x="-30%" y="-30%" width="160%" height="160%">
                                <feGaussianBlur stdDeviation="4" result="blur" />
                                <feMerge>
                                    <feMergeNode in="blur" />
                                    <feMergeNode in="blur" />
                                    <feMergeNode in="SourceGraphic" />
                                </feMerge>
                            </filter>
                            <filter id="softGlow" x="-40%" y="-40%" width="180%" height="180%">
                                <feGaussianBlur stdDeviation="8" result="blur" />
                                <feMerge>
                                    <feMergeNode in="blur" />
                                    <feMergeNode in="SourceGraphic" />
                                </feMerge>
                            </filter>
                            <linearGradient id="dg1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#a855f7" />
                                <stop offset="100%" stop-color="#6366f1" />
                            </linearGradient>
                            <linearGradient id="dg2" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#f97316" />
                                <stop offset="100%" stop-color="#f59e0b" />
                            </linearGradient>
                            <linearGradient id="dg3" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#ec4899" />
                                <stop offset="100%" stop-color="#a855f7" />
                            </linearGradient>
                        </defs>

                        {{-- Platform --}}
                        <ellipse cx="140" cy="210" rx="90" ry="18" fill="rgba(249,115,22,0.12)"
                            filter="url(#softGlow)" />
                        <ellipse cx="140" cy="208" rx="70" ry="12" fill="rgba(249,115,22,0.25)" />
                        <ellipse cx="140" cy="205" rx="50" ry="8" fill="rgba(249,115,22,0.4)" />

                        {{-- Neon shape — glow layer --}}
                        <path filter="url(#softGlow)"
                            d="M80 50 C95 50 130 90 140 115 C150 90 185 50 200 50 C220 50 230 70 220 90 C210 110 175 130 155 148 C148 155 144 162 140 178 C136 162 132 155 125 148 C105 130 70 110 60 90 C50 70 60 50 80 50Z"
                            stroke="url(#neonGrad)" stroke-width="14" fill="none" opacity="0.5" />

                        {{-- Neon shape — crisp --}}
                        <path filter="url(#neonGlow)"
                            d="M80 50 C95 50 130 90 140 115 C150 90 185 50 200 50 C220 50 230 70 220 90 C210 110 175 130 155 148 C148 155 144 162 140 178 C136 162 132 155 125 148 C105 130 70 110 60 90 C50 70 60 50 80 50Z"
                            stroke="url(#neonGrad)" stroke-width="5" fill="none" stroke-linecap="round" />

                        {{-- Loop at bottom --}}
                        <path filter="url(#softGlow)"
                            d="M140 178 C145 190 158 198 158 205 C158 213 150 218 140 218 C130 218 122 213 122 205 C122 198 135 190 140 178Z"
                            stroke="url(#neonGrad)" stroke-width="10" fill="none" opacity="0.4" />
                        <path filter="url(#neonGlow)"
                            d="M140 178 C145 190 158 198 158 205 C158 213 150 218 140 218 C130 218 122 213 122 205 C122 198 135 190 140 178Z"
                            stroke="url(#neonGrad)" stroke-width="4.5" fill="none" stroke-linecap="round" />

                        {{-- Floating diamonds --}}
                        <g transform="translate(28,30) rotate(15)">
                            <polygon points="10,0 20,10 10,20 0,10" fill="url(#dg1)" opacity="0.85" />
                        </g>
                        <g transform="translate(52,70) rotate(-10)">
                            <polygon points="6,0 12,6 6,12 0,6" fill="url(#dg3)" opacity="0.6" />
                        </g>
                        <g transform="translate(230,18) rotate(20)">
                            <polygon points="9,0 18,9 9,18 0,9" fill="url(#dg2)" opacity="0.9" />
                        </g>
                        <g transform="translate(250,55) rotate(-15)">
                            <polygon points="7,0 14,7 7,14 0,7" fill="url(#dg3)" opacity="0.7" />
                        </g>
                        <g transform="translate(255,110) rotate(25)">
                            <polygon points="8,0 16,8 8,16 0,8" fill="url(#dg1)" opacity="0.65" />
                        </g>
                        <g transform="translate(20,150) rotate(-20)">
                            <polygon points="7,0 14,7 7,14 0,7" fill="url(#dg2)" opacity="0.55" />
                        </g>
                        <g transform="translate(245,165) rotate(10)">
                            <polygon points="9,0 18,9 9,18 0,9" fill="url(#dg2)" opacity="0.7" />
                        </g>
                    </svg>
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
                        'color' => 'orange',
                        'svg_path' => '<path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>',
                        'stroke' => '#f97316',
                    ],
                    [
                        'title' => 'Focus First',
                        'desc' => 'Built to eliminate distractions and help you go deep.',
                        'color' => 'amber',
                        'svg_path' =>
                            '<circle cx="12" cy="12" r="3"/><circle cx="12" cy="12" r="7" stroke-dasharray="2 1"/><circle cx="12" cy="12" r="11"/>',
                        'stroke' => '#f97316',
                    ],
                    [
                        'title' => 'Data Driven',
                        'desc' => 'Analytics that help you improve every day.',
                        'color' => 'pink',
                        'svg_path' =>
                            '<rect x="3" y="14" width="4" height="7" rx="1"/><rect x="9.5" y="9" width="4" height="12" rx="1"/><rect x="16" y="4" width="4" height="17" rx="1"/><polyline points="3 7 9 4 15 7 21 3" stroke-width="1.6"/>',
                        'stroke' => '#ec4899',
                    ],
                    [
                        'title' => 'Privacy First',
                        'desc' => 'Your data is yours. Always.',
                        'color' => 'pink',
                        'svg_path' =>
                            '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/><circle cx="12" cy="16" r="1.2" fill="currentColor"/>',
                        'stroke' => '#ec4899',
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

                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center flex-shrink-0">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                stroke="{{ $feature['stroke'] }}" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" class="drop-shadow-[0_0_7px_{{ $feature['stroke'] }}]">
                                {!! $feature['svg_path'] !!}
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[15px] font-bold dark:text-white text-gray-900 mb-1">
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
                    <h2 class="text-[40px] font-extrabold dark:text-white text-gray-900">Dashboard</h2>
                    <p class="text-[20px] font-semibold dark:text-white text-gray-800 mt-1">
                        Welcome to, {{ auth()->user()->name ?? 'Leon' }}! 👋
                    </p>
                    <p class="text-[20px] dark:text-gray-500 text-gray-400 mt-0.5">
                        Let's make today extraordinary.
                    </p>
                </div>

                <div class="flex items-center gap-2.5">
                    <select id="periodFilter"
                        onchange="window.location.href = '{{ route('user.dashboard') }}?period=' + this.value"
                        class="px-4 py-3 rounded-xl text-[12.5px] outline-none
                        dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-600
                        border dark:border-white/[0.1] border-black/[0.12]">
                        <option value="today" @selected($period === 'today')>Today</option>
                        <option value="week" @selected($period === 'week')>This week</option>
                        <option value="month" @selected($period === 'month')>This month</option>
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
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px] flex flex-col items-center">

                    <p class="text-[14px] font-semibold dark:text-gray-400 text-gray-500 mb-3 self-center">Daily Score</p>

                    {{-- Ring --}}
                    <div class="relative w-[120px] h-[120px]">
                        <svg class="w-full h-full" viewBox="0 0 120 120">
                            <defs>
                                <linearGradient id="scoreGrad" x1="0%" y1="0%" x2="100%"
                                    y2="0%">
                                    <stop offset="0%" stop-color="#ec4899" />
                                    <stop offset="100%" stop-color="#f97316" />
                                </linearGradient>
                            </defs>

                            {{-- Track: dark=deep purple | light=warm orange --}}
                            <circle cx="60" cy="60" r="50" fill="none" stroke-width="9"
                                class="dark:[stroke:#21192c] [stroke:#fed7aa]" />

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
                            <span class="text-[11px] dark:text-gray-500 text-gray-400 mt-0.5">/100</span>
                        </div>
                    </div>

                    {{-- Label --}}
                    <p class="text-[13px] font-semibold dark:text-pink-400 text-orange-500 mt-3">
                        @if ($dailyProgress >= 90)
                            Amazing work! 🔥
                        @elseif($dailyProgress >= 70)
                            Great job!
                        @elseif($dailyProgress >= 40)
                            Keep going!
                        @else
                            Let's start!
                        @endif
                    </p>
                </div>

                <!-- Streak -->
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px] text-center">
                    <p class="text-left text-[14px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Streak</p>
                    <span class="text-[46px] leading-none">🔥</span>
                    <h3 class="text-[38px] font-extrabold dark:text-white text-gray-900 leading-none mt-1">
                        {{ $streakDays }}</h3>
                    <p class="text-[14px] dark:text-gray-500 text-gray-400">days</p>
                    <p class="text-[13px] font-semibold dark:text-pink-400 text-orange-500 mt-1">{{ $streakMessage }}</p>
                </div>

                <!-- XP -->
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">

                    <p class="text-[14px] font-semibold dark:text-gray-400 text-gray-500 mb-6">
                        XP Progress
                    </p>

                    <h3 class="text-[20px] font-bold text-orange-400 mb-2">
                        Level {{ $gamification->level ?? 1 }}
                    </h3>

                    <p class="text-[14px] dark:text-gray-400 text-gray-500 mb-3">
                        {{ number_format($gamification->xp ?? 0) }} /
                        {{ number_format($levelProgress['next_level_xp'] ?? 100) }} XP
                    </p>

                    <div class="w-full h-[8px] rounded-full dark:bg-white/[0.08] bg-orange-100 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-pink-500 to-orange-500"
                            style="width: {{ $levelProgress['progress_pct'] ?? 0 }}%">
                        </div>
                    </div>
                </div>

                <!-- Focus Time -->
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                    <p class="text-[14px] font-semibold dark:text-gray-400 text-gray-500 mb-5">Focus Time</p>
                    <h3 class="text-[28px] font-extrabold dark:text-white text-gray-900 leading-none">
                        {{ $focusTimeFormatted }}</h3>
                    <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-1 mb-3">{{ $periodLabel }}</p>

                    <svg viewBox="0 0 160 45" class="w-full h-[45px]" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="focusLine" x1="0" y1="0" x2="1" y2="0">
                                <stop stop-color="#ec4899" />
                                <stop offset="1" stop-color="#f97316" />
                            </linearGradient>
                        </defs>
                        @php
                            $maxVal = max(1, max($focusSparkline));
                            $points = collect($focusSparkline)
                                ->map(function ($v, $i) use ($maxVal) {
                                    $x = $i * (160 / 6);
                                    $y = 40 - ($v / $maxVal) * 32;
                                    return round($x, 1) . ' ' . round($y, 1);
                                })
                                ->implode(' L ');
                        @endphp
                        <path d="M{{ $points }}" fill="none" stroke="url(#focusLine)" stroke-width="3"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>

            <!-- Priorities + Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3.5">

                <!-- Priorities -->
                <div
                    class="hover:-translate-y-1 transition-transform duration-200
                        dark:bg-[#1a1625] bg-white border dark:border-white/[0.07] border-orange-100 rounded-2xl p-[18px]">

                    <h3 class="text-[17px] font-bold dark:text-white text-gray-900 mb-1">Top 3 Priorities</h3>

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
                                    class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center
                                {{-- Light mode: filled numbered circle --}}
                                dark:border-2 dark:border-pink-500 dark:bg-transparent
                                {{-- Dark mode hides the number --}}
                                @if ($plan['color'] === 'pink') dark:border-pink-500
                                @elseif($plan['color'] === 'orange') dark:border-orange-400
                                @else dark:border-green-400 @endif

                                @if ($plan['color'] === 'pink') bg-gradient-to-br from-orange-400 to-pink-500
                                @elseif($plan['color'] === 'orange') bg-gradient-to-br from-orange-400 to-amber-500
                                @else bg-gradient-to-br from-green-400 to-emerald-500 @endif">

                                    <span class="dark:hidden text-[12px] font-bold text-white leading-none">
                                        {{ $plan['num'] }}
                                    </span>
                                </div>

                                {{-- Title --}}
                                <span class="flex-1 text-[13.5px] dark:text-gray-300 text-gray-700 font-medium truncate">
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
                            <p class="text-[13px] dark:text-gray-500 text-gray-400">No pending tasks. You're all caught up!
                                🎉</p>
                            <a href="{{ route('user.tasks.create') }}"
                                class="inline-block mt-3 px-4 py-2 rounded-lg text-[12px] font-bold text-white
                                bg-gradient-to-r from-orange-500 to-pink-500">
                                + Add Task
                            </a>
                        </div>
                    @endforelse
                </div>

                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                    <h3 class="text-[17px] font-bold dark:text-white text-gray-900 mb-1">Activity Feed</h3>

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
                                <p class="text-[13px] font-semibold dark:text-gray-200 text-gray-800 leading-[1.35] mb-0">
                                    {{ $activity['title'] }}
                                </p>
                                @if ($activity['desc'])
                                    <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-0.5 truncate">
                                        {{ $activity['desc'] }}
                                    </p>
                                @endif
                            </div>

                            {{-- Time --}}
                            <span class="text-[12.5px] dark:text-gray-600 text-gray-400 flex-shrink-0 pt-[2px]">
                                {{ $activity['time'] }}
                            </span>
                        </div>
                    @empty
                        <div class="py-8 text-center">
                            <p class="text-[13px] dark:text-gray-500 text-gray-400">
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
                <div
                    class="hover:-translate-y-1 transition-transform duration-200
                    dark:bg-[#12101a] bg-white
                    border dark:border-white/[0.07] border-orange-100
                    rounded-2xl p-[18px]">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-[17px] font-bold dark:text-white text-gray-900">
                            Productivity Overview
                        </h3>
                        {{-- Legend --}}
                        <div class="flex items-center gap-4 text-[12px] dark:text-gray-500 text-gray-400">
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-[2.5px] rounded-full bg-pink-500 inline-block"></span>
                                This week
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-[2.5px] rounded-full bg-orange-400 inline-block"></span>
                                Last week
                            </span>
                        </div>
                    </div>

                    <div class="relative h-[180px]">
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
                                {{ $periodLabel }} Completed
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('productivityChart');
            if (!ctx) return;

            const isDark = document.documentElement.classList.contains('dark');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                            label: 'This week',
                            data: @json($thisWeekData),
                            borderColor: '#ec4899',
                            backgroundColor: 'rgba(236,72,153,0.08)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 3,
                            pointBackgroundColor: '#ec4899',
                        },
                        {
                            label: 'Last week',
                            data: @json($lastWeekData),
                            borderColor: '#fb923c',
                            backgroundColor: 'rgba(251,146,60,0.06)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 3,
                            pointBackgroundColor: '#fb923c',
                            borderDash: [4, 4],
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: isDark ? '#6b7280' : '#9ca3af',
                                font: {
                                    size: 11
                                }
                            },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: isDark ? '#6b7280' : '#9ca3af',
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                color: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.04)'
                            },
                        },
                    },
                },
            });
        });
    </script>
@endsection
