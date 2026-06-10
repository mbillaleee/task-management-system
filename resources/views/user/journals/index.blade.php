@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    Journal Workspace
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Daily journal, mood tracking, gratitude and personal reflections.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('user.journal.categories.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                    <i class="fas fa-list"></i> Categories
                </a>

                <a href="{{ route('user.journals.statistics') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                    <i class="fas fa-chart-bar"></i> Statistics
                </a>

                <a href="{{ route('user.journals.create') }}"
                    class="flex items-center justify-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    + New Entry
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-bold">Total Journals</p>
                <h3 class="text-[34px] font-black dark:text-white text-gray-900 mt-2">{{ $totalJournals }}</h3>
                <p class="text-[13px] text-orange-400 font-bold">All personal logs</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-bold">Today</p>
                <h3 class="text-[34px] font-black text-pink-400 mt-2">{{ $todayJournals }}</h3>
                <p class="text-[13px] text-pink-400 font-bold">Today's entries</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-bold">Gratitude</p>
                <h3 class="text-[34px] font-black text-emerald-400 mt-2">{{ $gratitudeCount }}</h3>
                <p class="text-[13px] text-emerald-400 font-bold">Gratitude journals</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-bold">Favorites</p>
                <h3 class="text-[34px] font-black text-yellow-400 mt-2">{{ $favoriteCount }}</h3>
                <p class="text-[13px] text-yellow-400 font-bold">Important logs</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-bold">Writing Streak</p>
                <h3 class="text-[34px] font-black text-purple-400 mt-2">{{ $writingStreak }}</h3>
                <p class="text-[13px] text-purple-400 font-bold">
                    {{ $writingStreak === 1 ? 'day' : 'days' }} in a row
                </p>
            </div>
        </div>

        {{-- Filter + List --}}
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 mb-5">
                <div>
                    <h3 class="text-[20px] font-extrabold dark:text-white text-gray-900">Timeline View</h3>
                    <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-1">
                        Search, filter and manage journal entries.
                    </p>
                </div>

                <form method="GET" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                        class="col-span-2 md:col-span-3 lg:col-span-1 px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-white dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1]">

                    <select name="type"
                        class="px-3.5 py-2.5 rounded-[10px] text-[14px] dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.1] border-black/[0.1]">
                        <option value="">All Types</option>
                        <option value="daily" @selected(request('type') == 'daily')>Daily</option>
                        <option value="gratitude" @selected(request('type') == 'gratitude')>Gratitude</option>
                        <option value="reflection" @selected(request('type') == 'reflection')>Reflection</option>
                        <option value="personal_log" @selected(request('type') == 'personal_log')>Personal Log</option>
                    </select>

                    <select name="mood"
                        class="px-3.5 py-2.5 rounded-[10px] text-[14px] dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.1] border-black/[0.1]">
                        <option value="">All Moods</option>
                        @foreach (['happy', 'calm', 'neutral', 'sad', 'angry', 'stressed', 'excited'] as $mood)
                            <option value="{{ $mood }}" @selected(request('mood') == $mood)>
                                {{ ucfirst($mood) }}
                            </option>
                        @endforeach
                    </select>

                    <select name="journal_category_id"
                        class="px-3.5 py-2.5 rounded-[10px] text-[14px] dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.1] border-black/[0.1]">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(request('journal_category_id') == $cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <input type="date" name="journal_date" value="{{ request('journal_date') }}"
                        class="px-3.5 py-2.5 rounded-[10px] text-[14px] dark:bg-[#1a1625] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.1] border-black/[0.1]">

                    <div class="flex gap-2">
                        <button
                            class="flex-1 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                            Filter
                        </button>
                        @if (request()->hasAny(['search', 'type', 'mood', 'journal_category_id', 'journal_date', 'favorites']))
                            <a href="{{ route('user.journals.index') }}"
                                class="px-3 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-600">
                                ✕
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Quick filter tabs --}}
            <div class="flex flex-wrap items-center gap-2 mb-5">
                <a href="{{ route('user.journals.index') }}"
                    class="px-3 py-1.5 rounded-lg text-[12px] font-bold {{ !request()->hasAny(['type', 'mood', 'favorites']) ? 'bg-gradient-to-r from-orange-500 to-pink-500 text-white' : 'dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-600' }}">
                    All
                </a>
                @foreach ([
            'daily' => '📝 Daily',
            'gratitude' => '🙏 Gratitude',
            'reflection' => '💭 Reflection',
            'personal_log' => '📔 Personal Log',
        ] as $val => $label)
                    <a href="{{ route('user.journals.index', ['type' => $val]) }}"
                        class="px-3 py-1.5 rounded-lg text-[12px] font-bold {{ request('type') === $val ? 'bg-gradient-to-r from-orange-500 to-pink-500 text-white' : 'dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-600' }}">
                        {{ $label }}
                    </a>
                @endforeach
                <a href="{{ route('user.journals.index', ['favorites' => 1]) }}"
                    class="px-3 py-1.5 rounded-lg text-[12px] font-bold {{ request('favorites') ? 'bg-gradient-to-r from-yellow-400 to-orange-400 text-white' : 'dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-600' }}">
                    ★ Favorites
                </a>
            </div>

            <div class="space-y-4">
                @forelse($journals as $journal)
                    @php
                        $categoryColor = $journal->category?->color ?? '#f97316';
                        $moodEmojis = [
                            'happy' => '😊',
                            'calm' => '😌',
                            'neutral' => '😐',
                            'sad' => '😢',
                            'angry' => '😠',
                            'stressed' => '😤',
                            'excited' => '🤩',
                        ];
                        $emoji = $journal->mood ? $moodEmojis[$journal->mood] ?? '' : '';
                    @endphp

                    <div class="relative pl-6">
                        <div class="absolute left-[5px] top-2 bottom-0 w-[2px]" style="background: {{ $categoryColor }}">
                        </div>
                        <div class="absolute left-0 top-2 w-[12px] h-[12px] rounded-full shadow-lg"
                            style="background: {{ $categoryColor }}"></div>

                        <div
                            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="text-[16px] font-bold dark:text-white text-gray-900">
                                            {{ $journal->title }}
                                        </h3>
                                        @if ($journal->is_favorite)
                                            <span class="text-yellow-400 text-[14px]">★</span>
                                        @endif
                                        @if ($journal->is_private)
                                            <span
                                                class="px-1.5 py-[2px] rounded text-[10px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-400 text-gray-500">
                                                🔒 Private
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-1">
                                        {{ $journal->journal_date->format('d M, Y') }} •
                                        {{ ucwords(str_replace('_', ' ', $journal->type)) }}
                                        @if ($journal->category)
                                            • {{ $journal->category->name }}
                                        @endif
                                    </p>
                                </div>

                                @if ($journal->mood)
                                    <span class="flex-shrink-0 px-2.5 py-[4px] rounded-lg text-[12px] font-bold border"
                                        style="background: {{ $categoryColor }}22; color: {{ $categoryColor }}; border-color: {{ $categoryColor }}55;">
                                        {{ $emoji }} {{ ucfirst($journal->mood) }}
                                    </span>
                                @endif
                            </div>

                            @if ($journal->content)
                                <p class="text-[14px] dark:text-gray-400 text-gray-500 leading-relaxed mt-3">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($journal->content), 160) }}
                                </p>
                            @endif

                            <div
                                class="flex items-center justify-between mt-4 pt-4 border-t dark:border-white/[0.06] border-black/[0.05]">
                                <a href="{{ route('user.journals.show', $journal) }}"
                                    class="px-3 py-2 rounded-lg text-[14px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                                    View
                                </a>

                                <div class="flex items-center gap-2">
                                    <form action="{{ route('user.journals.favorite', $journal) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="px-3 py-2 rounded-lg text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                                            {{ $journal->is_favorite ? '★ Saved' : '☆ Save' }}
                                        </button>
                                    </form>

                                    <a href="{{ route('user.journals.edit', $journal) }}"
                                        class="px-3 py-2 rounded-lg text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                                        Edit
                                    </a>

                                    <form action="{{ route('user.journals.destroy', $journal) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete this journal entry?')"
                                            class="px-3 py-2 rounded-lg text-[14px] font-bold dark:bg-red-500/[0.15] bg-red-50 text-red-500">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="dark:bg-white/[0.03] bg-gray-50 border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-10 text-center">
                        <div class="text-5xl mb-3">📔</div>
                        <h3 class="text-[18px] font-bold dark:text-white text-gray-900">No journals found</h3>
                        <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-1">
                            @if (request()->hasAny(['search', 'type', 'mood', 'journal_category_id', 'journal_date', 'favorites']))
                                No entries match your current filters.
                            @else
                                Start writing your first journal entry today.
                            @endif
                        </p>
                        <a href="{{ route('user.journals.create') }}"
                            class="inline-block mt-4 px-5 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                            + New Entry
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $journals->links() }}
            </div>
        </div>

    </section>
@endsection
