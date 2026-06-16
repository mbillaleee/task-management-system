@extends('user.layouts.master')

@section('user')
    @php
        $moodEmojis = [
            'happy' => '😊',
            'calm' => '😌',
            'neutral' => '😐',
            'sad' => '😢',
            'angry' => '😠',
            'stressed' => '😤',
            'excited' => '🤩',
        ];
        $moodColors = [
            'happy' => 'text-yellow-400',
            'calm' => 'text-blue-400',
            'neutral' => 'text-gray-400',
            'sad' => 'text-indigo-400',
            'angry' => 'text-red-400',
            'stressed' => 'text-orange-400',
            'excited' => 'text-pink-400',
        ];
        $emoji = $journal->mood ? $moodEmojis[$journal->mood] ?? '' : '';
        $moodColor = $journal->mood ? $moodColors[$journal->mood] ?? 'text-gray-400' : 'text-gray-400';
    @endphp

    <section class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-book-open mr-2"></i> Journal Details
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    View journal content, mood, prompt and gratitude notes.
                </p>
            </div>

            <div class="flex gap-2 flex-wrap">
                <form action="{{ route('user.journals.favorite', $journal) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button
                        class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                        {{ $journal->is_favorite ? '★ Saved' : '☆ Save' }}
                    </button>
                </form>

                <a href="{{ route('user.journals.edit', $journal) }}"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>

                <form action="{{ route('user.journals.destroy', $journal) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Are you sure you want to delete this journal entry?')"
                        class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-red-500/[0.15] bg-red-50 text-red-500 border dark:border-red-500/[0.2] border-red-200">
                        <i class="fas fa-trash-alt mr-1"></i> Delete
                    </button>
                </form>

                <a href="{{ route('user.journals.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

            {{-- Main content --}}
            <div class="xl:col-span-2 space-y-4">
                <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900">
                                {{ $journal->title }}
                                @if ($journal->is_favorite)
                                    <span class="text-yellow-400 ml-1">★</span>
                                @endif
                            </h3>

                            <p class="text-[13px] dark:text-white text-gray-800 mt-1">
                                {{ $journal->journal_date->format('l, d M Y') }} •
                                {{ ucwords(str_replace('_', ' ', $journal->type)) }}
                                @if ($journal->category)
                                    •
                                    <span class="font-bold" style="color: {{ $journal->category->color ?? '#f97316' }}">
                                        {{ $journal->category->name }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        @if ($journal->mood)
                            <div class="flex-shrink-0 text-center">
                                <div class="text-4xl">{{ $emoji }}</div>
                                <p class="text-[11px] font-bold {{ $moodColor }} mt-1">{{ ucfirst($journal->mood) }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-5 text-[15px] dark:text-gray-300 text-gray-700 leading-relaxed whitespace-pre-line">
                        {!! $journal->content ?? 'No content added.' !!}
                    </div>
                </div>

                @if ($journal->prompt)
                    <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
                        <h3 class="text-[16px] font-bold dark:text-white text-gray-900 mb-2 flex items-center gap-2">
                            <i class="fas fa-lightbulb mr-2"></i> Writing Prompt
                        </h3>
                        <p class="text-[14px] dark:text-gray-400 text-gray-600 italic">
                            "{{ $journal->prompt }}"
                        </p>
                    </div>
                @endif

                @if ($journal->gratitude_notes)
                    <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
                        <h3 class="text-[16px] font-bold dark:text-white text-gray-900 mb-2 flex items-center gap-2">
                            <i class="fas fa-heart mr-2"></i> Gratitude Notes
                        </h3>
                        <p class="text-[14px] dark:text-gray-400 text-gray-600 whitespace-pre-line">
                            {{ $journal->gratitude_notes }}
                        </p>
                    </div>
                @endif
            </div>

            {{-- Sidebar info --}}
            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-bold dark:text-white text-gray-900 mb-4">Journal Info</h3>

                <div class="space-y-3">
                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[12px] font-bold dark:text-white text-gray-800 uppercase tracking-wide">Date</p>
                        <h4 class="text-[15px] font-bold dark:text-white text-gray-900 mt-1">
                            {{ $journal->journal_date->format('d M, Y') }}
                        </h4>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[12px] font-bold dark:text-white text-gray-800 uppercase tracking-wide">Type</p>
                        <h4 class="text-[15px] font-bold text-orange-400 mt-1">
                            {{ ucwords(str_replace('_', ' ', $journal->type)) }}
                        </h4>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[12px] font-bold dark:text-white text-gray-800 uppercase tracking-wide">Mood</p>
                        <h4 class="text-[18px] font-bold {{ $moodColor }} mt-1">
                            {{ $emoji }} {{ $journal->mood ? ucfirst($journal->mood) : 'Not set' }}
                        </h4>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[12px] font-bold dark:text-white text-gray-800 uppercase tracking-wide">Category
                        </p>
                        <h4 class="text-[15px] font-bold mt-1"
                            style="color: {{ $journal->category?->color ?? '#f97316' }}">
                            {{ $journal->category?->name ?? 'Uncategorized' }}
                        </h4>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[12px] font-bold dark:text-white text-gray-800 uppercase tracking-wide">Privacy
                        </p>
                        <h4 class="text-[15px] font-bold dark:text-white text-gray-900 mt-1">
                            {{ $journal->is_private ? '🔒 Private' : '🌐 Public' }}
                        </h4>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[12px] font-bold dark:text-white text-gray-800 uppercase tracking-wide">Saved</p>
                        <h4 class="text-[15px] font-bold text-yellow-400 mt-1">
                            {{ $journal->is_favorite ? '★ Yes' : '☆ No' }}
                        </h4>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[12px] font-bold dark:text-white text-gray-800 uppercase tracking-wide">Word Count
                        </p>
                        <h4 class="text-[15px] font-bold dark:text-white text-gray-900 mt-1">
                            ~{{ $journal->content ? str_word_count(strip_tags($journal->content)) : 0 }} words
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
