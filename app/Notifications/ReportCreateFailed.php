<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportCreateFailed extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $reason;

    public function __construct($reason)
    {
        $this->reason = $reason;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Gagal Mengirim Aduan',
            'message' => 'Laporan Anda gagal diproses: ' . $this->reason,
            'url' => route('user.aduan.index'), // Sesuaikan route create aduan user
        ];
    }
}
