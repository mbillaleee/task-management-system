<section class="space-y-5">

    {{-- Title --}}
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Journal Title</label>
        <input type="text" name="title" value="{{ old('title', $journal->title ?? '') }}"
            placeholder="Enter journal title"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
        @error('title')
            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Writing Prompt (optional quick pick) --}}
    @if (!empty($prompts))
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
                Writing Prompt
                <span class="font-normal dark:text-gray-500 text-gray-400 ml-1">(optional)</span>
            </label>
            <div class="flex gap-2">
                <input type="text" name="prompt" id="promptInput"
                    value="{{ old('prompt', $journal->prompt ?? '') }}" placeholder="Write your own or pick one below…"
                    class="flex-1 px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <button type="button" onclick="pickRandomPrompt()"
                    class="px-3 py-2 rounded-[10px] text-[13px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-600 whitespace-nowrap">
                    🎲 Random
                </button>
            </div>
            <div class="mt-2 flex flex-wrap gap-1.5">
                @foreach (array_slice($prompts, 0, 4) as $p)
                    <button type="button"
                        onclick="document.getElementById('promptInput').value = '{{ addslashes($p) }}'"
                        class="px-2.5 py-1 rounded-lg text-[11px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-400 text-gray-500 hover:text-orange-500 dark:hover:text-orange-400">
                        {{ $p }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Content --}}
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
            Content
            <span id="wordCount" class="font-normal dark:text-gray-500 text-gray-400 ml-2">0 words</span>
        </label>
        <textarea name="content" id="journalContent" rows="10" placeholder="Write your journal entry here…"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none resize-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">{{ old('content', $journal->content ?? '') }}</textarea>
        @error('content')
            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Row: Category / Type / Mood / Date --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Category</label>
            <select name="journal_category_id"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="">No Category</option>
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
                <option value="daily" @selected(old('type', $journal->type ?? 'daily') == 'daily')>📝 Daily Journal</option>
                <option value="gratitude" @selected(old('type', $journal->type ?? '') == 'gratitude')>🙏 Gratitude</option>
                <option value="reflection" @selected(old('type', $journal->type ?? '') == 'reflection')>💭 Reflection</option>
                <option value="personal_log" @selected(old('type', $journal->type ?? '') == 'personal_log')>📔 Personal Log</option>
            </select>
        </div>

        <div>
            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Mood</label>
            <select name="mood"
                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 dark:border dark:border-white/[0.1] border border-black/[0.1]">
                <option value="">No Mood</option>
                @foreach (['happy' => '😊 Happy', 'calm' => '😌 Calm', 'neutral' => '😐 Neutral', 'sad' => '😢 Sad', 'angry' => '😠 Angry', 'stressed' => '😤 Stressed', 'excited' => '🤩 Excited'] as $val => $label)
                    <option value="{{ $val }}" @selected(old('mood', $journal->mood ?? '') == $val)>
                        {{ $label }}
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

    {{-- Gratitude Notes --}}
    <div>
        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
            🙏 Gratitude Notes
            <span class="font-normal dark:text-gray-500 text-gray-400 ml-1">(optional)</span>
        </label>
        <textarea name="gratitude_notes" rows="3" placeholder="Write 3 things you are grateful for today…"
            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none resize-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">{{ old('gratitude_notes', $journal->gratitude_notes ?? '') }}</textarea>
    </div>

    {{-- Checkboxes --}}
    <div class="flex flex-wrap items-center gap-4">
        <label class="flex items-center gap-2 text-[14px] font-bold dark:text-gray-300 text-gray-700 cursor-pointer">
            <input type="checkbox" name="is_private" value="1" @checked(old('is_private', $journal->is_private ?? true))
                class="w-4 h-4 accent-orange-500">
            🔒 Private
        </label>

        <label class="flex items-center gap-2 text-[14px] font-bold dark:text-gray-300 text-gray-700 cursor-pointer">
            <input type="checkbox" name="is_favorite" value="1" @checked(old('is_favorite', $journal->is_favorite ?? false))
                class="w-4 h-4 accent-yellow-400">
            ★ Mark as Favorite
        </label>
    </div>

    {{-- Actions --}}
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

<script>
    // Word count
    const content = document.getElementById('journalContent');
    const wc = document.getElementById('wordCount');

    function countWords() {
        const words = content.value.trim().split(/\s+/).filter(w => w.length > 0);
        wc.textContent = words.length + ' word' + (words.length !== 1 ? 's' : '');
    }
    if (content) {
        content.addEventListener('input', countWords);
        countWords();
    }

    // Random prompt picker
    const prompts = @json($prompts ?? []);

    function pickRandomPrompt() {
        if (!prompts.length) return;
        const r = prompts[Math.floor(Math.random() * prompts.length)];
        document.getElementById('promptInput').value = r;
    }
</script>
