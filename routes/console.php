<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


/*
|──────────────────────────────────────────────────────────────────
|  1. TASK REMINDERS
|     Fires when a task's remind_at <= now() and
|     reminder_sent_at is still null.
|     Run every 5 minutes — covers all users.
|──────────────────────────────────────────────────────────────────
*/
Schedule::command('veroa:send-reminders --type=task')
    ->everyFiveMinutes()
    ->withoutOverlapping()
    ->runInBackground()
    ->name('task-reminders')
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::error('[Veroa] veroa:send-reminders --type=task failed.');
    });


/*
|──────────────────────────────────────────────────────────────────
|  2. DEADLINE WARNINGS
|     Sends alerts for tasks that are:
|       - overdue (due_date < today)
|       - due today
|       - due tomorrow
|     Runs once per day at 08:00 AM server time.
|──────────────────────────────────────────────────────────────────
*/
Schedule::command('veroa:send-reminders --type=deadline')
    ->dailyAt('08:00')
    ->withoutOverlapping()
    ->name('deadline-warnings')
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::error('[Veroa] veroa:send-reminders --type=deadline failed.');
    });


/*
|──────────────────────────────────────────────────────────────────
|  3. HABIT REMINDERS
|     Each habit has a remind_time (e.g. "08:30").
|     Command checks a 5-minute window around remind_time
|     and sends only once per habit per day.
|     Runs every minute — the command itself gates per-window.
|──────────────────────────────────────────────────────────────────
*/
Schedule::command('veroa:send-reminders --type=habit')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground()
    ->name('habit-reminders')
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::error('[Veroa] veroa:send-reminders --type=habit failed.');
    });


/*
|──────────────────────────────────────────────────────────────────
|  4. GOAL REMINDERS
|     Sends a reminder when a goal's deadline is
|     within the next 3 days. Once per goal per day.
|     Runs once per day at 09:00 AM.
|──────────────────────────────────────────────────────────────────
*/
Schedule::command('veroa:send-reminders --type=goal')
    ->dailyAt('09:00')
    ->withoutOverlapping()
    ->name('goal-reminders')
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::error('[Veroa] veroa:send-reminders --type=goal failed.');
    });
