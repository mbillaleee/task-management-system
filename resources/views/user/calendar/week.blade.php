@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900"><i
                        class="fas fa-calendar-week mr-2"></i> Calendar</h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">Weekly planner — schedule and manage your
                    week.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <div class="flex items-center dark:bg-white/[0.06] bg-black/[0.05] rounded-[10px] p-1 gap-1">
                    <a href="{{ route('user.calendar.index') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors"><i
                            class="fas fa-calendar-alt mr-1"></i>Month</a>
                    <a href="{{ route('user.calendar.week') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 text-white"><i
                            class="fas fa-calendar-week mr-1"></i>Week</a>
                    <a href="{{ route('user.calendar.day') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors"><i
                            class="fas fa-calendar-day mr-1"></i>Day</a>
                    <a href="{{ route('user.calendar.timeline') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors"><i
                            class="fas fa-list mr-1"></i>Timeline</a>
                </div>
                <button onclick="openCreateModal()"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-[10px] text-white text-[14px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 shadow-[0_4px_16px_rgba(249,115,22,0.38)]">
                    <i class="fas fa-plus mr-1"></i>
                    Add Event
                </button>
            </div>
        </div>

        {{-- Week nav --}}
        <div
            class="dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b dark:border-white/[0.07] border-black/[0.07]">
                <a href="{{ route('user.calendar.week', ['date' => $prevWeek->toDateString()]) }}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl dark:bg-white/[0.06] bg-black/[0.05] dark:text-gray-300 text-gray-600 hover:dark:bg-white/[0.1] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h3 class="text-[16px] font-extrabold dark:text-white text-gray-900">
                    {{ $startOfWeek->format('M j') }} – {{ $endOfWeek->format('M j, Y') }}
                </h3>
                <a href="{{ route('user.calendar.week', ['date' => $nextWeek->toDateString()]) }}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl dark:bg-white/[0.06] bg-black/[0.05] dark:text-gray-300 text-gray-600 hover:dark:bg-white/[0.1] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            {{-- Day columns header --}}
            <div class="grid grid-cols-8 border-b dark:border-white/[0.07] border-black/[0.07]">
                <div class="py-3 px-2 text-[11px] font-bold dark:text-gray-600 text-gray-300 uppercase text-center"><i
                        class="fas fa-clock mr-1"></i> Time
                </div>
                @foreach ($weekDays as $wd)
                    @php $isToday = $wd->isToday(); @endphp
                    <div class="py-3 text-center border-l dark:border-white/[0.05] border-black/[0.05]">
                        <div class="text-[11px] font-bold uppercase dark:text-gray-500 text-gray-400 tracking-wider">
                            {{ $wd->format('D') }}</div>
                        <div
                            class="w-8 h-8 mx-auto mt-0.5 flex items-center justify-center rounded-full text-[15px] font-extrabold
                    {{ $isToday ? 'bg-gradient-to-br from-orange-500 to-pink-500 text-white' : 'dark:text-gray-200 text-gray-700' }}">
                            {{ $wd->day }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Time grid --}}
            <div class="overflow-y-auto max-h-[600px]">
                @foreach ($timeSlots as $slot)
                    @php $slotHour = \Carbon\Carbon::parse($slot)->hour; @endphp
                    <div class="grid grid-cols-8 border-b dark:border-white/[0.04] border-black/[0.04]"
                        style="min-height:60px;">
                        <div class="px-2 pt-1 text-[11px] dark:text-gray-600 text-gray-400 font-medium text-right">
                            {{ $slot }}</div>
                        @foreach ($weekDays as $wd)
                            @php
                                $key = $wd->format('Y-m-d');
                                $dayEvs = $events->get($key, collect())->filter(function ($ev) use ($slotHour) {
                                    if ($ev->all_day) {
                                        return false;
                                    }
                                    $h = $ev->start_time ? (int) \Carbon\Carbon::parse($ev->start_time)->hour : 0;
                                    return $h === $slotHour;
                                });
                            @endphp
                            <div class="border-l dark:border-white/[0.05] border-black/[0.05] p-0.5 relative">
                                @foreach ($dayEvs as $ev)
                                    @php
                                        $bgColor = match ($ev->color) {
                                            'blue'
                                                => 'dark:bg-blue-500/25 bg-blue-100 dark:border-blue-500/40 border-blue-300 dark:text-blue-200 text-blue-800',
                                            'green'
                                                => 'dark:bg-emerald-500/25 bg-emerald-100 dark:border-emerald-500/40 border-emerald-300 dark:text-emerald-200 text-emerald-800',
                                            'pink'
                                                => 'dark:bg-pink-500/25 bg-pink-100 dark:border-pink-500/40 border-pink-300 dark:text-pink-200 text-pink-800',
                                            'purple'
                                                => 'dark:bg-purple-500/25 bg-purple-100 dark:border-purple-500/40 border-purple-300 dark:text-purple-200 text-purple-800',
                                            'red'
                                                => 'dark:bg-red-500/25 bg-red-100 dark:border-red-500/40 border-red-300 dark:text-red-200 text-red-800',
                                            'yellow'
                                                => 'dark:bg-yellow-500/25 bg-yellow-100 dark:border-yellow-500/40 border-yellow-300 dark:text-yellow-200 text-yellow-800',
                                            'teal'
                                                => 'dark:bg-teal-500/25 bg-teal-100 dark:border-teal-500/40 border-teal-300 dark:text-teal-200 text-teal-800',
                                            default
                                                => 'dark:bg-orange-500/25 bg-orange-100 dark:border-orange-500/40 border-orange-300 dark:text-orange-200 text-orange-800',
                                        };
                                    @endphp
                                    <div onclick="openEventModal({{ $ev->id }})"
                                        class="rounded-md border-l-2 px-1.5 py-1 mb-0.5 cursor-pointer hover:opacity-80 transition-opacity {{ $bgColor }}">
                                        <p class="text-[11px] font-bold truncate">{{ $ev->title }}</p>
                                        @if ($ev->start_time)
                                            <p class="text-[10px] opacity-70">
                                                {{ \Carbon\Carbon::parse($ev->start_time)->format('g:i A') }}</p>
                                        @endif
                                    </div>
                                @endforeach

                                {{-- All day events in first row --}}
                                @if ($slotHour === 6)
                                    @foreach ($events->get($wd->format('Y-m-d'), collect())->where('all_day', true) as $ev)
                                        <div onclick="openEventModal({{ $ev->id }})"
                                            class="rounded-md px-1.5 py-1 mb-0.5 text-[11px] font-bold cursor-pointer bg-gradient-to-r from-orange-500/20 to-pink-500/20 dark:text-orange-300 text-orange-700 border dark:border-orange-500/30 border-orange-200 hover:opacity-80 transition-opacity truncate">
                                            📅 {{ $ev->title }}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
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
            const form = e.target;
            const data = new FormData(form);
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
