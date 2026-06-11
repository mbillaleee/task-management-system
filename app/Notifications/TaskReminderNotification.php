<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskReminderNotification extends Notification
{
    use Queueable;

    public function __construct(public Task $task) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'       => 'task_reminder',
            'title'      => 'Task Reminder',
            'message'    => 'Reminder for task: ' . $this->task->title,
            'task_id'    => $this->task->id,
            'task_title' => $this->task->title,
            'priority'   => $this->task->priority,
            'status'     => $this->task->status,
            'due_date'   => $this->task->due_date?->format('Y-m-d'),
            'remind_at'  => $this->task->remind_at?->format('Y-m-d H:i:s'),
            'icon'       => '✅',
            'url'        => route('user.tasks.show', $this->task),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
