<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DeadlineWarningNotification extends Notification
{
    use Queueable;

    public function __construct(public Task $task, public string $urgency = 'today') {}
    // urgency: 'overdue' | 'today' | 'tomorrow'

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $labels = [
            'overdue'  => ['title' => '⚠️ Task Overdue',    'icon' => '⚠️', 'msg' => 'This task is overdue: '],
            'today'    => ['title' => '📅 Due Today',        'icon' => '📅', 'msg' => 'Task due today: '],
            'tomorrow' => ['title' => '🔔 Due Tomorrow',     'icon' => '🔔', 'msg' => 'Task due tomorrow: '],
        ];

        $l = $labels[$this->urgency] ?? $labels['today'];

        return [
            'type'       => 'deadline_warning',
            'title'      => $l['title'],
            'message'    => $l['msg'] . $this->task->title,
            'task_id'    => $this->task->id,
            'task_title' => $this->task->title,
            'due_date'   => $this->task->due_date?->format('Y-m-d'),
            'priority'   => $this->task->priority,
            'urgency'    => $this->urgency,
            'icon'       => $l['icon'],
            'url'        => route('user.tasks.show', $this->task),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
