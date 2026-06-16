{{-- ============================================================ --}}
{{-- FILE: resources/views/admin/gamification/partials/badge-form.blade.php --}}
{{-- ============================================================ --}}
@php $prefix = isset($edit) ? 'edit_badge_' : 'badge_'; @endphp

<div>
    <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Badge Name</label>
    <input type="text" name="name" id="{{ $prefix }}name"
        class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
</div>

<div>
    <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Description</label>
    <textarea name="description" id="{{ $prefix }}description" rows="3"
        class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none resize-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]"></textarea>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Icon (emoji)</label>
        <input type="text" name="icon" id="{{ $prefix }}icon" placeholder="🏆"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
    </div>
    <div>
        <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Color</label>
        <input type="color" name="color" id="{{ $prefix }}color" value="#f97316"
            class="w-full h-11 rounded-[10px] cursor-pointer outline-none dark:bg-[#1a1625] bg-white dark:border dark:border-white/[0.1] border border-black/[0.1]">
    </div>
    <div>
        <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">XP Required</label>
        <input type="number" name="xp_required" id="{{ $prefix }}xp" value="0" min="0"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
    </div>
</div>

<label class="flex items-center gap-2 text-[14px] font-bold dark:text-white text-gray-800 cursor-pointer">
    <input type="checkbox" name="is_active" value="1" id="{{ $prefix }}active" checked>
    <i class="fas fa-toggle-on"></i> Active Badge
</label>

<div class="flex justify-end">
    <button type="submit"
        class="px-5 py-2.5 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
        <i class="fas fa-save"></i> Save Badge
    </button>
</div>
