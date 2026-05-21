@extends('user.layouts.master')

@section('user')
    <div class="space-y-6">

        <!-- Dashboard Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    Dashboard
                </h2>
                <p class="text-[14px] font-semibold dark:text-white text-gray-800 mt-0.5">
                    Welcome back, {{ auth()->user()->name ?? 'Masum' }}! 👋
                </p>
                <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Track your tasks, habits, focus time and progress.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                <select
                    class="px-3 py-1.5 rounded-[9px] text-[12.5px] font-medium outline-none cursor-pointer
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-600
                dark:border dark:border-white/[0.1] border border-black/[0.12]">
                    <option>Today</option>
                    <option>This week</option>
                    <option>This month</option>
                </select>

                <a href="#"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[12.5px] font-bold
                bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    + Add Task
                </a>
            </div>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[12px] font-semibold dark:text-gray-400 text-gray-500 mb-2">Total Tasks</p>
                <h3 class="text-[30px] font-extrabold dark:text-white text-gray-900">48</h3>
                <p class="text-[11.5px] text-orange-400 mt-1">All created tasks</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[12px] font-semibold dark:text-gray-400 text-gray-500 mb-2">Completed Tasks</p>
                <h3 class="text-[30px] font-extrabold text-emerald-500">31</h3>
                <p class="text-[11.5px] text-emerald-500 mt-1">Great progress</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[12px] font-semibold dark:text-gray-400 text-gray-500 mb-2">Pending Tasks</p>
                <h3 class="text-[30px] font-extrabold text-yellow-500">17</h3>
                <p class="text-[11.5px] text-yellow-500 mt-1">Need attention</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[12px] font-semibold dark:text-gray-400 text-gray-500 mb-2">Active Habits</p>
                <h3 class="text-[30px] font-extrabold text-pink-500">8</h3>
                <p class="text-[11.5px] text-pink-500 mt-1">Daily routines</p>
            </div>

        </div>

        <!-- Progress Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">

            <!-- Focus Time -->
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[12px] font-semibold dark:text-gray-400 text-gray-500 mb-2.5">Today Focus Time</p>
                <p class="text-[26px] font-extrabold dark:text-white text-gray-900 leading-none">3h 24m</p>
                <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-2">Deep work today</p>
            </div>

            <!-- XP -->
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[12px] font-semibold dark:text-gray-400 text-gray-500 mb-3">XP Points</p>
                <p class="text-[16px] font-bold text-orange-400 mb-1">2,450 XP</p>
                <p class="text-[12px] dark:text-gray-400 text-gray-500 mb-2.5">2,450 / 3,500 XP</p>
                <div class="w-full h-[7px] rounded-full dark:bg-white/[0.08] bg-gray-100 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500" style="width:70%"></div>
                </div>
            </div>

            <!-- Level -->
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[12px] font-semibold dark:text-gray-400 text-gray-500 mb-2">Current Level</p>
                <h3 class="text-[30px] font-extrabold dark:text-white text-gray-900">24</h3>
                <p class="text-[11.5px] text-orange-400 mt-1">Productivity Master</p>
            </div>

            <!-- Streak -->
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[12px] font-semibold dark:text-gray-400 text-gray-500 mb-2">Streak Count</p>
                <div class="flex items-center gap-3">
                    <span class="text-[36px]">🔥</span>
                    <div>
                        <h3 class="text-[30px] font-extrabold dark:text-white text-gray-900 leading-none">12</h3>
                        <p class="text-[11.5px] text-orange-400 mt-1">Days streak</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Today's Plan + Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3.5">

            <!-- Today's Plan -->
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[14px] font-bold dark:text-white text-gray-900 mb-3.5">Today's Plan</h3>

                <div class="flex items-center gap-2.5 py-2.5 border-b dark:border-white/[0.06] border-black/[0.05]">
                    <div
                        class="w-5 h-5 rounded-full border-2 dark:border-white/20 border-transparent flex-shrink-0 flex items-center justify-center dark:bg-transparent bg-gradient-to-br from-orange-400 to-amber-500">
                        <span class="dark:hidden text-[10px] text-white font-bold">1</span>
                    </div>
                    <span class="flex-1 text-[13px] font-medium dark:text-gray-200 text-gray-700">Complete task module
                        UI</span>
                    <span
                        class="px-2.5 py-[3px] rounded-[7px] text-[11px] font-semibold bg-red-50 text-red-600 border border-red-200 dark:bg-red-500/[0.15] dark:text-red-400 dark:border-red-500/[0.3]">High</span>
                </div>

                <div class="flex items-center gap-2.5 py-2.5 border-b dark:border-white/[0.06] border-black/[0.05]">
                    <div
                        class="w-5 h-5 rounded-full border-2 dark:border-white/20 border-transparent flex-shrink-0 flex items-center justify-center dark:bg-transparent bg-gradient-to-br from-orange-400 to-amber-500">
                        <span class="dark:hidden text-[10px] text-white font-bold">2</span>
                    </div>
                    <span class="flex-1 text-[13px] font-medium dark:text-gray-200 text-gray-700">Review habit tracker
                        structure</span>
                    <span
                        class="px-2.5 py-[3px] rounded-[7px] text-[11px] font-semibold bg-orange-50 text-orange-600 border border-orange-200 dark:bg-orange-500/[0.15] dark:text-orange-400 dark:border-orange-500/[0.3]">Medium</span>
                </div>

                <div class="flex items-center gap-2.5 py-2.5">
                    <div
                        class="w-5 h-5 rounded-full border-2 dark:border-white/20 border-transparent flex-shrink-0 flex items-center justify-center dark:bg-transparent bg-gradient-to-br from-orange-400 to-amber-500">
                        <span class="dark:hidden text-[10px] text-white font-bold">3</span>
                    </div>
                    <span class="flex-1 text-[13px] font-medium dark:text-gray-200 text-gray-700">Plan focus timer
                        feature</span>
                    <span
                        class="px-2.5 py-[3px] rounded-[7px] text-[11px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200 dark:bg-emerald-500/[0.15] dark:text-emerald-400 dark:border-emerald-500/[0.3]">Low</span>
                </div>
            </div>

            <!-- Recent Activity -->
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[14px] font-bold dark:text-white text-gray-900 mb-3.5">Recent Activity</h3>

                <div class="flex items-start gap-2.5 py-2 border-b dark:border-white/[0.06] border-black/[0.05]">
                    <div
                        class="w-8 h-8 rounded-[9px] flex items-center justify-center flex-shrink-0 text-[14px] font-bold bg-emerald-500/[0.18] text-emerald-400">
                        ✓</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[12.5px] font-semibold dark:text-gray-200 text-gray-800">You completed a task</p>
                        <p class="text-[11.5px] dark:text-gray-500 text-gray-400">Dashboard static design implemented</p>
                    </div>
                    <span class="text-[11px] dark:text-gray-600 text-gray-400 flex-shrink-0 mt-0.5">2m ago</span>
                </div>

                <div class="flex items-start gap-2.5 py-2 border-b dark:border-white/[0.06] border-black/[0.05]">
                    <div
                        class="w-8 h-8 rounded-[9px] flex items-center justify-center flex-shrink-0 text-[16px] bg-orange-500/[0.18]">
                        🔥</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[12.5px] font-semibold dark:text-gray-200 text-gray-800">You reached 12 days streak
                        </p>
                        <p class="text-[11.5px] dark:text-gray-500 text-gray-400">Daily productivity streak</p>
                    </div>
                    <span class="text-[11px] dark:text-gray-600 text-gray-400 flex-shrink-0 mt-0.5">1h ago</span>
                </div>

                <div class="flex items-start gap-2.5 py-2 border-b dark:border-white/[0.06] border-black/[0.05]">
                    <div
                        class="w-8 h-8 rounded-[9px] flex items-center justify-center flex-shrink-0 text-[15px] bg-pink-500/[0.18]">
                        🎯</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[12.5px] font-semibold dark:text-gray-200 text-gray-800">Focus session completed</p>
                        <p class="text-[11.5px] dark:text-gray-500 text-gray-400">3 hours 24 minutes today</p>
                    </div>
                    <span class="text-[11px] dark:text-gray-600 text-gray-400 flex-shrink-0 mt-0.5">2h ago</span>
                </div>

                <div class="flex items-start gap-2.5 py-2">
                    <div
                        class="w-8 h-8 rounded-[9px] flex items-center justify-center flex-shrink-0 text-[15px] bg-purple-500/[0.18]">
                        ⭐</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[12.5px] font-semibold dark:text-gray-200 text-gray-800">XP points increased</p>
                        <p class="text-[11.5px] dark:text-gray-500 text-gray-400">You earned 120 XP today</p>
                    </div>
                    <span class="text-[11px] dark:text-gray-600 text-gray-400 flex-shrink-0 mt-0.5">3h ago</span>
                </div>
            </div>

        </div>

    </div>
@endsection
