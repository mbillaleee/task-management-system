@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-chart-bar mr-2"></i> Journal Statistics
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Writing streak, mood trends and monthly overview.
                </p>
            </div>
            <a href="{{ route('user.journals.index') }}"
                class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                <i class="fas fa-arrow-left mr-1"></i> Back to Journals
            </a>
        </div>

        {{-- Top stat cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-bold"> <i class="fas fa-file-alt mr-1"></i>
                    Total Entries</p>
                <h3 class="text-[34px] font-black dark:text-white text-gray-900 mt-2">{{ $totalJournals }}</h3>
                <p class="text-[13px] text-orange-400 font-bold">All time</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-bold"> <i class="fas fa-fire mr-1"></i> Writing
                    Streak</p>
                <h3 class="text-[34px] font-black text-purple-400 mt-2">{{ $writingStreak }}</h3>
                <p class="text-[13px] text-purple-400 font-bold">days in a row</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-bold"> <i class="fas fa-calendar-alt mr-1"></i>
                    This Month</p>
                <h3 class="text-[34px] font-black text-pink-400 mt-2">{{ $thisMonthCount }}</h3>
                <p class="text-[13px] text-pink-400 font-bold">{{ now()->format('F') }}</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-bold"> <i class="fas fa-font mr-1"></i> Total
                    Words</p>
                <h3 class="text-[34px] font-black text-emerald-400 mt-2">{{ number_format($totalWords) }}</h3>
                <p class="text-[13px] text-emerald-400 font-bold">approximate</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

            {{-- Monthly chart --}}
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900 mb-1"> <i
                        class="fas fa-calendar-alt mr-1"></i> Monthly Activity</h3>
                <p class="text-[13px] dark:text-gray-500 text-gray-400 mb-5">Entries written per month (last 12 months)</p>

                @php $maxMonthly = max(array_values($months) ?: [1]); @endphp
                <div class="flex items-end gap-2 h-40">
                    @foreach ($months as $month => $count)
                        @php $pct = $maxMonthly > 0 ? ($count / $maxMonthly) * 100 : 0; @endphp
                        <div class="flex flex-col items-center gap-1 flex-1">
                            <span class="text-[10px] dark:text-gray-500 text-gray-400 font-bold">
                                {{ $count > 0 ? $count : '' }}
                            </span>
                            <div class="w-full rounded-t-md transition-all"
                                style="height: {{ max($pct, 4) }}%; background: linear-gradient(to top, #f97316, #ec4899); min-height: 4px;">
                            </div>
                            <span class="text-[9px] dark:text-gray-600 text-gray-400 font-bold">
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Mood distribution --}}
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900 mb-1"> <i class="fas fa-smile mr-1"></i>
                    Mood Distribution</h3>
                <p class="text-[13px] dark:text-gray-500 text-gray-400 mb-5">How you have been feeling across all entries
                </p>

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
                    $moodColorHex = [
                        'happy' => '#facc15',
                        'calm' => '#60a5fa',
                        'neutral' => '#9ca3af',
                        'sad' => '#818cf8',
                        'angry' => '#f87171',
                        'stressed' => '#fb923c',
                        'excited' => '#f472b6',
                    ];
                    $totalMood = array_sum($moodData);
                @endphp

                @if (empty($moodData))
                    <p class="text-[14px] dark:text-gray-500 text-gray-400 text-center py-8">
                        No mood data recorded yet.
                    </p>
                @else
                    <div class="space-y-3">
                        @foreach ($moodData as $mood => $count)
                            @php
                                $pct = $totalMood > 0 ? round(($count / $totalMood) * 100) : 0;
                                $color = $moodColorHex[$mood] ?? '#f97316';
                                $emoji = $moodEmojis[$mood] ?? '';
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[13px] font-bold dark:text-gray-300 text-gray-700">
                                        {{ $emoji }} {{ ucfirst($mood) }}
                                    </span>
                                    <span class="text-[12px] font-bold dark:text-gray-400 text-gray-500">
                                        {{ $count }} ({{ $pct }}%)
                                    </span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-white/[0.06] rounded-full h-2">
                                    <div class="h-2 rounded-full"
                                        style="width: {{ $pct }}%; background: {{ $color }};"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Journal types breakdown --}}
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900 mb-1"> <i class="fas fa-list mr-1"></i>
                    Entry Types</h3>
                <p class="text-[13px] dark:text-gray-500 text-gray-400 mb-5">Breakdown by journal type</p>

                @php
                    $typeLabels = [
                        'daily' => [
                            'icon' => 'fas fa-calendar-day',
                            'label' => 'Daily Journal',
                            'color' => '#f97316',
                        ],
                        'gratitude' => [
                            'icon' => 'fas fa-heart',
                            'label' => 'Gratitude',
                            'color' => '#10b981',
                        ],
                        'reflection' => [
                            'icon' => 'fas fa-lightbulb',
                            'label' => 'Reflection',
                            'color' => '#8b5cf6',
                        ],
                        'personal_log' => [
                            'icon' => 'fas fa-book-open',
                            'label' => 'Personal Log',
                            'color' => '#3b82f6',
                        ],
                    ];

                    $typeTotal = array_sum($byType);
                @endphp

                @if (empty($byType))
                    <p class="text-[14px] dark:text-gray-500 text-gray-400 text-center py-8">
                        No entries yet.
                    </p>
                @else
                    <div class="grid grid-cols-2 gap-3">
                        @foreach ($typeLabels as $key => $item)
                            @php
                                $count = $byType[$key] ?? 0;
                                $color = $item['color'];
                            @endphp

                            <div class="rounded-xl p-4 border dark:border-white/[0.07] border-black/[0.07]"
                                style="background: {{ $color }}11;">

                                <p class="text-[13px] font-bold dark:text-gray-300 text-gray-600 flex items-center gap-2">
                                    <i class="{{ $item['icon'] }}" style="color: {{ $color }}"></i>
                                    {{ $item['label'] }}
                                </p>

                                <h4 class="text-[28px] font-black mt-1" style="color: {{ $color }}">
                                    {{ $count }}
                                </h4>

                                <p class="text-[11px] font-bold dark:text-gray-500 text-gray-400 mt-0.5">
                                    {{ $typeTotal > 0 ? round(($count / $typeTotal) * 100) : 0 }}% of total
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Best writing days --}}
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900 mb-1"> <i
                        class="fas fa-calendar-day mr-1"></i> Most Active Days</h3>
                <p class="text-[13px] dark:text-gray-500 text-gray-400 mb-5">Which day of the week you write most</p>

                @php $maxDay = max(array_values($dayData) ?: [1]); @endphp

                @if (empty($dayData))
                    <p class="text-[14px] dark:text-gray-500 text-gray-400 text-center py-8">No data yet.</p>
                @else
                    <div class="space-y-3">
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            @php
                                $count = $dayData[$day] ?? 0;
                                $pct = $maxDay > 0 ? round(($count / $maxDay) * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-3">
                                <span class="text-[12px] font-bold dark:text-gray-400 text-gray-500 w-24 flex-shrink-0">
                                    {{ substr($day, 0, 3) }}
                                </span>
                                <div class="flex-1 bg-gray-100 dark:bg-white/[0.06] rounded-full h-2">
                                    <div class="h-2 rounded-full bg-gradient-to-r from-orange-500 to-pink-500"
                                        style="width: {{ $pct }}%;"></div>
                                </div>
                                <span class="text-[12px] font-bold dark:text-gray-400 text-gray-500 w-6 text-right">
                                    {{ $count }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </section>
@endsection
