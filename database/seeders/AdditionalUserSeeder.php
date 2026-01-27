<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdditionalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Budi Santoso',
            'Siti Aminah',
            'Agus Prayitno',
            'Larasati Putri',
            'Rahmat Hidayat',
            'Dewi Lestari',
            'Eko Saputra',
            'Indah Permata',
            'Andi Wijaya',
            'Siska Amelia',
            'Hendra Kusuma',
            'Maya Sari',
            'Fajar Ramadhan',
            'Anita Wijayanti',
            'Rizky Pratama',
            'Dian Saputri',
            'Arif Rahman',
            'Yuni Kartika',
            'Doni Setiawan',
            'Rina Marlina',
            'Taufik Hidayat',
            'Linda Kusuma',
            'Bambang Sudarsono',
            'Mega Utami',
            'Adi Nugroho',
            'Rosa Melinda',
            'Galang Pradana',
            'Vina Panduwinata',
            'Dedi Kurniawan',
            'Nia Ramadhani'
        ];

        for ($i = 1; $i <= 74; $i++) {
            $baseName = $names[array_rand($names)];
            $name = $baseName . ' ' . $i;
            $email = Str::slug($baseName) . $i . '@example.com';

            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
                'nik' => '34' . mt_rand(10000000000000, 99999999999999),
                'nomor_telepon' => '08' . mt_rand(111111111, 999999999),
                'role' => 'user',
                'google_id' => null,
                'avatar' => null,
                'foto' => null,
                'email_verified_at' => now(),
            ]);
        }
    }
}
