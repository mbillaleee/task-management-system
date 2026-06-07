@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    Journal Details
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    View journal content, mood, prompt and gratitude notes.
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('user.journals.edit', $journal) }}"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    Edit Journal
                </a>

                <a href="{{ route('user.journals.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <div class="xl:col-span-2 space-y-4">
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                    <h3 class="text-[22px] font-extrabold dark:text-white text-gray-900">
                        {{ $journal->title }}
                    </h3>

                    <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-1">
                        {{ $journal->journal_date->format('d M, Y') }} •
                        {{ ucwords(str_replace('_', ' ', $journal->type)) }} •
                        {{ $journal->category?->name ?? 'Uncategorized' }}
                    </p>

                    <div class="mt-5 text-[15px] dark:text-gray-300 text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $journal->content ?? 'No content added.' }}
                    </div>
                </div>

                @if ($journal->prompt)
                    <div
                        class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                        <h3 class="text-[16px] font-bold dark:text-white text-gray-900 mb-2">Writing Prompt</h3>
                        <p class="text-[14px] dark:text-gray-400 text-gray-600">{{ $journal->prompt }}</p>
                    </div>
                @endif

                @if ($journal->gratitude_notes)
                    <div
                        class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                        <h3 class="text-[16px] font-bold dark:text-white text-gray-900 mb-2">Gratitude Notes</h3>
                        <p class="text-[14px] dark:text-gray-400 text-gray-600 whitespace-pre-line">
                            {{ $journal->gratitude_notes }}</p>
                    </div>
                @endif
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-bold dark:text-white text-gray-900 mb-4">
                    Journal Info
                </h3>

                <div class="space-y-4">
                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[13px] dark:text-gray-500 text-gray-400">Mood</p>
                        <h4 class="text-[18px] font-bold text-orange-400 mt-1">
                            {{ $journal->mood ? ucfirst($journal->mood) : 'No Mood' }}
                        </h4>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[13px] dark:text-gray-500 text-gray-400">Privacy</p>
                        <h4 class="text-[16px] font-bold dark:text-white text-gray-900 mt-1">
                            {{ $journal->is_private ? 'Private' : 'Public' }}
                        </h4>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-4">
                        <p class="text-[13px] dark:text-gray-500 text-gray-400">Favorite</p>
                        <h4 class="text-[16px] font-bold text-yellow-400 mt-1">
                            {{ $journal->is_favorite ? 'Yes' : 'No' }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
