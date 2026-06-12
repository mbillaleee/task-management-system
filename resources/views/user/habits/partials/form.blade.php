{{-- NOTE: Quick Add Category form is intentionally NOT here.
     It lives outside the main habit form in create.blade.php and edit.blade.php
     to avoid nested <form> tags which are invalid HTML. --}}

<div class="space-y-5">

    {{-- ─── Title ─────────────────────────────────────────────── --}}
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Habit Title</label>
        <input type="text" name="title" value="{{ old('title', $habit->title ?? '') }}" placeholder="Enter habit title"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
            dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
            dark:border dark:border-white/[0.1] border border-black/[0.1]">
        @error('title')
            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- ─── Description ───────────────────────────────────────── --}}
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Description</label>
        <textarea name="description" rows="4" placeholder="Write habit description..."
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none resize-none
            dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
            dark:border dark:border-white/[0.1] border border-black/[0.1]">{{ old('description', $habit->description ?? '') }}</textarea>
    </div>

    {{-- ─── Category / Type / Frequency ───────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Category</label>
            <select name="habit_category_id"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="">General</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('habit_category_id', $habit->habit_category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Type</label>
            <select name="type"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="positive" @selected(old('type', $habit->type ?? 'positive') == 'positive')>✅ Positive</option>
                <option value="negative" @selected(old('type', $habit->type ?? '') == 'negative')>❌ Negative</option>
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Frequency</label>
            <select name="frequency" id="frequency"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="daily" @selected(old('frequency', $habit->frequency ?? 'daily') == 'daily')>Daily</option>
                <option value="weekly" @selected(old('frequency', $habit->frequency ?? '') == 'weekly')>Weekly</option>
            </select>
        </div>
    </div>

    {{-- ─── Weekly Days ────────────────────────────────────────── --}}
    @php $selectedDays = old('days', $habit->days ?? []); @endphp
    <div id="weeklyDays" class="{{ old('frequency', $habit->frequency ?? 'daily') === 'weekly' ? '' : 'hidden' }}">
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-2">Repeat on Days</label>
        <div class="flex flex-wrap gap-2">
            @foreach (['mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 'thu' => 'Thu', 'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun'] as $key => $day)
                <label
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-[8px] text-[12px] font-semibold cursor-pointer
                    dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600
                    border dark:border-white/[0.08] border-black/[0.06]">
                    <input type="checkbox" name="days[]" value="{{ $key }}" class="accent-orange-500"
                        @checked(in_array($key, $selectedDays ?? []))>
                    {{ $day }}
                </label>
            @endforeach
        </div>
    </div>

    {{-- ─── Start Date + Status ────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Start Date</label>
            <input type="date" name="start_date"
                value="{{ old('start_date', isset($habit) && $habit->start_date ? $habit->start_date->format('Y-m-d') : today()->format('Y-m-d')) }}"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Status</label>
            <select name="status"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="1" @selected(old('status', $habit->status ?? 1) == 1)>Active</option>
                <option value="0" @selected(old('status', $habit->status ?? 1) == 0)>Inactive</option>
            </select>
        </div>
    </div>

    {{-- ─── Reminder ───────────────────────────────────────────── --}}
    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4 border dark:border-white/[0.06] border-black/[0.05]">
        <label class="flex items-center gap-2.5 cursor-pointer">
            <input type="checkbox" name="reminder_enabled" value="1" id="reminderToggle"
                class="w-4 h-4 rounded accent-orange-500" @checked(old('reminder_enabled', $habit->reminder_enabled ?? false))>
            <span class="text-[13px] font-bold dark:text-gray-200 text-gray-700">
                <i class="fas fa-bell mr-1.5 text-orange-400"></i>Enable Daily Reminder
            </span>
        </label>

        <div id="reminderField" class="mt-4"
            style="{{ old('reminder_enabled', $habit->reminder_enabled ?? false) ? '' : 'display:none' }}">
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Remind me at</label>
            <input type="time" name="remind_time" value="{{ old('remind_time', $habit->remind_time ?? '08:00') }}"
                class="w-full md:w-48 px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
            @error('remind_time')
                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- ─── Buttons ────────────────────────────────────────────── --}}
    <div class="flex items-center justify-end gap-2 pt-3 border-t dark:border-white/[0.06] border-black/[0.05]">
        <a href="{{ route('user.habits.index') }}"
            class="px-4 py-2 rounded-[10px] text-[14px] font-bold
            dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
            <i class="fas fa-times mr-1"></i> Cancel
        </a>
        <button type="submit"
            class="px-5 py-2 rounded-[10px] text-white text-[14px] font-bold
            bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
            <i class="fas fa-save mr-1"></i> {{ $buttonText ?? 'Save Habit' }}
        </button>
    </div>
</div>

<script>
    document.getElementById('frequency').addEventListener('change', function() {
        document.getElementById('weeklyDays').classList.toggle('hidden', this.value !== 'weekly');
    });
    document.getElementById('reminderToggle').addEventListener('change', function() {
        document.getElementById('reminderField').style.display = this.checked ? '' : 'none';
    });
</script>
