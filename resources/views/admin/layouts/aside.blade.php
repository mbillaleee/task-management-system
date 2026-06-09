<aside id="sidebar"
    class="fixed top-0 left-0 h-full w-64 z-50 flex flex-col
    dark:bg-[#100e1a] bg-[#fdf6ee]
    dark:border-r dark:border-white/[0.06] border-r border-black/[0.06]
    shadow-2xl">

    <!-- Logo -->
    <div
        class="flex items-center gap-3 px-5 py-5 dark:border-b dark:border-white/[0.06] border-b border-black/[0.06] flex-shrink-0">
        <svg width="32" height="32" viewBox="0 0 40 40" fill="none">
            <defs>
                <linearGradient id="sLg1" x1="7" y1="3" x2="33" y2="28"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="#f97316" />
                    <stop offset="1" stop-color="#ec4899" />
                </linearGradient>
                <linearGradient id="sLg2" x1="13" y1="22" x2="27" y2="37"
                    gradientUnits="userSpaceOnUse">
                    <stop stop-color="#f59e0b" />
                    <stop offset="1" stop-color="#f97316" />
                </linearGradient>
            </defs>
            <path d="M20 3L7 19.5L20 28.5L33 19.5Z" fill="url(#sLg1)" opacity=".95" />
            <path d="M13 22L20 37L27 22" fill="url(#sLg2)" opacity=".9" />
        </svg>

        <span class="text-[20px] font-extrabold tracking-[-0.4px] dark:text-white text-gray-900">
            {{ translate('veroa') }}
        </span>
    </div>

    <!-- Nav items -->
    <nav class="flex-1 px-3 py-4 flex flex-col gap-1.5 overflow-y-auto">



        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[15px] font-semibold cursor-pointer no-underline transition-all duration-200
            {{ request()->routeIs('admin.dashboard')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-600 dark:text-gray-400 dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            <span>{{ translate('Dashboard') }}</span>
        </a>

        {{-- Users --}}
        <a id="nav-users" href="{{ route('admin.users.index') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-semibold cursor-pointer no-underline transition-all duration-200
            {{ request()->routeIs('admin.users.*')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-600 dark:text-gray-400 dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M23 21v-2a4 4 0 00-3-3.87" />
                <path d="M16 3.13a4 4 0 010 7.75" />
            </svg>
            <span>{{ translate('Users') }}</span>
        </a>


        <a href="{{ route('admin.subscriptions.index') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-semibold cursor-pointer no-underline transition-all duration-200
            {{ request()->routeIs('admin.subscriptions.*')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-600 dark:text-gray-400 dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                <line x1="1" y1="10" x2="23" y2="10" />
            </svg>
            <span>{{ translate('Subscriptions') }}</span>
        </a>


        <a id="nav-tasks" href="{{ route('admin.gamification.index') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-semibold cursor-pointer no-underline
            {{ request()->routeIs('admin.gamification.index')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-600 dark:text-gray-400 dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            <span>{{ translate('Gamification') }}</span>
        </a>

        <a id="nav-tasks" href="{{ route('admin.languages') }}"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-semibold cursor-pointer no-underline
            {{ request()->routeIs('admin.languages')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-600 dark:text-gray-400 dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            <span>{{ translate('Languages') }}</span>
        </a>



        {{-- Settings --}}
        <a id="nav-settings" href="#"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-semibold cursor-pointer no-underline
            dark:text-gray-400 text-gray-600 dark:hover:bg-white/[0.06] hover:bg-black/[0.05]
            dark:hover:text-white hover:text-gray-900 transition-all duration-200">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="3" />
                <path
                    d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" />
            </svg>
            <span>{{ translate('Settings') }}</span>
        </a>

        {{-- Logout --}}
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-semibold cursor-pointer no-underline
            dark:text-gray-400 text-gray-600 dark:hover:bg-white/[0.06] hover:bg-black/[0.05]
            dark:hover:text-white hover:text-gray-900 transition-all duration-200">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M17 16l4-4m0 0l-4-4m4 4H7" />
            </svg>
            <span>{{ translate('Logout') }}</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </nav>


    <!-- User Profile -->
    <div class="mx-3 mb-3 rounded-2xl flex-shrink-0 transition-all duration-300
    dark:bg-[#1a1625] bg-white
    dark:border dark:border-white/[0.06] border border-black/[0.06]"
        style="">

        <div class="flex items-center gap-3 px-4 py-3.5">

            {{-- Avatar with glow ring --}}
            <div class="relative flex-shrink-0">
                <div class="w-11 h-11 rounded-full p-[2px]"
                    style="background: linear-gradient(135deg, #f97316, #ec4899);
                       box-shadow: 0 0 10px rgba(249,115,22,0.45), 0 0 20px rgba(249,115,22,0.18);">
                    <div
                        class="w-full h-full rounded-full overflow-hidden dark:bg-gray-800 bg-gray-200 flex items-center justify-center">
                        @if (auth()->user()->profile_photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                alt="{{ auth()->user()->name }}" class="w-full h-full object-cover rounded-full">
                        @else
                            <span class="dark:text-white text-gray-700 text-[15px] font-bold">
                                {{ strtoupper(substr(auth()->user()->name ?? 'L', 0, 1)) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Name & Plan --}}
            <div class="flex-1 min-w-0">
                <div class="text-[14px] font-bold dark:text-white text-gray-900 leading-none mb-1 truncate">
                    {{ auth()->user()->name ?? 'Leon' }}
                </div>
                <div class="text-[11px] dark:text-gray-500 text-gray-400 font-medium">
                    {{ translate('Pro Plan') }}
                </div>
            </div>

            {{-- Chevron --}}
            <a href="{{ route('profile.edit') }}"
                class="flex-shrink-0 p-1.5 rounded-lg dark:hover:bg-white/[0.06] hover:bg-black/[0.05] transition-colors duration-200">
                <svg class="w-4 h-4 dark:text-gray-500 text-gray-400" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </a>
        </div>
    </div>
</aside>
