@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900"><i
                        class="fas fa-calendar-alt mr-2"></i> Calendar</h2>
                <p class="text-[14px] dark:text-white text-gray-800 mt-0.5">Timeline — chronological view of all your
                    events.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <div class="flex items-center dark:bg-white/[0.06] bg-black/[0.05] rounded-[10px] p-1 gap-1">
                    <a href="{{ route('user.calendar.index') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold dark:text-white text-gray-800 dark:hover:text-white hover:text-gray-900 transition-colors">
                        <i class="fas fa-calendar mr-1"></i>Month</a>
                    <a href="{{ route('user.calendar.week') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold dark:text-white text-gray-800 dark:hover:text-white hover:text-gray-900 transition-colors">
                        <i class="fas fa-calendar-week mr-1"></i>Week</a>
                    <a href="{{ route('user.calendar.day') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold dark:text-white text-gray-800 dark:hover:text-white hover:text-gray-900 transition-colors">
                        <i class="fas fa-calendar-day mr-1"></i>Day</a>
                    <a href="{{ route('user.calendar.timeline') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 text-white">
                        <i class="fas fa-list mr-1"></i>Timeline</a>
                </div>
                <button onclick="openCreateModal()"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    <i class="fas fa-plus mr-1"></i>
                    Add Event
                </button>
            </div>
        </div>

        {{-- Month nav --}}
        <div class="flex items-center justify-between veroa-card rounded-2xl px-5 py-4">
            <a href="{{ route('user.calendar.timeline', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}"
                class="w-9 h-9 flex items-center justify-center rounded-xl dark:bg-white/[0.06] bg-black/[0.05] dark:text-white text-gray-800 hover:dark:bg-white/[0.1] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h3 class="text-[18px] font-extrabold dark:text-white text-gray-800">
                {{ $startDate->format('F Y') }}
            </h3>
            <a href="{{ route('user.calendar.timeline', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}"
                class="w-9 h-9 flex items-center justify-center rounded-xl dark:bg-white/[0.06] bg-black/[0.05] dark:text-white text-gray-800 hover:dark:bg-white/[0.1] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        {{-- Summary bar --}}
        <div class="grid grid-cols-3 gap-3">
            <div class="veroa-card rounded-2xl p-4 text-center">
                <p class="text-[28px] font-black text-orange-400">{{ $events->count() }}</p>
                <p class="text-[12px] font-bold dark:text-white text-gray-800 mt-0.5"> Total Events</p>
            </div>
            <div class="veroa-card rounded-2xl p-4 text-center">
                <p class="text-[28px] font-black text-blue-400">{{ $events->where('status', 'upcoming')->count() }}</p>
                <p class="text-[12px] font-bold dark:text-white text-gray-800 mt-0.5">Upcoming</p>
            </div>
            <div class="veroa-card rounded-2xl p-4 text-center">
                <p class="text-[28px] font-black text-emerald-400">{{ $events->where('status', 'completed')->count() }}</p>
                <p class="text-[12px] font-bold dark:text-white text-gray-800 mt-0.5">Completed</p>
            </div>
        </div>

        {{-- Timeline body --}}
        @if ($events->count() === 0)
            <div class="veroa-card rounded-2xl p-16 text-center">
                <div
                    class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-orange-500/20 to-pink-500/20 flex items-center justify-center">
                    <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </div>
                <h3 class="text-[17px] font-extrabold dark:text-white text-gray-900">No events this month</h3>
                <p class="text-[14px] dark:text-white text-gray-800 mt-1 mb-5">Start adding events to see them here.</p>
                <button onclick="openCreateModal()"
                    class="px-5 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500">
                    + Add First Event
                </button>
            </div>
        @else
            <div class="space-y-0">
                @php $prevDateStr = null; @endphp
                @foreach ($timelineDays as $dateStr => $dayData)
                    @php
                        $dayDate = $dayData['date'];
                        $dayEvs = $dayData['events'];
                        $isToday = $dayDate->isToday();
                        $isPast = $dayDate->isPast() && !$isToday;
                        $hasMark = $dayEvs->count() > 0 || $isToday;
                    @endphp
                    @if ($dayEvs->count() > 0 || $isToday)
                        <div class="flex gap-0">
                            {{-- Left: date column --}}
                            <div class="w-24 sm:w-32 flex-shrink-0 flex flex-col items-end pr-4 pt-4">
                                <div class="text-right">
                                    <p
                                        class="text-[11px] font-bold uppercase tracking-wider {{ $isToday ? 'text-orange-400' : ($isPast ? 'dark:text-white text-gray-800' : 'dark:text-white text-gray-800') }}">
                                        {{ $dayDate->format('D') }}
                                    </p>
                                    <p
                                        class="text-[22px] font-extrabold {{ $isToday ? 'text-orange-400' : ($isPast ? 'dark:text-white text-gray-800' : 'dark:text-white text-gray-900') }}">
                                        {{ $dayDate->format('j') }}
                                    </p>
                                    <p class="text-[11px] dark:text-white text-gray-800 font-medium">
                                        {{ $dayDate->format('M') }}</p>
                                </div>
                            </div>

                            {{-- Center: timeline line + dot --}}
                            <div class="flex flex-col items-center w-8 flex-shrink-0">
                                <div
                                    class="w-px flex-1 {{ $prevDateStr ? 'dark:bg-white/[0.08] bg-black/[0.08]' : 'bg-transparent' }}">
                                </div>
                                <div
                                    class="w-3.5 h-3.5 rounded-full border-2 flex-shrink-0
                    {{ $isToday ? 'bg-orange-500 border-orange-400 shadow-[0_0_10px_rgba(249,115,22,0.6)]' : ($dayEvs->count() > 0 ? 'dark:bg-white/[0.15] bg-black/[0.1] dark:border-white/[0.25] border-black/[0.15]' : 'dark:bg-white/[0.05] bg-black/[0.05] dark:border-white/[0.1] border-black/[0.08]') }}">
                                </div>
                                <div class="w-px flex-1 dark:bg-white/[0.08] bg-black/[0.08]"></div>
                            </div>

                            {{-- Right: events --}}
                            <div class="flex-1 pt-1 pb-6 pl-4 space-y-2">
                                @if ($isToday && $dayEvs->count() === 0)
                                    <div class="text-[13px] dark:text-white text-gray-800 font-medium italic pt-2">Today
                                        — no events scheduled</div>
                                @endif
                                @foreach ($dayEvs->sortBy('start_time') as $ev)
                                    @php
                                        $bgc = match ($ev->color) {
                                            'blue'
                                                => 'dark:bg-blue-500/[0.12] bg-blue-50 dark:border-blue-500/30 border-blue-200 dark:text-blue-200 text-blue-800',
                                            'green'
                                                => 'dark:bg-emerald-500/[0.12] bg-emerald-50 dark:border-emerald-500/30 border-emerald-200 dark:text-emerald-200 text-emerald-800',
                                            'pink'
                                                => 'dark:bg-pink-500/[0.12] bg-pink-50 dark:border-pink-500/30 border-pink-200 dark:text-pink-200 text-pink-800',
                                            'purple'
                                                => 'dark:bg-purple-500/[0.12] bg-purple-50 dark:border-purple-500/30 border-purple-200 dark:text-purple-200 text-purple-800',
                                            'red'
                                                => 'dark:bg-red-500/[0.12] bg-red-50 dark:border-red-500/30 border-red-200 dark:text-red-200 text-red-800',
                                            'yellow'
                                                => 'dark:bg-yellow-500/[0.12] bg-yellow-50 dark:border-yellow-500/30 border-yellow-200 dark:text-yellow-200 text-yellow-800',
                                            'teal'
                                                => 'dark:bg-teal-500/[0.12] bg-teal-50 dark:border-teal-500/30 border-teal-200 dark:text-teal-200 text-teal-800',
                                            default
                                                => 'dark:bg-orange-500/[0.12] bg-orange-50 dark:border-orange-500/30 border-orange-200 dark:text-orange-200 text-orange-800',
                                        };
                                        $dot = match ($ev->color) {
                                            'blue' => 'bg-blue-500',
                                            'green' => 'bg-emerald-500',
                                            'pink' => 'bg-pink-500',
                                            'purple' => 'bg-purple-500',
                                            'red' => 'bg-red-500',
                                            'yellow' => 'bg-yellow-400',
                                            'teal' => 'bg-teal-500',
                                            default => 'bg-orange-500',
                                        };
                                        $statusBadge = match ($ev->status) {
                                            'completed'
                                                => 'dark:bg-emerald-500/20 bg-emerald-100 dark:text-emerald-400 text-emerald-700',
                                            'cancelled'
                                                => 'dark:bg-red-500/20 bg-red-100 dark:text-red-400 text-red-700',
                                            default
                                                => 'dark:bg-blue-500/20 bg-blue-100 dark:text-blue-400 text-blue-700',
                                        };
                                    @endphp
                                    <div onclick="openEventModal({{ $ev->id }})"
                                        class="group flex items-start gap-3 p-3.5 rounded-xl border cursor-pointer hover:opacity-80 transition-all {{ $bgc }} {{ $ev->status === 'completed' ? 'opacity-60' : '' }}">
                                        <span
                                            class="w-2.5 h-2.5 rounded-full flex-shrink-0 mt-1 {{ $dot }}"></span>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between gap-2">
                                                <p
                                                    class="text-[14px] font-bold truncate {{ $ev->status === 'completed' ? 'line-through opacity-70' : '' }}">
                                                    {{ $ev->title }}</p>
                                                <span
                                                    class="text-[10px] font-bold px-2 py-0.5 rounded-full flex-shrink-0 {{ $statusBadge }}">{{ ucfirst($ev->status) }}</span>
                                            </div>
                                            <div class="flex items-center gap-3 mt-0.5 flex-wrap">
                                                <span class="text-[12px] opacity-70">
                                                    <i class="fas fa-clock mr-1 text-[10px]"></i>
                                                    {{ $ev->formatted_time }}
                                                </span>
                                                @if ($ev->location)
                                                    <span class="text-[12px] opacity-70">
                                                        <i
                                                            class="fas fa-map-marker-alt mr-1 text-[10px]"></i>{{ $ev->location }}
                                                    </span>
                                                @endif
                                                @if ($ev->type !== 'event')
                                                    <span
                                                        class="text-[11px] font-bold opacity-80 uppercase">{{ $ev->type }}</span>
                                                @endif
                                            </div>
                                            @if ($ev->description)
                                                <p class="text-[12px] opacity-60 mt-1 line-clamp-1">{{ $ev->description }}
                                                </p>
                                            @endif
                                        </div>
                                        {{-- Quick action buttons on hover --}}
                                        <div
                                            class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0">
                                            <button onclick="event.stopPropagation(); quickComplete({{ $ev->id }})"
                                                class="w-7 h-7 flex items-center justify-center rounded-lg dark:bg-white/[0.08] bg-black/[0.06] dark:text-emerald-400 text-emerald-600 dark:hover:bg-emerald-500/20 hover:bg-emerald-100 transition-colors"
                                                title="Mark complete">
                                                <i class="fas fa-check text-[11px]"></i>
                                            </button>
                                            <button onclick="event.stopPropagation(); deleteEvent({{ $ev->id }})"
                                                class="w-7 h-7 flex items-center justify-center rounded-lg dark:bg-white/[0.08] bg-black/[0.06] dark:text-red-400 text-red-500 dark:hover:bg-red-500/20 hover:bg-red-100 transition-colors"
                                                title="Delete">
                                                <i class="fas fa-trash text-[11px]"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @php $prevDateStr = $dateStr; @endphp
                    @endif
                @endforeach
            </div>
        @endif

    </section>

    @include('user.calendar.partials.event-modal')
    @include('user.calendar.partials.create-modal')

    <script>
        let editingEventId = null;

        function openCreateModal(date = null) {
            editingEventId = null;
            document.getElementById('modalTitle').textContent = 'Add Event';
            document.getElementById('submitBtn').textContent = 'Create Event';
            document.getElementById('eventForm').reset();
            document.getElementById('colorOrange').checked = true;
            const today = date || new Date().toISOString().split('T')[0];
            document.getElementById('start_date').value = today;
            document.getElementById('end_date').value = today;
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        function openEventModal(id) {
            fetch(`/user/calendar/${id}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => r.json()).then(ev => {
                    document.getElementById('evTitle').textContent = ev.title;
                    document.getElementById('evType').textContent = ev.type;
                    document.getElementById('evStatus').textContent = ev.status;
                    document.getElementById('evPriority').textContent = ev.priority;
                    document.getElementById('evDate').textContent = ev.start_date + (ev.start_date !== ev.end_date ?
                        ' – ' + ev.end_date : '');
                    document.getElementById('evTime').textContent = ev.all_day ? 'All day' : ((ev.start_time || '') + (
                        ev.end_time ? ' – ' + ev.end_time : ''));
                    document.getElementById('evDesc').textContent = ev.description || '—';
                    document.getElementById('evLocation').textContent = ev.location || '—';
                    document.getElementById('editEventBtn').onclick = () => {
                        closeEventModal();
                        openEditModal(ev);
                    };
                    document.getElementById('deleteEventBtn').onclick = () => deleteEvent(id);
                    document.getElementById('eventModal').classList.remove('hidden');
                });
        }

        function closeEventModal() {
            document.getElementById('eventModal').classList.add('hidden');
        }

        function openEditModal(ev) {
            editingEventId = ev.id;
            document.getElementById('modalTitle').textContent = 'Edit Event';
            document.getElementById('submitBtn').textContent = 'Update Event';
            document.getElementById('ev_title').value = ev.title;
            document.getElementById('ev_description').value = ev.description || '';
            document.getElementById('ev_location').value = ev.location || '';
            document.getElementById('start_date').value = ev.start_date;
            document.getElementById('start_time').value = ev.start_time || '';
            document.getElementById('end_date').value = ev.end_date;
            document.getElementById('end_time').value = ev.end_time || '';
            document.getElementById('ev_type').value = ev.type;
            document.getElementById('ev_priority').value = ev.priority;
            document.getElementById('ev_all_day').checked = ev.all_day;
            const c = document.getElementById('color' + ev.color.charAt(0).toUpperCase() + ev.color.slice(1));
            if (c) c.checked = true;
            document.getElementById('createModal').classList.remove('hidden');
        }

        function submitEventForm(e) {
            e.preventDefault();
            const data = new FormData(e.target);
            const url = editingEventId ? `/user/calendar/${editingEventId}` : '/user/calendar';
            if (editingEventId) data.append('_method', 'PUT');
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    },
                    body: data
                })
                .then(r => r.json()).then(res => {
                    if (res.success) {
                        closeCreateModal();
                        location.reload();
                    }
                });
        }

        function deleteEvent(id) {
            if (!confirm('Delete this event?')) return;
            fetch(`/user/calendar/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(() => location.reload());
        }

        function quickComplete(id) {
            fetch(`/user/calendar/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: 'completed'
                    })
                })
                .then(() => location.reload());
        }
        document.getElementById('ev_all_day')?.addEventListener('change', function() {
            document.getElementById('timeFields').classList.toggle('hidden', this.checked);
        });
    </script>
@endsection
