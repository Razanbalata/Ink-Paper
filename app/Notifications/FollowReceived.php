<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class FollowReceived extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $user
    ) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * Used for the database notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'follow',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'message' => $this->user->name.' started following you.',
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        \Log::info('FOLLOW BROADCAST TRIGGERED', [
            'notifiable' => $notifiable->id,
            'follower' => $this->user->id,
        ]);

        return new BroadcastMessage([
            'type' => 'follow',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'message' => $this->user->name.' started following you.',
        ]);
    }
}
