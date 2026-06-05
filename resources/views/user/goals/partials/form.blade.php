<section class="space-y-5">
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Goal Title</label>
        <input type="text" name="title" value="{{ old('title', $goal->title ?? '') }}" placeholder="Enter goal title"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
        @error('title')
            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Description</label>
        <textarea name="description" rows="5" placeholder="Write goal description..."
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none resize-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">{{ old('description', $goal->description ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Category</label>
            <select name="goal_category_id"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('goal_category_id', $goal->goal_category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Type</label>
            <select name="type"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="short_term" @selected(old('type', $goal->type ?? '') == 'short_term')>Short Term</option>
                <option value="long_term" @selected(old('type', $goal->type ?? 'long_term') == 'long_term')>Long Term</option>
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Priority</label>
            <select name="priority"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="low" @selected(old('priority', $goal->priority ?? '') == 'low')>Low</option>
                <option value="medium" @selected(old('priority', $goal->priority ?? 'medium') == 'medium')>Medium</option>
                <option value="high" @selected(old('priority', $goal->priority ?? '') == 'high')>High</option>
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Status</label>
            <select name="status"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="not_started" @selected(old('status', $goal->status ?? 'not_started') == 'not_started')>Not Started</option>
                <option value="in_progress" @selected(old('status', $goal->status ?? '') == 'in_progress')>In Progress</option>
                <option value="completed" @selected(old('status', $goal->status ?? '') == 'completed')>Completed</option>
                <option value="cancelled" @selected(old('status', $goal->status ?? '') == 'cancelled')>Cancelled</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Start Date</label>
            <input type="date" name="start_date"
                value="{{ old('start_date', isset($goal) && $goal->start_date ? $goal->start_date->format('Y-m-d') : '') }}"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 dark:border dark:border-white/[0.1] border border-black/[0.1]">
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Deadline</label>
            <input type="date" name="deadline"
                value="{{ old('deadline', isset($goal) && $goal->deadline ? $goal->deadline->format('Y-m-d') : '') }}"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 dark:border dark:border-white/[0.1] border border-black/[0.1]">
        </div>
    </div>

    <div class="flex items-center justify-end gap-2 pt-3">
        <a href="{{ route('user.goals.index') }}"
            class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
            Cancel
        </a>

        <button type="submit"
            class="px-5 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
            Save Goal
        </button>
    </div>
</section>
