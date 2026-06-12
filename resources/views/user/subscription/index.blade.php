@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">

        {{-- ── Header ─────────────────────────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-cube mr-2"></i> My Subscription
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Manage your plan, view usage, and explore upgrades.
                </p>
            </div>
            <a href="{{ route('user.pricing') }}"
                class="flex items-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold
                  bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.35)]">
                <i class="fas fa-arrow-up mr-1"></i> View All Plans
            </a>
        </div>

        {{-- ── Alerts ──────────────────────────────────────────────────────────── --}}
        @if (session('success'))
            <div
                class="flex items-start gap-3 p-4 rounded-xl dark:bg-emerald-500/[0.12] bg-emerald-50
                border dark:border-emerald-500/25 border-emerald-200">
                <i class="fas fa-check-circle text-emerald-400 mt-0.5"></i>
                <p class="text-[14px] font-semibold dark:text-emerald-300 text-emerald-700">{!! session('success') !!}</p>
            </div>
        @endif
        @if (session('error'))
            <div
                class="flex items-start gap-3 p-4 rounded-xl dark:bg-red-500/[0.12] bg-red-50
                border dark:border-red-500/25 border-red-200">
                <i class="fas fa-exclamation-circle text-red-400 mt-0.5"></i>
                <p class="text-[14px] font-semibold dark:text-red-300 text-red-700">{{ session('error') }}</p>
            </div>
        @endif

        {{-- ══════════════════════════════════════════════════════════════
         CURRENT PLAN CARD
    ═══════════════════════════════════════════════════════════════ --}}
        @if ($currentSubscription)
            @php
                $plan = $currentSubscription->plan;
                $planColor = $plan->color ?? '#f97316';
                $isFree = $plan->price_monthly == 0;
                $statusColors = [
                    'active' => [
                        'bg' => 'dark:bg-emerald-500/20 bg-emerald-50',
                        'text' => 'dark:text-emerald-400 text-emerald-600',
                        'border' => 'dark:border-emerald-500/30 border-emerald-200',
                    ],
                    'trial' => [
                        'bg' => 'dark:bg-blue-500/20 bg-blue-50',
                        'text' => 'dark:text-blue-400 text-blue-600',
                        'border' => 'dark:border-blue-500/30 border-blue-200',
                    ],
                    'cancelled' => [
                        'bg' => 'dark:bg-red-500/20 bg-red-50',
                        'text' => 'dark:text-red-400 text-red-600',
                        'border' => 'dark:border-red-500/30 border-red-200',
                    ],
                    'expired' => [
                        'bg' => 'dark:bg-gray-500/20 bg-gray-50',
                        'text' => 'dark:text-gray-400 text-gray-500',
                        'border' => 'dark:border-gray-500/30 border-gray-200',
                    ],
                ];
                $sc = $statusColors[$currentSubscription->status] ?? $statusColors['active'];
            @endphp
            <div
                class="relative overflow-hidden rounded-2xl border dark:border-white/[0.07] border-black/[0.07]
                dark:bg-[#17141f] bg-white p-6">

                {{-- Ambient glow --}}
                <div class="absolute top-0 right-0 w-56 h-56 rounded-full blur-3xl opacity-[0.12] pointer-events-none"
                    style="background:{{ $planColor }}"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 rounded-full blur-3xl opacity-[0.08] pointer-events-none"
                    style="background:{{ $planColor }}"></div>

                <div class="relative z-10">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">

                        {{-- Left: Plan info --}}
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-[32px] flex-shrink-0"
                                style="background:{{ $planColor }}22; border:1.5px solid {{ $planColor }}44;">
                                {{ $plan->icon ?? '💎' }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="text-[20px] font-extrabold dark:text-white text-gray-900">
                                        {{ $plan->name }} Plan
                                    </h3>
                                    <span
                                        class="px-2.5 py-[3px] rounded-full text-[11px] font-bold border {{ $sc['bg'] }} {{ $sc['text'] }} {{ $sc['border'] }}">
                                        {{ ucfirst($currentSubscription->status) }}
                                    </span>
                                </div>
                                <p class="text-[13px] dark:text-gray-400 text-gray-500">
                                    {{ $isFree ? 'Free plan — upgrade anytime to unlock more.' : $plan->description ?? '' }}
                                </p>
                                <div
                                    class="flex flex-wrap items-center gap-3 mt-2 text-[12px] dark:text-gray-500 text-gray-400">
                                    <span><i class="fas fa-calendar-alt mr-1 text-orange-400"></i>
                                        Started
                                        {{ $currentSubscription->starts_at?->format('M d, Y') ?? 'N/A' }}
                                    </span>
                                    @if ($currentSubscription->ends_at)
                                        <span><i class="fas fa-clock mr-1 text-pink-400"></i>
                                            Renews
                                            {{ $currentSubscription->ends_at->format('M d, Y') }}
                                        </span>
                                    @else
                                        <span><i class="fas fa-infinity mr-1 text-emerald-400"></i> No expiry</span>
                                    @endif
                                    <span><i class="fas fa-sync mr-1"></i>
                                        {{ ucfirst($currentSubscription->billing_cycle) }} billing
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Right: Price + actions --}}
                        <div class="flex-shrink-0 text-right">
                            <p class="text-[32px] font-extrabold dark:text-white text-gray-900 leading-none">
                                @if ($isFree)
                                    $0
                                @else
                                    ${{ $currentSubscription->billing_cycle === 'yearly'
                                        ? number_format($plan->price_yearly, 2)
                                        : number_format($plan->price_monthly, 2) }}
                                @endif
                            </p>
                            <p class="text-[13px] dark:text-gray-500 text-gray-400">
                                / {{ $currentSubscription->billing_cycle === 'yearly' ? 'year' : 'month' }}
                            </p>

                            <div class="flex items-center justify-end gap-2 mt-3">
                                @if (!$isFree && $currentSubscription->status !== 'cancelled')
                                    <button onclick="document.getElementById('cancelModal').classList.remove('hidden')"
                                        class="px-3 py-2 rounded-[9px] text-[12px] font-bold dark:bg-white/[0.06] bg-gray-100 dark:text-red-400 text-red-500 dark:hover:bg-red-500/20 hover:bg-red-100 transition-colors">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </button>
                                @endif
                                @if ($isFree)
                                    <a href="{{ route('user.pricing') }}"
                                        class="px-4 py-2 rounded-[10px] text-white text-[12px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_12px_rgba(249,115,22,0.35)]">
                                        <i class="fas fa-arrow-up mr-1"></i> Upgrade Now
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Plan features at a glance --}}
                    @if ($plan->features && count($plan->features) > 0)
                        <div class="mt-5 pt-4 border-t dark:border-white/[0.06] border-black/[0.05]">
                            <p
                                class="text-[11px] font-bold uppercase tracking-wider dark:text-gray-500 text-gray-400 mb-2.5">
                                <i class="fas fa-check-circle mr-1"></i> Plan Includes
                            </p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($plan->features as $feat)
                                    <span
                                        class="flex items-center gap-1.5 text-[12px] font-semibold px-2.5 py-1 rounded-lg
                                         dark:bg-white/[0.05] bg-gray-100 dark:text-gray-300 text-gray-600">
                                        <span style="color:{{ $planColor }}">✓</span> {{ $feat }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            {{-- No subscription found --}}
            <div
                class="p-10 text-center dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl">
                <div class="text-[40px] mb-3">🌱</div>
                <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900">No active plan found</h3>
                <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-1 mb-4">
                    Start with our free plan to access all basic features.
                </p>
                <a href="{{ route('user.pricing') }}"
                    class="inline-block px-5 py-2.5 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-eye mr-1"></i> View Plans
                </a>
            </div>
        @endif

        {{-- ══════════════════════════════════════════════════════════════
         USAGE STATS
    ═══════════════════════════════════════════════════════════════ --}}
        <div class="dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
            <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900 mb-4">
                <i class="fas fa-chart-line mr-1"></i> Usage This Month
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($usageStats as $stat)
                    @php
                        $isUnlimited = $stat['limit'] === -1;
                        $isWarning = !$isUnlimited && $stat['pct'] >= 80;
                        $isDanger = !$isUnlimited && $stat['pct'] >= 100;
                        $barColor = $isDanger
                            ? 'bg-red-500'
                            : ($isWarning
                                ? 'bg-yellow-400'
                                : 'bg-gradient-to-r from-orange-500 to-pink-500');
                        $textColor = $isDanger
                            ? 'text-red-400'
                            : ($isWarning
                                ? 'text-yellow-400'
                                : 'dark:text-white text-gray-900');
                    @endphp
                    <div
                        class="dark:bg-white/[0.03] bg-gray-50 rounded-xl p-4 border dark:border-white/[0.05] border-black/[0.04]">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <span class="text-[18px] leading-none">{{ $stat['icon'] }}</span>
                                <span
                                    class="text-[13px] font-bold dark:text-gray-300 text-gray-700">{{ $stat['label'] }}</span>
                            </div>
                            <span class="text-[13px] font-extrabold {{ $textColor }}">
                                {{ $stat['used'] }}{{ $isUnlimited ? '' : ' / ' . $stat['limit'] }}
                                @if ($isUnlimited)
                                    <span class="text-[11px] text-orange-400">∞</span>
                                @endif
                            </span>
                        </div>
                        <div class="w-full h-[6px] rounded-full dark:bg-white/[0.08] bg-gray-200 overflow-hidden">
                            @if ($isUnlimited)
                                <div
                                    class="h-full w-full rounded-full bg-gradient-to-r from-orange-500/30 to-pink-500/30
                                bg-[length:200%_100%] animate-pulse">
                                </div>
                            @else
                                <div class="h-full rounded-full {{ $barColor }} transition-all duration-700"
                                    style="width:{{ $stat['pct'] }}%"></div>
                            @endif
                        </div>
                        @if (!$isUnlimited)
                            <p class="text-[10px] dark:text-gray-600 text-gray-400 mt-1 text-right">
                                {{ $stat['pct'] }}% used
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════
         UPGRADE CTA (if on free plan)
    ═══════════════════════════════════════════════════════════════ --}}
        @if (!$currentSubscription || $currentSubscription->plan->price_monthly == 0)
            <div
                class="relative overflow-hidden rounded-2xl p-6
                dark:bg-[#17141f] bg-white border border-orange-500/30
                shadow-[0_0_40px_rgba(249,115,22,0.1)]">
                <div
                    class="absolute top-0 right-0 w-56 h-56 rounded-full blur-3xl opacity-15 pointer-events-none bg-orange-500">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-44 h-44 rounded-full blur-3xl opacity-10 pointer-events-none bg-pink-500">
                </div>
                <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-5">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-[24px]"><i class="fas fa-crown"></i></span>
                            <span
                                class="text-[14px] font-bold px-2.5 py-0.5 rounded-full
                                 bg-orange-500/20 text-orange-400 border border-orange-500/30">
                                <i class="fas fa-arrow-up mr-1"></i> Upgrade to Pro
                            </span>
                        </div>
                        <h3 class="text-[20px] font-extrabold dark:text-white text-gray-900 mb-1">
                            Unlock unlimited power
                        </h3>
                        <p class="text-[13px] dark:text-gray-400 text-gray-500 max-w-[420px]">
                            Remove all limits on tasks, habits, notes and goals. Get advanced analytics,
                            custom themes, priority support and more.
                        </p>
                        <div class="flex flex-wrap gap-3 mt-3">
                            @foreach (['Unlimited tasks & habits', 'Advanced analytics', 'Custom themes', 'Priority support'] as $feat)
                                <span class="flex items-center gap-1.5 text-[12px] dark:text-gray-300 text-gray-600">
                                    <span class="text-orange-400"><i class="fas fa-check"></i></span> {{ $feat }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex-shrink-0 text-center">
                        <p class="text-[32px] font-extrabold dark:text-white text-gray-900 leading-none">$9.99</p>
                        <p class="text-[12px] dark:text-gray-500 text-gray-400 mb-3">/month</p>
                        <a href="{{ route('user.pricing') }}"
                            class="block px-6 py-3 rounded-xl text-white font-bold text-[14px]
                          bg-gradient-to-r from-orange-500 to-pink-500
                          shadow-[0_4px_18px_rgba(249,115,22,0.42)]
                          hover:shadow-[0_6px_24px_rgba(249,115,22,0.55)] transition-shadow">
                            Upgrade Now <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- ══════════════════════════════════════════════════════════════
         AVAILABLE PLANS (quick upgrade section)
    ═══════════════════════════════════════════════════════════════ --}}
        @if ($availablePlans->count() > 1)
            <div class="dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900">
                        <i class="fas fa-list mr-2"></i> Available Plans
                    </h3>
                    <a href="{{ route('user.pricing') }}"
                        class="text-[13px] font-bold text-orange-400 hover:text-orange-500">
                        <i class="fas fa-sync-alt mr-1"></i> Full comparison <i
                            class="fas fa-arrow-right ml-1 text-[11px]"></i>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach ($availablePlans as $plan)
                        @php
                            $isCurrentPlan = $currentSubscription?->subscription_plan_id === $plan->id;
                            $planColor = $plan->color ?? '#f97316';
                            $isFree = $plan->price_monthly == 0;
                        @endphp
                        <div
                            class="relative overflow-hidden rounded-xl p-4 border transition-all
                        {{ $plan->is_featured
                            ? 'dark:border-orange-500/40 border-orange-200 dark:bg-[#1e1628] bg-orange-50/50'
                            : 'dark:border-white/[0.07] border-black/[0.07] dark:bg-white/[0.02] bg-gray-50' }}">

                            <div class="absolute top-0 right-0 w-24 h-24 rounded-full blur-2xl opacity-[0.15] pointer-events-none"
                                style="background:{{ $planColor }}"></div>

                            @if ($isCurrentPlan)
                                <div
                                    class="absolute top-3 right-3 px-2 py-0.5 rounded-md text-[10px] font-bold
                            dark:bg-emerald-500/20 bg-emerald-100 dark:text-emerald-400 text-emerald-600">
                                    <i class="fas fa-check"></i> Current
                                </div>
                            @elseif($plan->is_featured && $plan->badge_label)
                                <div class="absolute top-3 right-3 px-2 py-0.5 rounded-md text-[10px] font-bold text-white"
                                    style="background:{{ $plan->badge_color ?? $planColor }}">
                                    {{ $plan->badge_label }}
                                </div>
                            @endif

                            <div class="relative z-10">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[22px]">{{ $plan->icon ?? '💎' }}</span>
                                    <span
                                        class="text-[15px] font-extrabold dark:text-white text-gray-900">{{ $plan->name }}</span>
                                </div>
                                <div class="mb-3">
                                    <span class="text-[24px] font-extrabold dark:text-white text-gray-900">
                                        {{ $isFree ? 'Free' : '$' . number_format($plan->price_monthly, 2) }}
                                    </span>
                                    @if (!$isFree)
                                        <span class="text-[12px] dark:text-gray-500 text-gray-400">/mo</span>
                                    @endif
                                </div>

                                @if ($isCurrentPlan)
                                    <div
                                        class="w-full py-2 rounded-lg text-center text-[12px] font-bold
                                dark:bg-emerald-500/10 bg-emerald-50 dark:text-emerald-400 text-emerald-600">
                                        <i class="fas fa-check"></i> Your Current Plan
                                    </div>
                                @elseif($isFree)
                                    <a href="{{ route('user.dashboard') }}"
                                        class="block w-full py-2 rounded-lg text-center text-[12px] font-bold
                              dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                                        Downgrade to Free
                                    </a>
                                @else
                                    <button
                                        onclick="openUpgradeModal({{ $plan->id }}, '{{ $plan->name }}', '{{ number_format($plan->price_monthly, 2) }}', '{{ number_format($plan->price_yearly, 2) }}')"
                                        class="block w-full py-2 rounded-lg text-center text-[12px] font-bold text-white
                              {{ $plan->is_featured
                                  ? 'bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_3px_10px_rgba(249,115,22,0.35)]'
                                  : 'dark:bg-white/[0.1] bg-gray-200 dark:text-gray-200 text-gray-800' }}
                              hover:opacity-90 transition-opacity">
                                        @if ($plan->has_team_workspace)
                                            Contact Sales
                                        @else
                                            Get {{ $plan->name }}
                                        @endif
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ══════════════════════════════════════════════════════════════
         SUBSCRIPTION HISTORY
    ═══════════════════════════════════════════════════════════════ --}}
        @if ($subscriptionHistory->count() > 0)
            <div class="dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900 mb-4">
                    <i class="fas fa-history mr-2"></i> Subscription History
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-[13px]">
                        <thead>
                            <tr class="border-b dark:border-white/[0.07] border-black/[0.07]">
                                <th
                                    class="text-left py-2.5 px-3 font-bold dark:text-gray-400 text-gray-500 text-[12px] uppercase tracking-wider">
                                    <i class="fas fa-box mr-1"></i> Plan
                                </th>
                                <th
                                    class="text-left py-2.5 px-3 font-bold dark:text-gray-400 text-gray-500 text-[12px] uppercase tracking-wider">
                                    <i class="fas fa-file-invoice mr-1"></i> Billing
                                </th>
                                <th
                                    class="text-left py-2.5 px-3 font-bold dark:text-gray-400 text-gray-500 text-[12px] uppercase tracking-wider">
                                    <i class="fas fa-info-circle mr-1"></i> Status
                                </th>
                                <th
                                    class="text-left py-2.5 px-3 font-bold dark:text-gray-400 text-gray-500 text-[12px] uppercase tracking-wider">
                                    <i class="fas fa-clock mr-1"></i> Started
                                </th>
                                <th
                                    class="text-left py-2.5 px-3 font-bold dark:text-gray-400 text-gray-500 text-[12px] uppercase tracking-wider">
                                    <i class="fas fa-calendar-alt mr-1"></i> Expires
                                </th>
                                <th
                                    class="text-right py-2.5 px-3 font-bold dark:text-gray-400 text-gray-500 text-[12px] uppercase tracking-wider">
                                    <i class="fas fa-dollar-sign mr-1"></i> Paid
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptionHistory as $sub)
                                @php
                                    $sColor = match ($sub->status) {
                                        'active'
                                            => 'dark:bg-emerald-500/20 bg-emerald-50 dark:text-emerald-400 text-emerald-600',
                                        'trial' => 'dark:bg-blue-500/20 bg-blue-50 dark:text-blue-400 text-blue-600',
                                        'cancelled' => 'dark:bg-red-500/20 bg-red-50 dark:text-red-400 text-red-600',
                                        'expired' => 'dark:bg-gray-500/20 bg-gray-100 dark:text-gray-400 text-gray-500',
                                        default => 'dark:bg-gray-500/20 bg-gray-100 dark:text-gray-400 text-gray-500',
                                    };
                                @endphp
                                <tr
                                    class="border-b dark:border-white/[0.04] border-black/[0.04] dark:hover:bg-white/[0.02] hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[16px]">{{ $sub->plan->icon ?? '💎' }}</span>
                                            <span
                                                class="font-bold dark:text-white text-gray-900">{{ $sub->plan->name ?? '—' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 dark:text-gray-400 text-gray-500 capitalize">
                                        {{ $sub->billing_cycle }}</td>
                                    <td class="py-3 px-3">
                                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $sColor }}">
                                            {{ ucfirst($sub->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 dark:text-gray-400 text-gray-500">
                                        {{ $sub->starts_at?->format('M d, Y') ?? '—' }}
                                    </td>
                                    <td class="py-3 px-3 dark:text-gray-400 text-gray-500">
                                        {{ $sub->ends_at ? $sub->ends_at->format('M d, Y') : '∞ No expiry' }}
                                    </td>
                                    <td class="py-3 px-3 text-right font-bold dark:text-white text-gray-900">
                                        ${{ number_format($sub->amount_paid, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </section>

    {{-- ══════════════════════════════════════════════════════════════
     UPGRADE REQUEST MODAL
═══════════════════════════════════════════════════════════════ --}}
    <div id="upgradeModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
        onclick="if(event.target===this) closeUpgradeModal()">
        <div class="absolute inset-0 dark:bg-black/70 bg-black/40 backdrop-blur-sm"></div>
        <div
            class="relative w-full max-w-md dark:bg-[#1a1625] bg-white border dark:border-white/[0.1] border-black/[0.08] rounded-2xl shadow-2xl">
            <div class="flex items-center justify-between px-6 py-5 border-b dark:border-white/[0.07] border-black/[0.07]">
                <div>
                    <h3 class="text-[17px] font-extrabold dark:text-white text-gray-900">Upgrade Plan</h3>
                    <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-0.5">Your request will be reviewed by our
                        team.</p>
                </div>
                <button onclick="closeUpgradeModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-xl dark:bg-white/[0.06] bg-black/[0.05] dark:text-gray-400 text-gray-500 dark:hover:bg-white/[0.1] hover:bg-black/[0.08] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('user.subscription.upgrade') }}" method="POST" class="px-6 py-5 space-y-4">
                @csrf
                <input type="hidden" name="plan_id" id="modalPlanId">

                {{-- Plan summary --}}
                <div
                    class="flex items-center gap-3 p-3.5 rounded-xl dark:bg-orange-500/[0.08] bg-orange-50 border dark:border-orange-500/20 border-orange-200">
                    <div class="text-[28px]" id="modalPlanIcon">⚡</div>
                    <div>
                        <p class="text-[14px] font-extrabold dark:text-white text-gray-900" id="modalPlanName">Pro</p>
                        <p class="text-[12px] text-orange-400 font-bold" id="modalPlanPrice">$9.99/mo</p>
                    </div>
                </div>

                {{-- Billing cycle --}}
                <div>
                    <label
                        class="block text-[12px] font-bold uppercase tracking-wider dark:text-gray-400 text-gray-500 mb-2">Billing
                        Cycle</label>
                    <div class="flex gap-2">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="billing_cycle" value="monthly" class="sr-only peer" checked>
                            <div
                                class="p-3 rounded-xl border-2 text-center text-[13px] font-bold transition-all
                                    dark:border-white/[0.08] border-black/[0.08]
                                    dark:peer-checked:border-orange-500/60 peer-checked:border-orange-400
                                    peer-checked:dark:bg-orange-500/10 peer-checked:bg-orange-50
                                    dark:text-gray-300 text-gray-700 peer-checked:text-orange-500">
                                <span id="modalMonthlyPrice">$9.99</span>/mo
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="billing_cycle" value="yearly" class="sr-only peer">
                            <div
                                class="p-3 rounded-xl border-2 text-center text-[13px] font-bold transition-all
                                    dark:border-white/[0.08] border-black/[0.08]
                                    dark:peer-checked:border-orange-500/60 peer-checked:border-orange-400
                                    peer-checked:dark:bg-orange-500/10 peer-checked:bg-orange-50
                                    dark:text-gray-300 text-gray-700 peer-checked:text-orange-500">
                                <span id="modalYearlyPrice">$89.99</span>/yr
                                <span class="block text-[10px] text-emerald-400">Save more</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Optional message --}}
                <div>
                    <label
                        class="block text-[12px] font-bold uppercase tracking-wider dark:text-gray-400 text-gray-500 mb-1.5">
                        Message to admin <span class="normal-case font-normal">(optional)</span>
                    </label>
                    <textarea name="message" rows="2" placeholder="Any special requests or notes..."
                        class="w-full px-3.5 py-2.5 rounded-xl border dark:border-white/[0.1] border-black/[0.1] dark:bg-white/[0.04] bg-black/[0.02] dark:text-white text-gray-900 text-[14px] placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500/50 resize-none"></textarea>
                </div>

                <p class="text-[12px] dark:text-gray-500 text-gray-400">
                    <i class="fas fa-info-circle text-orange-400 mr-1"></i>
                    Your upgrade request will be sent to the admin team who will activate it manually.
                </p>

                <div class="flex gap-2.5 pt-1">
                    <button type="button" onclick="closeUpgradeModal()"
                        class="flex-1 py-2.5 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-black/[0.05] dark:text-gray-300 text-gray-600">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
     CANCEL CONFIRMATION MODAL
═══════════════════════════════════════════════════════════════ --}}
    <div id="cancelModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
        onclick="if(event.target===this) document.getElementById('cancelModal').classList.add('hidden')">
        <div class="absolute inset-0 dark:bg-black/70 bg-black/40 backdrop-blur-sm"></div>
        <div
            class="relative w-full max-w-sm dark:bg-[#1a1625] bg-white border dark:border-white/[0.1] border-black/[0.08] rounded-2xl shadow-2xl p-6">
            <div class="text-center mb-5">
                <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-red-500/20 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-400 text-[22px]"></i>
                </div>
                <h3 class="text-[17px] font-extrabold dark:text-white text-gray-900">Cancel Subscription?</h3>
                <p class="text-[13px] dark:text-gray-400 text-gray-500 mt-2">
                    You'll be moved to the Free plan immediately. All your data will be preserved,
                    but you'll lose access to premium features.
                </p>
            </div>
            <div class="flex gap-2.5">
                <button onclick="document.getElementById('cancelModal').classList.add('hidden')"
                    class="flex-1 py-2.5 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-black/[0.05] dark:text-gray-300 text-gray-600">
                    Keep Plan
                </button>
                <form action="{{ route('user.subscription.cancel') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full py-2.5 rounded-[10px] text-white text-[14px] font-bold bg-red-500 hover:bg-red-600 transition-colors">
                        Yes, Cancel
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openUpgradeModal(planId, planName, monthlyPrice, yearlyPrice) {
            document.getElementById('modalPlanId').value = planId;
            document.getElementById('modalPlanName').textContent = planName + ' Plan';
            document.getElementById('modalPlanPrice').textContent = '$' + monthlyPrice + '/mo';
            document.getElementById('modalMonthlyPrice').textContent = '$' + monthlyPrice;
            document.getElementById('modalYearlyPrice').textContent = '$' + yearlyPrice;
            document.getElementById('upgradeModal').classList.remove('hidden');
        }

        function closeUpgradeModal() {
            document.getElementById('upgradeModal').classList.add('hidden');
        }
    </script>

@endsection
