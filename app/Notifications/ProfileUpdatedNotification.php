<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileUpdatedNotification extends Notification
{
    use Queueable;

    protected $changes;

    public function __construct($changes = [])
    {
        $this->changes = $changes;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $message = "Profil Anda telah berhasil diperbarui.";
        if (!empty($this->changes)) {
            $message .= " Perubahan pada: " . implode(', ', $this->changes);
        }

        return [
            'title' => 'Profil Diperbarui',
            'message' => $message,
            'url' => route('user.profile.edit'),
        ];
    }
}
