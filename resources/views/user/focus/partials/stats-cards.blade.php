<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
    <div
        class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
        <p class="text-[14px] dark:text-gray-500 text-gray-400">Total Focus</p>
        <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900 mt-1">
            {{ $stats['total_focus_minutes'] ?? 0 }} min
        </h3>
    </div>

    <div
        class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
        <p class="text-[14px] dark:text-gray-500 text-gray-400">Completed Sessions</p>
        <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900 mt-1">
            {{ $stats['completed_sessions'] ?? 0 }}
        </h3>
    </div>

    <div
        class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
        <p class="text-[14px] dark:text-gray-500 text-gray-400">XP Earned</p>
        <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900 mt-1">
            {{ $stats['total_xp'] ?? 0 }}
        </h3>
    </div>

    <div
        class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
        <p class="text-[14px] dark:text-gray-500 text-gray-400">Longest Session</p>
        <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900 mt-1">
            {{ $stats['longest_session'] ?? 0 }} min
        </h3>
    </div>
</div>
