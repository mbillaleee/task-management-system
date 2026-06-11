@extends('user.layouts.master')

@section('user')
    <div class="space-y-5">

        <!-- Header / Hero -->
        <section
            class="relative overflow-hidden rounded-2xl border dark:border-orange-500/[0.18] border-orange-200/70
        dark:bg-[#100b18] bg-orange-50/70 px-6 py-6">

            <div class="absolute inset-0 opacity-40 pointer-events-none"
                style="background:
            radial-gradient(circle at 80% 30%, rgba(236,72,153,.35), transparent 35%),
            radial-gradient(circle at 20% 70%, rgba(249,115,22,.25), transparent 32%);">
            </div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                <div>
                    <p class="text-[14px] font-semibold text-orange-400 mb-2">Notes Workspace</p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('user.note-folders.index') }}"
                        class="px-6 py-3 rounded-xl text-[15px] font-bold
                    dark:bg-white/[0.07] bg-white
                    dark:text-gray-300 text-gray-700
                    border dark:border-white/[0.08] border-black/[0.08]">
                        <i class="fas fa-list"></i> Folder
                    </a>
                    <a href="{{ route('user.note-categories.index') }}"
                        class="px-6 py-3 rounded-xl text-[15px] font-bold
                    dark:bg-white/[0.07] bg-white
                    dark:text-gray-300 text-gray-700
                    border dark:border-white/[0.08] border-black/[0.08]">
                        <i class="fas fa-list"></i> Category
                    </a>
                    <a href="{{ route('user.notes.create') }}"
                        class="px-6 py-3 rounded-xl text-white text-[15px] font-bold
                    bg-gradient-to-r from-orange-500 to-pink-500
                    shadow-[0_0_28px_rgba(249,115,22,.45)]">
                        <i class="fas fa-plus"></i> Create Note
                    </a>
                </div>
            </div>
        </section>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                <p class="text-[15px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Total Notes</p>
                <h3 class="text-[36px] font-extrabold dark:text-white text-gray-900 leading-none">
                    {{ $totalNotes ?? $notes->total() }}
                </h3>
                <p class="text-[14px] text-orange-400 mt-2">All saved notes</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                <p class="text-[15px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Pinned</p>
                <h3 class="text-[36px] font-extrabold text-pink-500 leading-none">
                    {{ $pinnedNotes ?? 0 }}
                </h3>
                <p class="text-[14px] text-pink-400 mt-2">Important notes</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                <p class="text-[15px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Favorites</p>
                <h3 class="text-[36px] font-extrabold text-amber-500 leading-none">
                    {{ $favoriteNotes ?? 0 }}
                </h3>
                <p class="text-[14px] text-amber-500 mt-2">Loved notes</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-pink-500/[0.18] border-orange-100 rounded-2xl p-[18px]">
                <p class="text-[15px] font-semibold dark:text-gray-400 text-gray-500 mb-3">Folders</p>
                <h3 class="text-[36px] font-extrabold text-emerald-500 leading-none">
                    {{ $folders->count() ?? 0 }}
                </h3>
                <p class="text-[14px] text-emerald-500 mt-2">Organized spaces</p>
            </div>
        </div>

        <!-- Main Panel -->
        <section
            class="rounded-2xl border dark:border-orange-500/[0.18] border-orange-200
        dark:bg-[#0f0b18] bg-orange-50/50 p-5 space-y-5 shadow-[0_0_35px_rgba(249,115,22,.12)]">

            <!-- Filter Header -->
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
                <div>
                    <h2 class="text-[22px] font-extrabold dark:text-white text-gray-900">All Notes</h2>
                    <p class="text-[13px] dark:text-gray-500 text-gray-500 mt-1">
                        Search, filter and manage your saved notes.
                    </p>
                </div>

                <form method="GET" action="{{ route('user.notes.index') }}"
                    class="flex flex-col md:flex-row gap-2.5 w-full xl:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search notes..."
                        class="w-full md:w-[260px] px-4 py-3 rounded-xl text-[14px] outline-none
            dark:bg-[#1a1625] bg-white dark:text-gray-200 text-gray-700
            border dark:border-white/[0.1] border-orange-200
            focus:border-orange-400 focus:ring-2 focus:ring-orange-500/20">

                    {{-- Folder Select With Add/Edit --}}
                    <div class="flex gap-2">
                        <select name="folder" id="folderSelect"
                            class="w-full md:w-[180px] px-4 py-3 rounded-xl text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                border dark:border-white/[0.1] border-orange-200">
                            <option value="">All Folders</option>
                            @foreach ($folders as $folder)
                                <option value="{{ $folder->id }}" data-name="{{ $folder->name }}"
                                    @selected(request('folder') == $folder->id)>
                                    {{ $folder->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Category Select With Add/Edit --}}
                    <div class="flex gap-2">
                        <select name="category" id="categorySelect"
                            class="w-full md:w-[180px] px-4 py-3 rounded-xl text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                border dark:border-white/[0.1] border-orange-200">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" data-name="{{ $category->name }}"
                                    @selected(request('category') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tag Filter --}}
                    @if ($userTags->count())
                        <div class="flex gap-2">
                            <select name="tag"
                                class="w-full md:w-[160px] px-4 py-3 rounded-xl text-[14px] outline-none
                dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700
                border dark:border-white/[0.1] border-orange-200">
                                <option value="">All Tags</option>
                                @foreach ($userTags as $userTag)
                                    <option value="{{ $userTag->slug }}" @selected(request('tag') == $userTag->slug)>
                                        #{{ $userTag->name }} ({{ $userTag->notes_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <button
                        class="px-5 py-3 rounded-xl text-white text-[14px] font-bold
            bg-gradient-to-r from-orange-500 to-pink-500
            shadow-[0_4px_18px_rgba(249,115,22,.35)]">
                        Filter
                    </button>
                </form>
            </div>

            {{-- Active tag filter indicator --}}
            @if (request('tag'))
                <div
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl
            dark:bg-orange-500/10 bg-orange-50 border dark:border-orange-500/20 border-orange-200">
                    <span class="text-[13px] dark:text-gray-400 text-gray-600">Filtered by tag:</span>
                    <span
                        class="px-2.5 py-1 rounded-lg text-[12px] font-bold
                dark:bg-orange-500/20 bg-orange-100 text-orange-500">
                        #{{ request('tag') }}
                    </span>
                    <a href="{{ route('user.notes.index', array_filter(request()->except('tag', 'page'))) }}"
                        class="ml-auto text-[12px] text-red-400 hover:text-red-300 font-bold transition">
                        ✕ Clear filter
                    </a>
                </div>
            @endif

            @if (session('success'))
                <div
                    class="rounded-xl px-4 py-3 text-[14px] font-semibold
                bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Notes Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @forelse($notes as $note)
                    <div
                        class="group hover-lift relative overflow-hidden rounded-2xl p-5
                    dark:bg-[#17141f] bg-white
                    border dark:border-pink-500/[0.18] border-orange-100
                    shadow-[0_0_25px_rgba(249,115,22,0.06)]
                    hover:shadow-[0_0_35px_rgba(236,72,153,0.16)]
                    transition-all duration-300">

                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none"
                            style="background: radial-gradient(circle at 20% 25%, rgba(249,115,22,.14), transparent 35%),
                        radial-gradient(circle at 90% 70%, rgba(236,72,153,.12), transparent 35%);">
                        </div>

                        <div class="relative z-10">
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        @if ($note->is_pinned)
                                            <span class="text-[18px]">📌</span>
                                        @endif

                                        @if ($note->is_favorite)
                                            <span class="text-[18px]">⭐</span>
                                        @endif
                                    </div>

                                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900 line-clamp-1">
                                        {{ $note->title }}
                                    </h3>
                                </div>

                                <span
                                    class="px-2.5 py-1 rounded-lg text-[12px] font-bold
                                dark:bg-orange-500/[0.14] bg-orange-50 text-orange-500
                                border dark:border-orange-500/[0.22] border-orange-200">
                                    {{ ucfirst($note->status) }}
                                </span>
                            </div>

                            <p class="text-[14px] leading-[1.7] dark:text-gray-400 text-gray-500 min-h-[72px] line-clamp-3">
                                {{ Str::limit(strip_tags($note->content), 150) ?: 'No content added yet.' }}
                            </p>

                            <div class="flex flex-wrap gap-2 mt-4">
                                @if ($note->folder)
                                    <span
                                        class="px-2.5 py-1 rounded-lg text-[12px] font-semibold dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600">
                                        📁 {{ $note->folder->name }}
                                    </span>
                                @endif

                                @if ($note->category)
                                    <span
                                        class="px-2.5 py-1 rounded-lg text-[12px] font-semibold dark:bg-pink-500/[0.12] bg-pink-50 text-pink-500">
                                        {{ $note->category->name }}
                                    </span>
                                @endif
                            </div>

                            @if ($note->tags->count())
                                <div class="flex flex-wrap gap-2 mt-3">
                                    @foreach ($note->tags as $tag)
                                        <a href="{{ route('user.notes.index', ['tag' => $tag->slug]) }}"
                                            class="px-2 py-1 rounded-lg text-[11px] font-semibold transition
                                        dark:bg-[#21192c] bg-orange-50 dark:text-gray-400 text-orange-600
                                        hover:dark:bg-orange-500/20 hover:bg-orange-100 hover:text-orange-500">
                                            #{{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <div
                                class="flex items-center justify-between mt-5 pt-4 border-t dark:border-white/[0.06] border-black/[0.05]">
                                <p class="text-[12px] dark:text-gray-500 text-gray-400">
                                    {{ $note->updated_at->diffForHumans() }}
                                </p>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('user.notes.show', $note) }}"
                                        class="px-3 py-2 rounded-lg text-[12px] font-bold
                                    dark:text-white text-gray-700
                                    border dark:border-white/[0.1] border-gray-200
                                    dark:bg-white/[0.03] bg-white">
                                        View
                                    </a>

                                    <a href="{{ route('user.notes.edit', $note) }}"
                                        class="px-3 py-2 rounded-lg text-[12px] font-bold text-white
                                    bg-gradient-to-r from-orange-500 to-pink-500">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 xl:col-span-3">
                        <div
                            class="rounded-2xl p-10 text-center dark:bg-[#17141f] bg-white border dark:border-white/[0.08] border-orange-100">
                            <div class="text-[52px] mb-3">📝</div>
                            <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900">No notes found</h3>
                            <p class="text-[14px] dark:text-gray-500 text-gray-500 mt-2">Start by creating your first note.
                            </p>

                            <a href="{{ route('user.notes.create') }}"
                                class="inline-flex mt-5 px-6 py-3 rounded-xl text-white text-[14px] font-bold
                            bg-gradient-to-r from-orange-500 to-pink-500">
                                + Create Note
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div>
                {{ $notes->links() }}
            </div>
        </section>
    </div>
@endsection
