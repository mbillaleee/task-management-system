@extends('admin.layouts.master')

@section('admin')
    <section class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold dark:text-white text-gray-900"> <i class="fas fa-gift"></i> Daily
                    Rewards</h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400">Configure streak-based daily login rewards (Day 1–7).
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.gamification.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button onclick="openCreateRewardModal()"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-plus"></i> Add Reward
                </button>
            </div>
        </div>

        @if (session('success'))
            <div
                class="px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[14px] font-bold">
                {{ session('success') }}
            </div>
        @endif

        {{-- Rewards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse($rewards as $reward)
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-pink-500 flex items-center justify-center text-[22px]">
                            {{ $reward->icon ?? '🎁' }}
                        </div>
                        <span
                            class="px-2.5 py-1 rounded-lg text-[12px] font-bold bg-orange-500/10 text-orange-400 border border-orange-500/20">
                            Day {{ $reward->day_number }}
                        </span>
                    </div>

                    <h3 class="text-[16px] font-bold dark:text-white text-gray-900">
                        {{ $reward->title ?? 'Day ' . $reward->day_number . ' Reward' }}</h3>
                    <p class="text-[22px] font-black text-orange-400 mt-1">+{{ $reward->xp_reward }} XP</p>

                    <div
                        class="flex items-center justify-between mt-5 pt-4 border-t dark:border-white/[0.06] border-black/[0.05]">
                        <button type="button"
                            onclick="openEditRewardModal(
                                '{{ $reward->id }}',
                                '{{ $reward->day_number }}',
                                '{{ $reward->xp_reward }}',
                                '{{ addslashes($reward->title) }}',
                                '{{ addslashes($reward->icon) }}'
                            )"
                            class="px-3 py-2 rounded-lg text-[13px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <form action="{{ route('admin.daily-rewards.destroy', $reward) }}" method="POST"
                            onsubmit="return confirm('Delete this reward?')">
                            @csrf
                            @method('DELETE')
                            <button
                                class="px-3 py-2 rounded-lg text-[13px] font-bold dark:bg-red-500/[0.15] bg-red-50 text-red-500">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full p-10 text-center rounded-2xl dark:bg-[#17141f] bg-white border dark:border-white/[0.07]">
                    <p class="text-[18px] font-bold dark:text-white text-gray-900">No rewards configured yet.</p>
                    <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-1">Add rewards for Day 1 through Day 7.</p>
                </div>
            @endforelse
        </div>


        {{-- CREATE MODAL --}}
        <div id="createRewardModal"
            class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center px-4">
            <div class="w-full max-w-md dark:bg-[#17141f] bg-white border dark:border-white/[0.08] rounded-2xl p-5">
                <div class="flex justify-between mb-4">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900"> <i class="fas fa-plus"></i> Add
                        Daily Reward</h3>
                    <button onclick="closeCreateRewardModal()" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
                </div>
                <form action="{{ route('admin.daily-rewards.store') }}" method="POST" class="space-y-4">
                    @csrf
                    @include('admin.gamification.partials.reward-form')
                </form>
            </div>
        </div>

        {{-- EDIT MODAL --}}
        <div id="editRewardModal"
            class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center px-4">
            <div class="w-full max-w-md dark:bg-[#17141f] bg-white border dark:border-white/[0.08] rounded-2xl p-5">
                <div class="flex justify-between mb-4">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900"> <i class="fas fa-edit"></i> Edit
                        Daily Reward</h3>
                    <button onclick="closeEditRewardModal()" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
                </div>
                <form id="editRewardForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    @include('admin.gamification.partials.reward-form', ['edit' => true])
                </form>
            </div>
        </div>

    </section>

    <script>
        function openCreateRewardModal() {
            document.getElementById('createRewardModal').classList.remove('hidden');
        }

        function closeCreateRewardModal() {
            document.getElementById('createRewardModal').classList.add('hidden');
        }

        function openEditRewardModal(id, day, xp, title, icon) {
            document.getElementById('editRewardForm').action = `/admin/daily-rewards/${id}`;
            document.getElementById('edit_reward_day_number').value = day;
            document.getElementById('edit_reward_xp_reward').value = xp;
            document.getElementById('edit_reward_title').value = title;
            document.getElementById('edit_reward_icon').value = icon;
            document.getElementById('editRewardModal').classList.remove('hidden');
        }

        function closeEditRewardModal() {
            document.getElementById('editRewardModal').classList.add('hidden');
        }
    </script>
@endsection
