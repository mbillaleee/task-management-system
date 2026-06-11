<?php

namespace App\Console\Commands;

use App\Models\Goal;
use App\Models\Habit;
use App\Models\Task;
use App\Models\User;
use App\Notifications\DeadlineWarningNotification;
use App\Notifications\GoalReminderNotification;
use App\Notifications\HabitReminderNotification;
use App\Notifications\TaskReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/*
|══════════════════════════════════════════════════════════════
|  Laravel 12 — No Kernel.php registration needed.
|  Commands in app/Console/Commands/ are auto-discovered.
|  Schedule calls live in routes/console.php.
|══════════════════════════════════════════════════════════════
*/

class SendAllReminders extends Command
{
    protected $signature = 'veroa:send-reminders
                            {--type=all : Which reminders to send (task|deadline|habit|goal|all)}';

    protected $description = 'Send Veroa push/reminder notifications to users (Laravel 12)';

    public function handle(): int
    {
        $type = $this->option('type');

        if (in_array($type, ['task',     'all'])) $this->sendTaskReminders();
        if (in_array($type, ['deadline', 'all'])) $this->sendDeadlineWarnings();
        if (in_array($type, ['habit',    'all'])) $this->sendHabitReminders();
        if (in_array($type, ['goal',     'all'])) $this->sendGoalReminders();

        return self::SUCCESS;
    }

    /* ──────────────────────────────────────────────────────────
     |  1. TASK REMINDERS
     |     remind_at <= now() AND reminder_sent_at IS NULL
     ────────────────────────────────────────────────────────── */
    private function sendTaskReminders(): void
    {
        $tasks = Task::with('user')
            ->where('reminder_enabled', true)
            ->whereNotNull('remind_at')
            ->whereNull('reminder_sent_at')
            ->where('remind_at', '<=', now())
            ->whereIn('status', ['pending', 'in_progress'])
            ->get();

        $sent = 0;
        foreach ($tasks as $task) {
            if (! $task->user) continue;

            // Respect user notification preference
            if (! ($task->user->notif_task_reminders ?? true)) continue;

            try {
                $task->user->notify(new TaskReminderNotification($task));
                $task->update(['reminder_sent_at' => now()]);
                $sent++;
            } catch (\Throwable $e) {
                Log::warning("[Veroa] Task reminder failed for task #{$task->id}: " . $e->getMessage());
            }
        }

        $this->info("✅ Task reminders sent: {$sent}");
    }

    /* ──────────────────────────────────────────────────────────
     |  2. DEADLINE WARNINGS
     |     overdue / due today / due tomorrow
     |     Deduplicated per task per day via notifications table
     ────────────────────────────────────────────────────────── */
    private function sendDeadlineWarnings(): void
    {
        $today    = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $sent     = 0;

        $tasks = Task::with('user')
            ->whereNotNull('due_date')
            ->whereIn('status', ['pending', 'in_progress'])
            ->where(function ($q) use ($today, $tomorrow) {
                $q->whereDate('due_date', '<',    $today)    // overdue
                  ->orWhereDate('due_date', '=',  $today)    // today
                  ->orWhereDate('due_date', '=',  $tomorrow); // tomorrow
            })
            ->get();

        foreach ($tasks as $task) {
            if (! $task->user) continue;
            if (! ($task->user->notif_task_reminders ?? true)) continue;

            // Avoid duplicate per day per task
            $alreadySent = DB::table('notifications')
                ->where('notifiable_id',   $task->user_id)
                ->where('notifiable_type', get_class($task->user))
                ->whereDate('created_at', $today)
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.task_id')) = ?", [$task->id])
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.type')) = 'deadline_warning'")
                ->exists();

            if ($alreadySent) continue;

            $urgency = match (true) {
                Carbon::parse($task->due_date)->lt($today)    => 'overdue',
                Carbon::parse($task->due_date)->isToday()     => 'today',
                default                                        => 'tomorrow',
            };

            try {
                $task->user->notify(new DeadlineWarningNotification($task, $urgency));
                $sent++;
            } catch (\Throwable $e) {
                Log::warning("[Veroa] Deadline warning failed for task #{$task->id}: " . $e->getMessage());
            }
        }

        $this->info("⚠️  Deadline warnings sent: {$sent}");
    }

    /* ──────────────────────────────────────────────────────────
     |  3. HABIT REMINDERS
     |     Checks 5-minute window around habit's remind_time.
     |     Deduplicates per habit per day.
     ────────────────────────────────────────────────────────── */
    private function sendHabitReminders(): void
    {
        $now   = Carbon::now();
        $today = strtolower($now->format('D')); // mon, tue, wed…
        $sent  = 0;

        $habits = Habit::with('user')
            ->where('reminder_enabled', true)
            ->whereNotNull('remind_time')
            ->where('status', true)
            ->get();

        foreach ($habits as $habit) {
            if (! $habit->user) continue;
            if (! ($habit->user->notif_habit_reminders ?? true)) continue;

            // Parse remind_time into a Carbon datetime for today
            try {
                $remindAt = Carbon::today()->setTimeFromTimeString($habit->remind_time);
            } catch (\Throwable) {
                continue;
            }

            // Only fire within a 5-minute window
            if ($now->lt($remindAt) || $now->gt($remindAt->copy()->addMinutes(5))) continue;

            // Weekly habits — check day matches
            if ($habit->frequency === 'weekly' && is_array($habit->days)) {
                if (! in_array($today, $habit->days)) continue;
            }

            // Deduplicate per habit per day
            $alreadySent = DB::table('notifications')
                ->where('notifiable_id',   $habit->user_id)
                ->where('notifiable_type', get_class($habit->user))
                ->whereDate('created_at', Carbon::today())
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.habit_id')) = ?", [$habit->id])
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.type')) = 'habit_reminder'")
                ->exists();

            if ($alreadySent) continue;

            try {
                $habit->user->notify(new HabitReminderNotification($habit));
                $sent++;
            } catch (\Throwable $e) {
                Log::warning("[Veroa] Habit reminder failed for habit #{$habit->id}: " . $e->getMessage());
            }
        }

        $this->info("🔥 Habit reminders sent: {$sent}");
    }

    /* ──────────────────────────────────────────────────────────
     |  4. GOAL REMINDERS
     |     Deadline within next 3 days.
     |     Deduplicates per goal per day.
     ────────────────────────────────────────────────────────── */
    private function sendGoalReminders(): void
    {
        $sent = 0;

        $goals = Goal::with('user')
            ->whereNotNull('deadline')
            ->where('status', '!=', 'completed')
            ->whereBetween('deadline', [now(), now()->addDays(3)])
            ->get();

        foreach ($goals as $goal) {
            if (! $goal->user) continue;
            if (! ($goal->user->notif_goal_updates ?? true)) continue;

            $alreadySent = DB::table('notifications')
                ->where('notifiable_id',   $goal->user_id)
                ->where('notifiable_type', get_class($goal->user))
                ->whereDate('created_at', Carbon::today())
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.goal_id')) = ?", [$goal->id])
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.type')) = 'goal_deadline'")
                ->exists();

            if ($alreadySent) continue;

            try {
                $goal->user->notify(new GoalReminderNotification($goal, 'deadline'));
                $sent++;
            } catch (\Throwable $e) {
                Log::warning("[Veroa] Goal reminder failed for goal #{$goal->id}: " . $e->getMessage());
            }
        }

        $this->info("🏆 Goal reminders sent: {$sent}");
    }
}
