@extends('admin.layouts.master')

@section('admin')
    <!-- ══ HERO SECTION ══ -->
    <section
        class="hero-dark dark:hero-dark rounded-2xl border dark:border-orange-500/[0.15] border-orange-200/60
        flex flex-col lg:flex-row items-center justify-between gap-4 px-7 py-9 relative overflow-hidden min-h-[240px]"
        id="heroSection">

        <!-- Hero Text -->
        <div class="flex-1 relative z-10 max-w-[400px]">
            <h1
                class="text-[32px] sm:text-[36px] font-extrabold leading-[1.15] tracking-[-0.5px] dark:text-white text-gray-900 mb-0.5">
                One system.
            </h1>
            <h1 class="text-[32px] sm:text-[36px] font-extrabold leading-[1.15] tracking-[-0.5px] mb-3">
                <span class="grad-text-dark dark:grad-text-dark" id="heroGradText">Infinite potential.</span>
            </h1>
            <p class="text-[13px] dark:text-gray-400 text-gray-500 leading-[1.7] mb-5">
                Veroa is your all-in-one productivity hub.<br />
                Tasks, habits, notes, focus timers, tools &amp; analytics –<br />
                everything you need to become your best self.
            </p>
            <!-- Buttons -->
            <div class="flex flex-wrap gap-2.5 mb-4">
                <button
                    class="flex items-center gap-1.5 px-5 py-2.5 rounded-[10px] text-white text-[13px] font-bold btn-trans
                        bg-gradient-to-r from-orange-500 to-pink-500
                        shadow-[0_4px_20px_rgba(249,115,22,0.45)]">
                    Start for free &nbsp;→
                </button>
                <button
                    class="flex items-center gap-1.5 px-5 py-2.5 rounded-[10px] text-[13px] font-semibold btn-trans
                                dark:text-white text-gray-800 border dark:border-white/[0.2] border-gray-300
                            dark:hover:border-orange-400/60 hover:border-orange-400  bg-transparent transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <polygon points="5,3 19,12 5,21" />
                    </svg>
                    See how it works
                </button>
            </div>
            <!-- Checks -->
            <div class="flex flex-wrap gap-4 text-[11.5px] dark:text-gray-500 text-gray-400">
                <span class="flex items-center gap-1.5"><span class="dark:text-orange-400 text-orange-500">✓</span> No
                    credit card</span>
                <span class="flex items-center gap-1.5"><span class="dark:text-orange-400 text-orange-500">✓</span> Free
                    forever</span>
                <span class="flex items-center gap-1.5"><span class="dark:text-orange-400 text-orange-500">✓</span> Cancel
                    anytime</span>
            </div>
            <!-- Social proof (light mode only) -->
            <div class="hidden dark:hidden mt-3.5 items-center gap-2.5" id="socialProof">
                <div class="flex -space-x-1.5">
                    <div
                        class="w-[26px] h-[26px] rounded-full border-2 border-white bg-gradient-to-br from-orange-400 to-pink-400 flex items-center justify-center text-white text-[10px] font-bold">
                        A</div>
                    <div
                        class="w-[26px] h-[26px] rounded-full border-2 border-white bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white text-[10px] font-bold">
                        B</div>
                    <div
                        class="w-[26px] h-[26px] rounded-full border-2 border-white bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center text-white text-[10px] font-bold">
                        C</div>
                </div>
                <span class="text-[11.5px] text-gray-500">Join 2,847+ focused people already leveling up their
                    life.</span>
            </div>
        </div>

        <!-- 3D Hero Logo Art -->
        <div
            class="flex-shrink-0 w-[240px] h-[220px] sm:w-[270px] sm:h-[240px] relative flex items-center justify-center animate-floatY">
            <!-- Glow bg -->
            <div class="absolute inset-0 rounded-full pointer-events-none"
                style="background:radial-gradient(circle at 50% 55%, rgba(249,115,22,0.2) 0%, transparent 65%);">
            </div>
            <!-- Platform -->
            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 w-[150px] h-[18px] rounded-full"
                style="background:radial-gradient(ellipse, rgba(249,115,22,0.5) 0%, transparent 70%); filter:blur(8px);">
            </div>
            <!-- SVG -->
            <svg class="relative z-10 hero-svg-dark dark:hero-svg-dark w-[210px] h-[210px]" id="heroSvg"
                viewBox="0 0 220 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="hg1" x1="20" y1="38" x2="200" y2="185"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#f59e0b" />
                        <stop offset="0.4" stop-color="#f97316" />
                        <stop offset="1" stop-color="#ec4899" />
                    </linearGradient>
                    <linearGradient id="hg2" x1="60" y1="148" x2="160" y2="200"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#f97316" />
                        <stop offset="1" stop-color="#f59e0b" />
                    </linearGradient>
                    <filter id="gf1" x="-20%" y="-20%" width="140%" height="140%">
                        <feGaussianBlur stdDeviation="3.5" result="blur" />
                        <feMerge>
                            <feMergeNode in="blur" />
                            <feMergeNode in="SourceGraphic" />
                        </feMerge>
                    </filter>
                </defs>
                <!-- Platform disc -->
                <ellipse cx="110" cy="190" rx="70" ry="10" fill="url(#hg1)" opacity=".22" />
                <ellipse cx="110" cy="186" rx="58" ry="7" fill="rgba(249,115,22,0.28)"
                    opacity=".7" />
                <!-- Main shape -->
                <path
                    d="M110 44 C72 44, 40 72, 40 106 C40 140, 72 160, 110 142 C148 160, 180 140, 180 106 C180 72, 148 44, 110 44Z"
                    fill="none" stroke="url(#hg1)" stroke-width="10" stroke-linecap="round" filter="url(#gf1)" />
                <path d="M110 142 C90 165, 72 180, 110 186 C148 180, 130 165, 110 142" fill="none" stroke="url(#hg2)"
                    stroke-width="8.5" stroke-linecap="round" filter="url(#gf1)" />
                <!-- Center glow -->
                <circle cx="110" cy="110" r="9" fill="white" opacity=".95" />
                <circle cx="110" cy="110" r="18" fill="rgba(249,115,22,0.22)" />
                <!-- Floating diamonds -->
                <polygon points="33,48 39,59 33,70 27,59" fill="#f97316" opacity=".85" />
                <polygon points="178,30 184,41 178,52 172,41" fill="#ec4899" opacity=".78" />
                <polygon points="188,150 194,161 188,172 182,161" fill="#f59e0b" opacity=".82" />
                <polygon points="22,138 28,149 22,160 16,149" fill="#a855f7" opacity=".65" />
                <polygon points="156,20 161,29 156,38 151,29" fill="#f97316" opacity=".6" />
                <!-- Sparkle dots -->
                <circle cx="58" cy="33" r="3" fill="#f59e0b" opacity=".75" />
                <circle cx="170" cy="78" r="2.5" fill="#ec4899" opacity=".65" />
                <circle cx="44" cy="160" r="2" fill="#f97316" opacity=".55" />
            </svg>
        </div>
    </section>

    <!-- ══ FEATURE CARDS ══ -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">

        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-2.5 text-base bg-amber-400/[0.15]">
                ⚡</div>
            <h4 class="text-[13px] font-bold dark:text-white text-gray-900 mb-1">All-in-One</h4>
            <p class="text-[11.5px] dark:text-gray-500 text-gray-400 leading-relaxed">Everything you need in
                one powerful workspace.</p>
        </div>

        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-2.5 text-base bg-pink-500/[0.15]">
                🎯</div>
            <h4 class="text-[13px] font-bold dark:text-white text-gray-900 mb-1">Focus First</h4>
            <p class="text-[11.5px] dark:text-gray-500 text-gray-400 leading-relaxed">Built to eliminate
                distractions and help you go deep.</p>
        </div>

        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-2.5 text-base bg-purple-500/[0.15]">
                📊</div>
            <h4 class="text-[13px] font-bold dark:text-white text-gray-900 mb-1">Data Driven</h4>
            <p class="text-[11.5px] dark:text-gray-500 text-gray-400 leading-relaxed">Analytics that help you
                improve every day.</p>
        </div>

        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-2.5 text-base bg-emerald-500/[0.15]">
                🔒</div>
            <h4 class="text-[13px] font-bold dark:text-white text-gray-900 mb-1">Privacy First</h4>
            <p class="text-[11.5px] dark:text-gray-500 text-gray-400 leading-relaxed">Your data is yours.
                Always.</p>
        </div>
    </div>

    <!-- ══ DASHBOARD HEADER ══ -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
        <div>
            <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">Dashboard
            </h2>
            <p class="text-[14px] font-semibold dark:text-white text-gray-800 mt-0.5">Welcome back, Leon! 👋
            </p>
            <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-0.5">Let's make today extraordinary.</p>
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
            <button
                class="flex items-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[12.5px] font-bold btn-trans
                        bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                + Add Task
            </button>
        </div>
    </div>

    <!-- ══ METRICS GRID ══ -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">

        <!-- Daily Score -->
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
            <p class="text-[12px] font-semibold dark:text-gray-400 text-gray-500 mb-3.5">Daily Score</p>
            <div class="flex flex-col items-center gap-2">
                <div class="relative w-24 h-24">
                    <svg class="w-full h-full" viewBox="0 0 96 96">
                        <circle cx="48" cy="48" r="40" fill="none" stroke-width="8"
                            class="dark:stroke-[#1e1a2e] stroke-gray-100" />
                        <circle cx="48" cy="48" r="40" fill="none" stroke-width="8"
                            stroke-linecap="round" stroke="url(#scoreGrad)" stroke-dasharray="251.3"
                            stroke-dashoffset="44" style="transform:rotate(-90deg);transform-origin:50% 50%;"
                            class="progress-circle" />
                        <defs>
                            <linearGradient id="scoreGrad" x1="0" y1="0" x2="1" y2="0">
                                <stop stop-color="#f97316" />
                                <stop offset="1" stop-color="#ec4899" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span
                            class="text-[26px] font-extrabold tracking-[-1px] dark:text-white text-gray-900 leading-none">87</span>
                        <span class="text-[11px] dark:text-gray-500 text-gray-400">/100</span>
                    </div>
                </div>
                <p class="text-[12px] font-semibold text-orange-400">Amazing work!</p>
            </div>
        </div>

        <!-- Streak -->
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
            <p class="text-[12px] font-semibold dark:text-gray-400 text-gray-500 mb-3.5">Streak</p>
            <div class="flex flex-col items-center gap-1">
                <span class="text-[44px] leading-none">🔥</span>
                <span
                    class="text-[38px] font-extrabold tracking-[-1px] dark:text-white text-gray-900 leading-none mt-1">12</span>
                <span class="text-[12px] dark:text-gray-500 text-gray-400">days</span>
                <p class="text-[12px] font-semibold text-orange-400 mt-0.5">Keep it hot! 🔥</p>
            </div>
        </div>

        <!-- XP Progress -->
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
            <p class="text-[12px] font-semibold dark:text-gray-400 text-gray-500 mb-3">XP Progress</p>
            <p class="text-[16px] font-bold text-orange-400 mb-1">Level 24</p>
            <p class="text-[12px] dark:text-gray-400 text-gray-500 mb-2.5">2,450 / 3,500 XP</p>
            <div class="w-full h-[7px] rounded-full dark:bg-white/[0.08] bg-gray-100 overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500" style="width:70%"></div>
            </div>
            <canvas id="xpSparkline" height="36" class="w-full mt-2.5 block"></canvas>
        </div>

        <!-- Focus Time -->
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
            <p class="text-[12px] font-semibold dark:text-gray-400 text-gray-500 mb-2.5">Focus Time</p>
            <p class="text-[26px] font-extrabold tracking-[-0.5px] dark:text-white text-gray-900 leading-none mb-1">
                3h 24m</p>
            <p class="text-[12px] dark:text-gray-500 text-gray-400 mb-2.5">Today</p>
            <canvas id="focusSparkline" height="36" class="w-full block"></canvas>
        </div>
    </div>

    <!-- ══ BOTTOM ROW: Priorities + Feed ══ -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3.5">

        <!-- Top 3 Priorities -->
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
            <h3 class="text-[14px] font-bold dark:text-white text-gray-900 mb-3.5">Top 3 Priorities</h3>

            <!-- Item 1 -->
            <div class="flex items-center gap-2.5 py-2.5 border-b dark:border-white/[0.06] border-black/[0.05]">
                <!-- Dark: empty circle | Light: numbered orange circle -->
                <div
                    class="w-5 h-5 rounded-full border-2 dark:border-white/20 border-transparent flex-shrink-0 flex items-center justify-center  dark:bg-transparent bg-gradient-to-br from-orange-400 to-amber-500">
                    <span class="dark:hidden text-[10px] text-white font-bold">1</span>
                </div>
                <span class="flex-1 text-[13px] font-medium dark:text-gray-200 text-gray-700">Launch new
                    landing page</span>
                <span
                    class="px-2.5 py-[3px] rounded-[7px] text-[11px] font-semibold  dark:bg-red-500/[0.15] dark:text-red-400 dark:border dark:border-red-500/[0.3] bg-red-50 text-red-600 border border-red-200">High</span>
                <span class="text-[11px] dark:text-gray-600 text-gray-300 cursor-grab ml-1">⋮⋮</span>
            </div>

            <!-- Item 2 -->
            <div class="flex items-center gap-2.5 py-2.5 border-b dark:border-white/[0.06] border-black/[0.05]">
                <div
                    class="w-5 h-5 rounded-full border-2 dark:border-white/20 border-transparent flex-shrink-0 flex items-center justify-center  dark:bg-transparent bg-gradient-to-br from-orange-400 to-amber-500">
                    <span class="dark:hidden text-[10px] text-white font-bold">2</span>
                </div>
                <span class="flex-1 text-[13px] font-medium dark:text-gray-200 text-gray-700">Workout &amp;
                    gym</span>
                <span
                    class="px-2.5 py-[3px] rounded-[7px] text-[11px] font-semibold  dark:bg-orange-500/[0.15] dark:text-orange-400 dark:border dark:border-orange-500/[0.3]  bg-orange-50 text-orange-600 border border-orange-200">Medium</span>
                <span class="text-[11px] dark:text-gray-600 text-gray-300 cursor-grab ml-1">⋮⋮</span>
            </div>

            <!-- Item 3 -->
            <div class="flex items-center gap-2.5 py-2.5">
                <div
                    class="w-5 h-5 rounded-full border-2 dark:border-white/20 border-transparent flex-shrink-0 flex items-center justify-center  dark:bg-transparent bg-gradient-to-br from-orange-400 to-amber-500">
                    <span class="dark:hidden text-[10px] text-white font-bold">3</span>
                </div>
                <span class="flex-1 text-[13px] font-medium dark:text-gray-200 text-gray-700">Read 20
                    pages</span>
                <span
                    class="px-2.5 py-[3px] rounded-[7px] text-[11px] font-semibold  dark:bg-emerald-500/[0.15]  bg-emerald-50 text-emerald-600 border border-emerald-200">Low</span>
                <span class="text-[11px] dark:text-gray-600 text-gray-300 cursor-grab ml-1">⋮⋮</span>
            </div>
        </div>

        <!-- Activity Feed -->
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
            <h3 class="text-[14px] font-bold dark:text-white text-gray-900 mb-3.5">Activity Feed</h3>

            <div class="flex items-start gap-2.5 py-2 border-b dark:border-white/[0.06] border-black/[0.05]">
                <div
                    class="w-8 h-8 rounded-[9px] flex items-center justify-center flex-shrink-0 text-[14px] font-bold
                        bg-emerald-500/[0.18] text-emerald-400">
                    ✓</div>
                <div class="flex-1 min-w-0">
                    <p class="text-[12.5px] font-semibold dark:text-gray-200 text-gray-800">You completed a
                        task</p>
                    <p class="text-[11.5px] dark:text-gray-500 text-gray-400">Build new habit system</p>
                </div>
                <span class="text-[11px] dark:text-gray-600 text-gray-400 flex-shrink-0 mt-0.5">2m ago</span>
            </div>

            <div class="flex items-start gap-2.5 py-2 border-b dark:border-white/[0.06] border-black/[0.05]">
                <div
                    class="w-8 h-8 rounded-[9px] flex items-center justify-center flex-shrink-0 text-[16px] bg-orange-500/[0.18]">
                    🔥</div>
                <div class="flex-1 min-w-0">
                    <p class="text-[12.5px] font-semibold dark:text-gray-200 text-gray-800">You reached a 12
                        day streak! 🔥</p>
                </div>
                <span class="text-[11px] dark:text-gray-600 text-gray-400 flex-shrink-0 mt-0.5">1h ago</span>
            </div>

            <div class="flex items-start gap-2.5 py-2 border-b dark:border-white/[0.06] border-black/[0.05]">
                <div
                    class="w-8 h-8 rounded-[9px] flex items-center justify-center flex-shrink-0 text-[15px]
                    bg-pink-500/[0.18]">
                    🎯</div>
                <div class="flex-1 min-w-0">
                    <p class="text-[12.5px] font-semibold dark:text-gray-200 text-gray-800">Focus session
                        completed</p>
                    <p class="text-[11.5px] dark:text-gray-500 text-gray-400">Deep Work Session</p>
                </div>
                <span class="text-[11px] dark:text-gray-600 text-gray-400 flex-shrink-0 mt-0.5">2h ago</span>
            </div>

            <div class="flex items-start gap-2.5 py-2">
                <div
                    class="w-8 h-8 rounded-[9px] flex items-center justify-center flex-shrink-0 text-[15px]
                    bg-purple-500/[0.18]">
                    📝</div>
                <div class="flex-1 min-w-0">
                    <p class="text-[12.5px] font-semibold dark:text-gray-200 text-gray-800">New note created
                    </p>
                    <p class="text-[11.5px] dark:text-gray-500 text-gray-400">Project Ideas</p>
                </div>
                <span class="text-[11px] dark:text-gray-600 text-gray-400 flex-shrink-0 mt-0.5">3h ago</span>
            </div>
        </div>
    </div>

    <!-- ══ ANALYTICS ROW ══ -->
    <div class="grid grid-cols-1 xl:grid-cols-[1fr_300px] gap-3.5">

        <!-- Productivity Chart -->
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[14px] font-bold dark:text-white text-gray-900">Productivity Overview</h3>
                <div class="flex items-center gap-3.5">
                    <div class="flex items-center gap-1.5 text-[11.5px] dark:text-gray-400 text-gray-500">
                        <div class="w-2.5 h-1 rounded-full bg-orange-400"></div>This week
                    </div>
                    <div class="flex items-center gap-1.5 text-[11.5px] dark:text-gray-400 text-gray-500">
                        <div class="w-2.5 h-1 rounded-full bg-amber-400/60"></div>Last week
                    </div>
                </div>
            </div>
            <div class="relative h-[130px]">
                <canvas id="productivityChart"></canvas>
            </div>
        </div>

        <!-- Focus Score -->
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px] flex flex-col items-center">
            <h3 class="text-[14px] font-bold dark:text-white text-gray-900 self-start mb-3.5">Focus Score</h3>
            <!-- Ring -->
            <div class="relative w-[120px] h-[120px] mb-4">
                <svg class="w-full h-full" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="50" fill="none" stroke-width="10"
                        class="dark:stroke-[#1e1a2e] stroke-gray-100" />
                    <circle cx="60" cy="60" r="50" fill="none" stroke-width="10"
                        stroke-linecap="round" stroke="url(#focusGrad)" stroke-dasharray="314.16"
                        stroke-dashoffset="37.7" style="transform:rotate(-90deg);transform-origin:50% 50%;"
                        class="progress-circle" />
                    <defs>
                        <linearGradient id="focusGrad" x1="0" y1="0" x2="1" y2="0">
                            <stop stop-color="#f97316" />
                            <stop offset="1" stop-color="#f59e0b" />
                        </linearGradient>
                    </defs>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span
                        class="text-[28px] font-extrabold tracking-[-0.5px] dark:text-white text-gray-900 leading-none">94<sup
                            class="text-[15px] align-super">%</sup></span>
                    <span class="text-[11.5px] dark:text-gray-400 text-gray-500 mt-0.5">Excellent</span>
                </div>
            </div>
            <!-- Goal bar -->
            <div class="w-full">
                <div class="flex justify-between text-[12px] mb-1.5">
                    <span class="dark:text-gray-400 text-gray-500">Weekly Goal</span>
                    <span class="font-bold dark:text-white text-gray-800">80%</span>
                </div>
                <div class="w-full h-[7px] rounded-full dark:bg-white/[0.08] bg-gray-100 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-amber-400" style="width:80%">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
