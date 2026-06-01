@php
    $selectedTags = $note ? $note->tags->pluck('name')->implode(', ') : '';
@endphp

<section
    class="rounded-2xl border dark:border-orange-500/[0.18] border-orange-200
    dark:bg-[#0f0b18] bg-orange-50/50 p-5 shadow-[0_0_35px_rgba(249,115,22,.12)]">

    <div class="grid grid-cols-1 xl:grid-cols-[1fr_340px] gap-5">

        <!-- Main Form -->
        <div class="rounded-2xl p-5 dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100">

            <div class="mb-5">
                <label class="block text-[14px] font-bold dark:text-gray-300 text-gray-700 mb-2">
                    Note Title
                </label>

                <input type="text" name="title"
                    value="{{ old('title', $note->title ?? '') }}"
                    placeholder="Enter note title..."
                    class="w-full px-4 py-3 rounded-xl text-[15px] outline-none
                    dark:bg-[#100b18] bg-orange-50/60
                    dark:text-white text-gray-900
                    border dark:border-white/[0.1] border-orange-200
                    focus:border-orange-400 focus:ring-2 focus:ring-orange-500/20"
                    required>

                @error('title')
                    <p class="text-[13px] text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-[14px] font-bold dark:text-gray-300 text-gray-700 mb-2">
                    Content
                </label>

                <textarea name="content" rows="18"
                    placeholder="Write your note here..."
                    class="w-full px-4 py-4 rounded-xl text-[15px] leading-[1.8] outline-none resize-y
                    dark:bg-[#100b18] bg-orange-50/60
                    dark:text-gray-200 text-gray-800
                    border dark:border-white/[0.1] border-orange-200
                    focus:border-orange-400 focus:ring-2 focus:ring-orange-500/20">{{ old('content', $note->content ?? '') }}</textarea>

                @error('content')
                    <p class="text-[13px] text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Sidebar Settings -->
        <div class="space-y-4">

            <div class="rounded-2xl p-5 dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100">
                <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900 mb-4">
                    Organization
                </h3>

                <div class="space-y-4">

                    <div>
                        <label class="block text-[13px] font-bold dark:text-gray-400 text-gray-600 mb-2">
                            Folder
                        </label>

                        <select name="note_folder_id"
                            class="w-full px-4 py-3 rounded-xl text-[14px] outline-none
                            dark:bg-[#100b18] bg-orange-50/60
                            dark:text-gray-300 text-gray-700
                            border dark:border-white/[0.1] border-orange-200">
                            <option value="">No Folder</option>
                            @foreach($folders as $folder)
                                <option value="{{ $folder->id }}"
                                    @selected(old('note_folder_id', $note->note_folder_id ?? '') == $folder->id)>
                                    {{ $folder->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[13px] font-bold dark:text-gray-400 text-gray-600 mb-2">
                            Category
                        </label>

                        <select name="note_category_id"
                            class="w-full px-4 py-3 rounded-xl text-[14px] outline-none
                            dark:bg-[#100b18] bg-orange-50/60
                            dark:text-gray-300 text-gray-700
                            border dark:border-white/[0.1] border-orange-200">
                            <option value="">No Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    @selected(old('note_category_id', $note->note_category_id ?? '') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[13px] font-bold dark:text-gray-400 text-gray-600 mb-2">
                            Tags
                        </label>

                        <input type="text" name="tags"
                            value="{{ old('tags', $selectedTags) }}"
                            placeholder="work, idea, personal"
                            class="w-full px-4 py-3 rounded-xl text-[14px] outline-none
                            dark:bg-[#100b18] bg-orange-50/60
                            dark:text-gray-300 text-gray-700
                            border dark:border-white/[0.1] border-orange-200">

                        <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-2">
                            Separate tags with comma.
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl p-5 dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100">
                <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900 mb-4">
                    Note Settings
                </h3>

                <div class="space-y-4">

                    <div>
                        <label class="block text-[13px] font-bold dark:text-gray-400 text-gray-600 mb-2">
                            Type
                        </label>

                        <select name="type"
                            class="w-full px-4 py-3 rounded-xl text-[14px] outline-none
                            dark:bg-[#100b18] bg-orange-50/60
                            dark:text-gray-300 text-gray-700
                            border dark:border-white/[0.1] border-orange-200">
                            <option value="text" @selected(old('type', $note->type ?? 'text') == 'text')>
                                Text
                            </option>
                            <option value="checklist" @selected(old('type', $note->type ?? '') == 'checklist')>
                                Checklist
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[13px] font-bold dark:text-gray-400 text-gray-600 mb-2">
                            Status
                        </label>

                        <select name="status"
                            class="w-full px-4 py-3 rounded-xl text-[14px] outline-none
                            dark:bg-[#100b18] bg-orange-50/60
                            dark:text-gray-300 text-gray-700
                            border dark:border-white/[0.1] border-orange-200">
                            <option value="draft" @selected(old('status', $note->status ?? 'draft') == 'draft')>
                                Draft
                            </option>
                            <option value="published" @selected(old('status', $note->status ?? '') == 'published')>
                                Published
                            </option>
                            <option value="archived" @selected(old('status', $note->status ?? '') == 'archived')>
                                Archived
                            </option>
                        </select>
                    </div>

                    <label class="flex items-center justify-between gap-3 cursor-pointer">
                        <span class="text-[14px] font-bold dark:text-gray-300 text-gray-700">
                            Pin Note
                        </span>

                        <input type="checkbox" name="is_pinned" value="1"
                            class="w-5 h-5 rounded border-orange-300 text-orange-500 focus:ring-orange-500"
                            @checked(old('is_pinned', $note->is_pinned ?? false))>
                    </label>

                    <label class="flex items-center justify-between gap-3 cursor-pointer">
                        <span class="text-[14px] font-bold dark:text-gray-300 text-gray-700">
                            Add to Favorite
                        </span>

                        <input type="checkbox" name="is_favorite" value="1"
                            class="w-5 h-5 rounded border-orange-300 text-pink-500 focus:ring-pink-500"
                            @checked(old('is_favorite', $note->is_favorite ?? false))>
                    </label>
                </div>
            </div>

            <button type="submit"
                class="w-full px-5 py-3.5 rounded-xl text-white text-[15px] font-extrabold
                bg-gradient-to-r from-orange-500 to-pink-500
                shadow-[0_4px_22px_rgba(249,115,22,.42)]">
                {{ $buttonText }}
            </button>

        </div>
    </div>
</section>