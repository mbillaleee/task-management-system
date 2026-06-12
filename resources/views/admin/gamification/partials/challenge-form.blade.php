{{-- ============================================================ --}}
{{-- FILE: resources/views/admin/gamification/partials/challenge-form.blade.php --}}
{{-- ============================================================ --}}
@php $prefix = isset($edit) ? 'edit_challenge_' : 'challenge_'; @endphp
@php
    $selectedChallengeAction = old('challenge_action', $challenge->challenge_action ?? 'manual');
@endphp

<div>
    <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Challenge Title</label>
    <input type="text" name="title" id="{{ $prefix }}title"
        class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
</div>

<div>
    <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Description</label>
    <textarea name="description" id="{{ $prefix }}description" rows="3"
        class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none resize-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]"></textarea>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Type</label>
        <select name="type" id="{{ $prefix }}type"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 dark:border dark:border-white/[0.1] border border-black/[0.1]">
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
        </select>
    </div>

    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Target Value</label>
        <input type="number" name="target_value" id="{{ $prefix }}target_value" value="1" min="1"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
    </div>

    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">XP Reward</label>
        <input type="number" name="xp_reward" id="{{ $prefix }}xp_reward" value="10" min="1"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
    </div>

    <div class="md:col-span-3">
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
            Challenge Action
            <span class="font-normal dark:text-gray-500 text-gray-400 ml-1">
                — How will progress increase?
            </span>
        </label>

        <select name="challenge_action" id="{{ $prefix }}challenge_action"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.1] border-black/[0.1] outline-none">

            <option value="manual" @selected($selectedChallengeAction === 'manual')>
                ✍️ Manual — User will manually add progress
            </option>

            <option value="complete_task" @selected($selectedChallengeAction === 'complete_task')>
                ✅ Auto — +1 when a task is completed
            </option>

            <option value="log_habit" @selected($selectedChallengeAction === 'log_habit')>
                🔁 Auto — +1 when a habit is logged
            </option>

            <option value="finish_focus" @selected($selectedChallengeAction === 'finish_focus')>
                ⏱ Auto — +1 when a focus session is completed
            </option>

            <option value="complete_goal" @selected($selectedChallengeAction === 'complete_goal')>
                🎯 Auto — +1 when a goal is completed
            </option>

            <option value="write_journal" @selected($selectedChallengeAction === 'write_journal')>
                📔 Auto — +1 when a journal entry is created
            </option>

            <option value="login_streak" @selected($selectedChallengeAction === 'login_streak')>
                🔥 Auto — +1 when a daily reward is claimed
            </option>
        </select>

        <p class="text-[11px] dark:text-gray-500 text-gray-400 mt-1">
            If Auto is selected, progress will increase automatically based on user activity — no manual input required.
        </p>

        @error('challenge_action')
            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div>
    <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Reward Title</label>
    <input type="text" name="reward_title" id="{{ $prefix }}reward_title"
        class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Start Date</label>
        <input type="date" name="start_date" id="{{ $prefix }}start_date"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
    </div>
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">End Date</label>
        <input type="date" name="end_date" id="{{ $prefix }}end_date"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
    </div>
</div>

<label class="flex items-center gap-2 text-[14px] font-bold dark:text-gray-300 text-gray-700 cursor-pointer">
    <input type="checkbox" name="is_active" value="1" id="{{ $prefix }}active" checked>
    <i class="fas fa-toggle-on"></i> Active Challenge
</label>

<div class="flex justify-end">
    <button type="submit"
        class="px-5 py-2.5 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
        <i class="fas fa-save"></i> Save Challenge
    </button>
</div>
