@extends('user.layouts.master')

@section('user')
    <div class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[22px] font-extrabold dark:text-white text-gray-900"><i class="fas fa-clock"></i> Focus
                    Analytics</h2>
                <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-0.5">Sessions, time tracked, XP earned and ambient
                    sounds.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('user.analytics.index') }}"
                    class="px-3 py-2 rounded-xl text-[13px] dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600 font-bold">←
                    <i class="fas fa-arrow-left"></i> Overview</a>
                @foreach ([7, 30, 90] as $p)
                    <a href="{{ route('user.analytics.focus', ['period' => $p]) }}"
                        class="px-3 py-2 rounded-xl text-[13px] font-bold transition
                {{ $period == $p ? 'bg-gradient-to-r from-orange-500 to-pink-500 text-white' : 'dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600' }}">
                        {{ $p }}d
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
            @php $cards = [['v' => $totalHours . 'h', 'l' => 'Total Focus', 's' => 'all-time hours', 'c' => 'text-blue-400'], ['v' => $totalSessions, 'l' => 'Sessions', 's' => 'all-time completed', 'c' => 'text-emerald-400'], ['v' => $periodMin . 'm', 'l' => 'Period Focus', 's' => "last {$period} days", 'c' => 'text-orange-400'], ['v' => $avgPerSession . 'm', 'l' => 'Avg Session', 's' => 'minutes per session', 'c' => 'text-pink-400'], ['v' => number_format($totalXp), 'l' => 'XP Earned', 's' => 'from focus sessions', 'c' => 'text-purple-400']]; @endphp
            @foreach ($cards as $c)
                <div class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] p-4">
                    <p class="text-[24px] font-black {{ $c['c'] }}">{{ $c['v'] }}</p>
                    <p class="text-[13px] font-bold dark:text-white text-gray-900">{{ $c['l'] }}</p>
                    <p class="text-[11px] dark:text-gray-500 text-gray-400">{{ $c['s'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Daily Focus Minutes Chart --}}
        <div class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] p-5">
            <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900 mb-4">Daily Focus Minutes — Last
                {{ $period }} Days</h3>
            @php $maxFocus = max(1, collect($focusChart)->max('minutes')); @endphp
            <div class="flex items-end gap-1 overflow-x-auto pb-2" style="height:130px">
                @foreach ($focusChart as $day)
                    @php
                        $barH = max(3, round(($day['minutes'] / $maxFocus) * 110));
                        $isToday = $day['date'] === now()->format('Y-m-d');
                    @endphp
                    <div class="flex flex-col items-center flex-shrink-0 group relative"
                        style="min-width:{{ $period <= 14 ? '36px' : '12px' }}">
                        @if ($day['minutes'] > 0)
                            <div
                                class="absolute -top-5 left-1/2 -translate-x-1/2 hidden group-hover:block bg-gray-900 text-white text-[10px] px-2 py-0.5 rounded whitespace-nowrap z-10">
                                {{ $day['minutes'] }}m · {{ $day['sessions'] }} session(s)
                            </div>
                        @endif
                        <div class="w-full rounded-t transition-all {{ $isToday ? 'bg-gradient-to-t from-blue-500 to-cyan-400' : 'dark:bg-blue-500/30 bg-blue-100' }}"
                            style="height:{{ $barH }}px"></div>
                        @if ($period <= 14)
                            <span
                                class="text-[9px] dark:text-gray-600 text-gray-400 mt-0.5">{{ substr($day['label'], 0, 5) }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Best Focus Day --}}
            <div class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] p-5">
                <h3 class="text-[15px] font-extrabold dark:text-white text-gray-900 mb-4">🏆 Best Focus Day</h3>
                @if ($bestDay)
                    <p class="text-[32px] font-black text-blue-400">{{ $bestDay->minutes }}m</p>
                    <p class="text-[14px] dark:text-gray-400 text-gray-600 mt-1">
                        {{ \Carbon\Carbon::parse($bestDay->date)->format('d M Y') }}</p>
                    <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-0.5">{{ round($bestDay->minutes / 60, 1) }}
                        hours of deep work</p>
                @else
                    <p class="text-[14px] dark:text-gray-500 text-gray-400">No completed sessions yet.</p>
                @endif
            </div>

            {{-- Ambient Sound Usage --}}
            <div class="dark:bg-[#17141f] bg-white rounded-2xl border dark:border-white/[0.07] border-black/[0.07] p-5">
                <h3 class="text-[15px] font-extrabold dark:text-white text-gray-900 mb-4">🎵 Ambient Sound Usage</h3>
                @php
                    $soundLabels = [
                        'white_noise' => 'White Noise 🌫',
                        'rain' => 'Rain 🌧',
                        'lofi' => 'Lo-Fi 🎵',
                        'none' => 'Silent 🔇',
                    ];
                    $soundTotal = max(1, $soundBreakdown->sum());
                    $soundColors = [
                        'white_noise' => 'bg-blue-400',
                        'rain' => 'bg-cyan-500',
                        'lofi' => 'bg-purple-500',
                        'none' => 'bg-gray-400',
                    ];
                @endphp
                <div class="space-y-3">
                    @foreach ($soundBreakdown as $sound => $cnt)
                        @php $pct = round($cnt/$soundTotal*100); @endphp
                        <div>
                            <div class="flex justify-between text-[13px] mb-1">
                                <span
                                    class="font-bold dark:text-gray-300 text-gray-700">{{ $soundLabels[$sound] ?? $sound }}</span>
                                <span class="dark:text-gray-500 text-gray-400">{{ $cnt }}
                                    ({{ $pct }}%)
                                </span>
                            </div>
                            <div class="h-2 rounded-full dark:bg-white/10 bg-gray-100 overflow-hidden">
                                <div class="{{ $soundColors[$sound] ?? 'bg-orange-400' }} h-full rounded-full"
                                    style="width:{{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                    @if ($soundBreakdown->isEmpty())
                        <p class="text-[13px] dark:text-gray-500 text-gray-400">No sessions yet.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
