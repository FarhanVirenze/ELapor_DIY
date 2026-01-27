<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\User;
use App\Models\KategoriUmum;
use App\Models\WilayahUmum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SpecificDateReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->pluck('id_user')->toArray();
        $kategori = KategoriUmum::all();
        $wilayah = WilayahUmum::pluck('id')->toArray();

        $statuses = ['Diajukan', 'Dibaca', 'Direspon', 'Selesai'];
        $priorities = ['Low', 'Medium', 'High', 'Emergency'];
        $sentiments = ['Positive', 'Neutral', 'Negative'];

        $publicPath = public_path('report_files');
        $allFiles = is_dir($publicPath) ? scandir($publicPath) : [];
        $sampleImages = array_filter($allFiles, function ($file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            return in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
        });
        $sampleImages = array_values($sampleImages);

        $regions = [
            'Kota Yogyakarta' => [
                'lat' => [-7.8200, -7.7700],
                'lng' => [110.3500, 110.3900],
                'sub' => ['Malioboro', 'Kotagede', 'Umbulharjo', 'Danurejan']
            ],
            'Sleman' => [
                'lat' => [-7.7600, -7.6500],
                'lng' => [110.3000, 110.4500],
                'sub' => ['Depok', 'Ngaglik', 'Mlati', 'Gamping']
            ],
            'Bantul' => [
                'lat' => [-8.0000, -7.8300],
                'lng' => [110.3000, 110.4000],
                'sub' => ['Kasihan', 'Sewon', 'Parangtritis', 'Piyungan']
            ],
            'Kulon Progo' => [
                'lat' => [-7.9000, -7.7500],
                'lng' => [110.0500, 110.2000],
                'sub' => ['Wates', 'Sentolo', 'Temon']
            ],
            'Gunung Kidul' => [
                'lat' => [-8.1000, -7.9000],
                'lng' => [110.5000, 110.7500],
                'sub' => ['Wonosari', 'Playen', 'Baron']
            ],
        ];

        $templates = [
            'Infrastruktur' => [
                ['judul' => 'Perbaikan Jalan Berlubang Segera', 'isi' => 'Mohon segera diperbaiki jalan yang berlubang di dekat jalan utama. Sangat membahayakan.'],
                ['judul' => 'Jembatan Rusak', 'isi' => 'Pondasi jembatan terlihat ambles, mohon segera ditangani.'],
            ],
            'Kesehatan' => [
                ['judul' => 'Layanan Puskesmas Lambat', 'isi' => 'Antrian pendaftaran sangat panjang. Mohon ditingkatkan.'],
            ],
            'Transportasi' => [
                ['judul' => 'Kemacetan Akibat Parkir Liar', 'isi' => 'Banyak kendaraan parkir sembarangan menyebabkan kemacetan.'],
            ],
            'Lingkungan' => [
                ['judul' => 'Tumpukan Sampah Liar', 'isi' => 'Warga mengeluhkan tumpukan sampah di pinggir jalan.'],
            ],
        ];

        $defaultTemplate = ['judul' => 'Laporan Fasilitas Umum', 'isi' => 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya.'];

        $regionKeys = array_keys($regions);

        // Generate 10 for Today
        for ($i = 1; $i <= 10; $i++) {
            $this->createReport($users, $kategori, $wilayah, $regions, $regionKeys, $templates, $defaultTemplate, $sampleImages, $statuses, $priorities, $sentiments, Carbon::today());
        }

        // Generate 10 for December 2025
        for ($i = 1; $i <= 10; $i++) {
            $date = Carbon::create(2025, 12, mt_rand(1, 31));
            $this->createReport($users, $kategori, $wilayah, $regions, $regionKeys, $templates, $defaultTemplate, $sampleImages, $statuses, $priorities, $sentiments, $date);
        }
    }

    private function createReport($users, $kategori, $wilayah, $regions, $regionKeys, $templates, $defaultTemplate, $sampleImages, $statuses, $priorities, $sentiments, $date)
    {
        $kat = $kategori->random();
        $regionName = $regionKeys[array_rand($regionKeys)];
        $regionData = $regions[$regionName];
        $subDistrict = $regionData['sub'][array_rand($regionData['sub'])];
        $templateSource = $templates[$kat->nama] ?? [$defaultTemplate];
        $selectedTemplate = $templateSource[array_rand($templateSource)];

        $lat = $regionData['lat'][0] + (mt_rand(0, 100000) / 100000) * ($regionData['lat'][1] - $regionData['lat'][0]);
        $lng = $regionData['lng'][0] + (mt_rand(0, 100000) / 100000) * ($regionData['lng'][1] - $regionData['lng'][0]);
        $img = !empty($sampleImages) ? $sampleImages[array_rand($sampleImages)] : 'default.jpg';

        Report::create([
            'tracking_id' => 'SPEC-' . strtoupper(Str::random(4)) . '-' . mt_rand(10000, 99999),
            'user_id' => !empty($users) ? $users[array_rand($users)] : null,
            'admin_id' => $kat->admin_id,
            'is_anonim' => (mt_rand(1, 100) > 75),
            'nama_pengadu' => 'Warga ' . $subDistrict,
            'email_pengadu' => 'user.' . Str::slug($subDistrict) . mt_rand(1, 999) . '@example.com',
            'telepon_pengadu' => '08' . mt_rand(111111111, 999999999),
            'nik' => '34' . mt_rand(01, 04) . mt_rand(100000000000, 999999999999),
            'judul' => $selectedTemplate['judul'] . ' (' . $date->format('d M Y') . ')',
            'isi' => $selectedTemplate['isi'] . ' Laporan ini dibuat pada ' . $date->format('d F Y') . '.',
            'kategori_id' => $kat->id,
            'wilayah_id' => $wilayah[array_rand($wilayah)],
            'file' => ['report_files/' . $img],
            'lokasi' => $subDistrict . ', ' . $regionName . ', DIY',
            'latitude' => $lat,
            'longitude' => $lng,
            'views' => mt_rand(1, 100),
            'status' => $statuses[array_rand($statuses)],
            'priority' => $priorities[array_rand($priorities)],
            'sentiment' => $sentiments[array_rand($sentiments)],
            'created_at' => $date->setTime(mt_rand(8, 17), mt_rand(0, 59)),
            'updated_at' => $date,
        ]);
    }
}
