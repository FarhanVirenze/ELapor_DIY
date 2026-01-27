<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;

class NewCommentNotification extends Notification
{
    use Queueable;

    public $report;
    public $comment;
    public $commenter;

    public function __construct($report, $comment, $commenter)
    {
        $this->report = $report;
        $this->comment = $comment;
        $this->commenter = $commenter;
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

        $name = ($notifiable->id_user === $this->commenter->id_user) ? 'Anda' : $this->commenter->name;

        return [
            'report_id' => $this->report->id,
            'tracking_id' => $this->report->tracking_id,
            'title' => 'Komentar Baru pada Aduan',
            'message' => "{$name} mengomentari aduan ({$this->report->tracking_id}): " . mb_substr($this->comment->pesan, 0, 50) . "...",
            'url' => $url,
        ];
    }
}
