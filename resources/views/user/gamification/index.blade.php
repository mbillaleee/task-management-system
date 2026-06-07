@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    Gamification
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Your XP, levels, badges and challenges.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                {{-- Daily Reward Button --}}
                <form action="{{ route('user.gamification.claimDailyReward') }}" method="POST">
                    @csrf
                    <button
                        class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 disabled:opacity-50"
                        {{ !$canClaimToday ? 'disabled' : '' }}>
                        {{ $canClaimToday ? '🎁 Claim Daily Reward' : '✓ Claimed Today' }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div
                class="px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[14px] font-bold">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-[14px] font-bold">
                {{ session('error') }}
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[13px] dark:text-gray-400 text-gray-500 font-bold">Total XP</p>
                <h3 class="text-[30px] font-black dark:text-white text-gray-900 mt-1">{{ number_format($gamification->xp) }}
                </h3>
                <p class="text-[12px] text-orange-400 font-bold">Experience points</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[13px] dark:text-gray-400 text-gray-500 font-bold">Level</p>
                <h3 class="text-[30px] font-black text-pink-400 mt-1">{{ $gamification->level }}</h3>
                <p class="text-[12px] text-pink-400 font-bold">Current level</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[13px] dark:text-gray-400 text-gray-500 font-bold">Streak 🔥</p>
                <h3 class="text-[30px] font-black text-emerald-400 mt-1">{{ $gamification->streak_days }}</h3>
                <p class="text-[12px] text-emerald-400 font-bold">days in a row</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[13px] dark:text-gray-400 text-gray-500 font-bold">Badges 🏅</p>
                <h3 class="text-[30px] font-black text-yellow-400 mt-1">{{ $userBadges->count() }}</h3>
                <p class="text-[12px] text-yellow-400 font-bold">unlocked</p>
            </div>
        </div>

        {{-- XP Progress Bar --}}
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
            <div class="flex justify-between text-[14px] mb-2">
                <span class="dark:text-gray-400 text-gray-500 font-bold">Level {{ $gamification->level }} Progress</span>
                <span class="dark:text-white text-gray-900 font-bold">{{ $levelProgress }}%</span>
            </div>
            <div class="w-full h-[10px] rounded-full dark:bg-white/[0.08] bg-gray-100 overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500 transition-all duration-500"
                    style="width: {{ $levelProgress }}%"></div>
            </div>
            <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-2">
                {{ $gamification->xp }} / {{ $nextLevelXp }} XP to reach Level {{ $gamification->level + 1 }}
            </p>
        </div>

        {{-- Daily Rewards Calendar --}}
        @if ($dailyRewards->count())
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900 mb-4">🗓 Daily Reward Track</h3>

                <div class="grid grid-cols-3 sm:grid-cols-7 gap-3">
                    @foreach ($dailyRewards as $reward)
                        @php
                            $isCurrent = $gamification->streak_days === $reward->day_number;
                            $isPast = $gamification->streak_days > $reward->day_number;
                        @endphp
                        <div
                            class="rounded-xl p-3 text-center border transition-all
                    {{ $isPast ? 'bg-emerald-500/10 border-emerald-500/30' : ($isCurrent ? 'bg-gradient-to-b from-orange-500/20 to-pink-500/20 border-orange-500/50' : 'dark:bg-white/[0.04] bg-gray-50 dark:border-white/[0.06] border-black/[0.06]') }}">
                            <p class="text-[11px] font-bold dark:text-gray-400 text-gray-500 mb-1">Day
                                {{ $reward->day_number }}</p>
                            <div class="text-[20px] my-1">{{ $reward->icon ?? '🎁' }}</div>
                            <p
                                class="text-[12px] font-black {{ $isPast ? 'text-emerald-400' : ($isCurrent ? 'text-orange-400' : 'dark:text-gray-300 text-gray-700') }}">
                                +{{ $reward->xp_reward }} XP
                            </p>
                            @if ($isPast)
                                <p class="text-[10px] text-emerald-400 font-bold mt-1">✓ Done</p>
                            @elseif($isCurrent)
                                <p class="text-[10px] text-orange-400 font-bold mt-1">Today!</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Badges + Challenges --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

            {{-- Unlocked Badges --}}
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900 mb-4">🏅 My Badges</h3>

                <div class="space-y-3">
                    @forelse($userBadges as $userBadge)
                        <div class="flex items-center gap-3 p-3 rounded-xl dark:bg-white/[0.04] bg-gray-50">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white font-black shrink-0"
                                style="background: {{ $userBadge->badge->color }}">
                                {{ $userBadge->badge->icon ?? '🏆' }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-[14px] font-bold dark:text-white text-gray-900 truncate">
                                    {{ $userBadge->badge->name }}
                                </h4>
                                <p class="text-[12px] dark:text-gray-500 text-gray-400">
                                    Unlocked {{ $userBadge->unlocked_at?->format('d M, Y') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-[16px] dark:text-gray-500 text-gray-400">🔒 No badges yet</p>
                            <p class="text-[13px] dark:text-gray-600 text-gray-300 mt-1">Earn XP to unlock badges!</p>
                        </div>
                    @endforelse
                </div>

                {{-- Locked badges preview --}}
                @php
                    $lockedBadges = $badges->filter(fn($b) => !$userBadges->pluck('badge_id')->contains($b->id));
                @endphp

                @if ($lockedBadges->count())
                    <div class="mt-4 pt-4 border-t dark:border-white/[0.06] border-black/[0.05]">
                        <p class="text-[13px] font-bold dark:text-gray-400 text-gray-500 mb-3">🔒 Locked Badges</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($lockedBadges->take(6) as $badge)
                                <div
                                    class="flex items-center gap-2 px-3 py-2 rounded-xl dark:bg-white/[0.03] bg-gray-50 opacity-60">
                                    <span class="text-[18px]">{{ $badge->icon ?? '🏆' }}</span>
                                    <div>
                                        <p class="text-[12px] font-bold dark:text-gray-400 text-gray-600">
                                            {{ $badge->name }}</p>
                                        <p class="text-[11px] dark:text-gray-600 text-gray-400">{{ $badge->xp_required }}
                                            XP</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- My Challenges --}}
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900 mb-4">⚡ My Challenges</h3>

                <div class="space-y-3">
                    @forelse($userChallenges as $userChallenge)
                        @php
                            $pct =
                                $userChallenge->challenge->target_value > 0
                                    ? min(
                                        round(
                                            ($userChallenge->progress / $userChallenge->challenge->target_value) * 100,
                                        ),
                                        100,
                                    )
                                    : 0;
                        @endphp
                        <div class="p-3 rounded-xl dark:bg-white/[0.04] bg-gray-50">
                            <div class="flex items-center justify-between">
                                <h4 class="text-[14px] font-bold dark:text-white text-gray-900 truncate flex-1 mr-2">
                                    {{ $userChallenge->challenge->title }}
                                </h4>
                                <span class="text-[12px] font-bold text-orange-400 shrink-0">
                                    +{{ $userChallenge->challenge->xp_reward }} XP
                                </span>
                            </div>

                            <div class="mt-2">
                                <div class="flex justify-between text-[12px] mb-1">
                                    <span class="text-gray-400">Progress</span>
                                    <span class="dark:text-white text-gray-700 font-bold">
                                        {{ $userChallenge->progress }}/{{ $userChallenge->challenge->target_value }}
                                    </span>
                                </div>
                                <div class="w-full h-[6px] rounded-full dark:bg-white/[0.08] bg-gray-200 overflow-hidden">
                                    <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500"
                                        style="width: {{ $pct }}%"></div>
                                </div>
                            </div>

                            @if (!$userChallenge->is_completed)
                                <form action="{{ route('user.userChallenges.progress', $userChallenge) }}" method="POST"
                                    class="mt-3 flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="progress" value="1" min="1"
                                        class="w-full px-3 py-2 rounded-lg text-[13px] dark:bg-[#1a1625] bg-white dark:text-white border dark:border-white/[0.1] border-black/[0.1] outline-none">
                                    <button
                                        class="px-3 py-2 rounded-lg text-white text-[13px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shrink-0">
                                        +Add
                                    </button>
                                </form>
                            @else
                                <p class="mt-2 text-[13px] text-emerald-400 font-bold">✓ Completed!</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-[16px] dark:text-gray-500 text-gray-400">No challenges joined yet</p>
                            <p class="text-[13px] dark:text-gray-600 text-gray-300 mt-1">Browse and join challenges below
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Available Challenges to Join --}}
        @php
            $joinedIds = $userChallenges->pluck('challenge_id');
            $availableChallenges = $challenges->filter(fn($c) => !$joinedIds->contains($c->id));
        @endphp

        @if ($availableChallenges->count())
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900 mb-4">🎯 Available Challenges</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3">
                    @foreach ($availableChallenges as $challenge)
                        <div class="p-4 rounded-xl dark:bg-white/[0.04] bg-gray-50 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-orange-500 blur-2xl opacity-10"></div>

                            <div class="flex items-start justify-between gap-2 mb-2">
                                <h4 class="text-[15px] font-bold dark:text-white text-gray-900">{{ $challenge->title }}
                                </h4>
                                <span class="text-[12px] font-bold text-orange-400 shrink-0">+{{ $challenge->xp_reward }}
                                    XP</span>
                            </div>

                            <p class="text-[13px] dark:text-gray-500 text-gray-400 mb-3">
                                {{ \Illuminate\Support\Str::limit($challenge->description, 70) }}
                            </p>

                            <div class="flex items-center justify-between">
                                <span class="text-[12px] dark:text-gray-500 text-gray-400">
                                    Target: {{ $challenge->target_value }} • {{ ucfirst($challenge->type) }}
                                </span>
                                <form action="{{ route('user.challenges.join', $challenge) }}" method="POST">
                                    @csrf
                                    <button
                                        class="px-3 py-1.5 rounded-lg text-[13px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                                        Join
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </section>
@endsection
