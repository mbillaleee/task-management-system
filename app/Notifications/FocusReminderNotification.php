<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FocusReminderNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $message = 'Time to start your focus session!',
        public string $type = 'focus_reminder'
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'    => $this->type,
            'title'   => 'Focus Reminder',
            'message' => $this->message,
            'icon'    => '⏱️',
            'url'     => route('user.focus.index'),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
