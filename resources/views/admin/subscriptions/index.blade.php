@extends('admin.layouts.master')

@section('admin')
    <section class="space-y-6">

        {{-- ── Page Header ── --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold dark:text-white text-gray-900">
                    <i class="fas fa-list"></i> Subscription Plans
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    Manage pricing tiers, features, and subscriber access.
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.subscriptions.subscribers') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-800 border dark:border-white/[0.08] border-black/[0.08]">
                    <i class="fa-solid fa-users mr-1.5 text-[13px]"></i> Subscribers
                </a>
                <button onclick="openCreateModal()"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-plus"></i> New Plan
                </button>
            </div>
        </div>

        {{-- ── Alerts ── --}}
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

        {{-- ── Stats Row ── --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
            @php
                $stats = [
                    [
                        'label' => 'Active Subscribers',
                        'value' => $totalSubscribers,
                        'icon' => 'fa-users',
                        'color' => 'text-emerald-400',
                        'bg' => 'bg-emerald-500/10',
                    ],
                    [
                        'label' => 'Total Revenue',
                        'value' => '$' . number_format($totalRevenue, 2),
                        'icon' => 'fa-circle-dollar-to-slot',
                        'color' => 'text-orange-400',
                        'bg' => 'bg-orange-500/10',
                    ],
                    [
                        'label' => 'Trial Users',
                        'value' => $trialUsers,
                        'icon' => 'fa-clock',
                        'color' => 'text-blue-400',
                        'bg' => 'bg-blue-500/10',
                    ],
                    [
                        'label' => 'Cancelled',
                        'value' => $cancelledCount,
                        'icon' => 'fa-ban',
                        'color' => 'text-red-400',
                        'bg' => 'bg-red-500/10',
                    ],
                ];
            @endphp
            @foreach ($stats as $s)
                <div
                    class="veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl border p-4 flex items-center gap-3">
                    <div class="{{ $s['bg'] }} w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid {{ $s['icon'] }} {{ $s['color'] }} text-[16px]"></i>
                    </div>
                    <div>
                        <p class="text-[20px] font-extrabold dark:text-white text-gray-800 leading-tight">
                            {{ $s['value'] }}</p>
                        <p class="text-[12px] dark:text-white text-gray-800">{{ $s['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── Plans Grid ── --}}
        @if ($plans->isEmpty())
            <div
                class="p-10 text-center rounded-2xl dark:bg-[#17141f] bg-white border  veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
                <div class="text-5xl mb-3">💎</div>
                <p class="text-[18px] font-bold dark:text-white text-gray-800">No plans yet</p>
                <p class="text-[14px] dark:text-white text-gray-800 mt-1">Create your first subscription plan to get
                    started.</p>
                <button onclick="openCreateModal()"
                    class="mt-4 px-5 py-2.5 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-plus"></i> Create Plan
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach ($plans as $plan)
                    <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] border rounded-2xl p-5 relative overflow-hidden flex flex-col
                    {{ $plan->is_featured ? 'ring-2' : '' }}"
                        style="{{ $plan->is_featured ? 'ring-color:' . $plan->color . '80;' : '' }}">

                        {{-- Ambient glow --}}

                        {{-- Featured ribbon --}}
                        @if ($plan->is_featured)
                            <div class="absolute top-3 right-3 px-2.5 py-1 rounded-lg text-[11px] font-bold text-white"
                                style="background: {{ $plan->badge_color ?? $plan->color }}">
                                {{ $plan->badge_label ?? 'Featured' }}
                            </div>
                        @endif

                        {{-- Plan header --}}
                        <div class="flex items-center gap-3 mb-4 relative z-10">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl font-black flex-shrink-0"
                                style="background: {{ $plan->color }}22; border: 1.5px solid {{ $plan->color }}44;">
                                {{ $plan->icon ?? '💎' }}
                            </div>
                            <div>
                                <h3 class="text-[17px] font-extrabold dark:text-white text-gray-800">{{ $plan->name }}
                                </h3>
                                <p class="text-[12px] dark:text-white text-gray-800">{{ $plan->slug }}</p>
                            </div>
                        </div>

                        {{-- Pricing --}}
                        <div class="flex items-end gap-4 mb-4 relative z-10">
                            <div>
                                <span class="text-[26px] font-extrabold dark:text-white text-gray-800">
                                    @if ($plan->price_monthly == 0)
                                        Free
                                    @else
                                        ${{ number_format($plan->price_monthly, 2) }}
                                    @endif
                                </span>
                                @if ($plan->price_monthly > 0)
                                    <span class="text-[13px] dark:text-white text-gray-800">/mo</span>
                                @endif
                            </div>
                            @if ($plan->price_yearly > 0)
                                <div class="text-[12px] dark:text-white text-gray-800 mb-1">
                                    ${{ number_format($plan->price_yearly, 2) }}/yr
                                    @if ($plan->yearlySavings() > 0)
                                        <span class="text-emerald-400 font-bold ml-1">Save
                                            ${{ number_format($plan->yearlySavings(), 2) }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- Description --}}
                        @if ($plan->description)
                            <p class="text-[13px] dark:text-gray-400 text-gray-800 mb-4 relative z-10 line-clamp-2">
                                {{ $plan->description }}
                            </p>
                        @endif

                        {{-- Feature flags --}}
                        <div class="grid grid-cols-2 gap-1.5 mb-4 relative z-10">
                            @php
                                $flags = [
                                    'has_analytics' => 'Analytics',
                                    'has_calendar' => 'Calendar',
                                    'has_gamification' => 'Gamification',
                                    'has_themes' => 'Themes',
                                    'has_team_workspace' => 'Team',
                                    'has_priority_support' => 'Priority Support',
                                ];
                            @endphp
                            @foreach ($flags as $key => $label)
                                <div
                                    class="flex items-center gap-1.5 text-[12px] {{ $plan->$key ? 'dark:text-gray-300 text-gray-800' : 'dark:text-gray-600 text-gray-300 line-through' }}">
                                    <i
                                        class="fa-solid {{ $plan->$key ? 'fa-circle-check text-emerald-400' : 'fa-circle-xmark text-gray-800' }} text-[12px]"></i>
                                    {{ $label }}
                                </div>
                            @endforeach
                        </div>

                        {{-- Limits --}}
                        <div class="flex flex-wrap gap-1.5 mb-4 relative z-10">
                            @foreach (['max_tasks' => 'Tasks', 'max_habits' => 'Habits', 'max_notes' => 'Notes', 'max_goals' => 'Goals'] as $field => $label)
                                <span
                                    class="px-2 py-0.5 rounded-lg text-[11px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-800">
                                    {{ $plan->limitLabel($field) }} {{ $label }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Footer --}}
                        {{-- Revenue per plan --}}
                        <div
                            class="relative z-10 flex items-center gap-3 py-3 border-t dark:border-white/[0.06] border-black/[0.05] mt-auto">
                            <div class="flex-1 dark:bg-white/[0.04] bg-gray-50 rounded-xl px-3 py-2 text-center">
                                <p class="text-[15px] font-extrabold dark:text-white text-gray-900 leading-tight">
                                    {{ $plan->active_subscribers_count ?? 0 }}
                                </p>
                                <p class="text-[10px] dark:text-white text-gray-800 uppercase tracking-wide">Active Subs
                                </p>
                            </div>
                            <div class="flex-1 dark:bg-orange-500/[0.08] bg-orange-50 rounded-xl px-3 py-2 text-center">
                                <p class="text-[15px] font-extrabold text-orange-400 leading-tight">
                                    ${{ number_format($plan->revenue_total ?? 0, 2) }}
                                </p>
                                <p class="text-[10px] dark:text-white text-gray-800 uppercase tracking-wide">Revenue</p>
                            </div>
                        </div>

                        <div
                            class="relative z-10 flex items-center justify-between pt-3 border-t dark:border-white/[0.06] border-black/[0.05]">
                            <span
                                class="px-2 py-1 rounded-lg text-[12px] font-bold {{ $plan->is_active ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                                {{ $plan->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <div class="flex gap-2">
                                <button type="button" onclick='openEditModal(@json($plan))'
                                    class="px-3 py-1.5 rounded-lg text-[13px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('admin.subscriptions.destroy', $plan) }}" method="POST"
                                    onsubmit="return confirm('Delete plan {{ $plan->name }}? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button
                                        class="px-3 py-1.5 rounded-lg text-[13px] font-bold dark:bg-red-500/[0.15] bg-red-50 text-red-500">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ══════════════════════════════════════════════
         CREATE MODAL
    ══════════════════════════════════════════════ --}}
        <div id="createModal"
            class="hidden fixed inset-0 z-50 veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] flex items-start justify-center px-4 py-8 overflow-y-auto">
            <div
                class="w-full max-w-2xl  veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] shadow-[0_20px_60px_rgba(0,0,0,0.25)] border rounded-2xl p-6 my-auto">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900"> <i class="fas fa-plus"></i> Create
                        Subscription Plan</h3>
                    <button onclick="closeCreateModal()"
                        class="dark:text-gray-400 text-gray-500 hover:text-gray-700 dark:hover:text-white text-xl">✕</button>
                </div>
                <form action="{{ route('admin.subscriptions.store') }}" method="POST" class="space-y-4">
                    @csrf
                    @include('admin.subscriptions.partials.plan-form')
                </form>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════
         EDIT MODAL
    ══════════════════════════════════════════════ --}}
        <div id="editModal"
            class="hidden fixed inset-0 z-50 veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] flex items-start justify-center px-4 py-8 overflow-y-auto">
            <div
                class="w-full max-w-2xl  veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] shadow-[0_20px_60px_rgba(0,0,0,0.25)] border rounded-2xl p-6 my-auto">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900"> <i class="fas fa-edit"></i> Edit
                        Subscription Plan</h3>
                    <button onclick="closeEditModal()"
                        class="dark:text-gray-400 text-gray-500 hover:text-gray-700 dark:hover:text-white text-xl">✕</button>
                </div>
                <form id="editPlanForm" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    @include('admin.subscriptions.partials.plan-form', ['edit' => true])
                </form>
            </div>
        </div>

    </section>

    <script>
        /* ─── CREATE MODAL ─── */
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        /* ─── EDIT MODAL ─── */
        function openEditModal(plan) {
            const form = document.getElementById('editPlanForm');

            if (!form || !plan || !plan.id) {
                console.error('Edit form or plan ID not found.');
                return;
            }

            // Set correct update URL
            form.action = "{{ url('admin/subscriptions') }}/" + plan.id;

            const set = (name, val) => {
                const el = form.querySelector(`[name="${name}"]`);
                if (!el) return;

                if (el.type === 'checkbox') {
                    el.checked = val == 1 || val === true || val === '1';
                } else {
                    el.value = val ?? '';
                }
            };

            set('name', plan.name);
            set('slug', plan.slug);
            set('description', plan.description);
            set('badge_label', plan.badge_label);
            set('badge_color', plan.badge_color ?? '#f97316');
            set('price_monthly', plan.price_monthly ?? 0);
            set('price_yearly', plan.price_yearly ?? 0);
            set('currency', plan.currency ?? 'USD');
            set('icon', plan.icon ?? '💎');
            set('color', plan.color ?? '#f97316');

            set('max_tasks', plan.max_tasks ?? -1);
            set('max_habits', plan.max_habits ?? -1);
            set('max_notes', plan.max_notes ?? -1);
            set('max_goals', plan.max_goals ?? -1);
            set('max_focus_sessions', plan.max_focus_sessions ?? -1);
            set('max_journals', plan.max_journals ?? -1);

            set('has_analytics', plan.has_analytics);
            set('has_calendar', plan.has_calendar);
            set('has_gamification', plan.has_gamification);
            set('has_themes', plan.has_themes);
            set('has_ai_tools', plan.has_ai_tools);
            set('has_team_workspace', plan.has_team_workspace);
            set('has_priority_support', plan.has_priority_support);

            set('sort_order', plan.sort_order ?? 0);
            set('is_active', plan.is_active);
            set('is_featured', plan.is_featured);

            // Features array/string/null -> textarea
            const featEl = form.querySelector('[name="features"]');
            if (featEl) {
                featEl.value = Array.isArray(plan.features) ?
                    plan.features.join('\n') :
                    (plan.features ?? '');
            }

            document.getElementById('editModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        /* Close modals on backdrop click */
        ['createModal', 'editModal'].forEach(id => {
            document.getElementById(id).addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
@endsection
