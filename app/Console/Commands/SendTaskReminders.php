<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\TaskHistory;
use App\Notifications\TaskReminderNotification;
use Illuminate\Console\Command;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-task-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send due task reminders to users';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $tasks = Task::with('user')
            ->where('reminder_enabled', true)
            ->whereNotNull('remind_at')
            ->whereNull('reminder_sent_at')
            ->where('remind_at', '<=', now())
            ->whereIn('status', ['pending', 'in_progress'])
            ->get();

        foreach ($tasks as $task) {

            if (! $task->user) {
                continue;
            }

            // Send notification
            $task->user->notify(
                new TaskReminderNotification($task)
            );

            // Update reminder sent time
            $task->update([
                'reminder_sent_at' => now(),
            ]);

            // Save history
            TaskHistory::create([
                'task_id' => $task->id,
                'user_id' => $task->user_id,
                'action' => 'Reminder Sent',
                'changes' => 'Reminder notification sent at ' . now()->format('d M Y, h:i A'),
            ]);
        }

        $this->info($tasks->count() . ' task reminder(s) sent.');

        return Command::SUCCESS;
    }
}