<?php

use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use App\Models\Report;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Carbon;

Schedule::call(function () {
    $count = Report::where('status', Report::STATUS_SELESAI)
        ->where('updated_at', '<=', Carbon::now()->subDays(7))
        ->update([
            'status' => Report::STATUS_ARSIP,
            'is_arsip' => true
        ]);

    if ($count > 0) {
        \Log::info("Auto-Archive: Berhasil mengarsipkan $count aduan yang sudah selesai lebih dari 7 hari.");
    }
})->dailyAt('00:00')->name('auto-archive-reports');
