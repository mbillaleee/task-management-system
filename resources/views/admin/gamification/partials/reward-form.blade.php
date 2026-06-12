{{-- ============================================================ --}}
{{-- FILE: resources/views/admin/gamification/partials/reward-form.blade.php --}}
{{-- ============================================================ --}}
@php $prefix = isset($edit) ? 'edit_reward_' : 'reward_'; @endphp

<div>
    <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Day Number (1–7)</label>
    <input type="number" name="day_number" id="{{ $prefix }}day_number" min="1" max="7"
        class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
</div>

<div>
    <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">XP Reward</label>
    <input type="number" name="xp_reward" id="{{ $prefix }}xp_reward" value="10" min="1"
        class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
</div>

<div>
    <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Title (optional)</label>
    <input type="text" name="title" id="{{ $prefix }}title" placeholder="Day 1 Reward"
        class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
</div>

<div>
    <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Icon (emoji, optional)</label>
    <input type="text" name="icon" id="{{ $prefix }}icon" placeholder="🎁"
        class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
</div>

<div class="flex justify-end">
    <button type="submit"
        class="px-5 py-2.5 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
        <i class="fas fa-save"></i> Save Reward
    </button>
</div>
