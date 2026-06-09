@extends('admin.layouts.master')

@section('admin')
    <section class="space-y-6">

        {{-- ── Header ── --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold dark:text-white text-gray-900">Subscribers</h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">View and manage individual user subscriptions.
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.subscriptions.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                    ← Plans
                </a>
                <button onclick="openAssignModal()"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    + Assign Plan
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

        {{-- ── Table ── --}}
        <div
            class="dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl overflow-hidden">
            <div class="p-4 border-b dark:border-white/[0.06] border-black/[0.05] flex items-center justify-between">
                <p class="text-[14px] font-bold dark:text-white text-gray-900">
                    All Subscriptions
                    <span
                        class="ml-2 px-2 py-0.5 rounded-lg text-[12px] dark:bg-white/[0.07] bg-gray-100 dark:text-gray-400 text-gray-500">
                        {{ $subscriptions->total() }}
                    </span>
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-[13px]">
                    <thead>
                        <tr class="dark:border-b dark:border-white/[0.05] border-b border-black/[0.05]">
                            <th
                                class="px-4 py-3 text-left text-[12px] font-bold dark:text-gray-500 text-gray-400 uppercase tracking-wide">
                                User</th>
                            <th
                                class="px-4 py-3 text-left text-[12px] font-bold dark:text-gray-500 text-gray-400 uppercase tracking-wide">
                                Plan</th>
                            <th
                                class="px-4 py-3 text-left text-[12px] font-bold dark:text-gray-500 text-gray-400 uppercase tracking-wide">
                                Billing</th>
                            <th
                                class="px-4 py-3 text-left text-[12px] font-bold dark:text-gray-500 text-gray-400 uppercase tracking-wide">
                                Status</th>
                            <th
                                class="px-4 py-3 text-left text-[12px] font-bold dark:text-gray-500 text-gray-400 uppercase tracking-wide">
                                Amount</th>
                            <th
                                class="px-4 py-3 text-left text-[12px] font-bold dark:text-gray-500 text-gray-400 uppercase tracking-wide">
                                Ends</th>
                            <th
                                class="px-4 py-3 text-right text-[12px] font-bold dark:text-gray-500 text-gray-400 uppercase tracking-wide">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-white/[0.04] divide-black/[0.04]">
                        @forelse($subscriptions as $sub)
                            <tr class="dark:hover:bg-white/[0.02] hover:bg-gray-50 transition">
                                {{-- User --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-[13px] font-extrabold text-white flex-shrink-0"
                                            style="background: linear-gradient(135deg,#f97316,#ec4899)">
                                            {{ strtoupper(substr($sub->user->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold dark:text-white text-gray-900 leading-tight">
                                                {{ $sub->user->name ?? 'Deleted User' }}</p>
                                            <p class="text-[11px] dark:text-gray-500 text-gray-400">
                                                {{ $sub->user->email ?? '—' }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Plan --}}
                                <td class="px-4 py-3">
                                    @if ($sub->plan)
                                        <span class="px-2.5 py-1 rounded-lg text-[12px] font-bold"
                                            style="background: {{ $sub->plan->color }}22; color: {{ $sub->plan->color }}">
                                            {{ $sub->plan->icon ?? '' }} {{ $sub->plan->name }}
                                        </span>
                                    @else
                                        <span class="dark:text-gray-500 text-gray-400">—</span>
                                    @endif
                                </td>

                                {{-- Billing --}}
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-0.5 rounded-md text-[11px] font-bold dark:bg-white/[0.06] bg-gray-100 dark:text-gray-300 text-gray-600 capitalize">
                                        {{ $sub->billing_cycle }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2.5 py-1 rounded-lg text-[12px] font-bold {{ $sub->statusBadgeClass() }} capitalize">
                                        {{ $sub->status }}
                                    </span>
                                </td>

                                {{-- Amount --}}
                                <td class="px-4 py-3 font-bold dark:text-white text-gray-900">
                                    ${{ number_format($sub->amount_paid, 2) }}
                                </td>

                                {{-- Ends --}}
                                <td class="px-4 py-3 dark:text-gray-400 text-gray-500">
                                    {{ $sub->ends_at ? $sub->ends_at->format('M d, Y') : '—' }}
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($sub->status === 'active' || $sub->status === 'trial')
                                            <form action="{{ route('admin.subscriptions.cancel', $sub) }}" method="POST"
                                                onsubmit="return confirm('Cancel this subscription?')">
                                                @csrf @method('PATCH')
                                                <button
                                                    class="px-3 py-1.5 rounded-lg text-[12px] font-bold dark:bg-red-500/[0.12] bg-red-50 text-red-500 hover:bg-red-100 dark:hover:bg-red-500/20 transition">
                                                    Cancel
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[12px] dark:text-gray-600 text-gray-300">—</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7"
                                    class="px-4 py-12 text-center dark:text-gray-500 text-gray-400 text-[14px]">
                                    No subscriptions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($subscriptions->hasPages())
                <div class="p-4 border-t dark:border-white/[0.06] border-black/[0.05]">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>

        {{-- ══════════════════════════════════════════════
         ASSIGN PLAN MODAL
    ══════════════════════════════════════════════ --}}
        <div id="assignModal"
            class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center px-4">
            <div
                class="w-full max-w-lg dark:bg-[#17141f] bg-white border dark:border-white/[0.08] border-black/[0.08] rounded-2xl p-6">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900">Assign Subscription Plan</h3>
                    <button onclick="closeAssignModal()"
                        class="dark:text-gray-400 text-gray-500 hover:text-gray-700 dark:hover:text-white text-xl">✕</button>
                </div>

                <form action="{{ route('admin.subscriptions.assign') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- User search --}}
                    <div>
                        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">
                            Select User <span class="text-red-400">*</span>
                        </label>

                        <select name="user_id" required
                            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition">
                            <option value="">-- Select a User --</option>
                            @foreach (App\Models\User::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>

                        <p class="text-[11px] dark:text-gray-600 text-gray-400 mt-1">
                            You can find the user in the Users section.
                        </p>
                    </div>

                    {{-- Plan --}}
                    <div>
                        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Plan <span
                                class="text-red-400">*</span></label>
                        <select name="subscription_plan_id" required
                            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition">
                            <option value="">Select a plan...</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }}
                                    ({{ $plan->formattedMonthlyPrice() }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Billing & Status --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Billing
                                Cycle</label>
                            <select name="billing_cycle"
                                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition">
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Status</label>
                            <select name="status"
                                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition">
                                <option value="active">Active</option>
                                <option value="trial">Trial</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="expired">Expired</option>
                            </select>
                        </div>
                    </div>

                    {{-- Dates --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Starts
                                At</label>
                            <input type="date" name="starts_at"
                                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition">
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Ends
                                At</label>
                            <input type="date" name="ends_at"
                                class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition">
                        </div>
                    </div>

                    {{-- Amount + Notes --}}
                    <div>
                        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Amount Paid
                            ($)</label>
                        <input type="number" name="amount_paid" value="0" min="0" step="0.01"
                            class="w-full px-3.5 py-2.5 rounded-[10px] text-[14px] outline-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition">
                    </div>
                    <div>
                        <label class="block text-[12px] font-bold dark:text-gray-300 text-gray-700 mb-1.5">Notes</label>
                        <textarea name="notes" rows="2" placeholder="Admin notes (optional)..."
                            class="w-full px-3.5 py-2.5 rounded-[10px] text-[13px] outline-none resize-none dark:bg-[#1a1625] bg-gray-50 dark:text-white text-gray-800 dark:border dark:border-white/[0.1] border border-black/[0.1] focus:border-orange-400 transition"></textarea>
                    </div>

                    <div class="flex justify-end pt-2 border-t dark:border-white/[0.06] border-black/[0.05]">
                        <button type="submit"
                            class="px-6 py-2.5 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 btn-trans">
                            Assign Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </section>

    <script>
        function openAssignModal() {
            document.getElementById('assignModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAssignModal() {
            document.getElementById('assignModal').classList.add('hidden');
            document.body.style.overflow = '';
        }
        document.getElementById('assignModal').addEventListener('click', function(e) {
            if (e.target === this) closeAssignModal();
        });
    </script>
@endsection
