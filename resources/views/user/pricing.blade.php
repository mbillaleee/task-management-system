@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        {{-- ── Header ── --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    Pricing
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Choose the right plan for your productivity journey.
                </p>
            </div>

            {{-- Monthly / Yearly toggle --}}
            <div class="flex items-center gap-2 p-1 rounded-[12px] dark:bg-white/[0.06] bg-gray-100">
                <button type="button" id="monthlyBtn" onclick="setBillingCycle('monthly')"
                    class="px-4 py-2 rounded-[10px] text-[12px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500 transition-all">
                    Monthly
                </button>
                <button type="button" id="yearlyBtn" onclick="setBillingCycle('yearly')"
                    class="px-4 py-2 rounded-[10px] text-[12px] font-bold dark:text-gray-400 text-gray-500 transition-all">
                    Yearly
                    <span
                        class="ml-1 px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-emerald-500/20 text-emerald-400">Save</span>
                </button>
            </div>
        </div>

        {{-- ── Current Plan Banner (if subscribed) ── --}}
        @if ($currentSubscription)
            <div
                class="relative overflow-hidden rounded-2xl border border-orange-500/30 dark:bg-[#1c1015] bg-orange-50 p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="absolute top-0 right-0 w-40 h-40 bg-orange-500 blur-[80px] opacity-10 pointer-events-none">
                </div>
                <div class="relative z-10 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl flex-shrink-0"
                        style="background: {{ $currentSubscription->plan->color ?? '#f97316' }}22; border: 1.5px solid {{ $currentSubscription->plan->color ?? '#f97316' }}44;">
                        {{ $currentSubscription->plan->icon ?? '💎' }}
                    </div>
                    <div>

                        <p class="text-[14px] font-extrabold dark:text-white text-gray-900">
                            You're on the <span
                                style="color: {{ $currentSubscription->plan->color ?? '#f97316' }}">{{ $currentSubscription->plan->name }}</span>
                            plan
                        </p>

                        <p class="text-[12px] dark:text-gray-400 text-gray-500 mt-0.5">
                            {{ ucfirst($currentSubscription->billing_cycle) }} billing
                            @if ($currentSubscription->ends_at)
                                · Renews {{ $currentSubscription->ends_at->format('M d, Y') }}
                            @endif
                            · <span
                                class="font-bold
                            {{ $currentSubscription->status === 'active' ? 'text-emerald-400' : 'text-blue-400' }}">
                                {{ ucfirst($currentSubscription->status) }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="relative z-10 flex-shrink-0">
                    <span
                        class="px-3 py-1.5 rounded-lg text-[12px] font-bold dark:bg-white/[0.07] bg-white/80 dark:text-gray-300 text-gray-600 border dark:border-white/[0.08] border-black/[0.08]">
                        Current Plan
                    </span>
                </div>
            </div>
        @endif

        {{-- ── Hero Banner ── --}}
        <div
            class="relative overflow-hidden rounded-2xl border dark:border-white/[0.07] border-black/[0.07]
        dark:bg-[#17141f] bg-white p-6 md:p-8 hover-lift">
            <div class="absolute top-0 right-0 w-72 h-72 bg-pink-500 blur-[100px] opacity-20 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-orange-500 blur-[100px] opacity-20 pointer-events-none"></div>
            <div class="relative z-10 max-w-2xl">
                <span
                    class="px-3 py-1 rounded-full text-[11px] font-bold bg-orange-500/[0.15] text-orange-400 border border-orange-500/20">
                    Simple & Transparent Pricing
                </span>
                <h1
                    class="text-[24px] sm:text-[32px] md:text-[44px] leading-tight font-extrabold tracking-[-1.4px] mt-5 dark:text-white text-gray-900">
                    Start free. <br>
                    <span class="bg-gradient-to-r from-orange-400 to-pink-500 bg-clip-text text-transparent">
                        Upgrade when you grow.
                    </span>
                </h1>
                <p class="text-[14px] dark:text-gray-400 text-gray-500 mt-4 leading-relaxed">
                    Manage your tasks, habits, notes, focus sessions and analytics with flexible plans for every workflow.
                </p>
            </div>
        </div>

        {{-- ── Plans Grid ── --}}
        @if ($plans->isEmpty())
            {{-- Fallback when no plans in DB yet --}}
            <div
                class="p-12 text-center rounded-2xl dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07]">
                <div class="text-4xl mb-3">💎</div>
                <p class="text-[16px] font-bold dark:text-white text-gray-900">Plans coming soon</p>
                <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-1">Our pricing tiers are being set up. Check back
                    shortly.</p>
            </div>
        @else
            @php
                // How many plans — adjust grid accordingly
                $count = $plans->count();
                $gridCls = match (true) {
                    $count === 1 => 'grid-cols-1 max-w-sm mx-auto',
                    $count === 2 => 'grid-cols-1 sm:grid-cols-2 max-w-2xl mx-auto',
                    default => 'grid-cols-1 lg:grid-cols-3',
                };
            @endphp

            <div class="grid {{ $gridCls }} gap-4" id="plansGrid">
                @foreach ($plans as $plan)
                    @php
                        $isCurrent = $currentPlanId === $plan->id;
                        $isFeatured = $plan->is_featured;
                        $isFree = $plan->price_monthly == 0;
                        $color = $plan->color ?? '#f97316';
                        $savings = $plan->yearlySavings();
                    @endphp

                    <div class="hover-lift relative overflow-hidden rounded-2xl p-[22px] flex flex-col
                    {{ $isFeatured
                        ? 'dark:bg-[#17141f] bg-white border border-orange-500/40 shadow-[0_0_40px_rgba(249,115,22,0.18)]'
                        : 'dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07]' }}"
                        style="{{ $isFeatured ? '' : '' }}">

                        {{-- Ambient glow --}}
                        <div class="absolute top-0 right-0 w-32 h-32 blur-3xl opacity-20 pointer-events-none"
                            style="background: {{ $color }}"></div>
                        @if ($isFeatured)
                            <div class="absolute bottom-0 left-0 w-32 h-32 blur-3xl opacity-20 pointer-events-none"
                                style="background: {{ $color }}"></div>
                        @endif

                        {{-- Badge (Featured / Most Popular) --}}
                        @if ($isFeatured && $plan->badge_label)
                            <div class="absolute top-4 right-4 px-2.5 py-[4px] rounded-lg text-[11px] font-bold text-white z-10"
                                style="background: {{ $plan->badge_color ?? $color }}">
                                {{ $plan->badge_label }}
                            </div>
                        @endif

                        {{-- Current plan indicator --}}
                        @if ($isCurrent)
                            <div
                                class="absolute top-4 right-4 px-2.5 py-[4px] rounded-lg text-[11px] font-bold z-10
                            bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                ✓ Current
                            </div>
                        @endif

                        <div class="relative z-10 flex flex-col flex-1">

                            {{-- Plan name + icon --}}
                            <div class="flex items-center gap-2.5 mb-1">
                                @if ($plan->icon)
                                    <span class="text-[22px]">{{ $plan->icon }}</span>
                                @endif
                                <h3
                                    class="text-[{{ $isFeatured ? '18' : '16' }}px] font-extrabold dark:text-white text-gray-900">
                                    {{ $plan->name }}
                                </h3>
                            </div>

                            @if ($plan->description)
                                <p class="text-[12.5px] dark:text-gray-500 text-gray-500 mt-1 mb-5">
                                    {{ $plan->description }}
                                </p>
                            @else
                                <div class="mb-5"></div>
                            @endif

                            {{-- Price display --}}
                            <div class="mb-6">
                                {{-- Monthly price (shown by default) --}}
                                <div class="plan-price-monthly">
                                    @if ($isFree)
                                        <span class="text-[38px] font-extrabold dark:text-white text-gray-900">$0</span>
                                        <span class="text-[12px] dark:text-gray-500 text-gray-500">/month</span>
                                    @else
                                        <span class="text-[38px] font-extrabold dark:text-white text-gray-900">
                                            ${{ rtrim(rtrim(number_format($plan->price_monthly, 2), '0'), '.') }}
                                        </span>
                                        <span class="text-[12px] dark:text-gray-500 text-gray-500">/month</span>
                                    @endif
                                </div>
                                {{-- Yearly price (hidden by default) --}}
                                <div class="plan-price-yearly hidden">
                                    @if ($isFree)
                                        <span class="text-[38px] font-extrabold dark:text-white text-gray-900">$0</span>
                                        <span class="text-[12px] dark:text-gray-500 text-gray-500">/year</span>
                                    @else
                                        <span class="text-[38px] font-extrabold dark:text-white text-gray-900">
                                            ${{ rtrim(rtrim(number_format($plan->price_yearly, 2), '0'), '.') }}
                                        </span>
                                        <span class="text-[12px] dark:text-gray-500 text-gray-500">/year</span>
                                        @if ($savings > 0)
                                            <div class="mt-1">
                                                <span
                                                    class="text-[11px] font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-md">
                                                    Save ${{ number_format($savings, 2) }} vs monthly
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            {{-- CTA Button --}}
                            @if ($isCurrent)
                                <div
                                    class="mb-6 block text-center px-4 py-2.5 rounded-[10px] text-[12.5px] font-bold
                                bg-emerald-500/10 text-emerald-400 border border-emerald-500/25">
                                    ✓ Your Current Plan
                                </div>
                            @elseif($isFree)
                                <a href="{{ route('user.dashboard') }}"
                                    class="mb-6 block text-center px-4 py-2.5 rounded-[10px] text-[12.5px] font-bold
                                dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                                    Start Free
                                </a>
                            @elseif($isFeatured)
                                <a href="{{ route('user.subscription.index') }}"
                                    class="mb-6 block text-center px-4 py-2.5 rounded-[10px] text-white text-[12.5px] font-bold
                                bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                                    Upgrade to {{ $plan->name }}
                                </a>
                            @else
                                <a href="{{ route('user.subscription.index') }}"
                                    class="mb-6 block text-center px-4 py-2.5 rounded-[10px] text-[12.5px] font-bold
                                dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                                    @if ($plan->has_team_workspace)
                                        Contact Sales
                                    @else
                                        Get {{ $plan->name }}
                                    @endif
                                </a>
                            @endif

                            {{-- Feature list --}}
                            <div class="space-y-2.5 flex-1">

                                {{-- Limits --}}
                                @php
                                    $limitLines = [];
                                    if ($plan->max_tasks != -1) {
                                        $limitLines[] = 'Up to ' . $plan->max_tasks . ' tasks';
                                    } else {
                                        $limitLines[] = 'Unlimited tasks';
                                    }
                                    if ($plan->max_habits != -1) {
                                        $limitLines[] = 'Up to ' . $plan->max_habits . ' habits';
                                    } else {
                                        $limitLines[] = 'Unlimited habits';
                                    }
                                    if ($plan->max_notes != -1) {
                                        $limitLines[] = 'Up to ' . $plan->max_notes . ' notes';
                                    } else {
                                        $limitLines[] = 'Unlimited notes';
                                    }
                                    if ($plan->max_goals != -1) {
                                        $limitLines[] = 'Up to ' . $plan->max_goals . ' goals';
                                    }
                                    if ($plan->max_focus_sessions != -1) {
                                        $limitLines[] = 'Up to ' . $plan->max_focus_sessions . ' focus sessions';
                                    }
                                @endphp

                                @foreach ($limitLines as $line)
                                    <div class="flex items-center gap-2.5">
                                        <span
                                            class="{{ $isFeatured ? 'text-orange-400' : 'text-emerald-400' }} text-[13px] flex-shrink-0">✓</span>
                                        <p
                                            class="text-[12.5px] {{ $isFeatured ? 'dark:text-gray-300 text-gray-600' : 'dark:text-gray-400 text-gray-500' }}">
                                            {{ $line }}
                                        </p>
                                    </div>
                                @endforeach

                                {{-- Feature flags --}}
                                @php
                                    $featureFlags = [
                                        'has_analytics' => 'Advanced analytics',
                                        'has_calendar' => 'Calendar view',
                                        'has_gamification' => 'XP levels & streaks',
                                        'has_themes' => 'Custom themes',
                                        'has_ai_tools' => 'AI tools',
                                        'has_team_workspace' => 'Team workspace',
                                        'has_priority_support' => 'Priority support',
                                    ];
                                @endphp
                                @foreach ($featureFlags as $flag => $label)
                                    @if ($plan->$flag)
                                        <div class="flex items-center gap-2.5">
                                            <span
                                                class="{{ $isFeatured ? 'text-orange-400' : 'text-emerald-400' }} text-[13px] flex-shrink-0">✓</span>
                                            <p
                                                class="text-[12.5px] {{ $isFeatured ? 'dark:text-gray-300 text-gray-600' : 'dark:text-gray-400 text-gray-500' }}">
                                                {{ $label }}
                                            </p>
                                        </div>
                                    @endif
                                @endforeach

                                {{-- Custom features from JSON --}}
                                @if ($plan->features && count($plan->features) > 0)
                                    @foreach ($plan->features as $feat)
                                        <div class="flex items-center gap-2.5">
                                            <span
                                                class="{{ $isFeatured ? 'text-orange-400' : 'text-emerald-400' }} text-[13px] flex-shrink-0">✓</span>
                                            <p
                                                class="text-[12.5px] {{ $isFeatured ? 'dark:text-gray-300 text-gray-600' : 'dark:text-gray-400 text-gray-500' }}">
                                                {{ $feat }}
                                            </p>
                                        </div>
                                    @endforeach
                                @endif

                                {{-- Light/dark mode always --}}
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="{{ $isFeatured ? 'text-orange-400' : 'text-emerald-400' }} text-[13px] flex-shrink-0">✓</span>
                                    <p
                                        class="text-[12.5px] {{ $isFeatured ? 'dark:text-gray-300 text-gray-600' : 'dark:text-gray-400 text-gray-500' }}">
                                        Light & dark mode
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ── Compare table (only if 2+ plans) ── --}}
        @if ($plans->count() >= 2)
            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl overflow-hidden">
                <div class="p-4 border-b dark:border-white/[0.06] border-black/[0.05]">
                    <h3 class="text-[15px] font-bold dark:text-white text-gray-900">Compare plans</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-[12.5px]">
                        <thead>
                            <tr class="border-b dark:border-white/[0.05] border-black/[0.05]">
                                <th class="px-4 py-3 text-left font-bold dark:text-gray-400 text-gray-500">Feature</th>
                                @foreach ($plans as $plan)
                                    <th
                                        class="px-4 py-3 text-center font-extrabold
                                    {{ $plan->is_featured ? 'dark:text-orange-400 text-orange-500' : 'dark:text-white text-gray-900' }}">
                                        {{ $plan->icon ?? '' }} {{ $plan->name }}
                                        @if ($currentPlanId === $plan->id)
                                            <span class="block text-[10px] font-bold text-emerald-400 mt-0.5">✓
                                                Current</span>
                                        @endif
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-white/[0.04] divide-black/[0.04]">
                            @php
                                $compareRows = [
                                    ['label' => 'Tasks', 'field' => 'max_tasks'],
                                    ['label' => 'Habits', 'field' => 'max_habits'],
                                    ['label' => 'Notes', 'field' => 'max_notes'],
                                    ['label' => 'Goals', 'field' => 'max_goals'],
                                    ['label' => 'Focus sessions', 'field' => 'max_focus_sessions'],
                                    ['label' => 'Journals', 'field' => 'max_journals'],
                                    ['label' => 'Analytics', 'field' => 'has_analytics', 'bool' => true],
                                    ['label' => 'Calendar', 'field' => 'has_calendar', 'bool' => true],
                                    ['label' => 'Gamification', 'field' => 'has_gamification', 'bool' => true],
                                    ['label' => 'Themes', 'field' => 'has_themes', 'bool' => true],
                                    ['label' => 'AI Tools', 'field' => 'has_ai_tools', 'bool' => true],
                                    ['label' => 'Team workspace', 'field' => 'has_team_workspace', 'bool' => true],
                                    ['label' => 'Priority support', 'field' => 'has_priority_support', 'bool' => true],
                                ];
                            @endphp
                            @foreach ($compareRows as $row)
                                <tr class="dark:hover:bg-white/[0.02] hover:bg-gray-50 transition">
                                    <td class="px-4 py-2.5 font-bold dark:text-gray-400 text-gray-500">{{ $row['label'] }}
                                    </td>
                                    @foreach ($plans as $plan)
                                        <td class="px-4 py-2.5 text-center">
                                            @if (!empty($row['bool']))
                                                @if ($plan->{$row['field']})
                                                    <span class="text-emerald-400 font-bold">✓</span>
                                                @else
                                                    <span class="dark:text-gray-600 text-gray-300">—</span>
                                                @endif
                                            @else
                                                @php $val = $plan->{$row['field']} ?? -1; @endphp
                                                <span
                                                    class="{{ $val == -1 ? 'text-orange-400 font-bold' : 'dark:text-gray-300 text-gray-600' }}">
                                                    {{ $val == -1 ? '∞' : $val }}
                                                </span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- ── FAQ ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[15px] font-bold dark:text-white text-gray-900 mb-4">What's included?</h3>
                <div class="space-y-3">
                    @foreach (['Task management with labels and subtasks', 'Habit streak and daily completion tracking', 'Focus sessions and productivity insights', 'XP progress, levels and activity history'] as $item)
                        <div
                            class="flex items-start gap-3 py-2 border-b last:border-b-0 dark:border-white/[0.06] border-black/[0.05]">
                            <span class="text-orange-400 flex-shrink-0">✓</span>
                            <p class="text-[12.5px] dark:text-gray-400 text-gray-500">{{ $item }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div
                class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-[18px]">
                <h3 class="text-[15px] font-bold dark:text-white text-gray-900 mb-4">Frequently Asked</h3>
                <div class="space-y-4">
                    @foreach ([['q' => 'Can I start for free?', 'a' => 'Yes, the free plan is available for basic productivity tracking with no credit card required.'], ['q' => 'Can I upgrade later?', 'a' => 'Yes, you can upgrade to any paid plan anytime. Your existing data is always preserved.'], ['q' => 'Can I switch billing cycle?', 'a' => 'Absolutely — you can switch between monthly and yearly billing at renewal time.'], ['q' => 'Is my data private?', 'a' => 'Your tasks, notes and analytics stay fully protected inside your personal workspace.']] as $faq)
                        <div class="border-b dark:border-white/[0.06] border-black/[0.05] pb-3 last:border-b-0 last:pb-0">
                            <p class="text-[12.5px] font-bold dark:text-gray-200 text-gray-800">{{ $faq['q'] }}</p>
                            <p class="text-[12px] dark:text-gray-500 text-gray-500 mt-1">{{ $faq['a'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </section>

    <script>
        // ── Billing cycle toggle ──────────────────────────────────
        let currentCycle = 'monthly';

        function setBillingCycle(cycle) {
            currentCycle = cycle;
            const monthlyBtn = document.getElementById('monthlyBtn');
            const yearlyBtn = document.getElementById('yearlyBtn');
            const activeClass =
                'px-4 py-2 rounded-[10px] text-[12px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500 transition-all';
            const inactiveClass =
                'px-4 py-2 rounded-[10px] text-[12px] font-bold dark:text-gray-400 text-gray-500 transition-all';

            if (cycle === 'monthly') {
                monthlyBtn.className = activeClass;
                yearlyBtn.className = inactiveClass + ' flex items-center gap-1';
            } else {
                yearlyBtn.className = activeClass + ' flex items-center gap-1';
                monthlyBtn.className = inactiveClass;
            }

            // Show/hide price blocks
            document.querySelectorAll('.plan-price-monthly').forEach(el => {
                el.classList.toggle('hidden', cycle === 'yearly');
            });
            document.querySelectorAll('.plan-price-yearly').forEach(el => {
                el.classList.toggle('hidden', cycle === 'monthly');
            });
        }
    </script>
@endsection
