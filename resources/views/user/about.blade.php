@extends('user.layouts.master')

@section('user')
    <div class="space-y-6">

        <!-- ABOUT HERO -->
        <section
            class="relative overflow-hidden rounded-2xl border dark:border-orange-500/[0.18] border-orange-200/70
        dark:bg-[#100b18] bg-orange-50/70 px-7 py-10">

            <div class="absolute inset-0 opacity-50 pointer-events-none"
                style="background:
            radial-gradient(circle at 20% 30%, rgba(249,115,22,.20), transparent 32%),
            radial-gradient(circle at 80% 55%, rgba(236,72,153,.22), transparent 36%);">
            </div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold
                    bg-orange-500/[0.14] text-orange-400 border border-orange-500/[0.25] mb-4">
                        <i class="fa-solid fa-info-circle"></i> About Veroa
                    </span>

                    <h1 class="text-[34px] sm:text-[42px] font-extrabold leading-[1.1] dark:text-white text-gray-900">
                        Built for focus.
                    </h1>

                    <h1 class="text-[34px] sm:text-[42px] font-extrabold leading-[1.1] mb-4">
                        <span
                            class="bg-gradient-to-r from-pink-500 via-orange-500 to-amber-400 bg-clip-text text-transparent">
                            Designed for growth.
                        </span>
                    </h1>

                    <p class="text-[13px] leading-[1.8] dark:text-gray-400 text-gray-600 max-w-[560px]">
                        Veroa is an all-in-one productivity platform that helps users manage tasks,
                        build habits, stay focused, track progress, and grow through a beautifully
                        gamified personal dashboard.
                    </p>
                </div>

                <div class="flex justify-center">
                    <div
                        class="w-[180px] h-[180px] rounded-[36px] flex items-center justify-center
                    dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-orange-200
                    shadow-[0_0_45px_rgba(249,115,22,.25)]">
                        <span class="text-[82px] drop-shadow-[0_0_20px_rgba(249,115,22,.9)]">✨</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- MISSION / VISION -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3.5">
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-6">
                <div class="text-[36px] mb-3"><i class="fa-solid fa-bullseye"></i></div>
                <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900 mb-2">Our Mission</h3>
                <p class="text-[12.5px] leading-[1.8] dark:text-gray-400 text-gray-500">
                    To help people organize their day, improve consistency, and turn productivity
                    into a simple, enjoyable daily system.
                </p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-6">
                <div class="text-[36px] mb-3"><i class="fa-solid fa-rocket"></i></div>
                <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900 mb-2">Our Vision</h3>
                <p class="text-[12.5px] leading-[1.8] dark:text-gray-400 text-gray-500">
                    To become a complete life operating system where tasks, habits, notes,
                    focus, analytics, and personal growth work together.
                </p>
            </div>
        </div>

        <!-- VALUES -->
        <div
            class="dark:bg-[#100b18] bg-white border dark:border-orange-500/[0.14] border-orange-200/70
        rounded-2xl p-5">

            <div class="mb-5">
                <h2 class="text-[18px] font-extrabold dark:text-white text-gray-900">Core Values</h2>
                <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-1">
                    The principles behind Veroa’s product experience.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                @php
                    $values = [
                        [
                            'icon' => '⚡',
                            'title' => 'Simplicity',
                            'desc' => 'Clean workflow without unnecessary complexity.',
                        ],
                        [
                            'icon' => '🔥',
                            'title' => 'Consistency',
                            'desc' => 'Small daily progress that compounds over time.',
                        ],
                        [
                            'icon' => '📊',
                            'title' => 'Clarity',
                            'desc' => 'Actionable insights from your productivity data.',
                        ],
                        [
                            'icon' => '🔒',
                            'title' => 'Privacy',
                            'desc' => 'Your personal data stays secure and controlled.',
                        ],
                    ];
                @endphp

                @foreach ($values as $value)
                    <div
                        class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07]
                    rounded-2xl p-5">
                        <div class="text-[34px] mb-3 drop-shadow-[0_0_14px_rgba(249,115,22,.75)]">
                            {{ $value['icon'] }}
                        </div>
                        <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-2">
                            {{ $value['title'] }}
                        </h4>
                        <p class="text-[12px] leading-[1.7] dark:text-gray-400 text-gray-500">
                            {{ $value['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- STATS -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[12px] dark:text-gray-400 text-gray-500"><i class="fa-solid fa-cubes"></i> Modules</p>
                <h3 class="text-[30px] font-extrabold text-orange-400 mt-2">12+</h3>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[12px] dark:text-gray-400 text-gray-500"><i class="fa-solid fa-tools"></i> Productivity Tools
                </p>
                <h3 class="text-[30px] font-extrabold text-pink-500 mt-2">30+</h3>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[12px] dark:text-gray-400 text-gray-500"><i class="fa-solid fa-th-large"></i> Dashboard
                    Widgets</p>
                <h3 class="text-[30px] font-extrabold text-emerald-500 mt-2">20+</h3>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <p class="text-[12px] dark:text-gray-400 text-gray-500"><i class="fa-solid fa-bolt"></i> Focus System</p>
                <h3 class="text-[30px] font-extrabold text-orange-500 mt-2">Pro</h3>
            </div>
        </div>

        <!-- STORY -->
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07]
        rounded-2xl p-6">

            <h2 class="text-[18px] font-extrabold dark:text-white text-gray-900 mb-3">
                Why Veroa exists
            </h2>

            <p class="text-[13px] leading-[1.9] dark:text-gray-400 text-gray-500">
                Most productivity tools focus on only one area: tasks, notes, habits, or analytics.
                Veroa brings these systems together into one connected workspace. The goal is to help
                users plan their day, execute with focus, track meaningful progress, and stay motivated
                through streaks, levels, and achievements.
            </p>
        </div>

    </div>
@endsection
