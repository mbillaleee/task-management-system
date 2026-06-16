@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-800">
                    <i class="fa-solid fa-tools"></i> Tools
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    Quick productivity tools to help you work smarter every day.
                </p>
            </div>

            <a href="{{ route('user.tasks.create') }}"
                class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold
            bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                <i class="fa-solid fa-plus"></i> Add Task
            </a>
        </div>

        {{-- Hero --}}
        <div class="relative overflow-hidden rounded-2xl border veroa-card p-6 md:p-8 hover-lift">
            <div class="relative z-10 max-w-2xl">
                <span
                    class="px-3 py-1 rounded-full text-[11px] font-bold
                bg-pink-500/[0.15] text-pink-400 border border-pink-500/20">
                    <i class="fa-solid fa-tools"></i> Productivity Toolkit
                </span>

                <h1
                    class="text-[24px] sm:text-[32px] md:text-[44px] leading-tight font-extrabold tracking-[-1.4px] mt-5 dark:text-white text-gray-800">
                    Powerful tools for <br>
                    <span class="bg-gradient-to-r from-orange-400 to-pink-500 bg-clip-text text-transparent">
                        focused daily work.
                    </span>
                </h1>

                <p class="text-[14px] md:text-[14px] dark:text-white text-gray-800 mt-4 leading-relaxed">
                    Use focus timer, checklist, calculator, planner and quick utilities to keep your workflow organized.
                </p>
            </div>
        </div>

        {{-- Tools Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

            @php
                $tools = [
                    [
                        'icon' => 'fa-stopwatch',
                        'title' => 'Pomodoro Timer',
                        'text' => 'Stay focused with work and break sessions.',
                        'status' => 'Active',
                        'color' => 'orange',
                    ],
                    [
                        'icon' => 'fa-check',
                        'title' => 'Quick Checklist',
                        'text' => 'Create small checklists for daily execution.',
                        'status' => 'Ready',
                        'color' => 'pink',
                    ],
                    [
                        'icon' => 'fa-calendar-day',
                        'title' => 'Daily Planner',
                        'text' => 'Plan today’s top priorities and deadlines.',
                        'status' => 'Ready',
                        'color' => 'blue',
                    ],
                    [
                        'icon' => 'fa-calculator',
                        'title' => 'Task',
                        'text' => 'Use quick calculations without leaving workspace.',
                        'status' => 'Utility',
                        'color' => 'purple',
                    ],
                    [
                        'icon' => 'fa-headphones',
                        'title' => 'Ambient Sounds',
                        'text' => 'Improve focus with calm working background sounds.',
                        'status' => 'Focus',
                        'color' => 'emerald',
                    ],
                    [
                        'icon' => 'fa-note-sticky',
                        'title' => 'Quick Notes',
                        'text' => 'Capture ideas, reminders and small thoughts.',
                        'status' => 'Notes',
                        'color' => 'yellow',
                    ],
                    [
                        'icon' => 'fa-bullseye',
                        'title' => 'Goal Tracker',
                        'text' => 'Track milestones and progress toward goals.',
                        'status' => 'Progress',
                        'color' => 'red',
                    ],
                    [
                        'icon' => 'fa-chart-line',
                        'title' => 'Productivity Score',
                        'text' => 'Review your daily productivity performance.',
                        'status' => 'Analytics',
                        'color' => 'green',
                    ],
                ];
            @endphp

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

            @foreach ($tools as $tool)
                <div class="veroa-card rounded-2xl p-[18px]
                hover:-translate-y-1 transition duration-300">

                    <!-- ICON (FEATURE STYLE) -->
                    <div
                        class="w-11 h-11 rounded-xl flex items-center justify-center text-[18px]
                    {{ $colorMap[$tool['color']] }}">
                        <i class="fa-solid {{ $tool['icon'] }}"></i>
                    </div>

                    <!-- TITLE -->
                    <h3 class="text-[15px] font-extrabold mt-4
                   text-gray-800 dark:text-white">
                        {{ $tool['title'] }}
                    </h3>

                    <!-- TEXT -->
                    <p class="text-[12.5px] mt-2 leading-relaxed
                  text-gray-800 dark:text-white">
                        {{ $tool['text'] }}
                    </p>

                    <!-- BUTTON (FEATURE STYLE CTA) -->
                    {{-- <button
                        class="mt-4 w-full px-3 py-2 rounded-[10px] text-[14px] font-bold
            bg-gradient-to-r from-orange-500 to-pink-500
            text-white
            shadow-[0_8px_25px_rgba(249,115,22,0.25)]
            hover:shadow-[0_12px_35px_rgba(236,72,153,0.35)]
            transition">

                        <i class="fa-solid fa-arrow-right mr-1"></i>
                        Open Tool
                    </button> --}}

                </div>
            @endforeach

        </div>

        {{-- Bottom Widgets --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            <div class="lg:col-span-2 hover-lift veroa-card rounded-2xl p-[18px]">
                <h3 class="text-[15px] font-bold dark:text-white text-gray-800 mb-4">
                    Today’s Utility Stack
                </h3>

                <div class="space-y-3">
                    @foreach (['Start 25 min focus session', 'Review today’s checklist', 'Update task priorities', 'Write quick progress note'] as $item)
                        <div
                            class="flex items-center gap-3 py-2.5 border-b last:border-b-0 dark:border-white/[0.06] border-black/[0.05]">
                            <span
                                class="w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                                ✓
                            </span>
                            <p class="text-[12.5px] font-medium dark:text-white text-gray-800">
                                {{ $item }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="hover-lift veroa-card rounded-2xl p-[18px]">
                <h3 class="text-[15px] font-bold dark:text-white text-gray-800 mb-4">
                    Tool Usage
                </h3>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-[11.5px] mb-1.5">
                            <span class="dark:text-gray-400 text-gray-500">Focus Tools</span>
                            <span class="font-bold text-orange-400">78%</span>
                        </div>
                        <div class="w-full h-[7px] rounded-full dark:bg-white/[0.08] bg-gray-100 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500" style="width:78%">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-[11.5px] mb-1.5">
                            <span class="dark:text-gray-400 text-gray-500">Planning</span>
                            <span class="font-bold text-pink-400">64%</span>
                        </div>
                        <div class="w-full h-[7px] rounded-full dark:bg-white/[0.08] bg-gray-100 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500" style="width:64%">
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-[11.5px] mb-1.5">
                            <span class="dark:text-gray-400 text-gray-500">Quick Notes</span>
                            <span class="font-bold text-purple-400">52%</span>
                        </div>
                        <div class="w-full h-[7px] rounded-full dark:bg-white/[0.08] bg-gray-100 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500" style="width:52%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection
