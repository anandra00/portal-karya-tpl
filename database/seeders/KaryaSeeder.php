<?php

namespace Database\Seeders;

use Modules\Karya\Models\Karya;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KaryaSeeder extends Seeder
{
   public function run(): void
    {
        $kategori = [
            'Aplikasi Web',
            'Aplikasi Mobile',
            'Internet of Things (IoT)',
            'Game',
            'UI/UX Design',
            'Machine Learning'
        ];

        $status = ['accepted', 'rejected', 'submission'];

        for ($i = 1; $i <= 10; $i++) {
            Karya::create([
                'user_id' => 1, // Ganti sesuai user yang tersedia
                'judul' => 'Karya Contoh ' . $i,
                'deskripsi' => 'Deskripsi singkat untuk karya contoh ke-' . $i,
                'kategori' => $kategori[array_rand($kategori)],
                'tahun' => rand(2020, date('Y')),
                'file_karya' => 'https://example.com/karya-' . $i, // dummy link
                'preview_karya' => 'karya/default.jpg', // pastikan ada file dummy
                'link_pengumpulan' => 'https://drive.google.com/file/d/' . Str::random(15),
                'tim_pembuat' => 'Tim Contoh ' . $i,
                'status_validasi' => $status[array_rand($status)],
                'tanggal_upload' => now()->subDays(rand(1, 120)),
            ]);
        }
    }
}
