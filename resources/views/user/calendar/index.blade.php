@extends('user.layouts.master')

@section('user')
    <section class="space-y-5">

        {{-- ── Header ──────────────────────────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
            <div>
                <h2 class="text-[20px] font-extrabold tracking-[-0.3px] dark:text-white text-gray-900">
                    Calendar
                </h2>
                <p class="text-[14px] dark:text-gray-500 text-gray-400 mt-0.5">
                    Plan events, schedule blocks, and manage your time.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                {{-- View switcher --}}
                <div class="flex items-center dark:bg-white/[0.06] bg-black/[0.05] rounded-[10px] p-1 gap-1">
                    <a href="{{ route('user.calendar.index', ['year' => $year, 'month' => $month]) }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold bg-gradient-to-r from-orange-500 to-pink-500 text-white">
                        Month
                    </a>
                    <a href="{{ route('user.calendar.week') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors">
                        Week
                    </a>
                    <a href="{{ route('user.calendar.day') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors">
                        Day
                    </a>
                    <a href="{{ route('user.calendar.timeline') }}"
                        class="px-3 py-1.5 rounded-[8px] text-[13px] font-bold dark:text-gray-400 text-gray-500 dark:hover:text-white hover:text-gray-900 transition-colors">
                        Timeline
                    </a>
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

        @if (session('success'))
            <div
                class="p-4 rounded-xl bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-[14px] font-bold">
                {{ session('success') }}
            </div>
        @endif

        {{-- ── Stats ────────────────────────────────────────────────────────── --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @php
                $statItems = [
                    ['label' => 'Total Events', 'value' => $stats['total'], 'color' => 'text-orange-400'],
                    ['label' => 'Upcoming', 'value' => $stats['upcoming'], 'color' => 'text-blue-400'],
                    ['label' => 'Completed', 'value' => $stats['completed'], 'color' => 'text-emerald-400'],
                    ['label' => 'Today\'s Events', 'value' => $stats['today'], 'color' => 'text-pink-400'],
                ];
            @endphp
            @foreach ($statItems as $s)
                <div
                    class="hover-lift dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl p-4">
                    <p class="text-[13px] dark:text-gray-400 text-gray-500 font-bold">{{ $s['label'] }}</p>
                    <h3 class="text-[30px] font-black {{ $s['color'] }} mt-1">{{ $s['value'] }}</h3>
                </div>
            @endforeach
        </div>

        {{-- ── Month navigation ────────────────────────────────────────────── --}}
        <div
            class="dark:bg-[#17141f] bg-white border dark:border-white/[0.07] border-black/[0.07] rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b dark:border-white/[0.07] border-black/[0.07]">
                <a href="{{ route('user.calendar.index', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl dark:bg-white/[0.06] bg-black/[0.05] dark:text-gray-300 text-gray-600 dark:hover:bg-white/[0.1] hover:bg-black/[0.08] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="text-center">
                    <h3 class="text-[18px] font-extrabold dark:text-white text-gray-900">
                        {{ $currentMonth->format('F Y') }}
                    </h3>
                    <p class="text-[12px] dark:text-gray-500 text-gray-400">
                        {{ now()->format('l, F j, Y') }}
                    </p>
                </div>
                <a href="{{ route('user.calendar.index', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl dark:bg-white/[0.06] bg-black/[0.05] dark:text-gray-300 text-gray-600 dark:hover:bg-white/[0.1] hover:bg-black/[0.08] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            {{-- Day headers --}}
            <div class="grid grid-cols-7 border-b dark:border-white/[0.07] border-black/[0.07]">
                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $d)
                    <div
                        class="py-2.5 text-center text-[12px] font-bold dark:text-gray-500 text-gray-400 uppercase tracking-wider">
                        {{ $d }}
                    </div>
                @endforeach
            </div>

            {{-- Calendar grid --}}
            <div class="grid grid-cols-7">
                @foreach ($calendarDays as $calDay)
                    @php
                        $key = $calDay->format('Y-m-d');
                        $dayEvents = $events->get($key, collect());
                        $isToday = $calDay->isToday();
                        $isCurrent = $calDay->month === $month;
                        $isWeekend = $calDay->isSaturday() || $calDay->isSunday();
                    @endphp
                    <div onclick="openCreateModalOnDate('{{ $key }}')"
                        class="min-h-[110px] p-2 border-r border-b dark:border-white/[0.05] border-black/[0.05] cursor-pointer
                        {{ $isCurrent ? 'dark:bg-transparent bg-transparent' : 'dark:bg-white/[0.01] bg-black/[0.01]' }}
                        {{ $isWeekend && $isCurrent ? 'dark:bg-white/[0.02] bg-black/[0.02]' : '' }}
                        hover:dark:bg-white/[0.03] hover:bg-black/[0.02] transition-colors group">

                        {{-- Day number --}}
                        <div class="flex items-center justify-between mb-1.5">
                            <span
                                class="w-7 h-7 flex items-center justify-center rounded-full text-[13px] font-bold
                        {{ $isToday ? 'bg-gradient-to-br from-orange-500 to-pink-500 text-white' : '' }}
                        {{ !$isToday && $isCurrent ? 'dark:text-gray-200 text-gray-700' : 'dark:text-gray-600 text-gray-300' }}">
                                {{ $calDay->day }}
                            </span>
                            @if ($dayEvents->count() > 0)
                                <span
                                    class="text-[10px] font-bold dark:text-gray-500 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity">
                                    +
                                </span>
                            @endif
                        </div>

                        {{-- Events --}}
                        <div class="space-y-1">
                            @foreach ($dayEvents->take(3) as $ev)
                                @php
                                    $dotColor = match ($ev->color) {
                                        'blue' => 'bg-blue-500',
                                        'green' => 'bg-emerald-500',
                                        'pink' => 'bg-pink-500',
                                        'purple' => 'bg-purple-500',
                                        'red' => 'bg-red-500',
                                        'yellow' => 'bg-yellow-400',
                                        'teal' => 'bg-teal-500',
                                        default => 'bg-orange-500',
                                    };
                                    $textColor = match ($ev->color) {
                                        'blue' => 'dark:text-blue-300 text-blue-700',
                                        'green' => 'dark:text-emerald-300 text-emerald-700',
                                        'pink' => 'dark:text-pink-300 text-pink-700',
                                        'purple' => 'dark:text-purple-300 text-purple-700',
                                        'red' => 'dark:text-red-300 text-red-700',
                                        'yellow' => 'dark:text-yellow-300 text-yellow-700',
                                        'teal' => 'dark:text-teal-300 text-teal-700',
                                        default => 'dark:text-orange-300 text-orange-700',
                                    };
                                    $bgColor = match ($ev->color) {
                                        'blue' => 'dark:bg-blue-500/20 bg-blue-50',
                                        'green' => 'dark:bg-emerald-500/20 bg-emerald-50',
                                        'pink' => 'dark:bg-pink-500/20 bg-pink-50',
                                        'purple' => 'dark:bg-purple-500/20 bg-purple-50',
                                        'red' => 'dark:bg-red-500/20 bg-red-50',
                                        'yellow' => 'dark:bg-yellow-500/20 bg-yellow-50',
                                        'teal' => 'dark:bg-teal-500/20 bg-teal-50',
                                        default => 'dark:bg-orange-500/20 bg-orange-50',
                                    };
                                @endphp
                                <div onclick="event.stopPropagation(); openEventModal({{ $ev->id }})"
                                    class="flex items-center gap-1 px-1.5 py-0.5 rounded-md {{ $bgColor }} {{ $textColor }} cursor-pointer hover:opacity-80 transition-opacity">
                                    <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $dotColor }}"></span>
                                    <span class="text-[11px] font-semibold truncate">
                                        @if (!$ev->all_day && $ev->start_time)
                                            {{ \Carbon\Carbon::parse($ev->start_time)->format('g:i') }}
                                        @endif
                                        {{ $ev->title }}
                                    </span>
                                </div>
                            @endforeach

                            @if ($dayEvents->count() > 3)
                                <div class="text-[11px] font-bold dark:text-gray-500 text-gray-400 px-1.5">
                                    +{{ $dayEvents->count() - 3 }} more
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── Upcoming events panel ────────────────────────────────────────── --}}
        @include('user.calendar.partials.upcoming-events', [
            'events' => \App\Models\CalendarEvent::forUser(auth()->id())->where('start_date', '>=', now()->toDateString())->where('status', 'upcoming')->orderBy('start_date')->orderBy('start_time')->limit(8)->get(),
        ])

    </section>

    {{-- ── Modals ──────────────────────────────────────────────────────────── --}}
    @include('user.calendar.partials.event-modal')
    @include('user.calendar.partials.create-modal')

    <script>
        // ── State ────────────────────────────────────────────────────────────────────
        const calendarBaseUrl = '{{ url('user/calendar') }}';
        let editingEventId = null;

        function clearFormErrors() {
            const errorBox = document.getElementById('eventFormError');
            const errorList = document.getElementById('eventFormErrorList');
            if (errorBox) {
                errorBox.classList.add('hidden');
            }
            if (errorList) {
                errorList.innerHTML = '';
            }
        }

        function showFormErrors(errors) {
            const errorBox = document.getElementById('eventFormError');
            const errorList = document.getElementById('eventFormErrorList');
            if (!errorBox || !errorList) return;
            errorList.innerHTML = '';
            Object.values(errors).flat().forEach(message => {
                const li = document.createElement('li');
                li.textContent = message;
                errorList.appendChild(li);
            });
            errorBox.classList.remove('hidden');
        }

        // ── Open create modal (optionally pre-fill date) ─────────────────────────────
        function openCreateModal(date = null) {
            editingEventId = null;
            document.getElementById('modalTitle').textContent = 'Add Event';
            document.getElementById('submitBtn').textContent = 'Create Event';
            document.getElementById('eventForm').reset();
            document.getElementById('ev_color').value = 'orange';
            document.getElementById('ev_priority').value = 'medium';
            document.getElementById('ev_type').value = 'event';
            document.getElementById('ev_all_day').checked = false;
            document.getElementById('timeFields').classList.remove('hidden');
            clearFormErrors();
            if (date) {
                document.getElementById('start_date').value = date;
                document.getElementById('end_date').value = date;
            } else {
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('start_date').value = today;
                document.getElementById('end_date').value = today;
            }
            document.getElementById('createModal').classList.remove('hidden');
        }

        function openCreateModalOnDate(date) {
            openCreateModal(date);
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        // ── Open event detail modal ───────────────────────────────────────────────────
        function openEventModal(id) {
            fetch(`${calendarBaseUrl}/${id}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => {
                    if (!r.ok) {
                        throw new Error('Unable to load event details.');
                    }
                    return r.json();
                })
                .then(ev => {
                    document.getElementById('evTitle').textContent = ev.title;
                    document.getElementById('evType').textContent = ev.type.charAt(0).toUpperCase() + ev.type.slice(1);
                    document.getElementById('evStatus').textContent = ev.status;
                    document.getElementById('evPriority').textContent = ev.priority;
                    document.getElementById('evDate').textContent = formatDate(ev.start_date) + (ev.start_date !== ev
                        .end_date ? ' – ' + formatDate(ev.end_date) : '');
                    document.getElementById('evTime').textContent = ev.all_day ? 'All day' : (formatTime(ev
                        .start_time) + (ev.end_time ? ' – ' + formatTime(ev.end_time) : ''));
                    document.getElementById('evDesc').textContent = ev.description || '—';
                    document.getElementById('evLocation').textContent = ev.location || '—';
                    document.getElementById('editEventBtn').onclick = () => {
                        closeEventModal();
                        openEditModal(ev);
                    };
                    document.getElementById('deleteEventBtn').onclick = () => deleteEvent(id);
                    document.getElementById('eventModal').classList.remove('hidden');
                })
                .catch(() => {
                    alert('Unable to load event details.');
                });
        }

        function closeEventModal() {
            document.getElementById('eventModal').classList.add('hidden');
        }

        // ── Open edit modal ───────────────────────────────────────────────────────────
        function openEditModal(ev) {
            editingEventId = ev.id;
            document.getElementById('modalTitle').textContent = 'Edit Event';
            document.getElementById('submitBtn').textContent = 'Update Event';
            document.getElementById('ev_title').value = ev.title || '';
            document.getElementById('ev_description').value = ev.description || '';
            document.getElementById('ev_location').value = ev.location || '';

            const normalizeDate = (d) => {
                if (!d) return '';
                if (typeof d === 'string') {
                    if (d.includes('T')) return d.split('T')[0];
                    if (d.includes(' ')) return d.split(' ')[0];
                    return d;
                }
                return '';
            };

            const normalizeTime = (t) => {
                if (!t) return '';
                const s = String(t);
                // turn "16:06:00" -> "16:06"
                if (s.length >= 5) return s.slice(0, 5);
                return s;
            };

            document.getElementById('start_date').value = normalizeDate(ev.start_date);
            document.getElementById('end_date').value = normalizeDate(ev.end_date);
            document.getElementById('start_time').value = normalizeTime(ev.start_time);
            document.getElementById('end_time').value = normalizeTime(ev.end_time);

            document.getElementById('ev_type').value = ev.type || 'event';
            document.getElementById('ev_priority').value = ev.priority || 'medium';
            document.getElementById('ev_color').value = ev.color || 'orange';
            document.getElementById('ev_all_day').checked = !!ev.all_day;
            document.getElementById('ev_reminder_enabled').checked = !!ev.reminder_enabled;
            document.getElementById('ev_recurring_type').value = ev.recurring_type || '';
            document.getElementById('ev_recurring_end_date').value = normalizeDate(ev.recurring_end_date || '');
            document.getElementById('ev_reminder_minutes').value = (ev.reminder_minutes !== null && ev.reminder_minutes !==
                undefined) ? ev.reminder_minutes : '';
            document.getElementById('timeFields').classList.toggle('hidden', !!ev.all_day);
            clearFormErrors();
            document.getElementById('createModal').classList.remove('hidden');
        }

        // ── Submit form ───────────────────────────────────────────────────────────────
        function submitEventForm(e) {
            e.preventDefault();
            const form = e.target;
            const data = new FormData(form);
            const url = editingEventId ? `${calendarBaseUrl}/${editingEventId}` : calendarBaseUrl;
            const token = form.querySelector('input[name="_token"]')?.value || document.querySelector(
                'meta[name="csrf-token"]')?.content;

            if (!token) {
                alert('CSRF token missing. Refresh the page and try again.');
                return;
            }

            if (!form.querySelector('input[name="_token"]')) {
                data.append('_token', token);
            }
            if (editingEventId) {
                data.append('_method', 'PUT');
            }

            clearFormErrors();

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: data
                })
                .then(async response => {
                    const json = await response.json();

                    if (response.ok && json.success) {
                        closeCreateModal();
                        location.reload();
                        return;
                    }

                    if (json.errors) {
                        showFormErrors(json.errors);
                        return;
                    }

                    alert(json.message || 'Unable to save the event.');
                })
                .catch(() => {
                    alert('Network error while saving event.');
                });
        }

        document.getElementById('eventForm')?.addEventListener('submit', submitEventForm);

        // ── Delete ────────────────────────────────────────────────────────────────────
        function deleteEvent(id) {
            if (!confirm('Delete this event?')) return;
            const token = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

            fetch(`${calendarBaseUrl}/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Unable to delete event.');
                }
            }).catch(() => {
                alert('Network error while deleting event.');
            });
        }

        // ── Helpers ───────────────────────────────────────────────────────────────────
        function formatDate(d) {
            if (!d) return '—';
            return new Date(d + 'T00:00:00').toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        }

        function formatTime(t) {
            if (!t) return '';
            const [h, m] = t.split(':');
            const hour = parseInt(h);
            return `${hour > 12 ? hour-12 : (hour || 12)}:${m} ${hour >= 12 ? 'PM' : 'AM'}`;
        }

        function capitalize(s) {
            return s ? s.charAt(0).toUpperCase() + s.slice(1) : '';
        }

        // ── All-day toggle ────────────────────────────────────────────────────────────
        document.getElementById('ev_all_day')?.addEventListener('change', function() {
            const timeFields = document.getElementById('timeFields');
            timeFields.classList.toggle('hidden', this.checked);
        });
    </script>
@endsection
