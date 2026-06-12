<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    // ─── Monthly Calendar View (default) ─────────────────────────────────────
    public function index(Request $request)
    {
        $year = (int) $request->query('year', date('Y'));
        $month = (int) $request->query('month', date('m'));

        if ($year < 2000 || $year > 2100) {
            $year = (int) date('Y');
        }

        if ($month < 1 || $month > 12) {
            $month = (int) date('m');
        }

        $currentMonth = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $prevMonth = $currentMonth->copy()->subMonth();
        $nextMonth = $currentMonth->copy()->addMonth();

        $events = CalendarEvent::forUser(auth()->id())
            ->inMonth($year, $month)
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($event) {
                return optional($event->start_date)->format('Y-m-d');
            });

        $startOfGrid = $currentMonth->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $endOfGrid = $currentMonth->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        $calendarDays = [];
        $day = $startOfGrid->copy();

        while ($day->lte($endOfGrid)) {
            $calendarDays[] = $day->copy();
            $day->addDay();
        }

        $stats = $this->getMonthStats($year, $month);

        return view('user.calendar.index', compact(
            'year',
            'month',
            'currentMonth',
            'prevMonth',
            'nextMonth',
            'events',
            'calendarDays',
            'stats'
        ));
    }
 
    // ─── Weekly View ──────────────────────────────────────────────────────────
    public function week(Request $request)
    {
        $date        = Carbon::parse($request->get('date', now()->toDateString()));
        $startOfWeek = $date->copy()->startOfWeek(Carbon::SUNDAY);
        $endOfWeek   = $startOfWeek->copy()->addDays(6);

        $weekDays = [];
        for ($i = 0; $i < 7; $i++) {
            $weekDays[] = $startOfWeek->copy()->addDays($i);
        }

        $events = CalendarEvent::forUser(auth()->id())
            ->inWeek($startOfWeek, $endOfWeek)
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn($e) => $e->start_date->format('Y-m-d'));

        // Time slots: 12am → 11pm (24 hours)
        $timeSlots = [];
        for ($h = 0; $h <= 23; $h++) {
            $timeSlots[] = Carbon::createFromTime($h, 0)->format('g:i A');
        }

        $prevWeek = $startOfWeek->copy()->subWeek();
        $nextWeek = $startOfWeek->copy()->addWeek();

        return view('user.calendar.week', compact(
            'date',
            'startOfWeek',
            'endOfWeek',
            'weekDays',
            'events',
            'timeSlots',
            'prevWeek',
            'nextWeek'
        ));
    }

    // ─── Daily View ───────────────────────────────────────────────────────────
    public function day(Request $request)
    {
        $date     = Carbon::parse($request->get('date', now()->toDateString()));
        $prevDay  = $date->copy()->subDay();
        $nextDay  = $date->copy()->addDay();

        $events = CalendarEvent::forUser(auth()->id())
            ->onDate($date->toDateString())
            ->orderBy('start_time')
            ->get();

        $allDayEvents = $events->where('all_day', true);
        $timedEvents  = $events->where('all_day', false);

        // Hour slots 0–23
        $hours = range(0, 23);

        return view('user.calendar.day', compact(
            'date', 'prevDay', 'nextDay',
            'events', 'allDayEvents', 'timedEvents', 'hours'
        ));
    }

    // ─── Timeline View ────────────────────────────────────────────────────────
    public function timeline(Request $request)
    {
        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year',  now()->year);

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate   = $startDate->copy()->endOfMonth();

        $events = CalendarEvent::forUser(auth()->id())
            ->inMonth($year, $month)
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();

        $groupedByDate = $events->groupBy(fn($e) => $e->start_date->format('Y-m-d'));

        // Build timeline days (only days that have events OR current/future days)
        $timelineDays = [];
        $day = $startDate->copy();
        while ($day->lte($endDate)) {
            $key = $day->format('Y-m-d');
            $timelineDays[$key] = [
                'date'   => $day->copy(),
                'events' => $groupedByDate->get($key, collect()),
            ];
            $day->addDay();
        }

        $prevMonth = $startDate->copy()->subMonth();
        $nextMonth = $startDate->copy()->addMonth();

        return view('user.calendar.timeline', compact(
            'year', 'month', 'startDate', 'endDate',
            'events', 'timelineDays', 'prevMonth', 'nextMonth'
        ));
    }

    // ─── CRUD ─────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'location'           => 'nullable|string|max:255',
            'start_date'         => 'required|date',
            'start_time'         => 'nullable|date_format:H:i',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'end_time'           => 'nullable|date_format:H:i',
            'all_day'            => 'boolean',
            'type'               => 'required|in:event,reminder,block,meeting,personal,task',
            'priority'           => 'required|in:low,medium,high',
            'color'              => 'required|string',
            'is_recurring'       => 'boolean',
            'recurring_type'     => 'nullable|in:daily,weekly,monthly,yearly',
            'recurring_end_date' => 'nullable|date',
            'reminder_enabled'   => 'boolean',
            'reminder_minutes'   => 'nullable|integer|min:0',
        ]);

        $validated['user_id']         = auth()->id();
        $validated['all_day']         = $request->boolean('all_day');
        $validated['is_recurring']    = $request->boolean('is_recurring');
        $validated['reminder_enabled'] = $request->boolean('reminder_enabled');

        if (! $validated['reminder_enabled']) {
            $validated['reminder_minutes'] = 0;
        } elseif (is_null($validated['reminder_minutes'])) {
            $validated['reminder_minutes'] = 15;
        }

        CalendarEvent::create($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Event created.']);
        }

        return back()->with('success', 'Event created successfully.');
    }

    public function show(CalendarEvent $calendarEvent)
    {
        $this->authorize_owner($calendarEvent);
        return response()->json($calendarEvent);
    }

    public function update(Request $request, CalendarEvent $calendarEvent)
    {
        $this->authorize_owner($calendarEvent);

        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'location'           => 'nullable|string|max:255',
            'start_date'         => 'required|date',
            'start_time'         => 'nullable|date_format:H:i',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'end_time'           => 'nullable|date_format:H:i',
            'all_day'            => 'boolean',
            'type'               => 'required|in:event,reminder,block,meeting,personal,task',
            'priority'           => 'required|in:low,medium,high',
            'color'              => 'required|string',
            'is_recurring'       => 'boolean',
            'recurring_type'     => 'nullable|in:daily,weekly,monthly,yearly',
            'recurring_end_date' => 'nullable|date',
            'reminder_enabled'   => 'boolean',
            'reminder_minutes'   => 'nullable|integer|min:0',
            'status'             => 'nullable|in:upcoming,completed,cancelled',
        ]);

        $validated['all_day']          = $request->boolean('all_day');
        $validated['is_recurring']     = $request->boolean('is_recurring');
        $validated['reminder_enabled'] = $request->boolean('reminder_enabled');

        if (! $validated['reminder_enabled']) {
            $validated['reminder_minutes'] = 0;
        } elseif (is_null($validated['reminder_minutes'])) {
            $validated['reminder_minutes'] = 15;
        }

        $calendarEvent->update($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Event updated.', 'event' => $calendarEvent->fresh()]);
        }

        return back()->with('success', 'Event updated successfully.');
    }

    public function destroy(CalendarEvent $calendarEvent)
    {
        $this->authorize_owner($calendarEvent);
        $calendarEvent->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Event deleted.']);
        }

        return back()->with('success', 'Event deleted.');
    }

    public function updateStatus(Request $request, CalendarEvent $calendarEvent)
    {
        $this->authorize_owner($calendarEvent);
        $request->validate(['status' => 'required|in:upcoming,completed,cancelled']);
        $calendarEvent->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    // ─── AJAX: events for a date range (used by JS calendar) ─────────────────
    public function events(Request $request)
    {
        $start = Carbon::parse($request->get('start', now()->startOfMonth()));
        $end   = Carbon::parse($request->get('end',   now()->endOfMonth()));

        $events = CalendarEvent::forUser(auth()->id())
            ->whereBetween('start_date', [$start->toDateString(), $end->toDateString()])
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get()
            ->map(fn($e) => [
                'id'          => $e->id,
                'title'       => $e->title,
                'start_date'  => $e->start_date->format('Y-m-d'),
                'start_time'  => $e->start_time,
                'end_date'    => $e->end_date->format('Y-m-d'),
                'end_time'    => $e->end_time,
                'all_day'     => $e->all_day,
                'type'        => $e->type,
                'color'       => $e->color,
                'color_class' => $e->color_class,
                'status'      => $e->status,
                'priority'    => $e->priority,
                'description' => $e->description,
                'location'    => $e->location,
                'time_label'  => $e->formatted_time,
            ]);

        return response()->json($events);
    }

    // ─── Private helpers ──────────────────────────────────────────────────────
    private function authorize_owner(CalendarEvent $event): void
    {
        abort_if($event->user_id !== auth()->id(), 403);
    }

    private function getMonthStats(int $year, int $month): array
    {
        $base = CalendarEvent::forUser(auth()->id())->inMonth($year, $month);

        return [
            'total'     => (clone $base)->count(),
            'upcoming'  => (clone $base)->where('status', 'upcoming')->count(),
            'completed' => (clone $base)->where('status', 'completed')->count(),
            'today'     => CalendarEvent::forUser(auth()->id())
                ->onDate(now()->toDateString())->count(),
        ];
    }
}