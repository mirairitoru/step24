<?php

namespace App\Notifications;

use App\Models\Animal;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MatchNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $user,
        public Animal $animal
    ){}

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
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [
            'type' => 'match',
            'title' => 'マッチ成立',
            'message' => "{$this->user->nickname}さんと「{$this->animal->animal_name}」のマッチが成立しました。",
            'animal_id' => $this->animal->id,
            'animal_name' => $this->animal->animal_name,
            'user_id' => $this->user->id,
            'url' => route('org.match.index'),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
