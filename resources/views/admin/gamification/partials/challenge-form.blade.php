{{-- ============================================================ --}}
{{-- FILE: resources/views/admin/gamification/partials/challenge-form.blade.php --}}
{{-- ============================================================ --}}
@php $prefix = isset($edit) ? 'edit_challenge_' : 'challenge_'; @endphp

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
    Active Challenge
</label>

<div class="flex justify-end">
    <button type="submit"
        class="px-5 py-2.5 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
        Save Challenge
    </button>
</div>
