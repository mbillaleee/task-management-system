@extends('admin.layouts.master')

@section('admin')
    <section class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-trophy"></i> Gamification Overview
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Platform-wide XP, badges, challenges and rewards management.
                </p>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('admin.badges.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                    <i class="fas fa-medal"></i> Manage Badges
                </a>
                <a href="{{ route('admin.challenges.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                    <i class="fas fa-tasks"></i> Manage Challenges
                </a>
                <a href="{{ route('admin.daily-rewards.index') }}"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-gift"></i> Daily Rewards
                </a>
            </div>
        </div>

        {{-- Platform Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-bold"><i class="fas fa-users"></i> Total Users
                </p>
                <h3 class="text-[34px] font-black dark:text-white text-gray-900 mt-2">{{ $totalUsers }}</h3>
                <p class="text-[13px] text-orange-400 font-bold"><i class="fas fa-user-plus"></i> Registered users</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-bold"><i class="fas fa-coins"></i> Total XP
                    Earned</p>
                <h3 class="text-[34px] font-black text-pink-400 mt-2">{{ number_format($totalXpEarned) }}</h3>
                <p class="text-[13px] text-pink-400 font-bold"><i class="fas fa-globe"></i> Platform-wide XP</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-bold"><i class="fas fa-medal"></i> Badges Given
                </p>
                <h3 class="text-[34px] font-black text-yellow-400 mt-2">{{ $totalBadgesGiven }}</h3>
                <p class="text-[13px] text-yellow-400 font-bold"><i class="fas fa-unlock"></i> Total unlocked</p>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-bold"><i class="fas fa-tasks"></i> Challenges
                    Done</p>
                <h3 class="text-[34px] font-black text-emerald-400 mt-2">{{ $totalChallengesDone }}</h3>
                <p class="text-[13px] text-emerald-400 font-bold"> <i class="fas fa-check-circle"></i> Completed by users
                </p>
            </div>
        </div>

        {{-- Top Users Leaderboard --}}
        <div
            class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
            <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900 mb-4"><i class="fas fa-trophy"></i> Top 10
                Leaderboard</h3>

            <div class="space-y-3">
                @foreach ($topUsers as $i => $ug)
                    <div class="flex items-center gap-4 p-3 rounded-xl dark:bg-white/[0.04] bg-gray-50">
                        {{-- Rank --}}
                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center font-black text-[13px]
                        {{ $i === 0 ? 'bg-yellow-400 text-yellow-900' : ($i === 1 ? 'bg-gray-300 text-gray-700' : ($i === 2 ? 'bg-orange-400 text-orange-900' : 'dark:bg-white/[0.08] bg-gray-200 dark:text-gray-300 text-gray-600')) }}">
                            {{ $i + 1 }}
                        </div>

                        <div class="flex-1">
                            <p class="text-[14px] font-bold dark:text-white text-gray-900">
                                {{ $ug->user->name ?? 'Unknown' }}
                            </p>
                            <p class="text-[12px] dark:text-gray-500 text-gray-400">
                                {{ $ug->user->email ?? '' }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-[14px] font-black text-orange-400">{{ number_format($ug->xp) }} XP</p>
                            <p class="text-[12px] dark:text-gray-500 text-gray-400"><i class="fas fa-level-up-alt"></i>
                                Level {{ $ug->level }}</p>
                        </div>

                        <div class="text-right hidden sm:block">
                            <p class="text-[14px] font-bold text-emerald-400"><i class="fas fa-fire"></i>
                                {{ $ug->streak_days }}</p>
                            <p class="text-[12px] dark:text-gray-500 text-gray-400"><i class="fas fa-clock"></i> Current
                                streak</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Quick Badge & Challenge Overview --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

            {{-- Badges Summary --}}
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900"><i class="fas fa-medal"></i> Recent
                        Badges</h3>
                    <a href="{{ route('admin.badges.index') }}"
                        class="text-[13px] font-bold text-orange-400 hover:underline"><i class="fas fa-eye"></i> View
                        all</a>
                </div>

                <div class="space-y-3">
                    @forelse($badges->take(5) as $badge)
                        <div class="flex items-center gap-3 p-3 rounded-xl dark:bg-white/[0.04] bg-gray-50">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-black"
                                style="background: {{ $badge->color }}">
                                {{ $badge->icon ?? '🏆' }}
                            </div>
                            <div class="flex-1">
                                <p class="text-[14px] font-bold dark:text-white text-gray-900">{{ $badge->name }}</p>
                                <p class="text-[12px] dark:text-gray-500 text-gray-400">{{ $badge->xp_required }} XP
                                    required</p>
                            </div>
                            <span class="text-[12px] font-bold text-emerald-400">
                                {{ $badge->users_count }} users
                            </span>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-6">No badges created yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Challenges Summary --}}
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900"><i class="fas fa-tasks"></i> Recent
                        Challenges</h3>
                    <a href="{{ route('admin.challenges.index') }}"
                        class="text-[13px] font-bold text-orange-400 hover:underline"><i class="fas fa-eye"></i> View
                        all</a>
                </div>

                <div class="space-y-3">
                    @forelse($challenges->take(5) as $challenge)
                        <div class="p-3 rounded-xl dark:bg-white/[0.04] bg-gray-50">
                            <div class="flex items-center justify-between">
                                <p class="text-[14px] font-bold dark:text-white text-gray-900">{{ $challenge->title }}</p>
                                <span class="text-[12px] font-bold text-orange-400">+{{ $challenge->xp_reward }} XP</span>
                            </div>
                            <div class="flex items-center gap-4 mt-1">
                                <span class="text-[12px] dark:text-gray-500 text-gray-400">
                                    {{ $challenge->users_count }} joined
                                </span>
                                <span class="text-[12px] text-emerald-400 font-bold">
                                    {{ $challenge->completed_count }} completed
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-6">No challenges created yet.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </section>
@endsection
