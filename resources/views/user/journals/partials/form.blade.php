<section class="space-y-5">
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Journal Title</label>
        <input type="text" name="title" value="{{ old('title', $journal->title ?? '') }}"
            placeholder="Enter journal title"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
        @error('title')
            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Content</label>
        <textarea name="content" rows="7" placeholder="Write your journal..."
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none resize-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">{{ old('content', $journal->content ?? '') }}</textarea>
        @error('content')
            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Category</label>
            <select name="journal_category_id"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('journal_category_id', $journal->journal_category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Type</label>
            <select name="type"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="daily" @selected(old('type', $journal->type ?? 'daily') == 'daily')>Daily Journal</option>
                <option value="gratitude" @selected(old('type', $journal->type ?? '') == 'gratitude')>Gratitude Journal</option>
                <option value="reflection" @selected(old('type', $journal->type ?? '') == 'reflection')>Reflection Page</option>
                <option value="personal_log" @selected(old('type', $journal->type ?? '') == 'personal_log')>Personal Log</option>
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Mood</label>
            <select name="mood"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="">Select Mood</option>
                @foreach (['happy', 'calm', 'neutral', 'sad', 'angry', 'stressed', 'excited'] as $mood)
                    <option value="{{ $mood }}" @selected(old('mood', $journal->mood ?? '') == $mood)>
                        {{ ucfirst($mood) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Journal Date</label>
            <input type="date" name="journal_date"
                value="{{ old('journal_date', isset($journal) && $journal->journal_date ? $journal->journal_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 dark:border dark:border-white/[0.1] border border-black/[0.1]">
            @error('journal_date')
                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Writing Prompt</label>
        <input type="text" name="prompt" value="{{ old('prompt', $journal->prompt ?? '') }}"
            placeholder="Example: What did I learn today?"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
    </div>

    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Gratitude Notes</label>
        <textarea name="gratitude_notes" rows="3" placeholder="Write what you are grateful for..."
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none resize-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">{{ old('gratitude_notes', $journal->gratitude_notes ?? '') }}</textarea>
    </div>

    <div class="flex flex-wrap items-center gap-4">
        <label class="flex items-center gap-2 text-[14px] font-bold dark:text-gray-300 text-gray-700">
            <input type="checkbox" name="is_private" value="1" @checked(old('is_private', $journal->is_private ?? true))>
            Private Journal
        </label>

        <label class="flex items-center gap-2 text-[14px] font-bold dark:text-gray-300 text-gray-700">
            <input type="checkbox" name="is_favorite" value="1" @checked(old('is_favorite', $journal->is_favorite ?? false))>
            Mark as Favorite
        </label>
    </div>

    <div class="flex items-center justify-end gap-2 pt-3">
        <a href="{{ route('user.journals.index') }}"
            class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
            Cancel
        </a>

        <button type="submit"
            class="px-5 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
            Save Journal
        </button>
    </div>
</section>
