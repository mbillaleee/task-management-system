@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-chart-bar mr-2"></i> Focus Statistics
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Track your focus time, XP, completed sessions and daily performance.
                </p>
            </div>

            <a href="{{ route('user.focus.index') }}"
                class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        @include('user.focus.partials.stats-cards', ['stats' => $stats])

        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
            <h3 class="text-[18px] font-bold dark:text-white text-gray-900 mb-4">
                <i class="fas fa-history mr-2"></i> Last 7 Days Focus
            </h3>

            <div class="space-y-3">
                @forelse($dailyFocus as $day)
                    @php
                        $max = max(1, $dailyFocus->max('minutes'));
                        $width = round(($day->minutes / $max) * 100);
                    @endphp

                    <div>
                        <div class="flex justify-between text-[14px] mb-1">
                            <span class="dark:text-gray-400 text-gray-500">
                                <i class="fas fa-calendar mr-2"></i> {{ \Carbon\Carbon::parse($day->date)->format('d M') }}
                            </span>
                            <span class="font-bold dark:text-white text-gray-800">
                                <i class="fas fa-clock mr-2"></i> {{ $day->minutes }} min
                            </span>
                        </div>

                        <div class="w-full h-[9px] rounded-full dark:bg-white/[0.08] bg-gray-100 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500"
                                style="width: {{ $width }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-[14px] dark:text-gray-500 text-gray-400">
                        <i class="fas fa-info-circle mr-2"></i> No completed focus data found.
                    </p>
                @endforelse
            </div>
        </div>

    </section>
@endsection
