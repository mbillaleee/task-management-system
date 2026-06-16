@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-800">
                    <i class="fas fa-trophy mr-2"></i> Gamification
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    Your XP, levels, badges, challenges and daily rewards.
                </p>
            </div>

            <form action="{{ route('user.gamification.claimDailyReward') }}" method="POST">
                @csrf
                <button
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)] disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ !$canClaimToday ? 'disabled' : '' }}>

                    <i class="fas {{ $canClaimToday ? 'fa-gift' : 'fa-badge-check' }} mr-1"></i>

                    {{ $canClaimToday ? 'Claim Daily Reward' : 'Reward Claimed' }}
                </button>
            </form>
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
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-5">
                <p class="text-[13px] dark:text-white text-gray-800 font-bold"><i class="fas fa-star mr-2"></i> Total XP
                </p>
                <h3 class="text-[30px] font-black dark:text-white text-gray-800 mt-1">{{ number_format($gamification->xp) }}
                </h3>
                <p class="text-[12px] text-orange-400 font-bold">Experience points</p>
            </div>

            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-5">
                <p class="text-[13px] dark:text-white text-gray-800 font-bold"><i class="fas fa-crown mr-2"></i> Current
                    Rank</p>
                <h3 class="text-[30px] font-black text-pink-400 mt-1">{{ $levelLabel }}</h3>
                <p class="text-[12px] text-pink-400 font-bold">Level {{ $gamification->level }}</p>
            </div>

            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-5">
                <p class="text-[13px] dark:text-white text-gray-800 font-bold"><i class="fas fa-fire mr-2"></i> Streak
                </p>
                <h3 class="text-[30px] font-black text-emerald-400 mt-1">{{ $gamification->streak_days }}</h3>
                <p class="text-[12px] text-emerald-400 font-bold">
                    days in a row
                    @if (($gamification->max_streak_days ?? 0) > 0)
                        <span class="text-gray-400 font-normal">· best: {{ $gamification->max_streak_days }}</span>
                    @endif
                </p>
            </div>

            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-5">
                <p class="text-[13px] dark:text-white text-gray-800 font-bold"><i class="fas fa-trophy mr-2"></i> Badges
                </p>
                <h3 class="text-[30px] font-black text-yellow-400 mt-1">{{ $userBadges->count() }}</h3>
                <p class="text-[12px] text-yellow-400 font-bold">
                    unlocked
                    @if ($badges->count() > 0)
                        <span class="text-gray-400 font-normal">/ {{ $badges->count() }} total</span>
                    @endif
                </p>
            </div>

            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-5">
                <p class="text-[13px] dark:text-white text-gray-800 font-bold"><i class="fas fa-bolt mr-2"></i>
                    Challenges </p>
                <h3 class="text-[30px] font-black text-purple-400 mt-1">
                    {{ $userChallenges->where('is_completed', true)->count() }}
                </h3>
                <p class="text-[12px] text-purple-400 font-bold">
                    <i class="fas fa-check mr-1"></i> completed
                    <span class="text-gray-400 font-normal">/ {{ $userChallenges->count() }} joined</span>
                </p>
            </div>
        </div>

        {{-- XP Progress Bar --}}
        <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
            <div class="flex justify-between text-[14px] mb-2">
                <span class="dark:text-white text-gray-800 font-bold">
                    Level {{ $gamification->level }} <i class="fas fa-arrow-right mx-2"></i> Level
                    {{ $gamification->level + 1 }}
                    <span class="text-orange-400 ml-1">({{ $levelLabel }})</span>
                </span>
                <span class="dark:text-white text-gray-800 font-bold">{{ $levelProgress['progress_pct'] }}%</span>
            </div>

            <div class="w-full h-[10px] rounded-full dark:bg-white/[0.08] bg-gray-400 overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500 transition-all duration-700"
                    style="width: {{ $levelProgress['progress_pct'] }}%">
                </div>
            </div>

            <div class="flex items-center justify-between mt-2">
                <p class="text-[13px] dark:text-white text-gray-800">
                    {{ $levelProgress['progress_xp'] }} / 100 XP toward next level
                </p>
                @if ($nextBadge)
                    <p class="text-[12px] dark:text-white text-gray-800">
                        Next badge: <span class="text-orange-400 font-bold">{{ $nextBadge->name }}</span>
                        — {{ max(0, $nextBadge->xp_required - $gamification->xp) }} XP away
                    </p>
                @endif
            </div>
        </div>

        {{-- Activity Stats Row --}}
        @if (
            $gamification->total_tasks_completed > 0 ||
                $gamification->total_habits_completed > 0 ||
                $gamification->total_focus_sessions > 0 ||
                $gamification->total_goals_completed > 0 ||
                $gamification->total_journals_written > 0)
            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
                <h3 class="text-[16px] font-extrabold dark:text-white text-gray-800 mb-4"><i
                        class="fas fa-chart-bar mr-2"></i> Your Activity</h3>
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                    @foreach ([['Tasks', $gamification->total_tasks_completed, '✅', 'text-blue-400'], ['Habits', $gamification->total_habits_completed, '🔁', 'text-green-400'], ['Focus', $gamification->total_focus_sessions, '⏱', 'text-purple-400'], ['Goals', $gamification->total_goals_completed, '🎯', 'text-yellow-400'], ['Journals', $gamification->total_journals_written, '📔', 'text-pink-400']] as [$label, $val, $icon, $color])
                        <div class="text-center dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <div class="text-[22px]">{{ $icon }}</div>
                            <div class="text-[22px] font-black {{ $color }} mt-1">{{ $val }}</div>
                            <div class="text-[11px] dark:text-white text-gray-800 font-bold">{{ $label }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Daily Rewards Calendar --}}
        @if ($dailyRewards->count())
            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-800"><i
                            class="fas fa-calendar-alt mr-2"></i> Daily Reward Track</h3>
                    <span class="text-[13px] dark:text-white text-gray-800">
                        Streak: <span class="text-orange-400 font-bold">{{ $gamification->streak_days }} days</span>
                    </span>
                </div>

                <div class="grid grid-cols-3 sm:grid-cols-7 gap-3">
                    @foreach ($dailyRewards as $reward)
                        @php
                            $isCurrent = $gamification->streak_days === $reward->day_number;
                            $isPast = $gamification->streak_days > $reward->day_number;
                        @endphp
                        <div
                            class="rounded-xl p-3 text-center border transition-all
                            {{ $isPast
                                ? 'bg-emerald-500/10 border-emerald-500/30'
                                : ($isCurrent
                                    ? 'bg-gradient-to-b from-orange-500/20 to-pink-500/20 border-orange-500/50 ring-1 ring-orange-500/30'
                                    : 'dark:bg-white/[0.04] bg-gray-50 dark:border-white/[0.06] border-black/[0.06]') }}">
                            <p class="text-[11px] font-bold dark:text-white text-gray-800 mb-1">Day
                                {{ $reward->day_number }}</p>
                            <div class="text-[22px] my-1">{{ $reward->icon ?? '🎁' }}</div>
                            <p
                                class="text-[12px] font-black
                                {{ $isPast ? 'text-emerald-400' : ($isCurrent ? 'text-orange-400' : 'dark:text-gray-300 text-gray-700') }}">
                                +{{ $reward->xp_reward }} XP
                            </p>
                            @if ($isPast)
                                <p class="text-[10px] text-emerald-400 font-bold mt-1"><i class="fas fa-check mr-1"></i>
                                    Done</p>
                            @elseif ($isCurrent)
                                <p class="text-[10px] text-orange-400 font-bold mt-1 animate-pulse"><i
                                        class="fas fa-star mr-1"></i> Today!</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Badges + Challenges --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

            {{-- Badges --}}
            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-800"><i class="fas fa-trophy mr-2"></i>
                        My Badges</h3>
                    <span class="text-[13px] dark:text-white text-gray-800">
                        {{ $userBadges->count() }} / {{ $badges->count() }} unlocked
                    </span>
                </div>

                {{-- Unlocked --}}
                @if ($userBadges->count())
                    <div class="space-y-2 mb-4">
                        @foreach ($userBadges as $ub)
                            <div class="flex items-center gap-3 p-3 rounded-xl dark:bg-white/[0.04] bg-gray-50">
                                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-[20px] shrink-0"
                                    style="background: {{ $ub->badge->color ?? '#f97316' }}22; border: 1px solid {{ $ub->badge->color ?? '#f97316' }}55;">
                                    {{ $ub->badge->icon ?? '🏆' }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-[14px] font-bold dark:text-white text-gray-800 truncate">
                                        {{ $ub->badge->name ?? 'Unnamed Badge' }}
                                    </h4>
                                    <p class="text-[12px] dark:text-white text-gray-800">
                                        {{ $ub->badge->description ?? 'No description available.' }}
                                    </p>
                                </div>
                                <span class="text-[11px] font-bold text-emerald-400 shrink-0"><i
                                        class="fas fa-check mr-1"></i> Unlocked</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Locked badges with progress --}}
                @php
                    $unlockedIds = $userBadges->pluck('badge_id');
                    $lockedBadges = $badges->filter(fn($b) => !$unlockedIds->contains($b->id));
                @endphp

                @if ($lockedBadges->count())
                    <div
                        class="{{ $userBadges->count() ? 'pt-4 border-t dark:border-white/[0.06] border-black/[0.05]' : '' }}">
                        @if ($userBadges->count())
                            <p class="text-[13px] font-bold dark:text-white text-gray-800 mb-3"><i
                                    class="fas fa-lock mr-2"></i> Locked Badges</p>
                        @else
                            <p class="text-[13px] font-bold dark:text-white text-gray-800 mb-3"><i
                                    class="fas fa-coins mr-2"></i> Earn XP to unlock badges!
                            </p>
                        @endif

                        <div class="space-y-2">
                            @foreach ($lockedBadges->take(5) as $badge)
                                @php
                                    // Progress toward this badge
                                    $userVal = match ($badge->badge_type ?? 'xp') {
                                        'xp' => $gamification->xp,
                                        'streak' => $gamification->streak_days,
                                        'task_count' => $gamification->total_tasks_completed,
                                        'habit_count' => $gamification->total_habits_completed,
                                        'focus_sessions' => $gamification->total_focus_sessions,
                                        'goals_completed' => $gamification->total_goals_completed,
                                        'journals_written' => $gamification->total_journals_written,
                                        default => 0,
                                    };
                                    $target =
                                        $badge->badge_type === 'xp' || ($badge->badge_type ?? 'xp') === 'xp'
                                            ? ($badge->xp_required ?:
                                            $badge->trigger_value)
                                            : $badge->trigger_value;
                                    $pct = $target > 0 ? min(100, round(($userVal / $target) * 100)) : 0;
                                    $remaining = max(0, $target - $userVal);
                                @endphp
                                <div class="p-3 rounded-xl dark:bg-white/[0.03] bg-gray-50 opacity-80">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div
                                            class="w-9 h-9 rounded-lg flex items-center justify-center text-[16px] dark:bg-white/[0.06] bg-gray-200 shrink-0">
                                            {{ $badge->icon ?? '🔒' }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-[13px] font-bold dark:text-gray-300 text-gray-700 truncate">
                                                {{ $badge->name }}
                                            </h4>
                                            <p class="text-[11px] dark:text-white text-gray-800">
                                                {{ $remaining }} more
                                                {{ match ($badge->badge_type ?? 'xp') {
                                                    'xp' => 'XP needed',
                                                    'streak' => 'streak days',
                                                    'task_count' => 'tasks to complete',
                                                    'habit_count' => 'habits to log',
                                                    'focus_sessions' => 'focus sessions',
                                                    'goals_completed' => 'goals to complete',
                                                    'journals_written' => 'journals to write',
                                                    default => 'needed',
                                                } }}
                                            </p>
                                        </div>
                                        <span class="text-[11px] font-bold dark:text-white text-gray-800 shrink-0">
                                            {{ $pct }}%
                                        </span>
                                    </div>
                                    <div class="w-full h-[4px] rounded-full dark:bg-white/[0.08] bg-gray-200">
                                        <div class="h-full rounded-full"
                                            style="width: {{ $pct }}%; background: {{ $badge->color ?? '#f97316' }};">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- My Challenges --}}
            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-extrabold dark:text-white text-gray-800 mb-4"><i
                        class="fas fa-tasks mr-2"></i> My Challenges</h3>

                <div class="space-y-3">
                    @forelse($userChallenges as $uc)
                        @php
                            $pct =
                                $uc->challenge->target_value > 0
                                    ? min(100, round(($uc->progress / $uc->challenge->target_value) * 100))
                                    : 0;
                            $isAuto = $uc->challenge->challenge_action !== 'manual';

                            $actionLabels = [
                                'manual' => null,
                                'complete_task' => '✅ Updates when you complete a task',
                                'log_habit' => '🔁 Updates when you log a habit',
                                'finish_focus' => '⏱ Updates when you finish a focus session',
                                'complete_goal' => '🎯 Updates when you complete a goal',
                                'write_journal' => '📔 Updates when you write a journal entry',
                                'login_streak' => '🔥 Updates when you claim your daily reward',
                            ];
                            $actionHint = $actionLabels[$uc->challenge->challenge_action] ?? null;
                        @endphp

                        <div class="p-3 rounded-xl dark:bg-white/[0.04] bg-gray-50">

                            {{-- Title row --}}
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="text-[14px] font-bold dark:text-white text-gray-800 truncate">
                                            {{ $uc->challenge->title }}
                                        </h4>
                                        @if ($uc->is_completed)
                                            <span
                                                class="text-[10px] font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full shrink-0">
                                                <i class="fas fa-check mr-1"></i> Done
                                            </span>
                                        @else
                                            <span
                                                class="text-[10px] font-bold dark:text-white text-gray-800 border dark:border-white/[0.1] border-black/[0.1] px-2 py-0.5 rounded-full shrink-0">
                                                {{ ucfirst($uc->challenge->type) }}
                                            </span>
                                            @if ($isAuto)
                                                <span
                                                    class="text-[10px] font-bold text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded-full shrink-0">
                                                    <i class="fas fa-bolt mr-1"></i> Auto
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                    <p class="text-[12px] dark:text-white text-gray-800 mt-0.5">
                                        +{{ $uc->challenge->xp_reward }} XP reward
                                    </p>
                                </div>

                                {{-- Leave button (only for active, non-completed) --}}
                                @if (!$uc->is_completed)
                                    <form action="{{ route('user.userChallenges.leave', $uc) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Leave this challenge?')"
                                            class="text-[11px] font-bold dark:text-white text-gray-800 hover:text-red-400 transition-colors shrink-0 pt-0.5">
                                            Leave
                                        </button>
                                    </form>
                                @endif
                            </div>

                            {{-- Progress bar --}}
                            <div class="mt-3">
                                <div class="flex justify-between text-[12px] mb-1">
                                    <span class="dark:text-white text-gray-800">Progress</span>
                                    <span class="dark:text-white text-gray-700 font-bold">
                                        {{ $uc->progress }} / {{ $uc->challenge->target_value }}
                                    </span>
                                </div>
                                <div class="w-full h-[6px] rounded-full dark:bg-white/[0.08] bg-gray-200 overflow-hidden">
                                    <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500 transition-all"
                                        style="width: {{ $pct }}%"></div>
                                </div>
                            </div>

                            {{-- Action hint (auto challenges) --}}
                            @if ($actionHint && !$uc->is_completed)
                                <p class="mt-2 text-[12px] dark:text-white text-gray-800 italic">
                                    {{ $actionHint }}
                                </p>
                            @endif

                            {{-- Manual input (only for manual challenges) --}}
                            @if (!$uc->is_completed && !$isAuto)
                                <form action="{{ route('user.userChallenges.progress', $uc) }}" method="POST"
                                    class="mt-3 flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="progress" value="1" min="1"
                                        max="{{ max(1, $uc->challenge->target_value - $uc->progress) }}"
                                        class="w-full px-3 py-2 rounded-lg text-[13px] dark:bg-[#1a1625] bg-white dark:text-white border dark:border-white/[0.1] border-black/[0.1] outline-none">
                                    <button
                                        class="px-4 py-2 rounded-lg text-white text-[13px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shrink-0">
                                        <i class="fas fa-plus mr-1"></i> Add
                                    </button>
                                </form>
                            @endif

                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-[16px] dark:text-white text-gray-800">No challenges joined yet</p>
                            <p class="text-[13px] dark:text-white text-gray-800 mt-1">Browse and join challenges below
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Available Challenges --}}
        @php
            $joinedIds = $userChallenges->pluck('challenge_id');
            $availableChallenges = $challenges->filter(fn($c) => !$joinedIds->contains($c->id));
        @endphp

        @if ($availableChallenges->count())
            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-extrabold dark:text-white text-gray-800 mb-4"><i
                        class="fas fa-tasks mr-2"></i> Available Challenges</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3">
                    @foreach ($availableChallenges as $challenge)
                        <div class="p-4 rounded-xl dark:bg-white/[0.04] bg-gray-50 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-orange-500 blur-2xl opacity-10"></div>

                            <div class="flex items-start justify-between gap-2 mb-1">
                                <h4 class="text-[15px] font-bold dark:text-white text-gray-800">{{ $challenge->title }}
                                </h4>
                                <span class="text-[12px] font-bold text-orange-400 shrink-0">
                                    <i class="fas fa-coins mr-1"></i> {{ $challenge->xp_reward }} XP</span>
                            </div>

                            <p class="text-[13px] dark:text-white text-gray-800 mb-1">
                                {{ \Illuminate\Support\Str::limit($challenge->description, 80) }}
                            </p>

                            <div class="flex items-center gap-2 mb-3">
                                <span
                                    class="text-[11px] font-bold dark:text-white text-gray-800 border dark:border-white/[0.1] border-black/[0.1] px-2 py-0.5 rounded-full">
                                    {{ ucfirst($challenge->type) }}
                                </span>
                                <span class="text-[11px] dark:text-white text-gray-800">
                                    Target: {{ $challenge->target_value }}
                                </span>
                                @if ($challenge->end_date)
                                    <span class="text-[11px] text-red-400 font-bold">
                                        <i class="fas fa-clock mr-1"></i> Ends {{ $challenge->end_date->format('d M') }}
                                    </span>
                                @endif
                            </div>

                            <form action="{{ route('user.challenges.join', $challenge) }}" method="POST">
                                @csrf
                                <button
                                    class="w-full px-3 py-2 rounded-lg text-[13px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                                    <i class="fas fa-tasks mr-1"></i> Join Challenge
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </section>
@endsection
