<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskReminderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Task $task)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'title' => 'Task Reminder',
            'message' => 'Reminder for task: ' . $this->task->title,
            'task_title' => $this->task->title,
            'priority' => $this->task->priority,
            'status' => $this->task->status,
            'due_date' => $this->task->due_date?->format('Y-m-d'),
            'remind_at' => $this->task->remind_at?->format('Y-m-d H:i:s'),
            'url' => route('user.tasks.show', $this->task),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}