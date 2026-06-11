<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CalendarEvent extends Model
{
    protected $guarded = [];

    protected $casts = [
        'start_date'         => 'date',
        'end_date'           => 'date',
        'recurring_end_date' => 'date',
        'all_day'            => 'boolean',
        'is_recurring'       => 'boolean',
        'reminder_enabled'   => 'boolean',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeInMonth($query, $year, $month)
    {
        return $query->where(function ($q) use ($year, $month) {
            $start = Carbon::create($year, $month, 1)->startOfMonth();
            $end   = Carbon::create($year, $month, 1)->endOfMonth();
            $q->whereBetween('start_date', [$start, $end])
              ->orWhereBetween('end_date', [$start, $end]);
        });
    }

    public function scopeInWeek($query, $startOfWeek, $endOfWeek)
    {
        return $query->where(function ($q) use ($startOfWeek, $endOfWeek) {
            $q->whereBetween('start_date', [$startOfWeek, $endOfWeek])
              ->orWhereBetween('end_date', [$startOfWeek, $endOfWeek]);
        });
    }

    public function scopeOnDate($query, $date)
    {
        return $query->whereDate('start_date', $date);
    }

    // ─── Accessors ────────────────────────────────────────────────────────────
    public function getColorClassAttribute(): string
    {
        return match($this->color) {
            'blue'   => 'bg-blue-500',
            'green'  => 'bg-emerald-500',
            'pink'   => 'bg-pink-500',
            'purple' => 'bg-purple-500',
            'red'    => 'bg-red-500',
            'yellow' => 'bg-yellow-500',
            'teal'   => 'bg-teal-500',
            default  => 'bg-orange-500',
        };
    }

    public function getColorBgLightAttribute(): string
    {
        return match($this->color) {
            'blue'   => 'dark:bg-blue-500/20 bg-blue-50 dark:text-blue-300 text-blue-700',
            'green'  => 'dark:bg-emerald-500/20 bg-emerald-50 dark:text-emerald-300 text-emerald-700',
            'pink'   => 'dark:bg-pink-500/20 bg-pink-50 dark:text-pink-300 text-pink-700',
            'purple' => 'dark:bg-purple-500/20 bg-purple-50 dark:text-purple-300 text-purple-700',
            'red'    => 'dark:bg-red-500/20 bg-red-50 dark:text-red-300 text-red-700',
            'yellow' => 'dark:bg-yellow-500/20 bg-yellow-50 dark:text-yellow-300 text-yellow-700',
            'teal'   => 'dark:bg-teal-500/20 bg-teal-50 dark:text-teal-300 text-teal-700',
            default  => 'dark:bg-orange-500/20 bg-orange-50 dark:text-orange-300 text-orange-700',
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'reminder' => 'fa-bell',
            'block'    => 'fa-ban',
            'meeting'  => 'fa-users',
            'personal' => 'fa-user',
            'task'     => 'fa-check-square',
            default    => 'fa-calendar',
        };
    }

    public function getFormattedTimeAttribute(): string
    {
        if ($this->all_day) return 'All day';
        $start = $this->start_time ? Carbon::parse($this->start_time)->format('g:i A') : '';
        $end   = $this->end_time   ? Carbon::parse($this->end_time)->format('g:i A')   : '';
        return $start && $end ? "{$start} – {$end}" : $start;
    }

    public function getIsMultiDayAttribute(): bool
    {
        return $this->start_date->ne($this->end_date);
    }
}