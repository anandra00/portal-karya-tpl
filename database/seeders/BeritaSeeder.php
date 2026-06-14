<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Akademik\Models\Berita;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Berita::create([
            'judul' => 'Lokakarya Kurikulum Baru TRPL SV IPB: Integrasi AI & Cloud',
            'isi' => 'Program Studi Teknologi Rekayasa Perangkat Lunak (TRPL) Sekolah Vokasi IPB menyelenggarakan lokakarya peninjauan kurikulum baru yang mengintegrasikan pembelajaran Kecerdasan Buatan (Artificial Intelligence) dan Cloud Computing secara mendalam. Hal ini bertujuan untuk membekali mahasiswa dengan keterampilan relevan industri.',
            'gambar' => 'berita/4g1tv9CKcL68T0aNmQgTc9ifmti4b6Att81YoHPz.png',
            'tanggal_publikasi' => now(),
            'user_id' => 2, // Admin TPL
        ]);

        Berita::create([
            'judul' => 'Prestasi Gemilang Mahasiswa TRPL di Kompetisi Hackathon Nasional',
            'isi' => 'Tim mahasiswa program studi Teknologi Rekayasa Perangkat Lunak (TRPL) Sekolah Vokasi IPB University berhasil meraih juara pertama dalam ajang Hackathon Nasional 2026. Aplikasi solusi IoT perkotaan pintar buatan mereka sukses memikat dewan juri.',
            'gambar' => 'berita/2PbTZSGx1EVChRfSEwrLMRMjgO87a5hf3klQmj44.jpg',
            'tanggal_publikasi' => now()->subDays(2),
            'user_id' => 2,
        ]);

        Berita::create([
            'judul' => 'Kolaborasi TRPL SV IPB dengan Perusahaan Teknologi Global',
            'isi' => 'Dalam rangka meningkatkan kesiapan kerja lulusan, Program Studi TRPL SV IPB menyepakati kerja sama strategis dengan penyedia layanan teknologi global. Kolaborasi ini mencakup program sertifikasi profesional, kuliah tamu dari praktisi, dan program magang bersertifikat.',
            'gambar' => 'berita/AOnkLdhq863nQOs068tbPQpDOrTH4TxbfPmC3VDL.jpg',
            'tanggal_publikasi' => now()->subDays(5),
            'user_id' => 2,
        ]);
    }
}
