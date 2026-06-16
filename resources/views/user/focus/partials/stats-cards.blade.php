<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
    <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-4">
        <p class="text-[14px] dark:text-white text-gray-800">
            <i class="fas fa-clock mr-2"></i> Total Focus
        </p>
        <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900 mt-1">
            {{ $stats['total_focus_minutes'] ?? 0 }} min
        </h3>
    </div>

    <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-4">
        <p class="text-[14px] dark:text-white text-gray-800">
            <i class="fas fa-check-circle mr-2"></i> Completed Sessions
        </p>
        <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900 mt-1">
            {{ $stats['completed_sessions'] ?? 0 }}
        </h3>
    </div>

    <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-4">
        <p class="text-[14px] dark:text-white text-gray-800">
            <i class="fas fa-star mr-2"></i> XP Earned
        </p>
        <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900 mt-1">
            {{ $stats['total_xp'] ?? 0 }}
        </h3>
    </div>

    <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-4">
        <p class="text-[14px] dark:text-white text-gray-800">
            <i class="fas fa-hourglass-half mr-2"></i> Longest Session
        </p>
        <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900 mt-1">
            {{ $stats['longest_session'] ?? 0 }} min
        </h3>
    </div>
</div>
