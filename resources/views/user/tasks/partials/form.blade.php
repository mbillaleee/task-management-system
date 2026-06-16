<section class="space-y-5">


    {{-- ─── Task Title ────────────────────────────────────────── --}}
    <div>
        <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Task Title</label>
        <input type="text" name="title" value="{{ old('title', $task->title ?? '') }}" placeholder="Enter task title"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
            dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
            dark:border dark:border-white/[0.1] border border-black/[0.1]">
        @error('title')
            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- ─── Description ───────────────────────────────────────── --}}
    <div>
        <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Description</label>
        <textarea name="description" rows="4" placeholder="Write task description..."
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none resize-none
            dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
            dark:border dark:border-white/[0.1] border border-black/[0.1]">{{ old('description', $task->description ?? '') }}</textarea>
    </div>

    {{-- ─── Category / Priority / Status ──────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Category</label>
            <select name="task_category_id"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
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
            <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Priority</label>
            <select name="priority"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="low" @selected(old('priority', $task->priority ?? '') == 'low')>Low</option>
                <option value="medium" @selected(old('priority', $task->priority ?? 'medium') == 'medium')>Medium</option>
                <option value="high" @selected(old('priority', $task->priority ?? '') == 'high')>High</option>
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Status</label>
            <select name="status"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="pending" @selected(old('status', $task->status ?? 'pending') == 'pending')>Pending</option>
                <option value="in_progress" @selected(old('status', $task->status ?? '') == 'in_progress')>In Progress</option>
                <option value="completed" @selected(old('status', $task->status ?? '') == 'completed')>Completed</option>
            </select>
        </div>
    </div>

    {{-- ─── Due Date + Due Time ────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Due Date</label>
            <input type="date" name="due_date"
                value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
            @error('due_date')
                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Due Time
                <span class="font-normal text-gray-400 ml-1">(optional)</span>
            </label>
            <input type="time" name="due_time"
                value="{{ old('due_time', isset($task) && $task->due_time ? \Carbon\Carbon::parse($task->due_time)->format('H:i') : '') }}"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
        </div>
    </div>

    {{-- ─── Recurring Task ─────────────────────────────────────── --}}
    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4 border dark:border-white/[0.06] border-black/[0.05]">
        <label class="flex items-center gap-2.5 cursor-pointer">
            <input type="checkbox" name="is_recurring" value="1" id="recurringToggle"
                class="w-4 h-4 rounded border-gray-300 accent-orange-500" @checked(old('is_recurring', $task->is_recurring ?? false))>
            <span class="text-[13px] font-bold dark:text-white text-gray-800">
                <i class="fas fa-redo-alt mr-1.5 text-orange-400"></i>Recurring Task
            </span>
            <span class="text-[11px] dark:text-white text-gray-800 ml-1">
                — auto-creates next task on completion
            </span>
        </label>

        <div id="recurringFields" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4"
            style="{{ old('is_recurring', $task->is_recurring ?? false) ? '' : 'display:none' }}">

            <div>
                <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Repeat Type</label>
                <select name="recurring_type"
                    class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                    dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
                    dark:border dark:border-white/[0.1] border border-black/[0.1]">
                    <option value="">Select type</option>
                    <option value="daily" @selected(old('recurring_type', $task->recurring_type ?? '') == 'daily')>Daily</option>
                    <option value="weekly" @selected(old('recurring_type', $task->recurring_type ?? '') == 'weekly')>Weekly</option>
                    <option value="monthly" @selected(old('recurring_type', $task->recurring_type ?? '') == 'monthly')>Monthly</option>
                </select>
                @error('recurring_type')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Recurring End Date
                    <span class="font-normal text-gray-400 ml-1">(optional)</span>
                </label>
                <input type="date" name="recurring_end_date"
                    value="{{ old('recurring_end_date', isset($task) && $task->recurring_end_date ? $task->recurring_end_date->format('Y-m-d') : '') }}"
                    class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                    dark:bg-[#1a1625] bg-white dark:text-white text-gray-800
                    dark:border dark:border-white/[0.1] border border-black/[0.1]">
                @error('recurring_end_date')
                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- ─── Reminder ───────────────────────────────────────────── --}}
    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4 border dark:border-white/[0.06] border-black/[0.05]">
        <label class="flex items-center gap-2.5 cursor-pointer">
            <input type="checkbox" name="reminder_enabled" value="1" id="reminderToggle"
                class="w-4 h-4 rounded border-gray-300 accent-orange-500" @checked(old('reminder_enabled', $task->reminder_enabled ?? false))>
            <span class="text-[13px] font-bold dark:text-white text-gray-800">
                <i class="fas fa-bell mr-1.5 text-orange-400"></i>Enable Reminder
            </span>
        </label>

        <div id="reminderField" class="mt-4"
            style="{{ old('reminder_enabled', $task->reminder_enabled ?? false) ? '' : 'display:none' }}">
            <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-1.5">Remind me at</label>
            <input type="datetime-local" name="remind_at"
                value="{{ old('remind_at', isset($task) && $task->remind_at ? $task->remind_at->format('Y-m-d\TH:i') : '') }}"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                dark:border dark:border-white/[0.1] border border-black/[0.1]">
            @error('remind_at')
                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- ─── Labels ─────────────────────────────────────────────── --}}
    <div>
        <label class="block text-[12px] font-bold dark:text-white text-gray-800 mb-2">Labels</label>
        @if ($labels->count())
            <div class="flex flex-wrap gap-2">
                @foreach ($labels as $label)
                    @php
                        $lc =
                            [
                                'red' => 'border-red-500/30 dark:text-red-400 text-red-600',
                                'orange' => 'border-orange-500/30 dark:text-orange-400 text-orange-600',
                                'yellow' => 'border-yellow-500/30 dark:text-yellow-400 text-yellow-600',
                                'green' => 'border-emerald-500/30 dark:text-emerald-400 text-emerald-600',
                                'blue' => 'border-blue-500/30 dark:text-blue-400 text-blue-600',
                                'purple' => 'border-purple-500/30 dark:text-purple-400 text-purple-600',
                                'pink' => 'border-pink-500/30 dark:text-pink-400 text-pink-600',
                            ][$label->color] ?? 'border-white/10 dark:text-gray-300 text-gray-600';
                    @endphp
                    <label
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-[8px] text-[12px] font-semibold
                        cursor-pointer dark:bg-white/[0.06] bg-gray-100
                        border dark:border-white/[0.08] border-black/[0.06] {{ $lc }}">
                        <input type="checkbox" name="labels[]" value="{{ $label->id }}" class="accent-orange-500"
                            @checked(isset($task) && $task->labels->contains($label->id))>
                        {{ $label->name }}
                    </label>
                @endforeach
            </div>
        @else
            <p class="text-[12px] dark:text-white text-gray-800 italic">
                No labels yet — use the quick add panel above.
            </p>
        @endif
    </div>

    {{-- ─── Buttons ────────────────────────────────────────────── --}}
    <div class="flex items-center justify-end gap-2 pt-3 border-t dark:border-white/[0.06] border-black/[0.05]">
        <a href="{{ route('user.tasks.index') }}"
            class="px-4 py-2 rounded-[10px] text-[14px] font-bold
            dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
            <i class="fas fa-times"></i> Cancel
        </a>
        <button type="submit"
            class="px-5 py-2 rounded-[10px] text-white text-[14px] font-bold
            bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
            <i class="fas fa-save"></i> Save Task
        </button>
    </div>
</section>

{{-- ─── Toggle JS ──────────────────────────────────────────────── --}}
<script>
    document.getElementById('recurringToggle').addEventListener('change', function() {
        document.getElementById('recurringFields').style.display = this.checked ? '' : 'none';
    });
    document.getElementById('reminderToggle').addEventListener('change', function() {
        document.getElementById('reminderField').style.display = this.checked ? '' : 'none';
    });
</script>
