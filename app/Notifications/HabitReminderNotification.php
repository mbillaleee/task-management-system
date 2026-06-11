<?php

namespace App\Notifications;

use App\Models\Habit;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class HabitReminderNotification extends Notification
{
    use Queueable;

    public function __construct(public Habit $habit) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'        => 'habit_reminder',
            'title'       => 'Habit Reminder',
            'message'     => 'Don\'t forget your habit: ' . $this->habit->title,
            'habit_id'    => $this->habit->id,
            'habit_title' => $this->habit->title,
            'frequency'   => $this->habit->frequency,
            'icon'        => '🔥',
            'url'         => route('user.habits.show', $this->habit),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
