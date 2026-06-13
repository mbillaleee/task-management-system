@extends('admin.layouts.master')

@section('admin')
    <section class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold dark:text-white text-gray-900"><i class="fas fa-medal"></i> Badges</h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400">Create and manage achievement badges.</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.gamification.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button onclick="openCreateBadgeModal()"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-plus"></i> Create Badge
                </button>
            </div>
        </div>

        {{-- Alert messages --}}
        @if (session('success'))
            <div
                class="px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[14px] font-bold">
                {{ session('success') }}
            </div>
        @endif

        {{-- Badge Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse($badges as $badge)
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 blur-3xl opacity-20"
                        style="background: {{ $badge->color }}"></div>

                    <div class="relative z-10 flex items-start justify-between gap-3">
                        <div>
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-black mb-3"
                                style="background: {{ $badge->color }}">
                                {{ $badge->icon ?? '🏆' }}
                            </div>
                            <h3 class="text-[16px] font-bold dark:text-white text-gray-900">{{ $badge->name }}</h3>
                            <p class="text-[13px] dark:text-gray-500 text-gray-400 mt-1">
                                {{ \Illuminate\Support\Str::limit($badge->description, 80) }}
                            </p>
                            <p class="text-[12px] text-emerald-400 font-bold mt-2">
                                {{ $badge->users_count }} users unlocked
                            </p>
                        </div>

                        <span class="px-2.5 py-[4px] rounded-lg text-[12px] font-bold border shrink-0"
                            style="background: {{ $badge->color }}22; color: {{ $badge->color }}; border-color: {{ $badge->color }}55;">
                            {{ $badge->xp_required }} XP
                        </span>
                    </div>

                    <div
                        class="relative z-10 flex items-center justify-between mt-5 pt-4 border-t dark:border-white/[0.06] border-black/[0.05]">

                        <span
                            class="px-2 py-1 rounded-lg text-[12px] font-bold
                        {{ $badge->is_active ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                            {{ $badge->is_active ? 'Active' : 'Inactive' }}
                        </span>

                        <div class="flex gap-2">
                            <button type="button"
                                onclick="openEditBadgeModal(
        {{ $badge->id }},
        @js($badge->name),
        @js($badge->description),
        @js($badge->icon),
        @js($badge->color),
        {{ $badge->xp_required }},
        {{ $badge->is_active ? 1 : 0 }}
    )"
                                class="px-3 py-2 rounded-lg text-[13px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <form action="{{ route('admin.badges.destroy', $badge) }}" method="POST"
                                onsubmit="return confirm('Delete this badge? This will also remove it from all users.')">
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
            @empty
                <div
                    class="col-span-full p-10 text-center rounded-2xl dark:bg-[#17141f] bg-white border dark:border-white/[0.07]">
                    <p class="text-[18px] font-bold dark:text-white text-gray-900">No badges created yet.</p>
                    <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-1">Create your first badge to reward users.
                    </p>
                </div>
            @endforelse
        </div>

        <div>{{ $badges->links() }}</div>


        {{-- ==================== CREATE MODAL ==================== --}}
        <div id="createBadgeModal"
            class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center px-4">
            <div
                class="w-full max-w-lg dark:bg-[#17141f] bg-white border dark:border-white/[0.08] border-black/[0.08] rounded-2xl p-5">
                <div class="flex justify-between mb-4">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900"> <i class="fas fa-plus"></i> Create
                        Badge</h3>
                    <button onclick="closeCreateBadgeModal()" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
                </div>

                <form action="{{ route('admin.badges.store') }}" method="POST" class="space-y-4">
                    @csrf
                    @include('admin.gamification.partials.badge-form')
                </form>
            </div>
        </div>


        {{-- ==================== EDIT MODAL ==================== --}}
        <div id="editBadgeModal"
            class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center px-4">
            <div
                class="w-full max-w-lg dark:bg-[#17141f] bg-white border dark:border-white/[0.08] border-black/[0.08] rounded-2xl p-5">
                <div class="flex justify-between mb-4">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900"> <i class="fas fa-edit"></i> Edit
                        Badge</h3>
                    <button onclick="closeEditBadgeModal()" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
                </div>

                <form id="editBadgeForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    @include('admin.gamification.partials.badge-form', ['edit' => true])
                </form>
            </div>
        </div>

    </section>

    <script>
        function openCreateBadgeModal() {
            document.getElementById('createBadgeModal').classList.remove('hidden');
        }

        function closeCreateBadgeModal() {
            document.getElementById('createBadgeModal').classList.add('hidden');
        }

        function openEditBadgeModal(id, name, description, icon, color, xp, active) {
            document.getElementById('editBadgeForm').action = `/admin/badges/${id}`;
            document.getElementById('edit_badge_name').value = name ?? '';
            document.getElementById('edit_badge_description').value = description ?? '';
            document.getElementById('edit_badge_icon').value = icon ?? '';
            document.getElementById('edit_badge_color').value = color || '#f97316';
            document.getElementById('edit_badge_xp').value = xp ?? 0;
            document.getElementById('edit_badge_active').checked = active == 1;
            document.getElementById('editBadgeModal').classList.remove('hidden');
        }

        function closeEditBadgeModal() {
            document.getElementById('editBadgeModal').classList.add('hidden');
        }
    </script>
@endsection
