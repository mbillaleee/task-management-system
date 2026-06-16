<aside id="sidebar" class="fixed top-3 left-3 bottom-3 w-[220px] z-50 flex flex-col">

    {{-- Logo Area --}}
    <div class="flex items-center gap-3 px-2 pb-3 flex-shrink-0">
        <img src="{{ asset('images/logo-dark.png') }}" alt="Veroa Logo"
            class="w-full h-20 object-contain  hidden dark:block">
        <img src="{{ asset('images/logo-light.png') }}" alt="Veroa Logo" class="w-full h-20 object-contain dark:hidden">
    </div>

    {{-- Main Rounded Container --}}
    <div
        class="flex-1 flex flex-col overflow-hidden
            rounded-[28px] border
            shadow-[0_20px_60px_rgba(0,0,0,0.25)] 
            dark:bg-[#07050f]/95
            bg-[rgba(255,239,213,0.55)]
            dark:border-pink-500/20 border-orange-200/60 mt-">

        <nav class="flex-1 px-3 py-4 flex flex-col gap-1.5 overflow-y-auto">

            <a href="{{ route('user.dashboard') }}"
                class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[15px] font-semibold cursor-pointer no-underline transition-all duration-200
            {{ request()->routeIs('user.dashboard')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-800 dark:text-white dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                <span>{{ translate('Dashboard') }}</span>
            </a>

            <a href="{{ route('user.tasks.index') }}"
                class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[15px] font-semibold cursor-pointer no-underline transition-all duration-200
            {{ request()->routeIs('user.tasks.index')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-800 dark:text-white dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <span>{{ translate('Tasks') }}</span>
            </a>



            <a href="{{ route('user.habits.index') }}"
                class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[15px] font-semibold cursor-pointer no-underline transition-all duration-200
            {{ request()->routeIs('user.habits.index')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-800 dark:text-white dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span>{{ translate('Habits') }}</span>
            </a>



            <a href="{{ route('user.notes.index') }}"
                class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[15px] font-semibold cursor-pointer no-underline transition-all duration-200
            {{ request()->routeIs('user.notes.index')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-800 dark:text-white dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">

                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <path d="M14 2v6h6" />
                    <path d="M16 13H8" />
                    <path d="M16 17H8" />
                    <path d="M10 9H8" />
                </svg>

                <span>{{ translate('Notes') }}</span>
            </a>



            <a href="{{ route('user.focus.index') }}"
                class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[15px] font-semibold cursor-pointer no-underline transition-all duration-200
            {{ request()->routeIs('user.focus.index')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-800 dark:text-white dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">

                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="8"></circle>
                    <circle cx="12" cy="12" r="4"></circle>
                    <circle cx="12" cy="12" r="1"></circle>
                </svg>

                <span>{{ translate('Focus') }}</span>
            </a>



            <a href="{{ route('user.goals.index') }}"
                class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[15px] font-semibold cursor-pointer no-underline transition-all duration-200
            {{ request()->routeIs('user.goals.index')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-800 dark:text-white dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">

                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M12 13V2l8 4-8 4"></path>
                    <path d="M20.55 10.23A9 9 0 1 1 8.53 3.59"></path>
                    <path d="M12 13l4.5-2.25"></path>
                </svg>

                <span>{{ translate('Goals') }}</span>
            </a>

            <a href="{{ route('user.journals.index') }}"
                class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[15px] font-semibold cursor-pointer no-underline transition-all duration-200
            {{ request()->routeIs('user.journals.index')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-800 dark:text-white dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">

                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    <path d="M8 7h8"></path>
                    <path d="M8 11h6"></path>
                </svg>

                <span>{{ translate('Journals') }}</span>
            </a>

            <a href="{{ route('user.gamification.index') }}"
                class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[15px] font-semibold cursor-pointer no-underline transition-all duration-200
            {{ request()->routeIs('user.gamification.index')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-800 dark:text-white dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">

                <!-- Trophy Icon -->
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M6 9H4a2 2 0 0 1-2-2V4h4"></path>
                    <path d="M18 9h2a2 2 0 0 0 2-2V4h-4"></path>
                    <path d="M4 22h16"></path>
                    <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                    <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path>
                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2z"></path>
                </svg>

                <span>{{ translate('Gamification') }}</span>
            </a>

            <a href="{{ route('user.calendar.index') }}"
                class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[15px] font-semibold cursor-pointer no-underline transition-all duration-200
            {{ request()->routeIs('user.calendar.index')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-800 dark:text-white dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">

                <!-- Calendar Icon -->
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>

                <span>{{ translate('Calendar') }}</span>
            </a>

            <a id="nav-subscription" href="{{ route('user.subscription.index') }}"
                class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[14px] font-semibold cursor-pointer no-underline transition-all duration-200
        {{ request()->routeIs('user.subscription.*')
            ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
            : 'text-gray-800 dark:text-white dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span>Subscription</span>
            </a>

            <a href="{{ route('user.analytics.index') }}"
                class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[15px] font-semibold cursor-pointer no-underline transition-all duration-200
            {{ request()->routeIs('user.analytics*')
                ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
                : 'text-gray-800 dark:text-white dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
                <span>{{ translate('Analytics') }}</span>
            </a>


            <a href="{{ route('user.settings') }}"
                class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[15px] font-semibold cursor-pointer no-underline transition-all duration-200
    {{ request()->routeIs('user.settings*')
        ? 'text-orange-600 dark:text-orange-400 nav-active-dark'
        : 'text-gray-800 dark:text-white dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="3" />
                    <path
                        d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" />
                </svg>
                <span>{{ translate('Settings') }}</span>
            </a>

            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl text-[15px] font-semibold cursor-pointer no-underline
            dark:text-white text-gray-800 dark:hover:bg-white/[0.06] hover:bg-black/[0.05]
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

        {{-- Upgrade Card --}}
        <div
            class="relative z-10 mx-3 mb-3 p-4 rounded-2xl border
            dark:bg-[#16091a]/90 bg-white/70
            dark:border-pink-500/20 border-orange-200/70 shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-4 h-4  text-orange-800" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5z" />
                    <path d="M2 17l10 5 10-5" />
                    <path d="M2 12l10 5 10-5" />
                </svg>
                <span
                    class="text-[13px] font-bold dark:text-white text-gray-900">{{ translate('Upgrade to Pro') }}</span>
            </div>
            <p class="text-[11.5px] dark:text-white text-gray-800 leading-relaxed mb-3">
                {{ translate('Unlock unlimited power and exclusive features.') }}
            </p>
            <a href="{{ route('user.subscription.index') }}"
                class="block w-full text-center py-2 rounded-xl
    text-white text-[12px] font-bold btn-trans
    bg-gradient-to-br from-orange-500 to-pink-500
    shadow-[0_4px_14px_rgba(249,115,22,0.4)]">
                {{ translate('Upgrade Now') }} →
            </a>
        </div>

        {{-- Profile Card --}}
        <div
            class="relative z-10 mx-3 mb-3 rounded-2xl border
            dark:bg-[#120d1d]/90 bg-white/75
            dark:border-pink-500/20 border-orange-200/70 veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)]">

            <div class="flex items-center gap-3 px-4 py-3.5">

                {{-- Avatar with glow ring --}}
                <div class="relative flex-shrink-0">
                    <div class="w-11 h-11 rounded-full p-[2px]"
                        style="background: linear-gradient(135deg, #f97316, #ec4899);
                       box-shadow: 0 0 10px rgba(249,115,22,0.45), 0 0 20px rgba(249,115,22,0.18);">
                        <div
                            class="w-full h-full rounded-full overflow-hidden dark:bg-gray-800 bg-gray-200 flex items-center justify-center">
                            @if (auth()->user()->profile)
                                <img src="{{ asset('storage/profile/' . auth()->user()->profile) }}"
                                    alt="{{ auth()->user()->name }}" alt="{{ auth()->user()->name }}"
                                    class="w-full h-full object-cover rounded-full">
                            @else
                                <span class="dark:text-white text-gray-800 text-[15px] font-bold">
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
                    <div class="text-[11px] dark:text-white text-gray-800 font-medium">
                        @php
                            $currentSubscription = \App\Models\UserSubscription::with('plan')
                                ->where('user_id', auth()->id())
                                ->whereIn('status', ['active', 'trial'])
                                ->latest()
                                ->first();
                        @endphp
                        {{ $currentSubscription ? translate($currentSubscription->plan->name) . ' Plan' : translate('Free Plan') }}
                    </div>
                </div>

                {{-- Chevron --}}
                <a href="{{ route('profile.edit') }}"
                    class="flex-shrink-0 p-1.5 rounded-lg dark:hover:bg-white/[0.06] hover:bg-black/[0.05] transition-colors duration-200">
                    <svg class="w-4 h-4 dark:text-white text-gray-800" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </a>
            </div>
        </div>

    </div>
</aside>
