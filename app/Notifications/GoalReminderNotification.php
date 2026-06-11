<?php

namespace App\Notifications;

use App\Models\Goal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GoalReminderNotification extends Notification
{
    use Queueable;

    public function __construct(public Goal $goal, public string $type = 'deadline') {}
    // type: 'deadline' | 'milestone'

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        if ($this->type === 'milestone') {
            return [
                'type'       => 'goal_milestone',
                'title'      => '🎯 Goal Milestone',
                'message'    => 'You have a milestone due for: ' . $this->goal->title,
                'goal_id'    => $this->goal->id,
                'goal_title' => $this->goal->title,
                'icon'       => '🎯',
                'url'        => route('user.goals.show', $this->goal),
            ];
        }

        return [
            'type'       => 'goal_deadline',
            'title'      => '🏆 Goal Deadline',
            'message'    => 'Goal deadline approaching: ' . $this->goal->title,
            'goal_id'    => $this->goal->id,
            'goal_title' => $this->goal->title,
            'deadline'   => $this->goal->deadline?->format('Y-m-d'),
            'icon'       => '🏆',
            'url'        => route('user.goals.show', $this->goal),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
