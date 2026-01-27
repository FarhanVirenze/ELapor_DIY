<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;

class NewFollowUpNotification extends Notification
{
    use Queueable;

    public $report;
    public $followUp;
    public $admin;

    public function __construct($report, $followUp, $admin)
    {
        $this->report = $report;
        $this->followUp = $followUp;
        $this->admin = $admin;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $role = $notifiable->role;
        $url = route('reports.show', $this->report->id); // default portal

        if ($role === 'admin') {
            $url = route('admin.reports.show', $this->report->id);
        } elseif ($role === 'superadmin') {
            $url = route('superadmin.reports.show', $this->report->id);
        }

        $name = ($notifiable->id_user === $this->admin->id_user) ? 'Anda' : $this->admin->name;

        return [
            'report_id' => $this->report->id,
            'tracking_id' => $this->report->tracking_id,
            'title' => 'Tindak Lanjut Baru',
            'message' => "{$name} memberikan tindak lanjut pada aduan ({$this->report->tracking_id}).",
            'url' => $url,
        ];
    }
}
