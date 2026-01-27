<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;

class ReportStatusChanged extends Notification
{
    use Queueable;

    public $report;
    public $oldStatus;
    public $newStatus;

    public function __construct($report, $oldStatus, $newStatus)
    {
        $this->report = $report;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $role = $notifiable->role;
        $url = '#';

        if ($role === 'user') {
            $url = route('reports.show', $this->report->id);
        } elseif ($role === 'admin') {
            $url = route('admin.reports.show', $this->report->id);
        } elseif ($role === 'superadmin') {
            $url = route('superadmin.reports.show', $this->report->id);
        }

        return [
            'report_id' => $this->report->id,
            'tracking_id' => $this->report->tracking_id,
            'title' => 'Status Aduan Berubah',
            'message' => "Status aduan dengan ID {$this->report->tracking_id} telah berubah dari {$this->oldStatus} menjadi {$this->newStatus}.",
            'url' => $url,
        ];
    }
}
