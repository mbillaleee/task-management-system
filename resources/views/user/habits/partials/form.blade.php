<section class="space-y-5">

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

    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Description</label>
        <textarea name="description" rows="5" placeholder="Write habit description..."
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none resize-none
            dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
            dark:border dark:border-white/[0.1] border border-black/[0.1]">{{ old('description', $habit->description ?? '') }}</textarea>
    </div>

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
                <option value="positive" @selected(old('type', $habit->type ?? 'positive') == 'positive')>Positive</option>
                <option value="negative" @selected(old('type', $habit->type ?? '') == 'negative')>Negative</option>
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

    @php
        $selectedDays = old('days', $habit->days ?? []);
    @endphp

    <div id="weeklyDays" class="{{ old('frequency', $habit->frequency ?? 'daily') == 'weekly' ? '' : 'hidden' }}">
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-2">Weekly Days</label>

        <div class="flex flex-wrap gap-2">
            @foreach (['mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 'thu' => 'Thu', 'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun'] as $key => $day)
                <label
                    class="px-3 py-1.5 rounded-[8px] text-[12px] font-semibold cursor-pointer
                    dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600">
                    <input type="checkbox" name="days[]" value="{{ $key }}" class="mr-1.5"
                        @checked(in_array($key, $selectedDays ?? []))>
                    {{ $day }}
                </label>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Start Date</label>
            <input type="date" name="start_date"
                value="{{ old('start_date', isset($habit) && $habit->start_date ? $habit->start_date->format('Y-m-d') : '') }}"
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

    <div class="flex items-center justify-end gap-2 pt-3">
        <a href="{{ route('user.habits.index') }}"
            class="px-4 py-2 rounded-[10px] text-[14px] font-bold
            dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
            Cancel
        </a>

        <button type="submit"
            class="px-5 py-2 rounded-[10px] text-white text-[14px] font-bold
            bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
            {{ $buttonText }}
        </button>
    </div>
</section>

<script>
    const frequency = document.getElementById('frequency');
    const weeklyDays = document.getElementById('weeklyDays');

    if (frequency) {
        frequency.addEventListener('change', function() {
            weeklyDays.classList.toggle('hidden', this.value !== 'weekly');
        });
    }
</script>
