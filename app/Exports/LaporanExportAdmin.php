<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanExportAdmin implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    private $counter = 1;
    protected $reports;

    public function __construct($reports)
    {
        $this->reports = $reports;
    }

    public function collection()
    {
        return $this->reports;
    }

    public function map($report): array
    {
        return [
            $this->counter++,
            $report->tracking_id,
            $report->judul,
            $report->isi,
            $report->is_anonim ? 'Anonim' : ($report->user->name ?? $report->nama_pengadu ?? '-'),
            $report->is_anonim ? '-' : ($report->user->email ?? $report->email_pengadu ?? '-'),
            $report->is_anonim ? '-' : ($report->telepon_pengadu ?? '-'),
            $report->is_anonim ? '-' : ($report->nik ?? '-'),
            $report->kategori->nama ?? '-',
            $report->wilayah->nama ?? '-',
            $report->status,
            $report->effective_priority,
            $report->sla_status,
            $report->longitude ?? '-',
            $report->latitude ?? '-',
            $report->lokasi ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Tracking',
            'Judul',
            'Isi Aduan',
            'Pelapor',
            'Email',
            'Telepon',
            'NIK',
            'Kategori',
            'Wilayah',
            'Status',
            'Urgensi',
            'SLA',
            'Longitude',
            'Latitude',
            'Lokasi',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 50,
            'D' => 60,
            'E' => 20,
            'F' => 25,
            'G' => 15,
            'H' => 15,
            'I' => 20,
            'J' => 20,
            'K' => 15,
            'L' => 12,
            'M' => 15,
            'N' => 15,
            'O' => 30,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()
                    ->getStyle('D')
                    ->getAlignment()
                    ->setWrapText(true);
            },
        ];
    }
}
