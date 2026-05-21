 <aside id="sidebar"
     class="fixed top-0 left-0 h-full w-52 z-50 flex flex-col
         dark:bg-[#100e1a] bg-[#fdf6ee]
         dark:border-r dark:border-white/[0.06] border-r border-black/[0.06]
         shadow-2xl">

     <!-- Logo -->
     <div
         class="flex items-center gap-2.5 px-4 py-[17px] dark:border-b dark:border-white/[0.06] border-b border-black/[0.06] flex-shrink-0">
         <svg width="26" height="26" viewBox="0 0 40 40" fill="none">
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
         <span class="text-[18px] font-bold tracking-[-0.3px] dark:text-white text-gray-900">veroa</span>
     </div>

     <!-- Nav items -->
     <nav class="flex-1 px-2.5 py-3 flex flex-col gap-0.5 overflow-y-auto">

         {{-- Dashboard --}}
         <a id="nav-dashboard" href="{{ route('user.dashboard') }}"
             class="nav-item flex items-center gap-2.5 px-3 py-[9px] rounded-[10px] text-[13.5px] font-semibold cursor-pointer no-underline transition-all duration-200
           {{ request()->routeIs('user.dashboard') ? 'text-orange-600 dark:text-orange-400 nav-active-dark' : 'text-gray-600 dark:text-gray-400' }}">
             <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                 <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                 <polyline points="9 22 9 12 15 12 15 22" />
             </svg>
             Dashboard
         </a>

         {{-- Users --}}


         <a id="nav-tasks" href="{{ route('user.tasks.index') }}"
             class="nav-item flex items-center gap-2.5 px-3 py-[9px] rounded-[10px]
   dark:text-gray-400 text-gray-500 text-[13.5px] font-medium cursor-pointer no-underline
   dark:hover:bg-white/[0.05] hover:bg-black/[0.04] dark:hover:text-white hover:text-gray-900
   transition-all duration-200">
             <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                 <path
                     d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
             </svg>
             Tasks
         </a>

         <a id="nav-habits" href="#" onclick="setNav('habits',event)"
             class="nav-item flex items-center gap-2.5 px-3 py-[9px] rounded-[10px]
             dark:text-gray-400 text-gray-500 text-[13.5px] font-medium cursor-pointer no-underline
             dark:hover:bg-white/[0.05] hover:bg-black/[0.04] dark:hover:text-white hover:text-gray-900
             transition-all duration-200">
             <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                 <path
                     d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
             </svg>Habits
         </a>

         <a id="nav-notes" href="#" onclick="setNav('notes',event)"
             class="nav-item flex items-center gap-2.5 px-3 py-[9px] rounded-[10px]
             dark:text-gray-400 text-gray-500 text-[13.5px] font-medium cursor-pointer no-underline
             dark:hover:bg-white/[0.05] hover:bg-black/[0.04] dark:hover:text-white hover:text-gray-900
             transition-all duration-200">
             <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                 <path
                     d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
             </svg>Notes
         </a>

         <a id="nav-focus" href="#" onclick="setNav('focus',event)"
             class="nav-item flex items-center gap-2.5 px-3 py-[9px] rounded-[10px]
             dark:text-gray-400 text-gray-500 text-[13.5px] font-medium cursor-pointer no-underline
             dark:hover:bg-white/[0.05] hover:bg-black/[0.04] dark:hover:text-white hover:text-gray-900
             transition-all duration-200">
             <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                 <circle cx="12" cy="12" r="10" />
                 <polyline points="12 6 12 12 16 14" />
             </svg>Focus
         </a>

         <a id="nav-tools" href="#" onclick="setNav('tools',event)"
             class="nav-item flex items-center gap-2.5 px-3 py-[9px] rounded-[10px]
             dark:text-gray-400 text-gray-500 text-[13.5px] font-medium cursor-pointer no-underline
             dark:hover:bg-white/[0.05] hover:bg-black/[0.04] dark:hover:text-white hover:text-gray-900
             transition-all duration-200">
             <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                 <circle cx="12" cy="12" r="3" />
                 <path
                     d="M19.07 4.93l-1.41 1.41M20 12h-2M17.66 17.66l-1.41-1.41M12 20v-2M6.34 17.66l1.41-1.41M4 12h2M6.34 6.34l1.41 1.41" />
             </svg>Tools
         </a>

         <a id="nav-analytics" href="#" onclick="setNav('analytics',event)"
             class="nav-item flex items-center gap-2.5 px-3 py-[9px] rounded-[10px]
             dark:text-gray-400 text-gray-500 text-[13.5px] font-medium cursor-pointer no-underline
             dark:hover:bg-white/[0.05] hover:bg-black/[0.04] dark:hover:text-white hover:text-gray-900
             transition-all duration-200">
             <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                 <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
             </svg>Analytics
         </a>

         <a id="nav-settings" href="#" onclick="setNav('settings',event)"
             class="nav-item flex items-center gap-2.5 px-3 py-[9px] rounded-[10px]
             dark:text-gray-400 text-gray-500 text-[13.5px] font-medium cursor-pointer no-underline
             dark:hover:bg-white/[0.05] hover:bg-black/[0.04] dark:hover:text-white hover:text-gray-900
             transition-all duration-200">
             <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                 <circle cx="12" cy="12" r="3" />
                 <path
                     d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" />
             </svg>Settings
         </a>

         <!-- Logout -->
         <a href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
             class="nav-item flex items-center gap-2.5 px-3 py-[9px] rounded-[10px]
   dark:text-gray-400 text-gray-500 text-[13.5px] font-medium cursor-pointer no-underline
   dark:hover:bg-white/[0.05] hover:bg-black/[0.04] dark:hover:text-white hover:text-gray-900
   transition-all duration-200">
             <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                 <path d="M17 16l4-4m0 0l-4-4m4 4H7" />
             </svg>
             Logout
         </a>

         <!-- Logout Form -->
         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
             @csrf
         </form>
     </nav>

     <!-- Upgrade to Pro -->
     <div class="mx-2.5 mb-2.5">
         <div class="upgrade-dark dark:upgrade-dark upgrade-light rounded-2xl p-3.5 border dark:border-orange-500/25 border-orange-300/50"
             id="upgradeCard">
             <div class="flex items-center gap-1.5 mb-1">
                 <span class="text-base">👑</span>
                 <span class="text-[13px] font-bold dark:text-white text-gray-900">Upgrade to Pro</span>
             </div>
             <p class="text-[11px] dark:text-gray-400 text-gray-500 leading-relaxed mb-2.5">Unlock unlimited power
                 and exclusive features.</p>
             <button
                 class="w-full py-2 rounded-[10px] text-white text-[12px] font-bold btn-trans
        bg-gradient-to-br from-orange-500 to-pink-500 dark:from-orange-500 dark:to-pink-500
        light:from-orange-600 light:to-amber-500
        shadow-[0_4px_14px_rgba(249,115,22,0.4)]">
                 Upgrade Now
             </button>
         </div>
     </div>

     <!-- User Profile -->
     <div
         class="flex items-center gap-2.5 px-3.5 py-3 dark:border-t dark:border-white/[0.06] border-t border-black/[0.06] flex-shrink-0">
         <div
             class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center text-white text-[13px] font-bold
      bg-gradient-to-br from-orange-400 to-pink-500">
             L</div>
         <div class="flex-1 min-w-0">
             <div class="text-[13px] font-semibold dark:text-white text-gray-900 leading-none mb-0.5">Leon</div>
             <div class="text-[11px] dark:text-gray-500 text-gray-400">Pro Plan</div>
         </div>
         <a href="{{ route('profile.edit') }}">
             <svg class="w-3.5 h-3.5 dark:text-gray-500 text-gray-400 flex-shrink-0" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 viewBox="0 0 24 24">
                 <polyline points="6 9 12 15 18 9" />
             </svg>
         </a>
     </div>
 </aside>
