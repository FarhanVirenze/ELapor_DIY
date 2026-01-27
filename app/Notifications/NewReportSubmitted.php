<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReportSubmitted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $report;

    public function __construct($report)
    {
        $this->report = $report;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'report_id' => $this->report->id,
            'tracking_id' => $this->report->tracking_id,
            'title' => 'Aduan Baru Masuk',
            'message' => 'Aduan baru dari ' . ($this->report->is_anonim ? 'Anonim' : $this->report->nama_pengadu),
            'url' => route(
                $notifiable->role === 'superadmin' ? 'superadmin.reports.show' : 'admin.reports.show',
                $this->report->id
            ),
        ];
    }
}
