<header id="appHeader"
    class="sticky top-0 z-30 flex items-center justify-between px-5 py-5 pt-8
    bg-transparent transition-all duration-300">

    <!-- Left: hamburger + mobile logo -->
    <div class="flex items-center gap-2">
        <button onclick="toggleSidebar()"
            class="lg:hidden w-8 h-8 flex items-center justify-center rounded-lg
               dark:text-white text-gray-800 dark:hover:text-white hover:text-orange-600 [0.05]
               transition-colors border-none bg-transparent cursor-pointer">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                viewBox="0 0 24 24">
                <line x1="3" y1="6" x2="21" y2="6" />
                <line x1="3" y1="12" x2="21" y2="12" />
                <line x1="3" y1="18" x2="21" y2="18" />
            </svg>
        </button>
        <!-- Mobile logo -->
        <div class="flex lg:hidden items-center gap-1.5">
            <svg width="20" height="20" viewBox="0 0 40 40" fill="none">
                <path d="M20 3L7 19.5L20 28.5L33 19.5Z" fill="url(#mLg1)" opacity=".95" />
                <path d="M13 22L20 37L27 22" fill="url(#mLg2)" opacity=".9" />
                <defs>
                    <linearGradient id="mLg1" x1="7" y1="3" x2="33" y2="28">
                        <stop stop-color="#f97316" />
                        <stop offset="1" stop-color="#ec4899" />
                    </linearGradient>
                    <linearGradient id="mLg2" x1="13" y1="22" x2="27" y2="37">
                        <stop stop-color="#f59e0b" />
                        <stop offset="1" stop-color="#f97316" />
                    </linearGradient>
                </defs>
            </svg>
            <span class="text-[16px] font-bold dark:text-white text-gray-900">veroa</span>
        </div>
    </div>

    <!-- Center: Nav links -->
    <nav class="hidden md:flex flex-1 justify-start items-center gap-8 ml-3">
        <a href="{{ route('user.features') }}"
            class="text-[15px] font-medium dark:text-white text-gray-800 dark:hover:text-white hover:text-orange-600 transition-colors no-underline">{{ translate('Features') }}</a>
        <a href="{{ route('user.tools') }}"
            class="text-[15px] font-medium dark:text-white text-gray-800 dark:hover:text-white hover:text-orange-600 transition-colors no-underline">{{ translate('Tools') }}</a>
        <a href="{{ route('user.pricing') }}"
            class="text-[15px] font-medium dark:text-white text-gray-800 dark:hover:text-white hover:text-orange-600 transition-colors no-underline">{{ translate('Pricing') }}</a>
        <a href="{{ route('user.about') }}"
            class="text-[15px] font-medium dark:text-white text-gray-800 dark:hover:text-white hover:text-orange-600 transition-colors no-underline">{{ translate('About') }}</a>
        <a href="{{ route('user.changelog') }}"
            class="text-[15px] font-medium dark:text-white text-gray-800 dark:hover:text-white hover:text-orange-600 transition-colors no-underline">{{ translate('Changelog') }}</a>
    </nav>

    <!-- Right: icons + toggle -->
    <div class="flex items-center gap-2">

        {{-- Search --}}
        <button type="button" class="top-action-btn">
            <svg class="w-[17px] h-[17px] dark:text-white text-gray-800" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
        </button>

        {{-- Notifications --}}
        <a href="{{ route('user.notifications.index') }}"
            class="top-action-btn relative {{ request()->routeIs('user.notifications.*') ? 'text-orange-500 bg-orange-500/10' : '' }}">
            <svg class="w-[17px] h-[17px] dark:text-white text-gray-800" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>

            <span id="sidebarNotifBadge"
                class="hidden absolute -top-1 -right-1 min-w-[16px] h-4 bg-orange-500 rounded-full
            text-[9px] text-white font-bold flex items-center justify-center px-0.5">
            </span>
        </a>

        {{-- Language --}}
        <div class="relative">
            <button type="button" id="languageButton" class="top-action-btn">
                <i class="fas fa-language text-[16px] dark:text-white text-gray-800"></i>
            </button>

            @php
                $locale = Session::get('locale', env('DEFAULT_LANGUAGE', config('app.locale')));
                $currentLang = App\Models\Language::where('language_code', $locale)->where('active', 1)->first();
            @endphp

            @if ($currentLang)
                <div id="languageDropdown"
                    class="hidden absolute right-0 mt-2 w-40 bg-white dark:bg-[#17141f]
                border border-black/[0.08] dark:border-white/[0.08]
                rounded-xl shadow-xl z-[999] overflow-hidden">

                    @foreach (App\Models\Language::where('active', 1)->get() as $language)
                        <form action="{{ route('user.languages.update.status', $language) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-between gap-2 px-4 py-2.5 text-[13px]
                            text-gray-800 dark:text-white hover:bg-black/[0.05] dark:hover:bg-white/[0.06] transition">
                                <span class="flex items-center gap-2">
                                    <i
                                        class="fas fa-globe-americas {{ $locale == $language->language_code ? 'text-emerald-500' : 'text-gray-800' }}"></i>
                                    {{ $language->title }}
                                </span>

                                @if ($locale == $language->language_code)
                                    <i class="fas fa-check text-emerald-500 text-[12px]"></i>
                                @endif
                            </button>
                        </form>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Theme toggle --}}
        <div class="flex items-center p-1 rounded-full bg-black/10 dark:bg-white/10 w-fit">

            <!-- LIGHT -->
            <button id="btnLight" onclick="setTheme('light')"
                class="relative flex items-center gap-2 px-4 py-1.5 rounded-full text-[13px] font-semibold transition-all duration-300
        text-gray-800 dark:text-white">

                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="5" />
                    <path
                        d="M12 1v2M12 21v2M4 12H2M22 12h-2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M18.36 5.64l1.42-1.42M4.22 19.78l1.42-1.42" />
                </svg>

                Light
            </button>

            <!-- DARK (ACTIVE STYLE LIKE IMAGE) -->
            <button id="btnDark" onclick="setTheme('dark')"
                class="relative flex items-center gap-2 px-4 py-1.5 rounded-full text-[13px] font-bold
        text-white
        bg-gradient-to-r from-[#ff8a00] via-[#ff5a1f] to-[#ff2d55]
        shadow-[0_0_25px_rgba(255,120,0,0.55)]
        transition-all duration-300">

                <!-- glow layer -->
                <span
                    class="absolute inset-0 rounded-full blur-xl opacity-60
            bg-gradient-to-r from-[#ff8a00] via-[#ff5a1f] to-[#ff2d55] -z-10"></span>

                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                </svg>

                Dark
            </button>

        </div>
    </div>

    <style>
        .top-action-btn {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s ease;
            color: rgb(107 114 128);
            background: transparent;
        }

        .top-action-btn:hover {
            background: rgba(0, 0, 0, .05);
            color: rgb(17 24 39);
        }

        .dark .top-action-btn {
            color: rgb(156 163 175);
        }

        .dark .top-action-btn:hover {
            background: rgba(255, 255, 255, .06);
            color: #fff;
        }

        .theme-action-btn {
            height: 26px;
            min-width: 30px;
            padding: 0 10px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all .2s ease;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const res = await fetch('{{ route('user.notifications.bell') }}', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();
                const badge = document.getElementById('sidebarNotifBadge');

                if (badge && data.count > 0) {
                    badge.textContent = data.count > 9 ? '9+' : data.count;
                    badge.classList.remove('hidden');
                }
            } catch (e) {}
        });

        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('languageButton');
            const dropdown = document.getElementById('languageDropdown');

            if (!btn || !dropdown) return;

            btn.addEventListener('click', function(e) {
                e.preventDefault();
                dropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function(e) {
                if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const header = document.getElementById('appHeader');

            function toggleHeader() {

                if (window.scrollY > 20) {

                    header.classList.add(
                        'dark:bg-[#05040B]/95',
                        'bg-[#f7e4c3]/90',
                        'backdrop-blur-xl',
                        'dark:border-b',
                        'border-b',
                        'dark:border-pink-500/10',
                        'border-orange-200/50'
                    );

                } else {

                    header.classList.remove(
                        'dark:bg-[#080612]/95',
                        'bg-[#f7e4c3]/90',
                        'backdrop-blur-xl',
                        'dark:border-b',
                        'border-b',
                        'dark:border-pink-500/10',
                        'border-orange-200/50'
                    );

                }
            }

            toggleHeader();

            window.addEventListener('scroll', toggleHeader);

        });
    </script>
</header>
