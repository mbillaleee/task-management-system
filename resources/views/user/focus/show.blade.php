@extends('user.layouts.master')

@section('user')
    @php
        $progress =
            $focus->duration_minutes > 0
                ? min(100, round(($focus->completed_minutes / $focus->duration_minutes) * 100))
                : 0;
    @endphp

    <section class="space-y-5">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    <i class="fas fa-info-circle mr-2"></i> Focus Details
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    View timer, progress, sound mode and activity history.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('user.focus.fullscreen', $focus->id) }}"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-expand mr-2"></i> Fullscreen
                </a>

                <a href="{{ route('user.focus.edit', $focus->id) }}"
                    class="px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    <i class="fas fa-edit mr-2"></i> Edit Focus
                </a>

                <a href="{{ route('user.focus.index') }}"
                    class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-gray-100 dark:text-gray-300 text-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-100 text-emerald-700 text-[14px] font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

            <div class="xl:col-span-2 space-y-4">
                <div
                    class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px] relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-28 h-28 bg-orange-500 blur-3xl opacity-20"></div>

                    <div class="relative z-10">
                        <h3 class="text-[18px] font-extrabold dark:text-white text-gray-800">
                            {{ $focus->title ?? 'Untitled Session' }}
                        </h3>

                        <p class="text-[14px] dark:text-white text-gray-800 mt-3 leading-relaxed">
                            {{ ucwords(str_replace('_', ' ', $focus->type)) }} session with
                            {{ ucwords(str_replace('_', ' ', $focus->ambient_sound ?? 'none')) }} ambient sound.
                        </p>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-5">
                            <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                                <p class="text-[14px] dark:text-white text-gray-800"> <i class="fas fa-clock mr-2"></i>
                                    Status</p>
                                <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                    {{ ucfirst($focus->status) }}
                                </p>
                            </div>

                            <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                                <p class="text-[14px] dark:text-white text-gray-800"> <i class="fas fa-tag mr-2"></i>
                                    Type</p>
                                <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                    {{ ucwords(str_replace('_', ' ', $focus->type)) }}
                                </p>
                            </div>

                            <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                                <p class="text-[14px] dark:text-white text-gray-800"> <i class="fas fa-volume-up mr-2"></i>
                                    Sound</p>
                                <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                    {{ ucwords(str_replace('_', ' ', $focus->ambient_sound ?? 'none')) }}
                                </p>
                            </div>

                            <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                                <p class="text-[14px] dark:text-white text-gray-800"> <i class="fas fa-star mr-2"></i> XP
                                </p>
                                <p class="text-[14px] font-bold dark:text-white text-gray-800">
                                    {{ $focus->xp_earned }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="flex justify-between text-[16px] mb-1.5">
                                <span class="dark:text-white text-gray-800">Progress</span>
                                <span class="font-bold dark:text-white text-gray-800">{{ $progress }}%</span>
                            </div>

                            <div class="w-full h-[9px] rounded-full dark:bg-white bg-gray-400 overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-orange-500 to-pink-500"
                                    style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('user.focus.partials.timer', ['focus' => $focus])

                <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
                    <h3 class="text-[16px] font-bold dark:text-white text-gray-900 mb-3.5">
                        <i class="fas fa-history mr-2"></i> Session History
                    </h3>

                    <div class="space-y-4">
                        @forelse($focus->histories as $history)
                            <div class="relative pl-5">
                                <div class="absolute left-[5px] top-1 bottom-0 w-[2px] bg-orange-500/70"></div>
                                <div
                                    class="absolute left-0 top-1.5 w-[12px] h-[12px] rounded-full bg-gradient-to-r from-orange-500 to-pink-500 shadow-lg">
                                </div>

                                <h4 class="text-[13px] font-bold dark:text-white text-gray-900">
                                    {{ $history->action }}
                                </h4>

                                <p class="text-[12px] dark:text-white text-gray-800 mt-1">
                                    {{ $history->description }}
                                </p>

                                <p class="text-[11px] dark:text-gray-600 text-gray-400 mt-1">
                                    {{ $history->created_at->format('d M Y h:i A') }}
                                </p>
                            </div>
                        @empty
                            <p class="text-[14px] dark:text-white text-gray-800">No history found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
                <h3 class="text-[18px] font-bold dark:text-white text-gray-900 mb-4">
                    <i class="fas fa-chart-line mr-2"></i> Time Overview
                </h3>

                <div class="space-y-3">
                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                        <p class="text-[14px] dark:text-white text-gray-800">
                            <i class="fas fa-clock mr-2"></i> Duration
                        </p>
                        <p class="text-[18px] font-extrabold dark:text-white text-gray-900">
                            {{ $focus->duration_minutes }} min
                        </p>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                        <p class="text-[14px] dark:text-white text-gray-800">
                            <i class="fas fa-check-circle mr-2"></i> Completed
                        </p>
                        <p class="text-[18px] font-extrabold dark:text-white text-gray-900">
                            {{ $focus->completed_minutes }} min
                        </p>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                        <p class="text-[14px] dark:text-white text-gray-800">
                            <i class="fas fa-expand mr-2"></i> Fullscreen
                        </p>
                        <p class="text-[14px] font-bold dark:text-white text-gray-800">
                            {{ $focus->fullscreen_mode ? 'Enabled' : 'Disabled' }}
                        </p>
                    </div>

                    {{-- <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                        <p class="text-[14px] dark:text-white text-gray-800">
                            <i class="fas fa-ban mr-2"></i> Distraction Free
                        </p>
                        <p class="text-[14px] font-bold dark:text-white text-gray-800">
                            {{ $focus->distraction_free ? 'Enabled' : 'Disabled' }}
                        </p>
                    </div> --}}

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                        <p class="text-[14px] dark:text-white text-gray-800">
                            <i class="fas fa-clock mr-2"></i> Started At
                        </p>
                        <p class="text-[14px] font-bold dark:text-white text-gray-800">
                            {{ $focus->started_at ? $focus->started_at->format('d M Y h:i A') : 'Not started' }}
                        </p>
                    </div>

                    <div class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3">
                        <p class="text-[14px] dark:text-white text-gray-800">
                            <i class="fas fa-check-circle mr-2"></i> Completed At
                        </p>
                        <p class="text-[14px] font-bold dark:text-white text-gray-800">
                            {{ $focus->completed_at ? $focus->completed_at->format('d M Y h:i A') : 'Not completed' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection
