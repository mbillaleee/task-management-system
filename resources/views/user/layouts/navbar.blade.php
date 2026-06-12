 <header
     class="sticky top-0 z-30 flex items-center justify-between px-5 py-4
                dark:bg-[#0d0b14]/90 bg-[#f0e8dc]/90
                dark:border-b dark:border-white/[0.06] border-b border-black/[0.06]
                backdrop-blur-xl">

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
         <a href="{{ route('user.features') }}"
             class="text-[15px] font-medium dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors no-underline">{{ translate('Features') }}</a>
         <a href="{{ route('user.tools') }}"
             class="text-[15px] font-medium dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors no-underline">{{ translate('Tools') }}</a>
         <a href="{{ route('user.pricing') }}"
             class="text-[15px] font-medium dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors no-underline">{{ translate('Pricing') }}</a>
         <a href="{{ route('user.about') }}"
             class="text-[15px] font-medium dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors no-underline">{{ translate('About') }}</a>
         {{-- <a href="{{ route('user.changelog') }}"
             class="text-[15px] font-medium dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors no-underline">{{ translate('Changelog') }}</a> --}}
     </nav>

     <!-- Right: icons + toggle -->
     <div class="flex items-center gap-2">

         {{-- Search --}}
         {{-- <button type="button" class="top-action-btn">
             <svg class="w-[17px] h-[17px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" viewBox="0 0 24 24">
                 <circle cx="11" cy="11" r="8" />
                 <line x1="21" y1="21" x2="16.65" y2="16.65" />
             </svg>
         </button> --}}

         {{-- Notifications --}}
         <a href="{{ route('user.notifications.index') }}"
             class="top-action-btn relative {{ request()->routeIs('user.notifications.*') ? 'text-orange-500 bg-orange-500/10' : '' }}">
             <svg class="w-[17px] h-[17px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" viewBox="0 0 24 24">
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
                 <i class="fas fa-language text-[16px]"></i>
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
                            text-gray-700 dark:text-gray-200 hover:bg-black/[0.05] dark:hover:bg-white/[0.06] transition">
                                 <span class="flex items-center gap-2">
                                     <i
                                         class="fas fa-globe-americas {{ $locale == $language->language_code ? 'text-emerald-500' : 'text-gray-400' }}"></i>
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
         <div class="flex items-center gap-1 rounded-xl p-1 h-[34px]
        dark:bg-white/[0.06] bg-black/[0.05]">

             <button type="button" id="btnLight" onclick="setTheme('light')"
                 class="theme-action-btn dark:text-gray-400 text-gray-800 dark:bg-transparent bg-white shadow-sm">
                 <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     viewBox="0 0 24 24">
                     <circle cx="12" cy="12" r="5" />
                     <line x1="12" y1="1" x2="12" y2="3" />
                     <line x1="12" y1="21" x2="12" y2="23" />
                     <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                     <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                     <line x1="1" y1="12" x2="3" y2="12" />
                     <line x1="21" y1="12" x2="23" y2="12" />
                     <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                     <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
                 </svg>
                 <span class="hidden sm:inline">{{ translate('Light') }}</span>
             </button>

             <button type="button" id="btnDark" onclick="setTheme('dark')"
                 class="theme-action-btn dark:text-white text-gray-500 dark:bg-[#1e1730] bg-transparent">
                 <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" viewBox="0 0 24 24">
                     <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                 </svg>
                 <span class="hidden sm:inline">{{ translate('Dark') }}</span>
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
 </header>
