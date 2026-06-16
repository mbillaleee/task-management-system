@extends('admin.layouts.master')

@section('admin')
    <section class="flex-1 p-4 sm:p-5 flex flex-col gap-5">

        {{-- ── Header ─────────────────────────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[22px] font-extrabold dark:text-white text-gray-900">
                    <i class="fas fa-id-badge text-orange-500 mr-2"></i> User Profile
                </h2>
                <p class="text-[13px] dark:text-gray-400 text-gray-500 mt-0.5">
                    Full user overview — activity, gamification, subscription & admin controls.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.users.edit', $user->id) }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-[10px] bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold text-[13px] hover:opacity-90 transition">
                    <i class="fas fa-pen"></i> Edit User
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded-[10px] dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-700 font-semibold text-[13px] hover:opacity-80 transition">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        {{-- ── Alerts ──────────────────────────────────────────────────────────── --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 text-[13px] font-semibold">
                <i class="fas fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-500 text-[13px] font-semibold">
                <i class="fas fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div
                class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-500 text-[13px] font-semibold">
                <i class="fas fa-triangle-exclamation"></i> {{ $errors->first() }}
            </div>
        @endif

        {{-- ── Profile Banner ──────────────────────────────────────────────────── --}}
        <div class="relative overflow-hidden rounded-2xl  veroa-card border">
            <div class="h-28 bg-gradient-to-r from-orange-500 via-pink-500 to-purple-600"></div>
            <div class="p-5 sm:p-6 -mt-14 flex flex-col md:flex-row md:items-end justify-between gap-5">
                <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                    @if ($user->profile)
                        <img src="{{ asset('storage/profile/' . $user->profile) }}" alt=""
                            class="w-24 h-24 rounded-2xl object-cover border-4 dark:border-[#17141f] border-white shadow-xl">
                    @else
                        <div
                            class="w-24 h-24 rounded-2xl bg-gradient-to-br from-orange-500 to-pink-500 flex items-center justify-center text-white font-black text-[36px] border-4 dark:border-[#17141f] border-white shadow-xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="pb-1">
                        <h3 class="text-[22px] font-black dark:text-white text-gray-900">{{ $user->name }}</h3>
                        <p class="text-[13px] dark:text-gray-400 text-gray-500 mt-0.5">
                            <i class="fas fa-envelope mr-1 text-orange-500"></i>{{ $user->email }}
                        </p>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @if ($user->status == 1)
                                <span
                                    class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-500/15 text-emerald-500">
                                    <i class="fas fa-circle text-[7px] mr-1"></i> Active
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-500/15 text-red-500">
                                    <i class="fas fa-ban text-[10px] mr-1"></i> Suspended
                                </span>
                            @endif
                            @foreach ($user->getRoleNames() as $r)
                                <span
                                    class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $r === 'super_admin' ? 'bg-purple-500/15 text-purple-400' : 'bg-orange-500/15 text-orange-400' }}">
                                    <i
                                        class="fas fa-{{ $r === 'super_admin' ? 'crown' : 'user' }} mr-1"></i>{{ $r }}
                                </span>
                            @endforeach
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-500/15 text-blue-500">
                                <i class="fas fa-calendar-plus mr-1"></i> Joined {{ $user->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
                {{-- Quick Admin Actions --}}
                <div class="flex flex-wrap gap-2 pb-1">
                    {{-- Suspend / Activate --}}
                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl text-[13px] font-bold transition
                                {{ $user->status == 1 ? 'bg-red-500/15 text-red-500 hover:bg-red-500/25 border border-red-500/20' : 'bg-emerald-500/15 text-emerald-500 hover:bg-emerald-500/25 border border-emerald-500/20' }}">
                            <i class="fas fa-{{ $user->status == 1 ? 'ban' : 'circle-check' }}"></i>
                            {{ $user->status == 1 ? 'Suspend' : 'Activate' }}
                        </button>
                    </form>
                    {{-- Impersonate --}}
                    @unless ($user->hasRole('super_admin'))
                        <form action="{{ route('admin.users.impersonate', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 rounded-xl text-[13px] font-bold bg-purple-500/15 text-purple-400 hover:bg-purple-500/25 border border-purple-500/20 transition">
                                <i class="fas fa-right-to-bracket"></i> Login as User
                            </button>
                        </form>
                    @endunless
                </div>
            </div>
        </div>

        {{-- ── Main Grid ────────────────────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

            {{-- ── Left Column ──────────────────────────────────────────────────── --}}
            <div class="space-y-5 xl:col-span-1">

                {{-- Gamification Stats --}}
                <div class="rounded-2xl  veroa-card border p-5">
                    <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-4">
                        <i class="fas fa-trophy text-amber-500 mr-2"></i> Gamification Stats
                    </h4>
                    @if ($gamification)
                        @php
                            $xpForNextLevel = $gamification->level * 100;
                            $xpProgress =
                                $xpForNextLevel > 0
                                    ? min(100, round((($gamification->xp % $xpForNextLevel) / $xpForNextLevel) * 100))
                                    : 0;
                        @endphp
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="p-3 rounded-xl dark:bg-[#0f0c17] bg-gray-50 text-center">
                                <div class="text-[22px] font-black text-amber-500">{{ number_format($gamification->xp) }}
                                </div>
                                <div class="text-[11px] dark:text-gray-500 text-gray-400 mt-0.5">Total XP</div>
                            </div>
                            <div class="p-3 rounded-xl dark:bg-[#0f0c17] bg-gray-50 text-center">
                                <div class="text-[22px] font-black text-indigo-500">{{ $gamification->level }}</div>
                                <div class="text-[11px] dark:text-gray-500 text-gray-400 mt-0.5">Level</div>
                            </div>
                            <div class="p-3 rounded-xl dark:bg-[#0f0c17] bg-gray-50 text-center">
                                <div class="text-[22px] font-black text-orange-500">{{ $gamification->streak_days ?? 0 }}
                                </div>
                                <div class="text-[11px] dark:text-gray-500 text-gray-400 mt-0.5">Day Streak</div>
                            </div>
                            <div class="p-3 rounded-xl dark:bg-[#0f0c17] bg-gray-50 text-center">
                                <div class="text-[22px] font-black text-pink-500">{{ $gamification->max_streak ?? 0 }}
                                </div>
                                <div class="text-[11px] dark:text-gray-500 text-gray-400 mt-0.5">Best Streak</div>
                            </div>
                        </div>
                        {{-- XP Progress Bar --}}
                        <div>
                            <div class="flex justify-between text-[11px] dark:text-gray-500 text-gray-400 mb-1.5">
                                <span>XP Progress to Lv.{{ $gamification->level + 1 }}</span>
                                <span>{{ $xpProgress }}%</span>
                            </div>
                            <div class="w-full h-2 rounded-full dark:bg-white/[0.06] bg-gray-100">
                                <div class="h-2 rounded-full bg-gradient-to-r from-orange-500 to-pink-500 transition-all"
                                    style="width:{{ $xpProgress }}%"></div>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center py-6 gap-2">
                            <i class="fas fa-trophy text-gray-300 dark:text-gray-700 text-[30px]"></i>
                            <p class="text-[13px] dark:text-gray-500 text-gray-400">No gamification data yet</p>
                        </div>
                    @endif
                </div>

                {{-- Subscription --}}
                <div class="rounded-2xl  veroa-card border p-5">
                    <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-4">
                        <i class="fas fa-gem text-blue-500 mr-2"></i> Subscription
                    </h4>
                    @if ($user->activeSubscription)
                        @php $sub = $user->activeSubscription; @endphp
                        <div
                            class="p-4 rounded-xl bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 mb-3">
                            <div class="text-[16px] font-black dark:text-white text-gray-900">
                                {{ $sub->plan->name ?? 'Unknown' }}</div>
                            <div class="text-[12px] dark:text-gray-400 text-gray-500 mt-0.5">
                                {{ ucfirst($sub->billing_cycle) }} ·
                                @if ($sub->plan && $sub->plan->price_monthly == 0)
                                    <span class="text-emerald-500 font-bold">Free Plan</span>
                                @else
                                    <span class="text-blue-400 font-bold">€{{ number_format($sub->amount_paid, 2) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="space-y-2 text-[12px]">
                            <div class="flex justify-between">
                                <span class="dark:text-gray-500 text-gray-400">Status</span>
                                <span
                                    class="font-semibold {{ $sub->status === 'active' ? 'text-emerald-500' : 'text-amber-500' }}">
                                    {{ ucfirst($sub->status) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="dark:text-gray-500 text-gray-400">Started</span>
                                <span class="dark:text-gray-300 text-gray-700 font-semibold">
                                    {{ $sub->starts_at ? $sub->starts_at->format('d M Y') : '—' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="dark:text-gray-500 text-gray-400">Expires</span>
                                <span class="dark:text-gray-300 text-gray-700 font-semibold">
                                    {{ $sub->ends_at ? $sub->ends_at->format('d M Y') : 'Never' }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center py-6 gap-2">
                            <i class="fas fa-gem text-gray-300 dark:text-gray-700 text-[28px]"></i>
                            <p class="text-[13px] dark:text-gray-500 text-gray-400">No active subscription</p>
                        </div>
                    @endif
                </div>

                {{-- Reset Password --}}
                <div class="rounded-2xl  veroa-card border p-5">
                    <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-4">
                        <i class="fas fa-key text-pink-500 mr-2"></i> Reset Password
                    </h4>
                    <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" class="space-y-3">
                        @csrf @method('PATCH')
                        <div>
                            <label
                                class="block text-[11px] font-semibold dark:text-gray-400 text-gray-500 mb-1 uppercase tracking-wide">New
                                Password</label>
                            <input type="password" name="new_password" required minlength="6"
                                placeholder="Min 6 characters"
                                class="w-full px-3 py-2.5 rounded-xl text-[13px] dark:bg-[#0f0c17] bg-gray-50 border dark:border-white/[0.07] border-gray-200 dark:text-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-500/40">
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-semibold dark:text-gray-400 text-gray-500 mb-1 uppercase tracking-wide">Confirm
                                Password</label>
                            <input type="password" name="new_password_confirmation" required minlength="6"
                                placeholder="Repeat password"
                                class="w-full px-3 py-2.5 rounded-xl text-[13px] dark:bg-[#0f0c17] bg-gray-50 border dark:border-white/[0.07] border-gray-200 dark:text-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-500/40">
                        </div>
                        <button type="submit"
                            class="w-full py-2.5 rounded-xl bg-gradient-to-r from-pink-500 to-purple-500 text-white font-bold text-[13px] hover:opacity-90 transition">
                            <i class="fas fa-key mr-2"></i> Reset Password
                        </button>
                    </form>
                </div>

            </div>

            {{-- ── Right Column ─────────────────────────────────────────────────── --}}
            <div class="xl:col-span-2 space-y-5">

                {{-- Activity Stats --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @php
                        $activityStats = [
                            [
                                'icon' => 'fa-list-check',
                                'color' => 'orange',
                                'value' => $user->tasks->count(),
                                'label' => 'Tasks',
                            ],
                            [
                                'icon' => 'fa-repeat',
                                'color' => 'emerald',
                                'value' => $user->habits->count(),
                                'label' => 'Habits',
                            ],
                            [
                                'icon' => 'fa-sticky-note',
                                'color' => 'blue',
                                'value' => $user->notes->count(),
                                'label' => 'Notes',
                            ],
                            [
                                'icon' => 'fa-bullseye',
                                'color' => 'purple',
                                'value' => $user->goals->count(),
                                'label' => 'Goals',
                            ],
                            [
                                'icon' => 'fa-book',
                                'color' => 'pink',
                                'value' => $user->journals->count(),
                                'label' => 'Journals',
                            ],
                            [
                                'icon' => 'fa-medal',
                                'color' => 'amber',
                                'value' => $user->badges->count(),
                                'label' => 'Badges',
                            ],
                        ];
                    @endphp
                    @foreach ($activityStats as $stat)
                        <div class="hover-lift p-4 rounded-2xl  veroa-card border flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-500/15 flex items-center justify-center shrink-0">
                                <i class="fas {{ $stat['icon'] }} text-{{ $stat['color'] }}-500 text-[15px]"></i>
                            </div>
                            <div>
                                <div class="text-[20px] font-extrabold dark:text-white text-gray-900 leading-none">
                                    {{ $stat['value'] }}</div>
                                <div class="text-[11px] dark:text-gray-500 text-gray-400 mt-0.5">{{ $stat['label'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Account Information --}}
                <div class="rounded-2xl  veroa-card border p-5">
                    <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-4">
                        <i class="fas fa-circle-info text-blue-500 mr-2"></i> Account Information
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @php
                            $infoRows = [
                                ['label' => 'Full Name', 'value' => $user->name, 'icon' => 'fa-user'],
                                ['label' => 'Email Address', 'value' => $user->email, 'icon' => 'fa-envelope'],
                                ['label' => 'User ID', 'value' => '#' . $user->id, 'icon' => 'fa-fingerprint'],
                                [
                                    'label' => 'Email Verified',
                                    'value' => $user->email_verified_at
                                        ? $user->email_verified_at->format('d M Y')
                                        : 'Not verified',
                                    'icon' => 'fa-shield-check',
                                ],
                                [
                                    'label' => 'Joined',
                                    'value' => $user->created_at->format('d M Y, H:i'),
                                    'icon' => 'fa-calendar-plus',
                                ],
                                [
                                    'label' => 'Last Updated',
                                    'value' => $user->updated_at->diffForHumans(),
                                    'icon' => 'fa-clock',
                                ],
                            ];
                        @endphp
                        @foreach ($infoRows as $row)
                            <div class="flex items-start gap-3 p-3 rounded-xl dark:bg-[#0f0c17] bg-gray-50">
                                <div
                                    class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center shrink-0 mt-0.5">
                                    <i class="fas {{ $row['icon'] }} text-blue-500 text-[11px]"></i>
                                </div>
                                <div>
                                    <div class="text-[11px] dark:text-gray-500 text-gray-400">{{ $row['label'] }}</div>
                                    <div class="text-[13px] font-semibold dark:text-white text-gray-900 mt-0.5">
                                        {{ $row['value'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Badges --}}
                @if ($user->badges->count() > 0)
                    <div class="rounded-2xl  veroa-card border p-5">
                        <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-4">
                            <i class="fas fa-medal text-amber-500 mr-2"></i> Earned Badges
                            <span
                                class="ml-2 px-2 py-0.5 rounded-full text-[10px] bg-amber-500/15 text-amber-500">{{ $user->badges->count() }}</span>
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($user->badges as $badge)
                                <div
                                    class="flex items-center gap-2 px-3 py-2 rounded-xl dark:bg-[#0f0c17] bg-gray-50 border dark:border-white/[0.05] border-gray-200">
                                    <i class="{{ $badge->icon ?? 'fas fa-medal' }} text-amber-500"></i>
                                    <span
                                        class="text-[12px] font-semibold dark:text-gray-300 text-gray-700">{{ $badge->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Subscription History --}}
                <div class="rounded-2xl  veroa-card border p-5">
                    <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-4">
                        <i class="fas fa-clock-rotate-left text-purple-500 mr-2"></i> Subscription History
                    </h4>
                    @if ($user->subscriptions->count() > 0)
                        <div class="space-y-2">
                            @foreach ($user->subscriptions->sortByDesc('created_at') as $sub)
                                <div class="flex items-center justify-between p-3 rounded-xl dark:bg-[#0f0c17] bg-gray-50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center">
                                            <i class="fas fa-gem text-purple-500 text-[11px]"></i>
                                        </div>
                                        <div>
                                            <div class="text-[13px] font-semibold dark:text-white text-gray-900">
                                                {{ $sub->plan->name ?? 'Unknown' }}</div>
                                            <div class="text-[11px] dark:text-gray-500 text-gray-400">
                                                {{ $sub->created_at->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-[12px] font-bold dark:text-gray-300 text-gray-700">€{{ number_format($sub->amount_paid, 2) }}</span>
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-bold
                                {{ $sub->status === 'active' ? 'bg-emerald-500/15 text-emerald-500' : ($sub->status === 'cancelled' ? 'bg-red-500/15 text-red-500' : 'bg-gray-500/15 text-gray-400') }}">
                                            {{ ucfirst($sub->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center py-6 gap-2">
                            <i class="fas fa-clock-rotate-left text-gray-300 dark:text-gray-700 text-[24px]"></i>
                            <p class="text-[13px] dark:text-gray-500 text-gray-400">No subscription history</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </section>
@endsection
