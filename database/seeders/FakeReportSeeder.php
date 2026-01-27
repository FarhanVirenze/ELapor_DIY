<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\User;
use App\Models\KategoriUmum;
use App\Models\WilayahUmum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FakeReportSeeder extends Seeder
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

        // Get all images from public/report_files
        $publicPath = public_path('report_files');
        $allFiles = is_dir($publicPath) ? scandir($publicPath) : [];
        $sampleImages = array_filter($allFiles, function ($file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            return in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
        });
        $sampleImages = array_values($sampleImages);

        // Bounding boxes for DIY Regions
        $regions = [
            'Kota Yogyakarta' => [
                'lat' => [-7.8200, -7.7700],
                'lng' => [110.3500, 110.3900],
                'sub' => ['Malioboro', 'Kotagede', 'Umbulharjo', 'Danurejan', 'Mangkubumi']
            ],
            'Sleman' => [
                'lat' => [-7.7600, -7.6500],
                'lng' => [110.3000, 110.4500],
                'sub' => ['Depok', 'Ngaglik', 'Mlati', 'Gamping', 'Kaliurang']
            ],
            'Bantul' => [
                'lat' => [-8.0000, -7.8300],
                'lng' => [110.3000, 110.4000],
                'sub' => ['Kasihan', 'Sewon', 'Parangtritis', 'Piyungan', 'Banguntapan']
            ],
            'Kulon Progo' => [
                'lat' => [-7.9000, -7.7500],
                'lng' => [110.0500, 110.2000],
                'sub' => ['Wates', 'Sentolo', 'Kalibawang', 'Nanggulan', 'Temon']
            ],
            'Gunung Kidul' => [
                'lat' => [-8.1000, -7.9000],
                'lng' => [110.5000, 110.7500],
                'sub' => ['Wonosari', 'Playen', 'Semanu', 'Baron', 'Karangmojo']
            ],
        ];

        $templates = [
            'Infrastruktur' => [
                ['judul' => 'Perbaikan Jalan Berlubang Parah', 'isi' => 'Mohon segera diperbaiki jalan yang berlubang di dekat jalan utama. Lubang cukup dalam dan sering membuat pengendara motor terjatuh.'],
                ['judul' => 'Pagar Pembatas Jembatan Ambles', 'isi' => 'Pagar pengaman di jembatan terlihat miring dan pondasinya ambles. Sangat berbahaya bagi warga sekitar.'],
                ['judul' => 'Saluran Irigasi Tersumbat', 'isi' => 'Saluran irigasi di area persawahan tersumbat material sampah. Air meluap ke jalan desa.'],
            ],
            'Kesehatan' => [
                ['judul' => 'Keluhan Antrian BPJS Terlalu Lama', 'isi' => 'Antrian pendaftaran sangat panjang dan tidak teratur. Mohon ditingkatkan sistem layanannya.'],
                ['judul' => 'Puskesmas Kurang Kebersihan', 'isi' => 'Kondisi ruang tunggu kurang bersih dan fasilitas air sering mati. Mohon segera dicek.'],
            ],
            'Transportasi' => [
                ['judul' => 'Parkir Liar di Bahu Jalan', 'isi' => 'Banyak kendaraan parkir sembarangan yang menyebabkan kemacetan parah di jam pulang kerja.'],
                ['judul' => 'Lampu APILL Error', 'isi' => 'Lampu lalu lintas di persimpangan ini hanya berkedip kuning, membuat lalu lintas semrawut.'],
            ],
            'Lingkungan' => [
                ['judul' => 'Pembuangan Sampah Liar', 'isi' => 'Warga mengeluhkan tumpukan sampah di pinggir jalan yang menimbulkan bau tidak sedap.'],
                ['judul' => 'Pohon Tumbang Belum Dievakuasi', 'isi' => 'Ada pohon besar tumbang menghalangi sebagian badan jalan, mohon segera ditangani.'],
            ],
            'Penerangan Jalan' => [
                ['judul' => 'Lampu PJU Mati Total', 'isi' => 'Lampu jalan di sepanjang area ini mati total, jalanan menjadi gelap dan rawan tindak kejahatan.'],
            ],
        ];

        $defaultTemplate = [
            'judul' => 'Laporan Kendala Fasilitas Umum',
            'isi' => 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama.'
        ];

        $regionKeys = array_keys($regions);

        for ($i = 1; $i <= 100; $i++) {
            $kat = $kategori->random();
            $katName = $kat->nama;

            // Pick a random region
            $regionName = $regionKeys[array_rand($regionKeys)];
            $regionData = $regions[$regionName];

            // Random sub-district for the location string
            $subDistrict = $regionData['sub'][array_rand($regionData['sub'])];

            $templateSource = $templates[$katName] ?? [$defaultTemplate];
            $selectedTemplate = $templateSource[array_rand($templateSource)];

            $lat = $regionData['lat'][0] + (mt_rand(0, 100000) / 100000) * ($regionData['lat'][1] - $regionData['lat'][0]);
            $lng = $regionData['lng'][0] + (mt_rand(0, 100000) / 100000) * ($regionData['lng'][1] - $regionData['lng'][0]);

            $img = !empty($sampleImages) ? $sampleImages[array_rand($sampleImages)] : 'default.jpg';

            Report::create([
                'tracking_id' => 'ADU-' . strtoupper(Str::random(4)) . '-' . mt_rand(10000, 99999),
                'user_id' => !empty($users) ? $users[array_rand($users)] : null,
                'admin_id' => $kat->admin_id,
                'is_anonim' => (mt_rand(1, 100) > 75),
                'nama_pengadu' => 'Warga ' . $subDistrict,
                'email_pengadu' => 'pelapor.' . Str::slug($subDistrict) . $i . '@example.com',
                'telepon_pengadu' => '08' . mt_rand(111111111, 999999999),
                'nik' => '34' . mt_rand(01, 04) . mt_rand(100000000000, 999999999999),
                'judul' => $selectedTemplate['judul'] . ' - ' . $subDistrict,
                'isi' => $selectedTemplate['isi'] . ' Lokasi detail di wilayah ' . $subDistrict . ', ' . $regionName . '.',
                'kategori_id' => $kat->id,
                'wilayah_id' => $wilayah[array_rand($wilayah)],
                'file' => ['report_files/' . $img],
                'lokasi' => $subDistrict . ', ' . $regionName . ', DI Yogyakarta',
                'latitude' => $lat,
                'longitude' => $lng,
                'views' => mt_rand(10, 300),
                'likes' => mt_rand(0, 50),
                'dislikes' => mt_rand(0, 10),
                'status' => $statuses[array_rand($statuses)],
                'priority' => $priorities[array_rand($priorities)],
                'sentiment' => $sentiments[array_rand($sentiments)],
                'ai_analysis' => 'Laporan masuk dari wilayah ' . $regionName . '. Analisis awal menunjukkan kebutuhan respon cepat.',
                'created_at' => Carbon::now()->subDays(mt_rand(1, 30)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
