@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    Features
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Explore all powerful tools designed to improve your productivity.
                </p>
            </div>

            <a href="{{ route('user.tasks.create') }}"
                class="flex items-center justify-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold
            bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                + Start Planning
            </a>
        </div>

        {{-- Hero --}}
        <div
            class="relative overflow-hidden rounded-2xl border dark:border-white/[0.07] border-black/[0.07]
        dark:bg-[#17141f] bg-white p-6 md:p-8 hover-lift">

            <div class="absolute top-0 right-0 w-72 h-72 bg-pink-500 blur-[100px] opacity-20"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-orange-500 blur-[100px] opacity-20"></div>

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
                        Infinite potential.
                    </span>
                </h1>

                <p class="text-[14px] md:text-[14px] dark:text-gray-400 text-gray-500 mt-4 leading-relaxed">
                    Manage tasks, habits, notes, focus sessions, analytics and goals from one powerful workspace.
                </p>

                <div class="flex flex-wrap gap-3 mt-6">
                    <a href="{{ route('user.tasks.index') }}"
                        class="px-5 py-2.5 rounded-[10px] text-white text-[14px] font-bold
                    bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                        View Tasks
                    </a>

                    <a href="#feature-list"
                        class="px-5 py-2.5 rounded-[10px] text-[14px] font-bold
                    dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                        See Features
                    </a>
                </div>
            </div>
        </div>

        {{-- Feature Cards --}}
        <div id="feature-list" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

            @php
                $features = [
                    [
                        'icon' => '✓',
                        'title' => 'Task Management',
                        'text' => 'Create, organize and track tasks with priorities, labels, subtasks and kanban view.',
                        'color' => 'orange',
                    ],
                    [
                        'icon' => '🔥',
                        'title' => 'Habit Tracking',
                        'text' => 'Build daily habits, track streaks and monitor personal growth over time.',
                        'color' => 'pink',
                    ],
                    [
                        'icon' => '📝',
                        'title' => 'Smart Notes',
                        'text' => 'Capture ideas, project notes and checklists in one clean workspace.',
                        'color' => 'purple',
                    ],
                    [
                        'icon' => '🎯',
                        'title' => 'Focus Tools',
                        'text' => 'Use focus sessions and productivity timers to stay distraction free.',
                        'color' => 'emerald',
                    ],
                    [
                        'icon' => '📊',
                        'title' => 'Analytics',
                        'text' => 'Understand your progress using activity feed, charts and productivity reports.',
                        'color' => 'blue',
                    ],
                    [
                        'icon' => '⚡',
                        'title' => 'XP System',
                        'text' => 'Earn XP, level up and stay motivated through gamified productivity.',
                        'color' => 'yellow',
                    ],
                    [
                        'icon' => '📅',
                        'title' => 'Planner',
                        'text' => 'Plan your day, deadlines and upcoming work with calendar-based organization.',
                        'color' => 'red',
                    ],
                    [
                        'icon' => '🔒',
                        'title' => 'Privacy First',
                        'text' => 'Your productivity data stays secure and fully controlled inside your system.',
                        'color' => 'green',
                    ],
                ];
            @endphp

            @foreach ($features as $feature)
                <div
                    class="hover-lift relative overflow-hidden dark:bg-[#17141f] bg-white border dark:border-white/[0.07]
                border-black/[0.07] rounded-2xl p-[18px]">

                    <div class="absolute top-0 right-0 w-24 h-24 bg-{{ $feature['color'] }}-500 blur-3xl opacity-20"></div>

                    <div class="relative z-10">
                        <div
                            class="w-11 h-11 rounded-xl flex items-center justify-center text-[21px]
                        dark:bg-white/[0.06] bg-gray-100">
                            {{ $feature['icon'] }}
                        </div>

                        <h3 class="text-[15px] font-extrabold dark:text-white text-gray-900 mt-4">
                            {{ $feature['title'] }}
                        </h3>

                        <p class="text-[12.5px] dark:text-gray-400 text-gray-500 leading-relaxed mt-2">
                            {{ $feature['text'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Bottom Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[15px] font-bold dark:text-white text-gray-900 mb-4">
                    Why Veroa?
                </h3>

                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <span class="text-orange-400">✓</span>
                        <p class="text-[12.5px] dark:text-gray-400 text-gray-500">
                            All-in-one workspace for tasks, habits, notes and focus.
                        </p>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="text-orange-400">✓</span>
                        <p class="text-[12.5px] dark:text-gray-400 text-gray-500">
                            Clean dark/light mode interface with premium SaaS experience.
                        </p>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="text-orange-400">✓</span>
                        <p class="text-[12.5px] dark:text-gray-400 text-gray-500">
                            Productivity analytics, XP progress and streak tracking.
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[15px] font-bold dark:text-white text-gray-900 mb-4">
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
