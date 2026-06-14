<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Akademik\Models\Dosen;
use Illuminate\Support\Facades\File;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $dosenDir = storage_path('app/public/dosen');
        if (!File::exists($dosenDir)) {
            File::makeDirectory($dosenDir, 0755, true);
        }

        $lecturers = [
            [
                'nama' => 'Amata Fami, M.Ds.',
                'image_src' => 'Bu Ami.png',
                'foto' => 'dosen/Bu Ami.png',
                'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
                'research_interest' => 'Desain Grafis, UI/UX, Creative Media',
            ],
            [
                'nama' => 'Gema Parasti Mindara, S.Si., M.Kom.',
                'image_src' => 'Bu Gema.png',
                'foto' => 'dosen/Bu Gema.png',
                'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
                'research_interest' => 'Interaksi Manusia dan Komputer, Sistem Informasi',
            ],
            [
                'nama' => 'Dra. Irma Rasita Gloria Barus, M.A.',
                'image_src' => 'Bu Irma.png',
                'foto' => 'dosen/Bu Irma.png',
                'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
                'research_interest' => 'Komunikasi Profesional, Humaniora',
            ],
            [
                'nama' => 'Medhanita Dewi Renanti, S.Kom., M.Kom.',
                'image_src' => 'Bu Medha.png',
                'foto' => 'dosen/Bu Medha.png',
                'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
                'research_interest' => 'Pemrograman Dasar, Mobile Application, Rekayasa Perangkat Lunak',
            ],
            [
                'nama' => 'Lathifunnisa Fathonah, S.ST., M.T.',
                'image_src' => 'Bu Nisa.png',
                'foto' => 'dosen/Bu Nisa.png',
                'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
                'research_interest' => 'Jaringan Komputer, Embedded Systems, IoT',
            ],
            [
                'nama' => 'Sofiyanti Indriasari, S.Kom., M.Kom.',
                'image_src' => 'Bu Sofiyanti.png',
                'foto' => 'dosen/Bu Sofiyanti.png',
                'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
                'research_interest' => 'Sistem Informasi, Manajemen Proyek Perangkat Lunak',
            ],
            [
                'nama' => 'Nur Aziezah, S.Si., M.Si.',
                'image_src' => 'Bu aziezah.png',
                'foto' => 'dosen/Bu aziezah.png',
                'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
                'research_interest' => 'Data Science, Statistika, Machine Learning',
            ],
            [
                'nama' => 'Aditya Wicaksono, S.Kom., M.Kom.',
                'image_src' => 'P adit.png',
                'foto' => 'dosen/P adit.png',
                'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
                'research_interest' => 'Pemrograman Game, Web Development, Rekayasa Perangkat Lunak',
            ],
            [
                'nama' => 'Muhammad Nasir, S.T., M.Kom.',
                'image_src' => 'Pak Nasir.png',
                'foto' => 'dosen/Pak Nasir.png',
                'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
                'research_interest' => 'Arsitektur Komputer, Jaringan & Keamanan Komputer',
            ],
        ];

        foreach ($lecturers as $l) {
            $srcPath = public_path('images/' . $l['image_src']);
            $destPath = $dosenDir . '/' . $l['image_src'];
            
            if (File::exists($srcPath)) {
                File::copy($srcPath, $destPath);
            }

            Dosen::updateOrCreate(
                ['nama' => $l['nama']],
                [
                    'foto' => $l['foto'],
                    'prodi' => $l['prodi'],
                    'research_interest' => $l['research_interest'],
                ]
            );
        }
    }
}
