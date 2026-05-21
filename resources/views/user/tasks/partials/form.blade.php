<section class="space-y-5">
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Task Title</label>
        <input type="text" name="title" value="{{ old('title', $task->title ?? '') }}" placeholder="Enter task title"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[13px] outline-none
            dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
            dark:border dark:border-white/[0.1] border border-black/[0.1]">
        @error('title')
            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Description</label>
        <textarea name="description" rows="5" placeholder="Write task description..."
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[13px] outline-none resize-none
            dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
            dark:border dark:border-white/[0.1] border border-black/[0.1]">{{ old('description', $task->description ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Category</label>
            <select name="task_category_id"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[13px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('task_category_id', $task->task_category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Priority</label>
            <select name="priority"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[13px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="low" @selected(old('priority', $task->priority ?? '') == 'low')>Low</option>
                <option value="medium" @selected(old('priority', $task->priority ?? 'medium') == 'medium')>Medium</option>
                <option value="high" @selected(old('priority', $task->priority ?? '') == 'high')>High</option>
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Status</label>
            <select name="status"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[13px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="pending" @selected(old('status', $task->status ?? 'pending') == 'pending')>Pending</option>
                <option value="in_progress" @selected(old('status', $task->status ?? '') == 'in_progress')>In Progress</option>
                <option value="completed" @selected(old('status', $task->status ?? '') == 'completed')>Completed</option>
            </select>
        </div>
    </div>

    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Due Date</label>
        <input type="date" name="due_date"
            value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[13px] outline-none
            dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
            dark:border dark:border-white/[0.1] border border-black/[0.1]">
    </div>

    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-2">Labels</label>
        <div class="flex flex-wrap gap-2">
            @foreach ($labels as $label)
                <label
                    class="px-3 py-1.5 rounded-[8px] text-[11.5px] font-semibold cursor-pointer
                    dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600">
                    <input type="checkbox" name="labels[]" value="{{ $label->id }}" class="mr-1.5"
                        @checked(isset($task) && $task->labels->contains($label->id))>
                    {{ $label->name }}
                </label>
            @endforeach
        </div>
    </div>

    <div class="flex items-center justify-end gap-2 pt-3">
        <a href="{{ route('user.tasks.index') }}"
            class="px-4 py-2 rounded-[10px] text-[12.5px] font-bold
            dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
            Cancel
        </a>

        <button type="submit"
            class="px-5 py-2 rounded-[10px] text-white text-[12.5px] font-bold
            bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
            Save Task
        </button>
    </div>
</section>
