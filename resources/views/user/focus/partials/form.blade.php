<section class="space-y-5">

    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
            Session Title
        </label>

        <input type="text" name="title" value="{{ old('title', $focus->title ?? '') }}"
            placeholder="Enter focus session title"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
            dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
            dark:border dark:border-white/[0.1] border border-black/[0.1]">

        @error('title')
            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
                Focus Type
            </label>

            <select name="type"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="pomodoro" @selected(old('type', $focus->type ?? 'pomodoro') == 'pomodoro')>Pomodoro Timer</option>
                <option value="deep_work" @selected(old('type', $focus->type ?? '') == 'deep_work')>Deep Work Session</option>
                <option value="focus_timer" @selected(old('type', $focus->type ?? '') == 'focus_timer')>Focus Timer</option>
                <option value="break" @selected(old('type', $focus->type ?? '') == 'break')>Break Timer</option>
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
                Ambient Sound
            </label>

            <select name="ambient_sound"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="none" @selected(old('ambient_sound', $focus->ambient_sound ?? 'none') == 'none')>None</option>
                <option value="white_noise" @selected(old('ambient_sound', $focus->ambient_sound ?? '') == 'white_noise')>White Noise</option>
                <option value="rain" @selected(old('ambient_sound', $focus->ambient_sound ?? '') == 'rain')>Rain Sounds</option>
                <option value="lofi" @selected(old('ambient_sound', $focus->ambient_sound ?? '') == 'lofi')>Lofi Mode</option>
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
                Status
            </label>

            <select name="status"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="pending" @selected(old('status', $focus->status ?? 'pending') == 'pending')>Pending</option>
                <option value="running" @selected(old('status', $focus->status ?? '') == 'running')>Running</option>
                <option value="paused" @selected(old('status', $focus->status ?? '') == 'paused')>Paused</option>
                <option value="completed" @selected(old('status', $focus->status ?? '') == 'completed')>Completed</option>
                <option value="cancelled" @selected(old('status', $focus->status ?? '') == 'cancelled')>Cancelled</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
                Duration Minutes
            </label>

            <input type="number" name="duration_minutes" min="1"
                value="{{ old('duration_minutes', $focus->duration_minutes ?? 25) }}"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
                Completed Minutes
            </label>

            <input type="number" name="completed_minutes" min="0"
                value="{{ old('completed_minutes', $focus->completed_minutes ?? 0) }}"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
                XP Earned
            </label>

            <input type="number" name="xp_earned" min="0" value="{{ old('xp_earned', $focus->xp_earned ?? 0) }}"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        <label
            class="px-3 py-2 rounded-[10px] text-[14px] font-bold cursor-pointer dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600">
            <input type="checkbox" name="fullscreen_mode" value="1" class="mr-1.5" @checked(old('fullscreen_mode', $focus->fullscreen_mode ?? false))>
            <i class="fas fa-expand mr-2"></i> Fullscreen Focus Mode
        </label>

        {{-- <label
            class="px-3 py-2 rounded-[10px] text-[14px] font-bold cursor-pointer dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600">
            <input type="checkbox" name="distraction_free" value="1" class="mr-1.5" @checked(old('distraction_free', $focus->distraction_free ?? false))>
            <i class="fas fa-ban mr-2"></i> Distraction-Free UI
        </label> --}}
    </div>

    <div class="flex items-center justify-end gap-2 pt-3">
        <a href="{{ route('user.focus.index') }}"
            class="px-4 py-2 rounded-[10px] text-[14px] font-bold
            dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
            <i class="fas fa-times mr-2"></i> Cancel
        </a>

        <button type="submit"
            class="px-5 py-2 rounded-[10px] text-white text-[14px] font-bold
            bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
            <i class="fas fa-save mr-2"></i> Save Focus
        </button>
    </div>

</section>
