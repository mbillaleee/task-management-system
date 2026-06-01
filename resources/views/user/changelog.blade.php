@extends('user.layouts.master')

@section('user')
    <div class="space-y-6">

        <!-- Page Header -->
        <div
            class="relative overflow-hidden rounded-2xl border dark:border-orange-500/[0.18] border-orange-200/70
        dark:bg-[#100b18] bg-orange-50/70 px-6 py-7">

            <div class="absolute inset-0 pointer-events-none opacity-50"
                style="background:
            radial-gradient(circle at 20% 30%, rgba(249,115,22,.18), transparent 30%),
            radial-gradient(circle at 80% 50%, rgba(236,72,153,.18), transparent 35%);">
            </div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                <div>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-bold
                    bg-orange-500/[0.14] text-orange-400 border border-orange-500/[0.25] mb-3">
                        Product Updates
                    </span>

                    <h1
                        class="text-[28px] sm:text-[32px] md:text-[38px] font-extrabold leading-tight dark:text-white text-gray-900">
                        Changelog
                    </h1>

                    <p class="text-[14px] dark:text-gray-400 text-gray-500 mt-2 max-w-[520px] leading-[1.7]">
                        Track every improvement, new feature, bug fix and performance update inside Veroa.
                    </p>
                </div>

                <div
                    class="w-[110px] h-[110px] rounded-3xl flex items-center justify-center
                bg-gradient-to-br from-orange-500/[0.18] to-pink-500/[0.18]
                border dark:border-white/[0.08] border-orange-200 shadow-[0_0_35px_rgba(249,115,22,.25)]">
                    <span class="text-[52px] drop-shadow-[0_0_18px_rgba(249,115,22,.9)]">🚀</span>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[14px] font-semibold dark:text-gray-400 text-gray-500 mb-2">Total Updates</p>
                <h3 class="text-[30px] font-extrabold dark:text-white text-gray-900">24</h3>
                <p class="text-[12px] text-orange-400 mt-1">Released changes</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[14px] font-semibold dark:text-gray-400 text-gray-500 mb-2">New Features</p>
                <h3 class="text-[30px] font-extrabold text-pink-500">12</h3>
                <p class="text-[12px] text-pink-500 mt-1">Major additions</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[14px] font-semibold dark:text-gray-400 text-gray-500 mb-2">Fixes</p>
                <h3 class="text-[30px] font-extrabold text-emerald-500">8</h3>
                <p class="text-[12px] text-emerald-500 mt-1">Bug resolved</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[14px] font-semibold dark:text-gray-400 text-gray-500 mb-2">Current Version</p>
                <h3 class="text-[30px] font-extrabold text-orange-500">v1.4</h3>
                <p class="text-[12px] text-orange-400 mt-1">Stable release</p>
            </div>

        </div>

        <!-- Changelog Timeline -->
        <div
            class="dark:bg-[#100b18] bg-white border dark:border-orange-500/[0.14] border-orange-200/70
        rounded-2xl p-5">

            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-[18px] font-extrabold dark:text-white text-gray-900">
                        Release Timeline
                    </h2>
                    <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-1">
                        Latest product improvements and version history.
                    </p>
                </div>

                <select
                    class="px-3 py-2 rounded-[10px] text-[12.5px] font-medium outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-600
                border dark:border-white/[0.1] border-black/[0.12]">
                    <option>All Updates</option>
                    <option>Features</option>
                    <option>Fixes</option>
                    <option>Improvements</option>
                </select>
            </div>

            @php
                $changes = [
                    [
                        'version' => 'v1.4',
                        'date' => 'May 21, 2026',
                        'type' => 'New',
                        'color' => 'orange',
                        'title' => 'Task Management Module Added',
                        'desc' =>
                            'Added task creation, priority level, status tracking, due date and dashboard task overview.',
                        'items' => [
                            'Create / Edit / Delete task',
                            'Priority: Low, Medium, High',
                            'Task status workflow',
                            'Today plan section',
                        ],
                    ],
                    [
                        'version' => 'v1.3',
                        'date' => 'May 18, 2026',
                        'type' => 'Improved',
                        'color' => 'pink',
                        'title' => 'Dashboard UI Improved',
                        'desc' =>
                            'Dashboard cards, analytics panel, activity feed and neon glassmorphism layout improved.',
                        'items' => [
                            'Daily score card',
                            'XP progress card',
                            'Focus score ring',
                            'Responsive dashboard layout',
                        ],
                    ],
                    [
                        'version' => 'v1.2',
                        'date' => 'May 15, 2026',
                        'type' => 'Fixed',
                        'color' => 'emerald',
                        'title' => 'User Profile & Role System Updated',
                        'desc' => 'Added profile information fields and improved user role based access control.',
                        'items' => [
                            'Phone and username fields',
                            'Profile bio support',
                            'Role based menu visibility',
                            'Account settings update',
                        ],
                    ],
                    [
                        'version' => 'v1.1',
                        'date' => 'May 10, 2026',
                        'type' => 'Core',
                        'color' => 'purple',
                        'title' => 'Admin & User Dashboard Created',
                        'desc' => 'Initial admin dashboard and user dashboard structure completed with base layout.',
                        'items' => ['Admin dashboard', 'User dashboard', 'Sidebar navigation', 'Dark / light base UI'],
                    ],
                ];
            @endphp

            <div class="relative">
                <div class="absolute left-[18px] top-2 bottom-2 w-px dark:bg-white/[0.08] bg-orange-200"></div>

                <div class="space-y-4">
                    @foreach ($changes as $change)
                        <div class="relative pl-12">

                            <div
                                class="absolute left-0 top-5 w-9 h-9 rounded-xl flex items-center justify-center
                            dark:bg-[#17141f] bg-orange-50 border dark:border-white/[0.08] border-orange-200
                            shadow-[0_0_20px_rgba(249,115,22,.18)]">
                                <span
                                    class="w-3 h-3 rounded-full
                                @if ($change['color'] == 'orange') bg-orange-500
                                @elseif($change['color'] == 'pink') bg-pink-500
                                @elseif($change['color'] == 'emerald') bg-emerald-500
                                @else bg-purple-500 @endif">
                                </span>
                            </div>

                            <div
                                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07]
                            rounded-2xl p-5">

                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-[13px] font-extrabold dark:text-white text-gray-900">
                                            {{ $change['version'] }}
                                        </span>

                                        <span
                                            class="px-2.5 py-[3px] rounded-full text-[11px] font-bold
                                        @if ($change['color'] == 'orange') bg-orange-500/[0.15] text-orange-400 border border-orange-500/[0.25]
                                        @elseif($change['color'] == 'pink') bg-pink-500/[0.15] text-pink-400 border border-pink-500/[0.25]
                                        @elseif($change['color'] == 'emerald') bg-emerald-500/[0.15] text-emerald-400 border border-emerald-500/[0.25]
                                        @else bg-purple-500/[0.15] text-purple-400 border border-purple-500/[0.25] @endif">
                                            {{ $change['type'] }}
                                        </span>
                                    </div>

                                    <span class="text-[11.5px] dark:text-gray-500 text-gray-400">
                                        {{ $change['date'] }}
                                    </span>
                                </div>

                                <h3 class="text-[15px] font-extrabold dark:text-white text-gray-900 mb-2">
                                    {{ $change['title'] }}
                                </h3>

                                <p class="text-[12.5px] leading-[1.7] dark:text-gray-400 text-gray-500 mb-4">
                                    {{ $change['desc'] }}
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach ($change['items'] as $item)
                                        <div
                                            class="flex items-center gap-2 px-3 py-2 rounded-xl
                                        dark:bg-[#1a1625] bg-gray-50 border dark:border-white/[0.05] border-black/[0.05]">
                                            <span class="text-orange-400 text-[12px]">✓</span>
                                            <span class="text-[12px] dark:text-gray-300 text-gray-700">
                                                {{ $item }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
@endsection
