@extends('user.layouts.master')

@section('user')
    <section class="space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-800">
                    <i class="fas fa-history mr-2"></i> Focus Session History
                </h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">
                    View all created, started, paused, completed and cancelled focus activities.
                </p>
            </div>

            <a href="{{ route('user.focus.index') }}"
                class="px-4 py-2 rounded-[10px] text-[14px] font-bold dark:bg-white/[0.07] bg-white dark:text-gray-300 text-gray-700 border dark:border-white/[0.08] border-black/[0.08]">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <div class="hover-lift veroa-card shadow-[0_20px_60px_rgba(0,0,0,0.25)] rounded-2xl p-[18px]">
            <div class="space-y-5">
                @forelse($histories as $history)
                    <div class="relative pl-5">
                        <div class="absolute left-[5px] top-1 bottom-0 w-[2px] bg-orange-500/70"></div>
                        <div
                            class="absolute left-0 top-1.5 w-[12px] h-[12px] rounded-full bg-gradient-to-r from-orange-500 to-pink-500 shadow-lg">
                        </div>

                        <div
                            class="dark:bg-white/[0.04] bg-gray-50 rounded-xl p-3 border dark:border-white/[0.05] border-black/[0.04]">
                            <h4 class="text-[14px] font-bold dark:text-white text-gray-900">
                                <i class="fas fa-info-circle mr-2"></i> {{ $history->action }}
                            </h4>

                            <p class="text-[13px] dark:text-white text-gray-800 mt-1">
                                {{ $history->description }}
                            </p>

                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="text-[12px] font-bold text-orange-400">
                                    {{ $history->focusSession?->title ?? 'Deleted Session' }}
                                </span>

                                <span class="text-[12px] dark:text-white text-gray-800">
                                    <i class="fas fa-clock mr-2"></i> {{ $history->created_at->format('d M Y h:i A') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <h3 class="text-[16px] font-bold dark:text-white text-gray-900">No history found</h3>
                        <p class="text-[12px] dark:text-white text-gray-800 mt-1">
                            <i class="fas fa-info-circle mr-2"></i> Focus activity history will appear here.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <div>
            {{ $histories->links() }}
        </div>

    </section>
@endsection
