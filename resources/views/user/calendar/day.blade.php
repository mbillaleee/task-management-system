@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">Calendar</h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">Daily planner — full schedule for the day.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <div class="flex items-center dark:bg-white/[0.06] bg-black/[0.05] rounded-[10px] p-1 gap-1">
                    <a href="{{ route('user.calendar.index') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors">Month</a>
                    <a href="{{ route('user.calendar.week') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors">Week</a>
                    <a href="{{ route('user.calendar.day') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 text-white">Day</a>
                    <a href="{{ route('user.calendar.timeline') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors">Timeline</a>
                </div>
                <button onclick="openCreateModal()"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Event
                </button>
            </div>
        </div>

        {{-- Day nav --}}
        <div
            class="flex items-center justify-between dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl px-5 py-4">
            <a href="{{ route('user.calendar.day', ['date' => $prevDay->toDateString()]) }}"
                class="w-9 h-9 flex items-center justify-center rounded-xl dark:bg-white/[0.06] bg-black/[0.05] dark:text-gray-300 text-gray-600 hover:dark:bg-white/[0.1] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div class="text-center">
                <h3 class="text-[20px] font-extrabold dark:text-white text-gray-900">
                    {{ $date->format('l') }}
                </h3>
                <p class="text-[14px] dark:text-gray-400 text-gray-500 font-medium">
                    {{ $date->format('F j, Y') }}
                    @if ($date->isToday())
                        <span
                            class="ml-2 px-2 py-0.5 rounded-full bg-orange-500/20 text-orange-400 text-[12px] font-bold">Today</span>
                    @endif
                </p>
            </div>
            <a href="{{ route('user.calendar.day', ['date' => $nextDay->toDateString()]) }}"
                class="w-9 h-9 flex items-center justify-center rounded-xl dark:bg-white/[0.06] bg-black/[0.05] dark:text-gray-300 text-gray-600 hover:dark:bg-white/[0.1] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- All-day events --}}
            @if ($allDayEvents->count())
                <div
                    class="lg:col-span-3 dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
                    <p class="text-[12px] font-bold uppercase tracking-wider dark:text-gray-500 text-gray-400 mb-3">All Day
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($allDayEvents as $ev)
                            @php
                                $bgc = match ($ev->color) {
                                    'blue'
                                        => 'dark:bg-blue-500/20 bg-blue-50 dark:text-blue-300 text-blue-700 dark:border-blue-500/30 border-blue-200',
                                    'green'
                                        => 'dark:bg-emerald-500/20 bg-emerald-50 dark:text-emerald-300 text-emerald-700 dark:border-emerald-500/30 border-emerald-200',
                                    'pink'
                                        => 'dark:bg-pink-500/20 bg-pink-50 dark:text-pink-300 text-pink-700 dark:border-pink-500/30 border-pink-200',
                                    'purple'
                                        => 'dark:bg-purple-500/20 bg-purple-50 dark:text-purple-300 text-purple-700 dark:border-purple-500/30 border-purple-200',
                                    'red'
                                        => 'dark:bg-red-500/20 bg-red-50 dark:text-red-300 text-red-700 dark:border-red-500/30 border-red-200',
                                    'yellow'
                                        => 'dark:bg-yellow-500/20 bg-yellow-50 dark:text-yellow-300 text-yellow-700 dark:border-yellow-500/30 border-yellow-200',
                                    'teal'
                                        => 'dark:bg-teal-500/20 bg-teal-50 dark:text-teal-300 text-teal-700 dark:border-teal-500/30 border-teal-200',
                                    default
                                        => 'dark:bg-orange-500/20 bg-orange-50 dark:text-orange-300 text-orange-700 dark:border-orange-500/30 border-orange-200',
                                };
                            @endphp
                            <div onclick="openEventModal({{ $ev->id }})"
                                class="flex items-center gap-2 px-3 py-1.5 rounded-xl border cursor-pointer hover:opacity-80 transition-opacity {{ $bgc }}">
                                <i class="fas fa-calendar-day text-[12px]"></i>
                                <span class="text-[13px] font-bold">{{ $ev->title }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Hour schedule --}}
            <div
                class="lg:col-span-2 dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b dark:border-white/[0.07] border-black/[0.07]">
                    <h4 class="text-[15px] font-extrabold dark:text-white text-gray-900">Schedule</h4>
                </div>
                <div class="overflow-y-auto max-h-[640px]">
                    @foreach ($hours as $hour)
                        @php
                            $isCurrentHour = $date->isToday() && now()->hour === $hour;
                            $slotEvents = $timedEvents->filter(function ($ev) use ($hour) {
                                return $ev->start_time && (int) \Carbon\Carbon::parse($ev->start_time)->hour === $hour;
                            });
                            $displayHour =
                                $hour === 0
                                    ? '12 AM'
                                    : ($hour < 12
                                        ? $hour . ' AM'
                                        : ($hour === 12
                                            ? '12 PM'
                                            : $hour - 12 . ' PM'));
                        @endphp
                        <div class="flex border-b dark:border-white/[0.04] border-black/[0.04] {{ $isCurrentHour ? 'dark:bg-orange-500/[0.06] bg-orange-50' : '' }}"
                            style="min-height:56px;">
                            <div
                                class="w-16 flex-shrink-0 px-3 pt-3 text-[11px] font-medium dark:text-gray-600 text-gray-400 text-right">
                                {{ $displayHour }}
                            </div>
                            <div class="flex-1 p-1.5 space-y-1 border-l dark:border-white/[0.05] border-black/[0.05]">
                                @foreach ($slotEvents as $ev)
                                    @php
                                        $evbg = match ($ev->color) {
                                            'blue'
                                                => 'dark:bg-blue-500/20 bg-blue-50 dark:border-l-blue-500 border-l-blue-500 dark:text-blue-200 text-blue-800',
                                            'green'
                                                => 'dark:bg-emerald-500/20 bg-emerald-50 dark:border-l-emerald-500 border-l-emerald-500 dark:text-emerald-200 text-emerald-800',
                                            'pink'
                                                => 'dark:bg-pink-500/20 bg-pink-50 dark:border-l-pink-500 border-l-pink-500 dark:text-pink-200 text-pink-800',
                                            'purple'
                                                => 'dark:bg-purple-500/20 bg-purple-50 dark:border-l-purple-500 border-l-purple-500 dark:text-purple-200 text-purple-800',
                                            'red'
                                                => 'dark:bg-red-500/20 bg-red-50 dark:border-l-red-500 border-l-red-500 dark:text-red-200 text-red-800',
                                            'yellow'
                                                => 'dark:bg-yellow-500/20 bg-yellow-50 dark:border-l-yellow-400 border-l-yellow-400 dark:text-yellow-200 text-yellow-800',
                                            'teal'
                                                => 'dark:bg-teal-500/20 bg-teal-50 dark:border-l-teal-500 border-l-teal-500 dark:text-teal-200 text-teal-800',
                                            default
                                                => 'dark:bg-orange-500/20 bg-orange-50 dark:border-l-orange-500 border-l-orange-500 dark:text-orange-200 text-orange-800',
                                        };
                                    @endphp
                                    <div onclick="openEventModal({{ $ev->id }})"
                                        class="flex items-start gap-2 px-2.5 py-2 rounded-lg border-l-[3px] cursor-pointer hover:opacity-80 transition-opacity {{ $evbg }}">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[13px] font-bold truncate">{{ $ev->title }}</p>
                                            <p class="text-[11px] opacity-70">
                                                {{ \Carbon\Carbon::parse($ev->start_time)->format('g:i A') }}
                                                @if ($ev->end_time)
                                                    – {{ \Carbon\Carbon::parse($ev->end_time)->format('g:i A') }}
                                                @endif
                                                @if ($ev->location)
                                                    · {{ $ev->location }}
                                                @endif
                                            </p>
                                        </div>
                                        @php $prioClass=['high'=>'text-red-400','medium'=>'text-orange-400','low'=>'text-gray-400'][$ev->priority]; @endphp
                                        <span
                                            class="text-[10px] font-bold uppercase {{ $prioClass }}">{{ $ev->priority }}</span>
                                    </div>
                                @endforeach
                                @if ($slotEvents->isEmpty())
                                    <div onclick="openCreateModalAtHour({{ $hour }}, '{{ $date->toDateString() }}')"
                                        class="h-8 rounded-lg cursor-pointer hover:dark:bg-white/[0.03] hover:bg-black/[0.02] transition-colors">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Sidebar: day summary --}}
            <div class="space-y-4">
                <div class="dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
                    <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-3">Today's Summary</h4>
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] dark:text-gray-400 text-gray-500">Total Events</span>
                            <span
                                class="text-[15px] font-extrabold dark:text-white text-gray-900">{{ $events->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] dark:text-gray-400 text-gray-500">Timed</span>
                            <span class="text-[15px] font-extrabold text-blue-400">{{ $timedEvents->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] dark:text-gray-400 text-gray-500">All Day</span>
                            <span class="text-[15px] font-extrabold text-purple-400">{{ $allDayEvents->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] dark:text-gray-400 text-gray-500">High Priority</span>
                            <span
                                class="text-[15px] font-extrabold text-red-400">{{ $events->where('priority', 'high')->count() }}</span>
                        </div>
                    </div>
                </div>

                {{-- Quick mini calendar nav --}}
                <div class="dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
                    <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-3">Jump to Date</h4>
                    <input type="date" id="jumpDate" value="{{ $date->toDateString() }}"
                        class="w-full px-3 py-2 rounded-xl border dark:border-white/[0.1] border-black/[0.1] dark:bg-white/[0.05] bg-black/[0.03] dark:text-white text-gray-900 text-[13px] font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/50"
                        onchange="location.href='/user/calendar/day?date='+this.value">
                </div>

                {{-- All events list --}}
                @if ($events->count())
                    <div
                        class="dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
                        <h4 class="text-[14px] font-extrabold dark:text-white text-gray-900 mb-3">All Events</h4>
                        <div class="space-y-2">
                            @foreach ($events->sortBy('start_time') as $ev)
                                @php
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
                                @endphp
                                <div onclick="openEventModal({{ $ev->id }})"
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl cursor-pointer dark:hover:bg-white/[0.04] hover:bg-black/[0.03] transition-colors">
                                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0 {{ $dot }}"></span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[13px] font-semibold dark:text-gray-200 text-gray-700 truncate">
                                            {{ $ev->title }}</p>
                                        <p class="text-[11px] dark:text-gray-500 text-gray-400">{{ $ev->formatted_time }}
                                        </p>
                                    </div>
                                    @php $sc = ['upcoming'=>'text-blue-400','completed'=>'text-emerald-400','cancelled'=>'text-red-400'][$ev->status] ?? 'text-gray-400'; @endphp
                                    <span
                                        class="text-[10px] font-bold {{ $sc }}">{{ ucfirst($ev->status) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

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
            const today = date || '{{ $date->toDateString() }}';
            document.getElementById('start_date').value = today;
            document.getElementById('end_date').value = today;
            document.getElementById('createModal').classList.remove('hidden');
        }

        function openCreateModalAtHour(hour, date) {
            openCreateModal(date);
            const h = hour.toString().padStart(2, '0');
            document.getElementById('start_time').value = h + ':00';
            document.getElementById('end_time').value = (hour + 1 < 24 ? (hour + 1).toString().padStart(2, '0') : '23') +
                ':00';
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
        document.getElementById('ev_all_day')?.addEventListener('change', function() {
            document.getElementById('timeFields').classList.toggle('hidden', this.checked);
        });
    </script>
@endsection
