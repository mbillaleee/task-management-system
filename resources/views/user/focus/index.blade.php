@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    Focus Sessions
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Manage Pomodoro, deep work, focus timer and break sessions.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('user.focus.statistics') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                    Statistics
                </a>

                <a href="{{ route('user.focus.history') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                    History
                </a>

                <a href="{{ route('user.focus.create') }}"
                    class="flex items-center justify-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    + Add Focus
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-100 text-emerald-700 text-[14px] font-bold">
                {{ session('success') }}
            </div>
        @endif

        @include('user.focus.partials.stats-cards', ['stats' => $stats])

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse($sessions as $session)
                @php
                    $progress =
                        $session->duration_minutes > 0
                            ? min(100, round(($session->completed_minutes / $session->duration_minutes) * 100))
                            : 0;

                    $statusClass =
                        [
                            'pending' => 'dark:bg-yellow-500/[0.15] bg-yellow-50 text-yellow-500',
                            'running' => 'dark:bg-blue-500/[0.15] bg-blue-50 text-blue-500',
                            'paused' => 'dark:bg-orange-500/[0.15] bg-orange-50 text-orange-500',
                            'completed' => 'dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500',
                            'cancelled' => 'dark:bg-red-500/[0.15] bg-red-50 text-red-500',
                        ][$session->status] ?? 'bg-gray-100 text-gray-500';

                    $typeClass =
                        [
                            'pomodoro' => 'dark:bg-orange-500/[0.15] bg-orange-50 text-orange-500 border-orange-500/20',
                            'deep_work' =>
                                'dark:bg-purple-500/[0.15] bg-purple-50 text-purple-500 border-purple-500/20',
                            'focus_timer' => 'dark:bg-blue-500/[0.15] bg-blue-50 text-blue-500 border-blue-500/20',
                            'break' =>
                                'dark:bg-emerald-500/[0.15] bg-emerald-50 text-emerald-500 border-emerald-500/20',
                        ][$session->type] ?? 'bg-gray-100 text-gray-500';
                @endphp

                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-orange-500 blur-3xl opacity-20"></div>

                    <div class="relative z-10 flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-[16px] font-bold dark:text-white text-gray-900 leading-snug">
                                {{ $session->title ?? 'Untitled Session' }}
                            </h3>
                            <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-1">
                                {{ ucwords(str_replace('_', ' ', $session->ambient_sound ?? 'none')) }} sound
                            </p>
                        </div>

                        <span class="px-2.5 py-[4px] rounded-lg text-[15px] font-bold border {{ $typeClass }}">
                            {{ ucwords(str_replace('_', ' ', $session->type)) }}
                        </span>
                    </div>

                    <div class="relative z-10 grid grid-cols-2 gap-3 mt-4">
                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[14px] dark:text-gray-500 text-gray-400">Duration</p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                {{ $session->duration_minutes }} min
                            </p>
                        </div>

                        <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                            <p class="text-[14px] dark:text-gray-500 text-gray-400">Completed</p>
                            <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                {{ $session->completed_minutes }} min
                            </p>
                        </div>
                    </div>

                    <div
                        class="relative z-10 flex items-center justify-between mt-4 pt-3 border-t dark:border-white/[0.06] border-black/[0.05]">
                        <div>
                            <p class="text-[16px] dark:text-gray-500 text-gray-400">XP Earned</p>
                            <p class="text-[14px] font-semibold dark:text-gray-300 text-gray-700">
                                {{ $session->xp_earned }}
                            </p>
                        </div>

                        <span class="px-2.5 py-[4px] rounded-lg text-[15px] font-bold {{ $statusClass }}">
                            {{ ucfirst($session->status) }}
                        </span>
                    </div>

                    <div class="relative z-10 mt-4">
                        <div class="flex justify-between text-[16px] mb-1.5">
                            <span class="dark:text-gray-400 text-gray-500">Progress</span>
                            <span class="font-bold dark:text-white text-gray-800">{{ $progress }}%</span>
                        </div>

                        <div class="w-full h-[7px] rounded-full dark:bg-white/[0.08] bg-gray-100 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500"
                                style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                    <div class="relative z-10 flex items-center justify-between gap-2 mt-4">
                        <a href="{{ route('user.focus.show', $session->id) }}"
                            class="px-3 py-2 rounded-lg text-[14px] font-bold text-white bg-gradient-to-r from-orange-500 to-pink-500">
                            View
                        </a>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('user.focus.edit', $session->id) }}"
                                class="px-3 py-2 rounded-lg text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                                Edit
                            </a>

                            <form action="{{ route('user.focus.destroy', $session->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this focus session?')"
                                    class="px-3 py-2 rounded-lg text-[14px] font-bold dark:bg-red-500/[0.15] bg-red-50 text-red-500">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-8 text-center">
                    <h3 class="text-[16px] font-bold dark:text-white text-gray-900">No focus sessions found</h3>
                    <p class="text-[12px] dark:text-gray-500 text-gray-400 mt-1">Create your first focus session to get
                        started.</p>
                </div>
            @endforelse
        </div>

        <div>
            {{ $sessions->links() }}
        </div>

    </section>
@endsection
