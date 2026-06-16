@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col  sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-800">
                    Features
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    Explore all powerful tools designed to improve your productivity.
                </p>
            </div>

            <a href="{{ route('user.tasks.create') }}"
                class="flex items-center justify-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold
            bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                <i class="fa-solid fa-plus"></i> Start Planning
            </a>
        </div>

        {{-- Hero --}}
        <div class="relative overflow-hidden rounded-2xl border veroa-card p-6 md:p-8 hover-lift">

            <div class="relative z-10 max-w-2xl">
                <span
                    class="px-3 py-1 rounded-full text-[11px] font-bold
                bg-orange-500/[0.15] text-orange-400 border border-orange-500/20">
                    Veroa Productivity System
                </span>

                <h1
                    class="text-[28px] sm:text-[36px] md:text-[46px] leading-tight font-extrabold tracking-[-1.5px] mt-5 dark:text-white text-gray-900">
                    One system. <br>
                    <span class="bg-gradient-to-r from-orange-400 to-pink-500 bg-clip-text text-transparent">
                        <i class="fa-solid fa-infinity"></i> Infinite potential.
                    </span>
                </h1>

                <p class="text-[14px] md:text-[14px] dark:text-white text-gray-800 mt-4 leading-relaxed">
                    Manage tasks, habits, notes, focus sessions, analytics and goals from one powerful workspace.
                </p>

                <div class="flex flex-wrap gap-3 mt-6">
                    <a href="{{ route('user.tasks.index') }}"
                        class="px-5 py-2.5 rounded-[10px] text-white text-[14px] font-bold
                    bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                        <i class="fa-solid fa-tasks"></i> View Tasks
                    </a>

                    <a href="{{ route('user.habits.index') }}"
                        class="px-5 py-2.5 rounded-[10px] text-[14px] font-bold
                    dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                        <i class="fa-solid fa-list"></i> Habits
                    </a>
                </div>
            </div>
        </div>

        {{-- Feature Cards --}}
        <div id="feature-list" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

            @php
                $features = [
                    [
                        'icon' => 'fa-tasks',
                        'title' => 'Task Management',
                        'text' => 'Create, organize and track tasks with priorities, labels, subtasks and kanban view.',
                        'color' => 'orange',
                    ],
                    [
                        'icon' => 'fa-fire',
                        'title' => 'Habit Tracking',
                        'text' => 'Build daily habits, track streaks and monitor personal growth over time.',
                        'color' => 'pink',
                    ],
                    [
                        'icon' => 'fa-pen',
                        'title' => 'Smart Notes',
                        'text' => 'Capture ideas, project notes and checklists in one clean workspace.',
                        'color' => 'purple',
                    ],
                    [
                        'icon' => 'fa-bullseye',
                        'title' => 'Focus Tools',
                        'text' => 'Use focus sessions and productivity timers to stay distraction free.',
                        'color' => 'emerald',
                    ],
                    [
                        'icon' => 'fa-chart-line',
                        'title' => 'Analytics',
                        'text' => 'Understand your progress using activity feed, charts and productivity reports.',
                        'color' => 'blue',
                    ],
                    [
                        'icon' => 'fa-bolt',
                        'title' => 'XP System',
                        'text' => 'Earn XP, level up and stay motivated through gamified productivity.',
                        'color' => 'yellow',
                    ],
                    [
                        'icon' => 'fa-calendar',
                        'title' => 'Planner',
                        'text' => 'Plan your day, deadlines and upcoming work with calendar-based organization.',
                        'color' => 'red',
                    ],
                    [
                        'icon' => 'fa-shield-alt',
                        'title' => 'Privacy First',
                        'text' => 'Your productivity data stays secure and fully controlled inside your system.',
                        'color' => 'green',
                    ],
                ];
            @endphp

            @foreach ($features as $feature)
                @php
                    $colorMap = [
                        'orange' => 'text-orange-500 bg-orange-500/10',
                        'pink' => 'text-pink-500 bg-pink-500/10',
                        'purple' => 'text-purple-500 bg-purple-500/10',
                        'emerald' => 'text-emerald-500 bg-emerald-500/10',
                        'blue' => 'text-blue-500 bg-blue-500/10',
                        'yellow' => 'text-yellow-500 bg-yellow-500/10',
                        'red' => 'text-red-500 bg-red-500/10',
                        'green' => 'text-green-500 bg-green-500/10',
                    ];
                @endphp

                <div
                    class="hover-lift relative overflow-hidden veroa-card rounded-2xl p-[18px]
                hover:-translate-y-1 transition duration-300">

                    <div class="relative z-10">

                        <!-- ICON -->
                        <div
                            class="w-11 h-11 rounded-xl flex items-center justify-center text-[18px]
                        {{ $colorMap[$feature['color']] }}">

                            <i class="fas {{ $feature['icon'] }}"></i>
                        </div>

                        <!-- TITLE -->
                        <h3 class="text-[15px] font-extrabold dark:text-white text-gray-800 mt-4">
                            {{ $feature['title'] }}
                        </h3>

                        <!-- TEXT -->
                        <p class="text-[12.5px] dark:text-white text-gray-800 leading-relaxed mt-2">
                            {{ $feature['text'] }}
                        </p>

                    </div>
                </div>
            @endforeach

        </div>

        {{-- Bottom Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <div class="hover-lift veroa-card rounded-2xl p-[18px]">
                <h3 class="text-[15px] font-bold dark:text-white text-gray-800 mb-4">
                    Why Veroa?
                </h3>

                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <span class="text-orange-400">✓</span>
                        <p class="text-[12.5px] dark:text-white text-gray-800">
                            All-in-one workspace for tasks, habits, notes and focus.
                        </p>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="text-orange-400">✓</span>
                        <p class="text-[12.5px] dark:text-white text-gray-800">
                            Clean dark/light mode interface with premium SaaS experience.
                        </p>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="text-orange-400">✓</span>
                        <p class="text-[12.5px] dark:text-white text-gray-800">
                            Productivity analytics, XP progress and streak tracking.
                        </p>
                    </div>
                </div>
            </div>

            <div class="hover-lift veroa-card rounded-2xl p-[18px]">
                <h3 class="text-[15px] font-bold dark:text-white text-gray-800 mb-4">
                    Core Modules
                </h3>

                <div class="flex flex-wrap gap-2">
                    @foreach (['Dashboard', 'Tasks', 'Habits', 'Notes', 'Focus', 'Tools', 'Analytics', 'Settings'] as $module)
                        <span
                            class="px-3 py-1.5 rounded-[8px] text-[11.5px] font-semibold
                        dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600">
                            {{ $module }}
                        </span>
                    @endforeach
                </div>
            </div>

        </div>

    </section>
@endsection
