@extends('user.layouts.master')

@section('user')
    <div class="space-y-5">

        <section class="relative overflow-hidden rounded-2xl border  veroa-card px-6 py-6">
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        @if ($note->is_pinned)
                            <span class="text-[20px]">📌</span>
                        @endif

                        @if ($note->is_favorite)
                            <span class="text-[20px]">⭐</span>
                        @endif

                        <span
                            class="px-3 py-1 rounded-lg text-[12px] font-bold
                        dark:bg-orange-500/[0.14] bg-orange-50 text-orange-500
                        border dark:border-orange-500/[0.22] border-orange-200">
                            <i class="fa-solid fa-info-circle"></i> {{ ucfirst($note->status) }}
                        </span>
                    </div>

                    <h1 class="text-[34px] sm:text-[42px] font-extrabold leading-[1.1] dark:text-white text-gray-900">
                        <i class="fa-solid fa-sticky-note"></i> {{ $note->title }}
                    </h1>

                    <p class="text-[14px] dark:text-gray-500 text-gray-500 mt-3">
                        <i class="fa-solid fa-clock"></i> Last edited:
                        {{ $note->last_edited_at ? $note->last_edited_at->format('d M Y, h:i A') : $note->updated_at->format('d M Y, h:i A') }}
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <a href="{{ route('user.notes.index') }}"
                        class="px-5 py-3 rounded-xl text-[14px] font-bold
                    dark:text-white text-gray-800 border dark:border-white/[0.14] border-orange-200
                    dark:bg-white/[0.03] bg-white/70">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </a>

                    <a href="{{ route('user.notes.edit', $note) }}"
                        class="px-5 py-3 rounded-xl text-white text-[14px] font-bold
                    bg-gradient-to-r from-orange-500 to-pink-500
                    shadow-[0_4px_18px_rgba(249,115,22,.35)]">
                        <i class="fa-solid fa-edit"></i> Edit Note
                    </a>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 xl:grid-cols-[1fr_320px] gap-5">

            <!-- Content -->
            <section
                class="rounded-2xl border dark:border-pink-500/15 bg-[#f7e4c3]/75
            dark:bg-[#080612]  backdrop-blur-xl  p-6  space-y-6
            shadow-[inset_0_1px_0_rgba(255,255,255,.65),0_20px_50px_rgba(180,95,20,.12),0_8px_20px_rgba(255,140,20,.08)]
            dark:shadow-[inset_0_1px_0_rgba(255,255,255,.03)] p-6">

                <div class="rounded-2xl p-6 min-h-[420px]  veroa-card">
                    <div class="prose max-w-none dark:prose-invert">
                        <div class="text-[15px] leading-[1.9] dark:text-gray-300 text-gray-700 whitespace-pre-line">
                            <i class="fa-solid fa-align-left"></i> {!! $note->content ?: 'No content added yet.' !!}
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sidebar -->
            <aside class="space-y-4">

                <div class="rounded-2xl p-5 veroa-card">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900 mb-4">
                        Note Details
                    </h3>

                    <div class="space-y-3 text-[14px]">
                        <div>
                            <p class="dark:text-gray-500 text-gray-400 mb-1">Folder</p>
                            <p class="font-bold dark:text-gray-200 text-gray-800">
                                {{ $note->folder?->name ?? 'No Folder' }}
                            </p>
                        </div>

                        <div>
                            <p class="dark:text-gray-500 text-gray-400 mb-1">Category</p>
                            <p class="font-bold dark:text-gray-200 text-gray-800">
                                {{ $note->category?->name ?? 'No Category' }}
                            </p>
                        </div>

                        <div>
                            <p class="dark:text-gray-500 text-gray-400 mb-1">Type</p>
                            <p class="font-bold dark:text-gray-200 text-gray-800">
                                {{ ucfirst($note->type) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl p-5 veroa-card">
                    <h3
                        class="text-[16px] font-extrabold dark:text-white text-gray-900 mb-3 flex items-center justify-between">
                        Tags
                        <span class="text-[12px] font-normal dark:text-gray-500 text-gray-400">{{ $note->tags->count() }}
                            tag(s)</span>
                    </h3>

                    {{-- Existing Tags (clickable filter + remove) --}}
                    <div class="flex flex-wrap gap-2 mb-3">
                        @forelse($note->tags as $tag)
                            <div
                                class="group flex items-center gap-1 px-2.5 py-1.5 rounded-lg
                            dark:bg-[#21192c] bg-orange-50 border dark:border-white/[0.06] border-orange-100">
                                <a href="{{ route('user.notes.index', ['tag' => $tag->slug]) }}"
                                    class="text-[12px] font-semibold dark:text-gray-300 text-orange-600 hover:text-orange-400 transition">
                                    #{{ $tag->name }}
                                </a>
                                {{-- Remove tag button --}}
                                <form action="{{ route('user.notes.tags.destroy', [$note, $tag]) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Remove tag"
                                        onclick="return confirm('Remove tag #{{ $tag->name }}?')"
                                        class="text-[14px] leading-none dark:text-gray-600 text-gray-400
                                    hover:text-red-400 transition ml-0.5 opacity-0- group-hover:opacity-100">
                                        <i class="fa-solid fa-xmark text-xl- text-red-900"></i>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-[13px] dark:text-gray-600 text-gray-400 italic">No tags yet.</p>
                        @endforelse
                    </div>

                    {{-- Add new tag inline --}}
                    <form action="{{ route('user.notes.tags.store', $note) }}" method="POST" class="flex gap-2 mt-2">
                        @csrf
                        <input type="text" name="name" placeholder="Add a tag..." maxlength="50"
                            class="flex-1 px-3 py-2 rounded-lg text-[13px] outline-none
                        dark:bg-[#100b18] bg-orange-50/60
                        dark:text-gray-300 text-gray-700
                        border dark:border-white/[0.1] border-orange-200
                        focus:border-orange-400 focus:ring-1 focus:ring-orange-500/20"
                            required>
                        <button type="submit"
                            class="px-3 py-2 rounded-lg text-white text-[13px] font-bold
                        bg-gradient-to-r from-orange-500 to-pink-500 shrink-0">
                            <i class="fa-solid fa-plus"></i> Add
                        </button>
                    </form>
                    <p class="text-[11px] dark:text-gray-600 text-gray-400 mt-1.5">
                        Hover a tag to remove it. Click to filter notes by tag.
                    </p>
                </div>

                <div class="rounded-2xl p-5 veroa-card space-y-3">
                    <form action="{{ route('user.notes.toggle-pin', $note) }}" method="POST">
                        @csrf
                        <button
                            class="w-full px-4 py-3 rounded-xl text-[14px] font-bold
                        dark:text-white text-gray-800 border dark:border-white/[0.12] border-orange-200
                        dark:bg-white/[0.03] bg-white">
                            <i class="fa-solid fa-thumbtack"></i> {{ $note->is_pinned ? 'Unpin Note' : 'Pin Note' }}
                        </button>
                    </form>

                    <form action="{{ route('user.notes.toggle-favorite', $note) }}" method="POST">
                        @csrf
                        <button
                            class="w-full px-4 py-3 rounded-xl text-[14px] font-bold text-white
                        bg-gradient-to-r from-orange-500 to-pink-500">
                            {{ $note->is_favorite ? 'Remove Favorite' : 'Add Favorite' }}
                        </button>
                    </form>

                    <form action="{{ route('user.notes.destroy', $note) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button onclick="return confirm('Delete this note?')"
                            class="w-full px-4 py-3 rounded-xl text-[14px] font-bold
                        bg-red-500/10 text-red-500 border border-red-500/20">
                            <i class="fa-solid fa-trash-can"></i> Delete Note
                        </button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
@endsection
