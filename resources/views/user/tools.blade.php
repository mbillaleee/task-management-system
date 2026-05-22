@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    Tools
                </h2>
                <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Quick productivity tools to help you work smarter every day.
                </p>
            </div>

            <a href="{{ route('user.tasks.create') }}"
                class="px-4 py-2 rounded-[10px] text-white text-[12.5px] font-bold
            bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                + Add Task
            </a>
        </div>

        {{-- Hero --}}
        <div
            class="relative overflow-hidden rounded-2xl border dark:border-white/[0.07] border-black/[0.07]
        dark:bg-[#17141f] bg-white p-6 md:p-8 hover-lift">

            <div class="absolute top-0 right-0 w-72 h-72 bg-orange-500 blur-[100px] opacity-20"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-pink-500 blur-[100px] opacity-20"></div>

            <div class="relative z-10 max-w-2xl">
                <span
                    class="px-3 py-1 rounded-full text-[11px] font-bold
                bg-pink-500/[0.15] text-pink-400 border border-pink-500/20">
                    Productivity Toolkit
                </span>

                <h1
                    class="text-[32px] md:text-[44px] leading-tight font-extrabold tracking-[-1.4px] mt-5 dark:text-white text-gray-900">
                    Powerful tools for <br>
                    <span class="bg-gradient-to-r from-orange-400 to-pink-500 bg-clip-text text-transparent">
                        focused daily work.
                    </span>
                </h1>

                <p class="text-[13px] md:text-[14px] dark:text-gray-400 text-gray-500 mt-4 leading-relaxed">
                    Use focus timer, checklist, calculator, planner and quick utilities to keep your workflow organized.
                </p>
            </div>
        </div>

        {{-- Tools Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

            @php
                $tools = [
                    [
                        'icon' => '⏱️',
                        'title' => 'Pomodoro Timer',
                        'text' => 'Stay focused with work and break sessions.',
                        'status' => 'Active',
                    ],
                    [
                        'icon' => '✅',
                        'title' => 'Quick Checklist',
                        'text' => 'Create small checklists for daily execution.',
                        'status' => 'Ready',
                    ],
                    [
                        'icon' => '📅',
                        'title' => 'Daily Planner',
                        'text' => 'Plan today’s top priorities and deadlines.',
                        'status' => 'Ready',
                    ],
                    [
                        'icon' => '🧮',
                        'title' => 'Calculator',
                        'text' => 'Use quick calculations without leaving workspace.',
                        'status' => 'Utility',
                    ],
                    [
                        'icon' => '🎧',
                        'title' => 'Ambient Sounds',
                        'text' => 'Improve focus with calm working background sounds.',
                        'status' => 'Focus',
                    ],
                    [
                        'icon' => '📝',
                        'title' => 'Quick Notes',
                        'text' => 'Capture ideas, reminders and small thoughts.',
                        'status' => 'Notes',
                    ],
                    [
                        'icon' => '🎯',
                        'title' => 'Goal Tracker',
                        'text' => 'Track milestones and progress toward goals.',
                        'status' => 'Progress',
                    ],
                    [
                        'icon' => '📊',
                        'title' => 'Productivity Score',
                        'text' => 'Review your daily productivity performance.',
                        'status' => 'Analytics',
                    ],
                ];
            @endphp

            @foreach ($tools as $tool)
                <div
                    class="hover-lift relative overflow-hidden dark:bg-[#17141f] bg-white border dark:border-white/[0.07]
                border-black/[0.07] rounded-2xl p-[18px]">

                    <div class="absolute top-0 right-0 w-24 h-24 bg-pink-500 blur-3xl opacity-20"></div>

                    <div class="relative z-10">
                        <div class="flex items-start justify-between gap-3">
                            <div
                                class="w-11 h-11 rounded-xl flex items-center justify-center text-[21px]
                            dark:bg-white/[0.06] bg-gray-100">
                                {{ $tool['icon'] }}
                            </div>

                            <span
                                class="px-2.5 py-[4px] rounded-lg text-[11px] font-bold
                            dark:bg-orange-500/[0.15] bg-orange-50 text-orange-500 border border-orange-500/20">
                                {{ $tool['status'] }}
                            </span>
                        </div>

                        <h3 class="text-[15px] font-extrabold dark:text-white text-gray-900 mt-4">
                            {{ $tool['title'] }}
                        </h3>

                        <p class="text-[12.5px] dark:text-gray-400 text-gray-500 leading-relaxed mt-2">
                            {{ $tool['text'] }}
                        </p>

                        <button
                            class="mt-4 w-full px-3 py-2 rounded-[10px] text-[12px] font-bold
                        dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                            Open Tool
                        </button>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- Bottom Widgets --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            <div
                class="lg:col-span-2 hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[15px] font-bold dark:text-white text-gray-900 mb-4">
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
                            <p class="text-[12.5px] font-medium dark:text-gray-300 text-gray-700">
                                {{ $item }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[15px] font-bold dark:text-white text-gray-900 mb-4">
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
