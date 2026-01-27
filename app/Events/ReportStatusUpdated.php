<?php

namespace App\Events;

use App\Models\Report;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Report $report;
    public string $oldStatus;
    public string $newStatus;

    public function __construct(Report $report, string $oldStatus, string $newStatus)
    {
        $this->report = $report;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        $channels = [];

        // Broadcast ke user pemilik laporan
        if ($this->report->user_id) {
            $channels[] = new PrivateChannel('user.' . $this->report->user_id);
        }

        return $channels;
    }

    /**
     * Data yang dikirim ke frontend
     */
    public function broadcastWith(): array
    {
        return [
            'report_id' => $this->report->id,
            'tracking_id' => $this->report->tracking_id,
            'judul' => $this->report->judul,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "Laporan \"{$this->report->judul}\" telah diupdate menjadi {$this->newStatus}",
            'url' => route('reports.show', $this->report->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'report.status.updated';
    }
}
