@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-th-large mr-1"></i> Habit Board
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    Manage habits by daily and weekly frequency.
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('user.habits.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-white text-gray-800">
                    <i class="fas fa-list mr-1"></i> List View
                </a>

                <a href="{{ route('user.habits.create') }}"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-plus mr-1"></i> Add Habit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @foreach (['daily' => 'Daily Habits', 'weekly' => 'Weekly Habits'] as $frequency => $title)
                <div
                    class="dark:bg-[#080612]  backdrop-blur-xl  p-6  space-y-6
                   shadow-[0_20px_60px_rgba(0,0,0,0.25)]
                    dark:shadow-[inset_0_1px_0_rgba(255,255,255,.03)] rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-[16px] font-bold dark:text-white text-gray-900">{{ $title }}</h3>

                        <span
                            class="px-2 py-[3px] rounded-md text-[12px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-white text-gray-800">
                            {{ isset($habits[$frequency]) ? count($habits[$frequency]) : 0 }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        @forelse (($habits[$frequency] ?? []) as $habit)
                            <div class="hover-lift veroa-card rounded-xl p-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h4 class="text-[14px] font-bold dark:text-white text-gray-800">
                                            {{ $habit->title }}
                                        </h4>

                                        <p class="text-[12px] dark:text-white text-gray-800 mt-1">
                                            {{ \Illuminate\Support\Str::limit($habit->description, 55) }}
                                        </p>
                                    </div>

                                    <span
                                        class="text-[12px] font-bold {{ $habit->type === 'positive' ? 'text-emerald-500' : 'text-red-500' }}">
                                        <i class="fas fa-arrow-up mr-1"></i> {{ ucfirst($habit->type) }}
                                    </span>
                                </div>

                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    <span
                                        class="px-2 py-[3px] rounded-md text-[11px] font-semibold dark:bg-white/[0.06] bg-white dark:text-white text-gray-800">
                                        <i class="fas fa-folder mr-1"></i> {{ $habit->category?->name ?? 'General' }}
                                    </span>

                                    <span
                                        class="px-2 py-[3px] rounded-md text-[11px] font-semibold dark:bg-orange-500/[0.15] bg-orange-50 text-orange-500">
                                        <i class="fas fa-fire mr-1"></i> {{ $habit->streak?->current_streak ?? 0 }} streak
                                    </span>
                                </div>

                                <div class="flex items-center justify-between mt-3">
                                    @if ($habit->todayLog?->is_completed)
                                        <span class="text-[12px] font-bold text-emerald-500">
                                            <i class="fas fa-check-circle mr-1"></i> Completed Today
                                        </span>
                                    @else
                                        <form action="{{ route('user.habits.toggle', $habit) }}" method="POST">
                                            @csrf
                                            <button class="text-[12px] font-bold text-orange-400">
                                                <i class="fas fa-check mr-1"></i> Mark Complete
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('user.habits.show', $habit) }}"
                                        class="text-[12px] font-bold text-pink-500">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div
                                class="border border-dashed dark:border-white/[0.08] border-black/[0.08] rounded-xl p-5 text-center">
                                <p class="text-[14px] dark:text-gray-500 text-gray-400">No {{ strtolower($title) }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>

    </section>
@endsection
