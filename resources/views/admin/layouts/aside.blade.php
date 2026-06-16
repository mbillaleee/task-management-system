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
                dark:border-pink-500/20 border-orange-200/60 mt-5-">


        {{-- Navigation --}}
        @php
            $baseClass =
                'relative z-10 flex items-center gap-3 px-4 py-3 rounded-xl text-[13px] font-extrabold cursor-pointer no-underline transition-all duration-200';

            $normalClass =
                'dark:text-gray-300 text-gray-700 dark:hover:bg-white/[0.07] hover:bg-white/65 dark:hover:text-white hover:text-gray-900';

            $activeClass =
                'text-white bg-gradient-to-r from-orange-500 via-orange-500 to-pink-500 shadow-[0_0_25px_rgba(249,115,22,.45)]';
        @endphp

        {{-- Nav --}}
        <nav class="relative z-10 flex-1 px-3 py-4 flex flex-col gap-1.5 overflow-y-auto">

            <a href="{{ route('admin.dashboard') }}"
                class="{{ $baseClass }} {{ request()->routeIs('admin.dashboard') ? $activeClass : $normalClass }}">
                <i class="fas fa-home w-4 text-center text-[14px]"></i>
                <span>{{ translate('Dashboard') }}</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('admin.users.*') ? $activeClass : $normalClass }}">
                <i class="fas fa-users w-4 text-center text-[14px]"></i>
                <span>{{ translate('Users') }}</span>
            </a>

            <a href="{{ route('admin.subscriptions.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('admin.subscriptions.*') ? $activeClass : $normalClass }}">
                <i class="fas fa-credit-card w-4 text-center text-[14px]"></i>
                <span>{{ translate('Subscriptions') }}</span>
            </a>

            <a href="{{ route('admin.gamification.index') }}"
                class="{{ $baseClass }} {{ request()->routeIs('admin.gamification.*') ? $activeClass : $normalClass }}">
                <i class="fas fa-gamepad w-4 text-center text-[14px]"></i>
                <span>{{ translate('Gamification') }}</span>
            </a>

            <a href="{{ route('admin.languages') }}"
                class="{{ $baseClass }} {{ request()->routeIs('admin.languages') ? $activeClass : $normalClass }}">
                <i class="fas fa-language w-4 text-center text-[14px]"></i>
                <span>{{ translate('Languages') }}</span>
            </a>

            <a href="#" class="{{ $baseClass }} {{ $normalClass }}">
                <i class="fas fa-cog w-4 text-center text-[14px]"></i>
                <span>{{ translate('Settings') }}</span>
            </a>

            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="{{ $baseClass }} {{ $normalClass }}">
                <i class="fas fa-right-from-bracket w-4 text-center text-[14px]"></i>
                <span>{{ translate('Logout') }}</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </nav>



        {{-- Profile Card --}}
        <div
            class="relative z-10 mx-3 mb-3 rounded-2xl border
            dark:bg-[#120d1d]/90 bg-white/75
            dark:border-pink-500/20 border-orange-200/70">


            <div class="flex items-center gap-3 px-3 py-3.5">
                <div class="w-11 h-11 rounded-full p-[2px] flex-shrink-0 ">
                    <div
                        class="w-full h-full rounded-full overflow-hidden dark:bg-gray-800 bg-gray-100 flex items-center justify-center">
                        @if (auth()->user()->profile_photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="dark:text-white text-gray-700 text-[15px] font-black">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="text-[13px] font-black dark:text-white text-[#151515] leading-none mb-1 truncate">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </div>
                    <div class="text-[10px] dark:text-gray-400 text-gray-500 font-bold">
                        {{ translate('Pro Plan') }}
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}"
                    class="w-7 h-7 rounded-lg flex items-center justify-center bg-orange-400 dark:bg-orange-600
                dark:hover:bg-orange-800 hover:bg-orange-500 transition">
                    <i class="fas fa-pen text-[10px] dark:text-white text-white"></i>
                </a>
            </div>
        </div>

    </div>
</aside>
