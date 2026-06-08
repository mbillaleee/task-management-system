<div
    class="dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-3xl overflow-hidden shadow-sm">
    <div class="px-5 py-4 border-b dark:border-white/[0.07] border-black/[0.07]">
        <h3 class="text-lg font-bold dark:text-white text-gray-900">Upcoming events</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Next scheduled events from your calendar.</p>
    </div>
    <div class="space-y-3 p-5">
        @forelse ($events as $event)
            <div class="rounded-3xl border border-black/[0.08] dark:border-white/[0.08] p-4 bg-white dark:bg-[#100d19]">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-bold dark:text-white text-gray-900 truncate">{{ $event->title }}</p>
                        <p class="mt-2 text-xs dark:text-gray-400 text-gray-500">
                            {{ $event->start_date?->format('M d, Y') }}
                            @if ($event->all_day)
                                · All day
                            @elseif ($event->start_time && $event->end_time)
                                · {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} –
                                {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                            @elseif ($event->start_time)
                                · {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                            @endif
                        </p>
                        <p class="mt-1 text-xs dark:text-gray-500 text-gray-400 truncate">{{ ucfirst($event->type) }} ·
                            {{ ucfirst($event->priority) }}</p>
                    </div>
                    <span
                        class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold uppercase {{ $event->status === 'upcoming' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : ($event->status === 'completed' ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-300' : 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-300') }}">{{ $event->status }}</span>
                </div>
                @if ($event->location)
                    <p class="mt-3 text-sm dark:text-gray-400 text-gray-500"><i class="fas fa-map-marker-alt mr-2"></i>
                        {{ $event->location }}</p>
                @endif
            </div>
        @empty
            <div class="rounded-3xl border border-black/[0.08] dark:border-white/[0.08] p-4 bg-white dark:bg-[#100d19]">
                <p class="text-sm dark:text-gray-400 text-gray-500">No upcoming events found.</p>
            </div>
        @endforelse
    </div>
</div>
