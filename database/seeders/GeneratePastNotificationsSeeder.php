<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;
use App\Models\User;
use App\Models\KategoriUmum;
use App\Notifications\NewReportSubmitted;
use App\Notifications\ReportStatusChanged;
use Illuminate\Support\Facades\Notification;

class GeneratePastNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reports = Report::with(['kategori', 'pelapor'])->get();
        $superadmins = User::where('role', 'superadmin')->get();

        foreach ($reports as $report) {
            try {
                $this->command->info("Processing Report ID: {$report->id}");

                // 1. Notifikasi "Aduan Baru Masuk"
                if ($report->kategori && $report->kategori->admin_id) {
                    $admin = User::find($report->kategori->admin_id);
                    if ($admin) {
                        $exists = $admin->notifications()
                            ->where('type', NewReportSubmitted::class)
                            ->where('data', 'like', '%"report_id":' . $report->id . '%') // Fallback JSON check
                            ->exists();
                        
                        if (!$exists) {
                            $admin->notify(new NewReportSubmitted($report));
                        }
                    }
                }

                foreach ($superadmins as $superadmin) {
                     $exists = $superadmin->notifications()
                        ->where('type', NewReportSubmitted::class)
                        ->where('data', 'like', '%"report_id":' . $report->id . '%')
                        ->exists();

                    if (!$exists) {
                        $superadmin->notify(new NewReportSubmitted($report));
                    }
                }

                // 2. Notifikasi User
                if ($report->status !== 'Diajukan' && $report->pelapor) {
                     $exists = $report->pelapor->notifications()
                        ->where('type', ReportStatusChanged::class)
                        ->where('data', 'like', '%"report_id":' . $report->id . '%')
                        ->exists();

                    if (!$exists) {
                        $report->pelapor->notify(new ReportStatusChanged($report, 'Diajukan', $report->status));
                    }
                }

            } catch (\Exception $e) {
                $this->command->error("Failed Report {$report->id}: " . $e->getMessage());
            }
        }
    }
}
