@extends('user.layouts.master')

@section('user')
    @php
        $activeTab = session('tab', request('tab', 'account'));
        $user = auth()->user();

        $tabs = [
            'account' => ['label' => 'Account', 'icon' => 'fa-user-circle'],
            'appearance' => ['label' => 'Appearance', 'icon' => 'fa-palette'],
            // 'notifications' => ['label' => 'Notifications', 'icon' => 'fa-bell'],
            'privacy' => ['label' => 'Privacy', 'icon' => 'fa-shield-halved'],
        ];
    @endphp

    <section class="space-y-5">

        {{-- ── Page Header ── --}}
        <div>
            <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900"><i
                    class="fas fa-cog mr-2"></i> Settings</h2>
            <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">Manage your account, appearance, and preferences.
            </p>
        </div>

        {{-- ── Alert ── --}}
        @if (session('success'))
            <div id="settingsAlert"
                class="px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[13px] font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    const a = document.getElementById('settingsAlert');
                    if (a) a.style.display = 'none';
                }, 3500);
            </script>
        @endif
        @if (session('error') || $errors->any())
            <div
                class="px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-[13px] font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-xmark"></i>
                {{ session('error') ?? $errors->first() }}
            </div>
        @endif

        {{-- ── Profile Hero Card ── --}}
        <div
            class="relative overflow-hidden dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5 flex flex-col sm:flex-row items-center sm:items-start gap-5">
            <div class="absolute top-0 right-0 w-48 h-48 bg-orange-500 blur-[80px] opacity-10 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-pink-500 blur-[80px] opacity-10 pointer-events-none"></div>

            {{-- Avatar --}}
            <div class="relative flex-shrink-0 z-10">
                <div class="w-20 h-20 rounded-2xl p-[2.5px]"
                    style="background: linear-gradient(135deg,#f97316,#ec4899); box-shadow: 0 0 18px rgba(249,115,22,0.45);">
                    <div
                        class="w-full h-full rounded-[14px] overflow-hidden dark:bg-[#1a1625] bg-gray-100 flex items-center justify-center">
                        @if ($user->profile)
                            <img src="{{ asset('storage/profile/' . $user->profile) }}" alt="{{ $user->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <span class="text-[28px] font-extrabold dark:text-white text-gray-700">
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            </span>
                        @endif
                    </div>
                </div>
                {{-- Online dot --}}
                <span
                    class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-emerald-400 border-2 dark:border-[#17141f] border-white"></span>
            </div>

            {{-- Info --}}
            <div class="flex-1 z-10 text-center sm:text-left">
                <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900">{{ $user->name }}</h3>
                <p class="text-[13px] dark:text-gray-400 text-gray-500 mt-0.5">{{ $user->email }}</p>
                @if ($user->bio)
                    <p class="text-[12.5px] dark:text-gray-500 text-gray-400 mt-1.5 max-w-md">{{ $user->bio }}</p>
                @endif
                <div class="flex flex-wrap items-center gap-2 mt-3 justify-center sm:justify-start">
                    @if ($subscription)
                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold"
                            style="background:{{ $subscription->plan->color ?? '#f97316' }}22; color:{{ $subscription->plan->color ?? '#f97316' }}; border: 1px solid {{ $subscription->plan->color ?? '#f97316' }}33">
                            {{ $subscription->plan->icon ?? '💎' }} {{ $subscription->plan->name }}
                        </span>
                    @else
                        <span
                            class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-gray-500/10 dark:text-gray-400 text-gray-500">
                            <i class="fa-solid fa-star"></i> Free Plan
                        </span>
                    @endif
                    @if ($user->username)
                        <span
                            class="px-2.5 py-1 rounded-lg text-[11px] font-bold dark:bg-white/[0.06] bg-gray-100 dark:text-gray-400 text-gray-500">
                            @ {{ $user->username }}
                        </span>
                    @endif
                    @if ($user->country)
                        <span
                            class="px-2.5 py-1 rounded-lg text-[11px] dark:bg-white/[0.06] bg-gray-100 dark:text-gray-400 text-gray-500">
                            📍 {{ $user->country }}
                        </span>
                    @endif
                    <span
                        class="px-2.5 py-1 rounded-lg text-[11px] dark:bg-white/[0.06] bg-gray-100 dark:text-gray-400 text-gray-500">
                        Joined {{ $user->created_at->format('M Y') }}
                    </span>
                </div>
            </div>

            {{-- Quick plan CTA --}}
            @if (!$subscription || $subscription->plan->price_monthly == 0)
                <a href="{{ route('user.pricing') }}"
                    class="flex-shrink-0 z-10 px-4 py-2 rounded-[10px] text-white text-[12px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 btn-trans">
                    Upgrade to Pro
                </a>
            @endif
        </div>

        {{-- ── Tab Bar + Content ── --}}
        <div
            class="dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl overflow-hidden">

            {{-- Tab Nav --}}
            <div class="flex overflow-x-auto border-b dark:border-white/[0.06] border-black/[0.05] scrollbar-hide">
                @foreach ($tabs as $key => $tab)
                    <button onclick="switchTab('{{ $key }}')" id="tab-btn-{{ $key }}"
                        class="tab-btn flex items-center gap-2 px-5 py-4 text-[13px] font-bold whitespace-nowrap border-b-2 transition-all flex-shrink-0
                        {{ $activeTab === $key
                            ? 'border-orange-500 text-orange-500 dark:text-orange-400'
                            : 'border-transparent dark:text-gray-500 text-gray-400 dark:hover:text-gray-300 hover:text-gray-600' }}">
                        <i class="fa-solid {{ $tab['icon'] }} text-[13px]"></i>
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>

            {{-- Tab Panels --}}
            <div class="p-5 sm:p-6">

                {{-- ══════════ ACCOUNT TAB ══════════ --}}
                <div id="tab-account" class="tab-panel {{ $activeTab !== 'account' ? 'hidden' : '' }} space-y-6">
                    @include('user.settings.tabs.account')
                </div>

                {{-- ══════════ APPEARANCE TAB ══════════ --}}
                <div id="tab-appearance" class="tab-panel {{ $activeTab !== 'appearance' ? 'hidden' : '' }} space-y-6">
                    @include('user.settings.tabs.appearance')
                </div>

                {{-- ══════════ NOTIFICATIONS TAB ══════════ --}}
                <div id="tab-notifications"
                    class="tab-panel {{ $activeTab !== 'notifications' ? 'hidden' : '' }} space-y-6">
                    @include('user.settings.tabs.notifications')
                </div>

                {{-- ══════════ PRIVACY TAB ══════════ --}}
                <div id="tab-privacy" class="tab-panel {{ $activeTab !== 'privacy' ? 'hidden' : '' }} space-y-6">
                    @include('user.settings.tabs.privacy')
                </div>

            </div>
        </div>

    </section>

    <script>
        function switchTab(tab) {
            // Hide all panels
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
            // Remove active from all buttons
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('border-orange-500', 'text-orange-500', 'dark:text-orange-400');
                b.classList.add('border-transparent', 'dark:text-gray-500', 'text-gray-400');
            });
            // Show selected panel
            const panel = document.getElementById('tab-' + tab);
            if (panel) panel.classList.remove('hidden');
            // Activate button
            const btn = document.getElementById('tab-btn-' + tab);
            if (btn) {
                btn.classList.add('border-orange-500', 'text-orange-500', 'dark:text-orange-400');
                btn.classList.remove('border-transparent', 'dark:text-gray-500', 'text-gray-400');
            }
            // Update URL without reload
            history.replaceState(null, '', '?tab=' + tab);
        }
    </script>
@endsection
