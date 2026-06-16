@extends('admin.layouts.master')

@section('admin')
    <div class="space-y-6">

        {{-- ═══════════════════════════════════════════════════
         PAGE HEADER
    ═══════════════════════════════════════════════════ --}}
        {{-- ADMIN HERO --}}
        <section
            class="relative overflow-hidden rounded-[18px] px-10 py-12 min-h-[360px]
                    border border-white/45 bg-[#f4dfbd]/70
                    shadow-[0_20px_60px_rgba(0,0,0,0.25)]
                    transition-colors duration-500
                    dark:border-orange-500/20 dark:bg-[#110715]
                    dark:shadow-[inset_0_1px_0_rgba(255,255,255,.04),0_0_45px_rgba(255,47,168,.08)]">

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div>
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[12px] font-bold
                            dark:bg-white/10 bg-white/60 dark:text-orange-300 text-orange-600 border dark:border-white/10 border-orange-200">
                        <i class="fas fa-shield-halved"></i>
                        Admin Control Center
                    </span>

                    <h1 class="mt-4 text-[32px] md:text-[42px] font-black leading-tight dark:text-white text-[#151515]">
                        Manage Veroa.
                        <span class="bg-gradient-to-r from-orange-400 to-pink-500 bg-clip-text text-transparent">
                            Grow smarter.
                        </span>
                    </h1>

                    <p class="mt-3 max-w-xl text-[14px] leading-7 dark:text-gray-400 text-gray-600">
                        Monitor users, subscriptions, productivity activity, gamification progress and platform performance.
                    </p>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <a href="{{ route('admin.users.index') }}"
                            class="px-5 py-3 rounded-xl text-white text-[13px] font-extrabold shadow-lg"
                            style="background:linear-gradient(135deg,#f97316,#ec4899);">
                            <i class="fas fa-users mr-1"></i> Manage Users
                        </a>

                        <a href="{{ route('admin.clear') }}"
                            class="px-5 py-3 rounded-xl text-[13px] font-extrabold
                             dark:bg-white/10 bg-white/70 dark:text-white text-gray-700 border dark:border-white/10 border-orange-100">
                            <i class="fas fa-rotate-right mr-1"></i> Clear Cache
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 min-w-[280px]">
                    <div
                        class="rounded-2xl p-4 dark:bg-white/[0.06] bg-white/60 border dark:border-white/10 border-orange-100">
                        <p class="text-[12px] dark:text-gray-400 text-gray-800 font-bold">Total Users</p>
                        <h3 class="text-[28px] font-black dark:text-white text-[#151515]">{{ number_format($totalUsers) }}
                        </h3>
                    </div>

                    <div
                        class="rounded-2xl p-4 dark:bg-white/[0.06] bg-white/60 border dark:border-white/10 border-orange-100">
                        <p class="text-[12px] dark:text-gray-400 text-gray-800 font-bold">Revenue</p>
                        <h3 class="text-[28px] font-black text-pink-400">${{ number_format($totalRevenue, 0) }}</h3>
                    </div>

                    <div
                        class="rounded-2xl p-4 dark:bg-white/[0.06] bg-white/60 border dark:border-white/10 border-orange-100">
                        <p class="text-[12px] dark:text-gray-400 text-gray-800 font-bold">Active Today</p>
                        <h3 class="text-[28px] font-black text-emerald-400">{{ number_format($activeToday) }}</h3>
                    </div>

                    <div
                        class="rounded-2xl p-4 dark:bg-white/[0.06] bg-white/60 border dark:border-white/10 border-orange-100">
                        <p class="text-[12px] dark:text-gray-400 text-gray-800 font-bold">Pro Users</p>
                        <h3 class="text-[28px] font-black text-purple-400">{{ number_format($proSubscribers) }}</h3>
                    </div>
                </div>
            </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         ROW 1 — PLATFORM KPIs (8 cards)
    ═══════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        {{-- Total Users --}}
        <div class="hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                    style="background: rgba(249,115,22,0.15);">
                    <i class="fas fa-users text-orange-400 text-[16px]"></i>
                </div>
                <span class="text-[11px] font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full">
                    <i class="fas fa-arrow-up"></i> {{ $newThisMonth }} this month
                </span>
            </div>
            <h3 class="text-[32px] font-black dark:text-white text-[#151515]">{{ number_format($totalUsers) }}</h3>
            <p class="text-[13px] dark:text-gray-400 text-gray-800 font-bold mt-0.5">Total Users</p>
        </div>

        {{-- Active Today --}}
        <div class="hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                    style="background: rgba(16,185,129,0.15);">
                    <i class="fas fa-circle-dot text-emerald-400 text-[16px]"></i>
                </div>
                <span class="text-[11px] font-bold dark:text-gray-500 text-gray-400">
                    {{ $activeThisWeek }} this week
                </span>
            </div>
            <h3 class="text-[32px] font-black text-emerald-400">{{ number_format($activeToday) }}</h3>
            <p class="text-[13px] dark:text-gray-400 text-gray-800 font-bold mt-0.5">Active Today</p>
        </div>

        {{-- Total Revenue --}}
        <div class="hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                    style="background: rgba(236,72,153,0.15);">
                    <i class="fas fa-dollar-sign text-pink-400 text-[16px]"></i>
                </div>
                <span class="text-[11px] font-bold text-pink-400 bg-pink-500/10 px-2 py-0.5 rounded-full">
                    ${{ number_format($revenueThisMonth, 0) }} this month
                </span>
            </div>
            <h3 class="text-[32px] font-black text-pink-400">${{ number_format($totalRevenue, 0) }}</h3>
            <p class="text-[13px] dark:text-gray-400 text-gray-800 font-bold mt-0.5">Total Revenue</p>
        </div>

        {{-- Pro Subscribers --}}
        <div class="hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                    style="background: rgba(139,92,246,0.15);">
                    <i class="fas fa-crown text-purple-400 text-[16px]"></i>
                </div>
                <span class="text-[11px] font-bold dark:text-gray-500 text-gray-800">
                    {{ $activeSubscribers }} active subs
                </span>
            </div>
            <h3 class="text-[32px] font-black text-purple-400">{{ number_format($proSubscribers) }}</h3>
            <p class="text-[13px] dark:text-gray-400 text-gray-800 font-bold mt-0.5">Pro Subscribers</p>
        </div>

        {{-- Total Tasks --}}
        <div class="hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                    style="background: rgba(59,130,246,0.15);">
                    <i class="fas fa-check-square text-blue-400 text-[16px]"></i>
                </div>
                <span class="text-[11px] font-bold text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded-full">
                    {{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}% done
                </span>
            </div>
            <h3 class="text-[32px] font-black text-blue-400">{{ number_format($totalTasks) }}</h3>
            <p class="text-[13px] dark:text-gray-400 text-gray-800 font-bold mt-0.5">Total Tasks</p>
        </div>

        {{-- Focus Sessions --}}
        <div class="hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                    style="background: rgba(249,115,22,0.15);">
                    <i class="fas fa-stopwatch text-orange-400 text-[16px]"></i>
                </div>
                <span class="text-[11px] font-bold dark:text-gray-500 text-gray-800">
                    {{ round($totalFocusMinutes / 60) }}h total
                </span>
            </div>
            <h3 class="text-[32px] font-black text-orange-400">{{ number_format($totalFocusSessions) }}</h3>
            <p class="text-[13px] dark:text-gray-400 text-gray-800 font-bold mt-0.5">Focus Sessions</p>
        </div>

        {{-- Total XP Earned --}}
        <div class="hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                    style="background: rgba(245,158,11,0.15);">
                    <i class="fas fa-bolt text-amber-400 text-[16px]"></i>
                </div>
                <span class="text-[11px] font-bold dark:text-gray-500 text-gray-800">
                    avg {{ number_format($avgXpPerUser) }} / user
                </span>
            </div>
            <h3 class="text-[32px] font-black text-amber-400">{{ number_format($totalXpEarned) }}</h3>
            <p class="text-[13px] dark:text-gray-400 text-gray-800 font-bold mt-0.5">Total XP Earned</p>
        </div>

        {{-- Badges Given --}}
        <div class="hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                    style="background: rgba(236,72,153,0.15);">
                    <i class="fas fa-medal text-pink-400 text-[16px]"></i>
                </div>
                <span class="text-[11px] font-bold dark:text-gray-500 text-gray-800">
                    {{ $totalChallengesDone }} challenges done
                </span>
            </div>
            <h3 class="text-[32px] font-black text-pink-400">{{ number_format($totalBadgesGiven) }}</h3>
            <p class="text-[13px] dark:text-gray-400 text-gray-800 font-bold mt-0.5">Badges Unlocked</p>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════
         ROW 2 — REGISTRATION CHART + REVENUE BY PLAN
    ═══════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        {{-- New Registrations — last 30 days --}}
        <div class="xl:col-span-2 hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-[16px] font-extrabold dark:text-white text-[#151515]">
                        <i class="fas fa-chart-line text-orange-400 mr-2"></i>New Registrations
                    </h3>
                    <p class="text-[12px] dark:text-gray-500 text-gray-800 mt-0.5">Last 30 days</p>
                </div>
                <span class="text-[13px] font-bold text-orange-400 bg-orange-500/10 px-3 py-1 rounded-full">
                    +{{ $newThisMonth }} this month
                </span>
            </div>
            <div style="height: 180px; position: relative;">
                <canvas id="registrationChart"></canvas>
            </div>
        </div>

        {{-- Revenue by Plan --}}
        <div class="hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <h3 class="text-[16px] font-extrabold dark:text-white text-[#151515] mb-5">
                <i class="fas fa-credit-card text-pink-400 mr-2"></i>Revenue by Plan
            </h3>
            @php
                $planColors = ['#f97316', '#ec4899', '#8b5cf6', '#3b82f6', '#10b981'];
            @endphp
            <div class="space-y-3">
                @forelse($revenueByPlan as $i => $plan)
                    @php $color = $planColors[$i % count($planColors)]; @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[13px] font-bold dark:text-gray-200 text-gray-700">
                                {{ $plan->name }}
                            </span>
                            <span class="text-[12px] font-bold dark:text-gray-400 text-gray-800">
                                ${{ number_format($plan->total_revenue ?? 0) }}
                                <span class="text-[10px] ml-1">({{ $plan->subscribers }} subs)</span>
                            </span>
                        </div>
                        <div class="h-3 rounded-full dark:bg-white/10 bg-gray-100 overflow-hidden">
                            <div class="h-full"
                                style="width: {{ min(100, round(($plan->total_revenue / max($totalRevenue, 1)) * 100)) }}%; background: {{ $color }};">
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-[13px] dark:text-gray-500 text-gray-800 text-center py-6">
                        <i class="fas fa-inbox text-2xl mb-2 block"></i>No subscription plans yet
                    </p>
                @endforelse
            </div>

            <div class="mt-4 pt-4 border-t dark:border-white/[0.06] border-black/[0.05] grid grid-cols-2 gap-3">
                <div class="text-center dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                    <div class="text-[20px] font-black text-pink-400">${{ number_format($totalRevenue, 0) }}</div>
                    <div class="text-[11px] dark:text-gray-500 text-gray-800 mt-0.5">All Time</div>
                </div>
                <div class="text-center dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                    <div class="text-[20px] font-black text-orange-400">${{ number_format($revenueThisMonth, 0) }}
                    </div>
                    <div class="text-[11px] dark:text-gray-500 text-gray-800 mt-0.5">This Month</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════
         ROW 3 — MODULE USAGE CHART + WEEKLY STATS
    ═══════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        {{-- Module usage chart (last 7 days) --}}
        <div class="xl:col-span-2 hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-[16px] font-extrabold dark:text-white text-[#151515]">
                        <i class="fas fa-chart-bar text-purple-400 mr-2"></i>Module Activity
                    </h3>
                    <p class="text-[12px] dark:text-gray-500 text-gray-800 mt-0.5">Last 7 days — tasks, habits, focus,
                        notes</p>
                </div>
                <div class="flex items-center gap-3 text-[11px] font-bold dark:text-gray-300 text-gray-800">
                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-orange-400 inline-block"></span>Tasks
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block"></span>Habits
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-pink-400 inline-block"></span>Focus
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-purple-400 inline-block"></span>Notes
                    </span>
                </div>
            </div>
            <div style="height: 180px; position: relative;">
                <canvas id="moduleChart"></canvas>
            </div>
        </div>

        {{-- Module usage numbers this week vs last week --}}
        <div class="hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <h3 class="text-[16px] font-extrabold dark:text-white text-[#151515] mb-4">
                <i class="fas fa-layer-group text-blue-400 mr-2"></i>Module Stats
            </h3>

            @php
                $modules = [
                    [
                        'label' => 'Tasks Created',
                        'this' => $weeklyModuleStats['tasks_this'],
                        'last' => $weeklyModuleStats['tasks_last'],
                        'icon' => 'fa-check-square',
                        'color' => 'text-blue-400',
                        'bg' => 'rgba(59,130,246,0.12)',
                    ],
                    [
                        'label' => 'Habits Logged',
                        'this' => $weeklyModuleStats['habits_this'],
                        'last' => $weeklyModuleStats['habits_last'],
                        'icon' => 'fa-repeat',
                        'color' => 'text-emerald-400',
                        'bg' => 'rgba(16,185,129,0.12)',
                    ],
                    [
                        'label' => 'Focus Sessions',
                        'this' => $weeklyModuleStats['focus_this'],
                        'last' => $weeklyModuleStats['focus_last'],
                        'icon' => 'fa-stopwatch',
                        'color' => 'text-orange-400',
                        'bg' => 'rgba(249,115,22,0.12)',
                    ],
                    [
                        'label' => 'Notes Created',
                        'this' => $weeklyModuleStats['notes_this'],
                        'last' => $weeklyModuleStats['notes_last'],
                        'icon' => 'fa-file-lines',
                        'color' => 'text-purple-400',
                        'bg' => 'rgba(139,92,246,0.12)',
                    ],
                ];
            @endphp

            <div class="space-y-3">
                @foreach ($modules as $mod)
                    @php
                        $diff = $mod['this'] - $mod['last'];
                        $pct = $mod['last'] > 0 ? round(($diff / $mod['last']) * 100) : 0;
                        $up = $diff >= 0;
                    @endphp
                    <div class="flex items-center gap-3 p-2.5 rounded-xl dark:bg-white/[0.03] bg-gray-50">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                            style="background: {{ $mod['bg'] }};">
                            <i class="fas {{ $mod['icon'] }} {{ $mod['color'] }} text-[14px]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[12px] dark:text-gray-400 text-gray-800">{{ $mod['label'] }}</p>
                            <p class="text-[16px] font-black dark:text-white text-[#151515]">{{ $mod['this'] }}</p>
                        </div>
                        <span class="text-[11px] font-bold {{ $up ? 'text-emerald-400' : 'text-red-400' }} shrink-0">
                            <i class="fas {{ $up ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[9px]"></i>
                            {{ abs($pct) }}%
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 pt-3 border-t dark:border-white/[0.06] border-black/[0.05]">
                <p class="text-[11px] dark:text-gray-600 text-gray-800 text-center">
                    <i class="fas fa-clock-rotate-left mr-1"></i>Compared to last week
                </p>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════
         ROW 4 — TOP XP LEADERBOARD + PLATFORM TOTALS
    ═══════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        {{-- Top 10 users by XP --}}
        <div class="xl:col-span-2 hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[16px] font-extrabold dark:text-white text-[#151515]">
                    <i class="fas fa-ranking-star text-amber-400 mr-2"></i>Top 10 Users by XP
                </h3>
                <a href="{{ route('admin.users.index') }}"
                    class="text-[12px] font-bold text-orange-400 hover:text-orange-300">
                    View all <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="space-y-2">
                @forelse($topUsers as $i => $ug)
                    @php
                        $rankColors = ['text-amber-400', 'text-gray-300', 'text-orange-600'];
                        $rankIcons = ['fa-trophy', 'fa-medal', 'fa-award'];
                        $rankColor = $rankColors[$i] ?? 'text-gray-500';
                        $rankIcon = $rankIcons[$i] ?? 'fa-circle-dot';
                        $maxXp = $topUsers->first()?->xp ?: 1;
                        $barPct = round(($ug->xp / $maxXp) * 100);
                    @endphp
                    <div
                        class="flex items-center gap-3 p-2.5 rounded-xl hover:dark:bg-white/[0.04] hover:bg-gray-50 transition-colors">
                        {{-- Rank --}}
                        <div class="w-7 text-center flex-shrink-0">
                            @if ($i < 3)
                                <i class="fas {{ $rankIcon }} {{ $rankColor }} text-[16px]"></i>
                            @else
                                <span
                                    class="text-[13px] font-black dark:text-gray-500 text-gray-800">{{ $i + 1 }}</span>
                            @endif
                        </div>

                        {{-- Avatar --}}
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-[14px] font-bold text-white flex-shrink-0"
                            style="background: linear-gradient(135deg, #f97316, #ec4899);">
                            {{ strtoupper(substr($ug->user?->name ?? 'U', 0, 1)) }}
                        </div>

                        {{-- Name + bar --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[13px] font-bold dark:text-white text-[#151515] truncate">
                                    {{ $ug->user?->name ?? 'Unknown' }}
                                </span>
                                <span class="text-[12px] font-bold text-amber-400 ml-2 shrink-0">
                                    <i class="fas fa-bolt text-[10px]"></i> {{ number_format($ug->xp) }} XP
                                </span>
                            </div>
                            <div class="w-full h-[4px] rounded-full dark:bg-white/[0.08] bg-gray-100">
                                <div class="h-full rounded-full"
                                    style="width: {{ $barPct }}%; background: linear-gradient(90deg, #f97316, #ec4899);">
                                </div>
                            </div>
                        </div>

                        {{-- Level --}}
                        <div class="text-center flex-shrink-0 ml-1">
                            <span class="text-[10px] font-bold dark:text-gray-500 text-gray-800">Lv</span>
                            <div class="text-[14px] font-black dark:text-white text-gray-700">{{ $ug->level }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 dark:text-gray-600 text-gray-800">
                        <i class="fas fa-chart-simple text-3xl mb-2 block"></i>
                        No XP data yet
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Platform totals sidebar --}}
        <div class="space-y-4">

            {{-- All-time module totals --}}
            <div class="hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
                <h3 class="text-[15px] font-extrabold dark:text-white text-[#151515] mb-4">
                    <i class="fas fa-database text-emerald-400 mr-2"></i>All-Time Totals
                </h3>
                <div class="space-y-2.5">
                    @foreach ([['Tasks Created', $totalTasks, 'fa-check-square', 'text-blue-400'], ['Tasks Completed', $completedTasks, 'fa-circle-check', 'text-emerald-400'], ['Habits Created', $totalHabits, 'fa-repeat', 'text-orange-400'], ['Habit Logs', $totalHabitLogs, 'fa-fire', 'text-red-400'], ['Notes Written', $totalNotes, 'fa-file-lines', 'text-purple-400'], ['Goals Created', $totalGoals, 'fa-bullseye', 'text-yellow-400'], ['Goals Completed', $completedGoals, 'fa-trophy', 'text-amber-400'], ['Journal Entries', $totalJournals, 'fa-book-open', 'text-pink-400']] as [$label, $val, $icon, $color])
                        <div class="flex items-center justify-between">
                            <span class="text-[12px] dark:text-gray-400 text-gray-800 flex items-center gap-1.5">
                                <i
                                    class="fas {{ $icon }} {{ $color }} text-[11px]"></i>{{ $label }}
                            </span>
                            <span class="text-[13px] font-black dark:text-white text-gray-800">
                                {{ number_format($val) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Gamification totals --}}
            <div class="hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
                <h3 class="text-[15px] font-extrabold dark:text-white text-[#151515] mb-4">
                    <i class="fas fa-gamepad text-amber-400 mr-2"></i>Gamification
                </h3>
                <div class="space-y-2.5">
                    @foreach ([['XP Earned', number_format($totalXpEarned), 'fa-bolt', 'text-amber-400'], ['Avg XP / User', number_format($avgXpPerUser), 'fa-chart-simple', 'text-orange-400'], ['Badges Unlocked', number_format($totalBadgesGiven), 'fa-medal', 'text-pink-400'], ['Challenges Done', number_format($totalChallengesDone), 'fa-flag', 'text-emerald-400']] as [$label, $val, $icon, $color])
                        <div class="flex items-center justify-between">
                            <span class="text-[12px] dark:text-gray-400 text-gray-800 flex items-center gap-1.5">
                                <i
                                    class="fas {{ $icon }} {{ $color }} text-[11px]"></i>{{ $label }}
                            </span>
                            <span class="text-[13px] font-black dark:text-white text-gray-800">{{ $val }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         ROW 5 — RECENT REGISTRATIONS
    ═══════════════════════════════════════════════════ --}}
    <div class="hover-lift veroa-card rounded-2xl p-5 border shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
            <div>
                <h3 class="text-[16px] font-extrabold dark:text-white text-[#151515] flex items-center gap-2">
                    <span
                        class="w-9 h-9 rounded-xl flex items-center justify-center
                    dark:bg-blue-500/10 bg-blue-100 text-blue-400">
                        <i class="fas fa-user-plus text-[14px]"></i>
                    </span>
                    Recent Registrations
                </h3>
                <p class="text-[12px] dark:text-gray-500 text-gray-800 mt-1">
                    Latest users who joined the platform
                </p>
            </div>

            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-[12px] font-extrabold
            dark:bg-white/[0.07] bg-white/70 dark:text-orange-300 text-orange-500
            border dark:border-white/[0.08] border-orange-200/70 hover:text-orange-400 transition">
                View all <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto rounded-2xl border dark:border-white/[0.06] border-orange-100/80">
            <table class="w-full text-left border-collapse min-w-[720px]">
                <thead>
                    <tr
                        class="text-[11px] font-black dark:text-gray-400 text-gray-500 uppercase tracking-wider
                    dark:bg-white/[0.04] bg-orange-50/70">
                        <th class="py-3 px-4">User</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Plan</th>
                        <th class="py-3 px-4">Registered</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y dark:divide-white/[0.05] divide-orange-100/80">
                    @forelse($recentUsers as $user)
                        <tr class="group hover:dark:bg-white/[0.04] hover:bg-orange-50/60 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-[13px] font-black text-white flex-shrink-0 shadow-lg"
                                            style="background: linear-gradient(135deg, #f97316, #ec4899);">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span
                                            class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 dark:border-[#0d0818] border-white"></span>
                                    </div>

                                    <div class="min-w-0">
                                        <span
                                            class="block text-[13px] font-extrabold dark:text-white text-[#151515] truncate">
                                            {{ $user->name }}
                                        </span>
                                        <span class="block text-[11px] dark:text-gray-500 text-gray-800">
                                            ID: #{{ $user->id }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-3.5 px-4 text-[13px] dark:text-gray-300 text-gray-600">
                                <span class="block max-w-[260px] truncate">
                                    {{ $user->email }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4">
                                @php $plan = $user->activeSubscription?->plan; @endphp

                                @if ($plan && $plan->price_monthly > 0)
                                    <span
                                        class="inline-flex items-center gap-1.5 text-[11px] font-extrabold text-purple-400
                                    bg-purple-500/10 border border-purple-500/20 px-2.5 py-1 rounded-full">
                                        <i class="fas fa-crown text-[9px]"></i> {{ $plan->name }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 text-[11px] font-extrabold
                                    dark:text-gray-300 text-gray-600 dark:bg-white/[0.06] bg-gray-100
                                    border dark:border-white/[0.06] border-gray-200 px-2.5 py-1 rounded-full">
                                        <i class="fas fa-circle text-[6px] text-emerald-400"></i> Free
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-[12px] dark:text-gray-400 text-gray-500 whitespace-nowrap">
                                <i class="fas fa-clock text-[10px] mr-1 text-orange-400"></i>
                                {{ $user->created_at->diffForHumans() }}
                            </td>

                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('admin.users.show', $user) }}"
                                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-[12px] font-extrabold
                                text-orange-400 dark:bg-orange-500/10 bg-orange-50 border border-orange-500/10
                                hover:bg-gradient-to-r hover:from-orange-500 hover:to-pink-500 hover:text-white transition-all">
                                    View <i class="fas fa-arrow-right text-[9px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div
                                    class="mx-auto w-14 h-14 rounded-2xl flex items-center justify-center
                                dark:bg-white/[0.05] bg-orange-50 text-orange-400 mb-3">
                                    <i class="fas fa-users-slash text-2xl"></i>
                                </div>
                                <p class="text-[14px] font-extrabold dark:text-white text-[#151515]">
                                    No users yet
                                </p>
                                <p class="text-[12px] dark:text-gray-500 text-gray-800 mt-1">
                                    New user registrations will appear here.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    </div>
@endsection


@push('js')
    <script>
        let registrationChartInstance = null;
        let moduleChartInstance = null;

        const regLabels = @json(array_column($registrationChart, 'date'));
        const regData = @json(array_column($registrationChart, 'count'));

        const modLabels = @json(array_column($moduleChart, 'label'));
        const modTasks = @json(array_column($moduleChart, 'tasks'));
        const modHabits = @json(array_column($moduleChart, 'habits'));
        const modFocus = @json(array_column($moduleChart, 'focus'));
        const modNotes = @json(array_column($moduleChart, 'notes'));

        function renderAdminCharts() {
            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.08)';
            const tickColor = isDark ? 'rgba(255,255,255,0.65)' : 'rgba(17,24,39,0.65)';
            const tooltipBg = isDark ? '#1a1625' : '#ffffff';
            const tooltipTxt = isDark ? '#ffffff' : '#111827';

            const baseChartOptions = (extraY = {}) => ({
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipTxt,
                        bodyColor: tooltipTxt,
                        borderColor: 'rgba(249,115,22,0.3)',
                        borderWidth: 1,
                        padding: 10,
                        cornerRadius: 10,
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: gridColor,
                            drawBorder: false
                        },
                        ticks: {
                            color: tickColor,
                            font: {
                                size: 11
                            }
                        },
                        border: {
                            display: false
                        },
                    },
                    y: {
                        grid: {
                            color: gridColor,
                            drawBorder: false
                        },
                        ticks: {
                            color: tickColor,
                            font: {
                                size: 11
                            },
                            ...extraY
                        },
                        border: {
                            display: false
                        },
                    }
                }
            });

            if (registrationChartInstance) {
                registrationChartInstance.destroy();
            }

            if (moduleChartInstance) {
                moduleChartInstance.destroy();
            }

            // ── Registration Chart ───────────────────────────────
            const regCtx = document.getElementById('registrationChart');
            if (regCtx) {
                const ctx = regCtx.getContext('2d');
                const grad = ctx.createLinearGradient(0, 0, 0, 180);
                grad.addColorStop(0, 'rgba(249,115,22,0.35)');
                grad.addColorStop(1, 'rgba(249,115,22,0.02)');

                registrationChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: regLabels,
                        datasets: [{
                            data: regData,
                            borderColor: '#f97316',
                            borderWidth: 2.5,
                            fill: true,
                            backgroundColor: grad,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 4,
                            pointHoverBackgroundColor: '#f97316',
                        }]
                    },
                    options: {
                        ...baseChartOptions({
                            stepSize: 1,
                            precision: 0
                        }),
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                    }
                });
            }

            // ── Module Activity Chart ────────────────────────────
            const modCtx = document.getElementById('moduleChart');
            if (modCtx) {
                moduleChartInstance = new Chart(modCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: modLabels,
                        datasets: [{
                                label: 'Tasks',
                                data: modTasks,
                                backgroundColor: 'rgba(249,115,22,0.75)',
                                borderRadius: 4
                            },
                            {
                                label: 'Habits',
                                data: modHabits,
                                backgroundColor: 'rgba(16,185,129,0.75)',
                                borderRadius: 4
                            },
                            {
                                label: 'Focus',
                                data: modFocus,
                                backgroundColor: 'rgba(236,72,153,0.75)',
                                borderRadius: 4
                            },
                            {
                                label: 'Notes',
                                data: modNotes,
                                backgroundColor: 'rgba(139,92,246,0.75)',
                                borderRadius: 4
                            },
                        ]
                    },
                    options: {
                        ...baseChartOptions({
                            stepSize: 1,
                            precision: 0
                        }),
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            ...baseChartOptions().plugins,
                            legend: {
                                display: false
                            },
                        }
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            renderAdminCharts();

            const observer = new MutationObserver(function() {
                renderAdminCharts();
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        });
    </script>
@endpush
