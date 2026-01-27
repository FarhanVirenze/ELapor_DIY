<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportSubmittedSuccessfully extends Notification
{
    use Queueable;

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
            'title' => 'Aduan Berhasil Dikirim',
            'message' => 'Laporan Anda dengan Nomor Tiket ' . $this->report->tracking_id . ' telah berhasil dikirim dan sedang menunggu moderasi/pembacaan oleh admin.',
            'url' => route('reports.show', $this->report->id),
        ];
    }
}
