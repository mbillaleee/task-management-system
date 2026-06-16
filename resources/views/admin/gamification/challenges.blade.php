@extends('admin.layouts.master')

@section('admin')
    <section class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold dark:text-white text-gray-800"> <i class="fas fa-tasks"></i> Challenges
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800">Manage daily, weekly and monthly challenges.</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.gamification.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button onclick="openCreateChallengeModal()"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-plus"></i> Create Challenge
                </button>
            </div>
        </div>

        @if (session('success'))
            <div
                class="px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[14px] font-bold">
                {{ session('success') }}
            </div>
        @endif

        {{-- Challenge Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse($challenges as $challenge)
                <div
                    class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] border rounded-2xl p-4 relative overflow-hidden">

                    <div class="relative z-10">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-[16px] font-bold dark:text-white text-gray-800">{{ $challenge->title }}</h3>
                                <p class="text-[13px] dark:text-white text-gray-800 mt-0.5">
                                    {{ ucfirst($challenge->type) }} Challenge
                                </p>
                            </div>
                            <span
                                class="px-2.5 py-[4px] rounded-lg text-[12px] font-bold bg-orange-500/15 text-orange-400 border border-orange-500/20 shrink-0">
                                +{{ $challenge->xp_reward }} XP
                            </span>
                        </div>

                        <p class="text-[14px] dark:text-white text-gray-800 leading-relaxed mt-3">
                            {{ \Illuminate\Support\Str::limit($challenge->description, 100) }}
                        </p>

                        <div class="grid grid-cols-3 gap-2 mt-4">
                            <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3 text-center">
                                <p class="text-[11px] text-gray-400"> <i class="fas fa-target"></i> Target</p>
                                <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                    {{ $challenge->target_value }}</p>
                            </div>
                            <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3 text-center">
                                <p class="text-[11px] text-gray-400"> <i class="fas fa-users"></i> Joined</p>
                                <p class="text-[14px] font-bold text-orange-400">{{ $challenge->users_count }}</p>
                            </div>
                            <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3 text-center">
                                <p class="text-[11px] text-gray-400"> <i class="fas fa-check-circle"></i> Done</p>
                                <p class="text-[14px] font-bold text-emerald-400">{{ $challenge->completed_count }}</p>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between mt-5 pt-4 border-t dark:border-white/[0.06] border-black/[0.05]">
                            <span
                                class="px-2 py-1 rounded-lg text-[12px] font-bold
                            {{ $challenge->is_active ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                                {{ $challenge->is_active ? 'Active' : 'Inactive' }}
                            </span>

                            <div class="flex gap-2">
                                <button type="button"
                                    onclick="openEditChallengeModal(
                                        '{{ $challenge->id }}',
                                        '{{ addslashes($challenge->title) }}',
                                        '{{ addslashes($challenge->description) }}',
                                        '{{ $challenge->type }}',
                                        '{{ $challenge->target_value }}',
                                        '{{ $challenge->xp_reward }}',
                                        '{{ addslashes($challenge->reward_title) }}',
                                        '{{ $challenge->start_date ? $challenge->start_date->format('Y-m-d') : '' }}',
                                        '{{ $challenge->end_date ? $challenge->end_date->format('Y-m-d') : '' }}',
                                        '{{ $challenge->is_active ? 1 : 0 }}'
                                    )"
                                    class="px-3 py-2 rounded-lg text-[13px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <form action="{{ route('admin.challenges.destroy', $challenge) }}" method="POST"
                                    onsubmit="return confirm('Delete this challenge?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-3 py-2 rounded-lg text-[13px] font-bold dark:bg-red-500/[0.15] bg-red-50 text-red-500">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full p-10 text-center rounded-2xl dark:bg-[#17141f] bg-white border dark:border-white/[0.07]">
                    <p class="text-[18px] font-bold dark:text-white text-gray-800">No challenges created yet.</p>
                </div>
            @endforelse
        </div>

        <div>{{ $challenges->links() }}</div>


        {{-- CREATE MODAL --}}
        <div id="createChallengeModal"
            class="hidden fixed inset-0 z-50 veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] border flex items-center justify-center px-4">
            <div
                class="w-full max-w-xl veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] border rounded-2xl p-5 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between mb-4">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900"> <i class="fas fa-plus"></i> Create
                        Challenge</h3>
                    <button onclick="closeCreateChallengeModal()" class="text-gray-800 hover:text-white text-xl">✕</button>
                </div>
                <form action="{{ route('admin.challenges.store') }}" method="POST" class="space-y-4">
                    @csrf
                    @include('admin.gamification.partials.challenge-form')
                </form>
            </div>
        </div>

        {{-- EDIT MODAL --}}
        <div id="editChallengeModal"
            class="hidden fixed inset-0 z-50 veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] border flex items-center justify-center px-4">
            <div
                class="w-full max-w-xl veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] border rounded-2xl p-5 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between mb-4">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-800"> <i class="fas fa-edit"></i> Edit
                        Challenge</h3>
                    <button onclick="closeEditChallengeModal()" class="text-gray-800 hover:text-gray-500 text-xl">✕</button>
                </div>
                <form id="editChallengeForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    @include('admin.gamification.partials.challenge-form', ['edit' => true])
                </form>
            </div>
        </div>

    </section>

    <script>
        function openCreateChallengeModal() {
            document.getElementById('createChallengeModal').classList.remove('hidden');
        }

        function closeCreateChallengeModal() {
            document.getElementById('createChallengeModal').classList.add('hidden');
        }

        function openEditChallengeModal(id, title, description, type, target, xp, reward, start, end, active) {
            document.getElementById('editChallengeForm').action = `/admin/challenges/${id}`;
            document.getElementById('edit_challenge_title').value = title;
            document.getElementById('edit_challenge_description').value = description;
            document.getElementById('edit_challenge_type').value = type;
            document.getElementById('edit_challenge_target_value').value = target;
            document.getElementById('edit_challenge_xp_reward').value = xp;
            document.getElementById('edit_challenge_reward_title').value = reward;
            document.getElementById('edit_challenge_start_date').value = start;
            document.getElementById('edit_challenge_end_date').value = end;
            document.getElementById('edit_challenge_active').checked = active == 1;
            document.getElementById('editChallengeModal').classList.remove('hidden');
        }

        function closeEditChallengeModal() {
            document.getElementById('editChallengeModal').classList.add('hidden');
        }
    </script>
@endsection
