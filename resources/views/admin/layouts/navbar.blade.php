<header id="appHeader"
    class="sticky top-0 z-30 flex items-center justify-between px-5 py-5
    bg-transparent transition-all duration-300">
    <!-- Left: hamburger + mobile logo -->
    <div class="flex items-center gap-2">
        <button onclick="toggleSidebar()"
            class="lg:hidden w-8 h-8 flex items-center justify-center rounded-lg
               dark:text-gray-400 text-gray-500 dark:hover:bg-white/[0.06] hover:bg-black/[0.05]
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
    <nav class="hidden md:flex items-center gap-6">
        {{-- <a href="#" class="text-[14px] font-medium dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors no-underline">Features</a> --}}

        {{-- <a href="{{ route('admin.clear') }}"
             class="text-[14px] font-medium dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors no-underline">Cache
             Clear</a> --}}
    </nav>

    <!-- Right: icons + toggle -->
    <div class="flex items-center gap-2">
        <!-- Search -->
        <a href="{{ route('admin.clear') }}"
            class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border-none bg-transparent cursor-pointer
    dark:text-gray-400 text-gray-500 dark:hover:bg-white/[0.06] hover:bg-black/[0.05]
    dark:hover:text-orange-400 hover:text-orange-500 transition-colors"
            title="Clear Cache">
            <i class="fas fa-rotate-right"></i>
        </a>

        <div class="relative inline-block text-left">
            <!-- Language Button -->
            <button id="languageButton"
                class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group relative">
                <i class="fas fa-language text-[#273C98] dark:text-[#05B2FC] text-lg sm:text-xl"></i>
                <span
                    class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap hidden sm:block">
                    {{ translate('Translate') }}
                </span>
            </button>

            @php
                $locale = Session::get('locale', env('DEFAULT_LANGUAGE', config('app.locale')));
                $currentLang = App\Models\Language::where('language_code', $locale)->where('active', 1)->first();
            @endphp

            @if ($currentLang)
                <!-- Dropdown -->
                <div class="relative z-[999]">
                    <div id="languageDropdown"
                        class="hidden absolute right-0 mt-2 w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg z-[99]">
                        @foreach (App\Models\Language::where('active', 1)->get() as $language)
                            <form action="{{ route('admin.languages.update.status', $language) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center justify-between text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                    data-lang="{{ $language->language_code }}">
                                    <div class="flex items-center space-x-2">
                                        <i
                                            class="fas fa-globe-americas {{ $locale == $language->language_code ? 'text-green-500' : 'text-red-500' }}"></i>
                                        <span>{{ $language->title }}</span>
                                    </div>
                                    @if ($locale == $language->language_code)
                                        <i class="fas fa-check text-green-500"></i>
                                    @endif
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>





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



        <!-- Dropdown Toggle Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('languageButton');
                const dropdown = document.getElementById('languageDropdown');

                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    dropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
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
                            'bg-[#F3DFBF]/90',
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
    </div>
</header>
