@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-repeat mr-1"></i> My Habits
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    Build consistency with daily and weekly habit tracking.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('user.habits.board') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-white text-gray-800 border dark:border-white/[0.08] border-black/[0.08]">
                    <i class="fas fa-th-large mr-1"></i> Board View
                </a>

                <a href="{{ route('user.habits.index') }}"
                    class="flex items-center justify-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    <i class="fas fa-list"></i> Today's Habits
                </a>

                <a href="{{ route('user.habits.create') }}"
                    class="flex items-center justify-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    <i class="fas fa-plus"></i> Add Habit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse ($habits as $habit)
                @php
                    $typeClass =
                        $habit->type === 'positive'
                            ? 'dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500 border-emerald-500/20'
                            : 'dark:bg-red-500/[0.15] bg-red-50 text-red-500 border-red-500/20';

                    $frequencyClass =
                        $habit->frequency === 'daily'
                            ? 'dark:bg-orange-500/[0.15] bg-orange-50 text-orange-500'
                            : 'dark:bg-blue-500/[0.15] bg-blue-50 text-blue-500';

                    $completed = $habit->todayLog?->is_completed;
                @endphp

                <div
                    class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-4 relative overflow-hidden">

                    <div class="relative z-10 flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-[16px] font-bold dark:text-white text-gray-900 leading-snug">
                                {{ $habit->title }}
                            </h3>

                            <p class="text-[14px] dark:text-white text-gray-800 mt-1">
                                {{ $habit->category?->name ?? 'General' }}
                            </p>
                        </div>

                        <span class="px-2.5 py-[4px] rounded-lg text-[15px] font-bold border {{ $typeClass }}">
                            {{ ucfirst($habit->type) }}
                        </span>
                    </div>

                    <p class="relative z-10 text-[14px] dark:text-white text-gray-800 leading-relaxed mt-3">
                        {{ \Illuminate\Support\Str::limit($habit->description, 120) ?? 'No description added.' }}
                    </p>

                    <div class="relative z-10 grid grid-cols-2 gap-3 mt-4">
                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[14px] dark:text-white text-gray-800">Current Streak</p>
                            <p class="text-[16px] font-bold dark:text-white text-gray-800">
                                {{ $habit->streak?->current_streak ?? 0 }} Days
                            </p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[14px] dark:text-white text-gray-800">Best Streak</p>
                            <p class="text-[16px] font-bold dark:text-white text-gray-800">
                                {{ $habit->streak?->best_streak ?? 0 }} Days
                            </p>
                        </div>
                    </div>

                    <div
                        class="relative z-10 flex items-center justify-between mt-4 pt-3 border-t dark:border-white/[0.06] border-black/[0.05]">
                        <div>
                            <p class="text-[16px] dark:text-white text-gray-800">Frequency</p>
                            <span
                                class="inline-block mt-1 px-2.5 py-[4px] rounded-lg text-[15px] font-bold {{ $frequencyClass }}">
                                {{ ucfirst($habit->frequency) }}
                            </span>
                        </div>

                        @if ($completed)
                            <span
                                class="px-2.5 py-[4px] rounded-lg text-[15px] font-bold dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500">
                                <i class="fas fa-check mr-1"></i> Completed
                            </span>
                        @else
                            <form action="{{ route('user.habits.toggle', $habit) }}" method="POST">
                                @csrf
                                <button
                                    class="px-3 py-2 rounded-lg text-[14px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                                    <i class="fas fa-check mr-1"></i> Mark Done
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="relative z-10 flex items-center justify-between gap-2 mt-4">
                        <a href="{{ route('user.habits.show', $habit) }}"
                            class="px-3 py-2 rounded-lg text-[14px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('user.habits.edit', $habit) }}"
                                class="px-3 py-2 rounded-lg text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-white text-gray-800">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>

                            <form action="{{ route('user.habits.destroy', $habit) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this habit?')"
                                    class="px-3 py-2 rounded-lg text-[14px] font-bold dark:bg-red-500/[0.15] bg-red-50 text-red-500">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full hover-lift veroa-card rounded-2xl p-8 text-center">
                    <h3 class="text-[16px] font-bold dark:text-white text-gray-900">No habits found</h3>
                    <p class="text-[12px] dark:text-white text-gray-800 mt-1">Create your first habit to start building
                        consistency.</p>
                </div>
            @endforelse
        </div>

        <div>
            {{ $habits->links() }}
        </div>

    </section>
@endsection
