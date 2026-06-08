 <header
     class="sticky top-0 z-30 flex items-center justify-between px-5 py-5
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
             class="text-[15px] font-medium dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors no-underline">Features</a>
         <a href="{{ route('user.tools') }}"
             class="text-[15px] font-medium dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors no-underline">Tools</a>
         <a href="{{ route('user.pricing') }}"
             class="text-[15px] font-medium dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors no-underline">Pricing</a>
         <a href="{{ route('user.about') }}"
             class="text-[15px] font-medium dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors no-underline">About</a>
         {{-- <a href="{{ route('user.changelog') }}"
             class="text-[15px] font-medium dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors no-underline">Changelog</a> --}}
     </nav>

     <!-- Right: icons + toggle -->
     <div class="flex items-center gap-2">
         <!-- Search -->
         <button
             class="w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border-none bg-transparent cursor-pointer
                        dark:text-gray-400 text-gray-500 dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900 transition-colors">
             <svg class="w-[17px] h-[17px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" viewBox="0 0 24 24">
                 <circle cx="11" cy="11" r="8" />
                 <line x1="21" y1="21" x2="16.65" y2="16.65" />
             </svg>
         </button>
         <!-- Bell -->
         <button
             class="relative w-[34px] h-[34px] flex items-center justify-center rounded-[8px] border-none bg-transparent cursor-pointer dark:text-gray-400 text-gray-500 dark:hover:bg-white/[0.06] hover:bg-black/[0.05] dark:hover:text-white hover:text-gray-900 transition-colors">
             <svg class="w-[17px] h-[17px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" viewBox="0 0 24 24">
                 <path
                     d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
             </svg>
             <span
                 class="absolute top-[7px] right-[7px] w-[7px] h-[7px] bg-orange-500 rounded-full border-[1.5px] dark:border-[#0d0b14] border-[#f0e8dc]"></span>
         </button>
         <!-- Theme toggle pill -->
         <div class="flex items-center gap-0.5 rounded-full p-[3px] dark:bg-white/[0.08] bg-black/[0.07]">
             <button id="btnLight" onclick="setTheme('light')"
                 class="flex items-center gap-1.5 px-3 py-[5px] rounded-full text-[12px] font-semibold border-none cursor-pointer transition-all duration-200  dark:text-gray-500 text-gray-800 dark:bg-transparent bg-white shadow-sm">
                 <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
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
                 <span class="hidden sm:inline">Light</span>
             </button>
             <button id="btnDark" onclick="setTheme('dark')"
                 class="flex items-center gap-1.5 px-3 py-[5px] rounded-full text-[12px] font-semibold border-none cursor-pointer transition-all duration-200  dark:text-white text-gray-400 dark:bg-[#1e1730] bg-transparent dark:shadow-sm">
                 <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     viewBox="0 0 24 24">
                     <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                 </svg>
                 <span class="hidden sm:inline">Dark</span>
             </button>
         </div>

         <div class="relative inline-block text-left">
             <!-- Language Button -->
             <button id="languageButton"
                 class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group relative">
                 <i class="fas fa-language text-[#273C98] dark:text-[#05B2FC] text-lg sm:text-xl"></i>
                 <span
                     class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap hidden sm:block">
                     অনুবাদ
                 </span>
             </button>

             @php
                 $locale = session('locale', env('DEFAULT_LANGUAGE', config('app.locale')));
                 $currentLang = App\Models\Language::where('language_code', $locale)->where('active', 1)->first();
                 $activeLanguages = App\Models\Language::where('active', 1)->get();
             @endphp

             @if ($currentLang)
                 <!-- Dropdown -->
                 <div class="relative z-[999]">
                     <div id="languageDropdown"
                         class="hidden absolute right-0 mt-2 w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg z-[99]">
                         @foreach ($activeLanguages as $language)
                             <form action="{{ route('user.languages.update.status', $language) }}" method="POST">
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
     </div>
 </header>
