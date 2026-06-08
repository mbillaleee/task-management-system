{{-- ─────────────────────────────────────────────────────────────────────── --}}
{{-- Event Detail Modal                                                       --}}
{{-- ─────────────────────────────────────────────────────────────────────── --}}
<div id="eventModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
    onclick="if(event.target===this) closeEventModal()">

    <div class="absolute inset-0 dark:bg-black/70 bg-black/40 backdrop-blur-sm"></div>

    <div
        class="relative w-full max-w-md dark:bg-[#1a1625] bg-white border dark:border-white/[0.1] border-black/[0.08] rounded-2xl shadow-2xl">

        {{-- Header --}}
        <div class="flex items-start justify-between px-6 py-5 border-b dark:border-white/[0.07] border-black/[0.07]">
            <div class="flex-1 pr-4">
                <div class="flex items-center gap-2 mb-1">
                    <span id="evType"
                        class="text-[11px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full dark:bg-orange-500/20 bg-orange-100 dark:text-orange-400 text-orange-700">
                        event
                    </span>
                    <span id="evPriority"
                        class="text-[11px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full dark:bg-white/[0.08] bg-black/[0.05] dark:text-gray-400 text-gray-600">
                        medium
                    </span>
                </div>
                <h3 id="evTitle" class="text-[18px] font-extrabold dark:text-white text-gray-900 leading-snug">Event
                    Title</h3>
            </div>
            <button onclick="closeEventModal()"
                class="w-8 h-8 flex items-center justify-center rounded-xl dark:bg-white/[0.06] bg-black/[0.05] dark:text-gray-400 text-gray-500 dark:hover:bg-white/[0.1] hover:bg-black/[0.08] transition-colors flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5 space-y-3.5">

            {{-- Status --}}
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl dark:bg-blue-500/20 bg-blue-50 flex items-center justify-center">
                    <i class="fas fa-circle-dot text-[13px] text-blue-400"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider dark:text-gray-500 text-gray-400">Status
                    </p>
                    <p id="evStatus" class="text-[14px] font-bold dark:text-white text-gray-900 capitalize">upcoming
                    </p>
                </div>
            </div>

            {{-- Date --}}
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl dark:bg-orange-500/20 bg-orange-50 flex items-center justify-center">
                    <i class="fas fa-calendar text-[13px] text-orange-400"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider dark:text-gray-500 text-gray-400">Date</p>
                    <p id="evDate" class="text-[14px] font-bold dark:text-white text-gray-900">—</p>
                </div>
            </div>

            {{-- Time --}}
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl dark:bg-purple-500/20 bg-purple-50 flex items-center justify-center">
                    <i class="fas fa-clock text-[13px] text-purple-400"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider dark:text-gray-500 text-gray-400">Time</p>
                    <p id="evTime" class="text-[14px] font-bold dark:text-white text-gray-900">—</p>
                </div>
            </div>

            {{-- Location --}}
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl dark:bg-emerald-500/20 bg-emerald-50 flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-[13px] text-emerald-400"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider dark:text-gray-500 text-gray-400">Location
                    </p>
                    <p id="evLocation" class="text-[14px] font-bold dark:text-white text-gray-900">—</p>
                </div>
            </div>

            {{-- Description --}}
            <div class="flex items-start gap-3">
                <div
                    class="w-8 h-8 rounded-xl dark:bg-pink-500/20 bg-pink-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-align-left text-[13px] text-pink-400"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-bold uppercase tracking-wider dark:text-gray-500 text-gray-400">Notes</p>
                    <p id="evDesc" class="text-[14px] dark:text-gray-300 text-gray-600 break-words">—</p>
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="flex items-center gap-2.5 px-6 py-4 border-t dark:border-white/[0.07] border-black/[0.07]">
            <button id="editEventBtn"
                class="flex-1 py-2.5 rounded-[10px] text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 text-white shadow-[0_4px_16px_rgba(249,115,22,0.3)] hover:shadow-[0_6px_20px_rgba(249,115,22,0.45)] transition-shadow">
                <i class="fas fa-edit mr-1.5"></i> Edit
            </button>
            <button id="deleteEventBtn"
                class="flex-1 py-2.5 rounded-[10px] text-[14px] font-bold dark:bg-red-500/20 bg-red-100 dark:text-red-400 text-red-600 dark:hover:bg-red-500/30 hover:bg-red-200 transition-colors">
                <i class="fas fa-trash mr-1.5"></i> Delete
            </button>
        </div>
    </div>
</div>
