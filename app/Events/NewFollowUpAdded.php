<?php

namespace App\Events;

use App\Models\FollowUp;
use App\Models\Report;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewFollowUpAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Report $report;
    public FollowUp $followUp;

    public function __construct(Report $report, FollowUp $followUp)
    {
        $this->report = $report;
        $this->followUp = $followUp;
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
            'followup_id' => $this->followUp->id,
            'message' => "Tindak lanjut baru untuk laporan \"{$this->report->judul}\"",
            'url' => route('reports.show', $this->report->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'followup.added';
    }
}
