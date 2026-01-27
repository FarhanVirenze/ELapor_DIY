<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    private $counter = 1; // Counter untuk nomor urut
    protected $reports;   // Property untuk menampung data yang dikirim dari controller

    // Constructor menerima data reports dari controller
    public function __construct($reports)
    {
        $this->reports = $reports;
    }

    // Gunakan data reports yang sudah difilter
    public function collection()
    {
        return $this->reports;
    }

    // Mapping tiap kolom
    public function map($report): array
    {
        return [
            $this->counter++, // No urut
            $report->tracking_id,
            $report->judul,
            $report->isi,
            $report->is_anonim ? 'Anonim' : ($report->user->name ?? $report->nama_pengadu ?? '-'),
            $report->is_anonim ? '-' : ($report->user->email ?? $report->email_pengadu ?? '-'),
            $report->is_anonim ? '-' : ($report->telepon_pengadu ?? '-'),
            $report->is_anonim ? '-' : ($report->nik ?? '-'),
            $report->admin->name ?? '-',
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

    // Header kolom Excel
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
            'Admin',
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

    // Lebar kolom
    public function columnWidths(): array
    {
        return [
            'A' => 5,    // No
            'B' => 15,   // Tracking
            'C' => 50,   // Judul
            'D' => 60,   // Isi Aduan
            'E' => 20,   // Pelapor
            'F' => 25,   // Email
            'G' => 15,   // Telepon
            'H' => 15,   // NIK
            'I' => 20,   // Admin
            'J' => 20,   // Kategori
            'K' => 20,   // Wilayah
            'L' => 15,   // Status
            'M' => 12,   // Tanggal
            'N' => 15,   // Longitude
            'O' => 15,   // Latitude
            'P' => 30,   // Lokasi
        ];
    }

    // Event untuk wrap text
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getStyle('D')->getAlignment()->setWrapText(true); // wrap text di kolom isi aduan
            },
        ];
    }
}
