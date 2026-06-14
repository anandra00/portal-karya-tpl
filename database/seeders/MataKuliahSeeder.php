<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Akademik\Models\MataKuliah;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        MataKuliah::truncate();

        $courses = [
            // Semester 1
            [
                'kode_matkul' => 'TPL1101',
                'nama_matkul' => 'Berpikir Komputasional',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 1,
            ],
            [
                'kode_matkul' => 'SV1001',
                'nama_matkul' => 'Bahasa Inggris',
                'sks_teori' => '2',
                'sks_praktik' => '1',
                'semester' => 1,
            ],
            [
                'kode_matkul' => 'TPL1102',
                'nama_matkul' => 'Dasar Pemrograman',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 1,
            ],
            [
                'kode_matkul' => 'TPL2101',
                'nama_matkul' => 'Logika Informatika',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 1,
            ],
            [
                'kode_matkul' => 'SV1002',
                'nama_matkul' => 'Pendidikan Agama Katolik',
                'sks_teori' => '2',
                'sks_praktik' => '1',
                'semester' => 1,
            ],
            [
                'kode_matkul' => 'SV1003',
                'nama_matkul' => 'Pendidikan Agama Protestan',
                'sks_teori' => '2',
                'sks_praktik' => '1',
                'semester' => 1,
            ],
            [
                'kode_matkul' => 'SV1004',
                'nama_matkul' => 'Pendidikan Agama Hindu',
                'sks_teori' => '2',
                'sks_praktik' => '1',
                'semester' => 1,
            ],
            [
                'kode_matkul' => 'SV1005',
                'nama_matkul' => 'Pendidikan Agama Budha',
                'sks_teori' => '2',
                'sks_praktik' => '1',
                'semester' => 1,
            ],
            [
                'kode_matkul' => 'SV1006',
                'nama_matkul' => 'Pendidikan Agama Konghucu',
                'sks_teori' => '2',
                'sks_praktik' => '1',
                'semester' => 1,
            ],
            [
                'kode_matkul' => 'SV1106',
                'nama_matkul' => 'Kepercayaan Kepada Tuhan Yang Maha Esa',
                'sks_teori' => '2',
                'sks_praktik' => '1',
                'semester' => 1,
            ],
            [
                'kode_matkul' => 'SV1109',
                'nama_matkul' => 'Bahasa Indonesia',
                'sks_teori' => '2',
                'sks_praktik' => '1',
                'semester' => 1,
            ],

            // Semester 2
            [
                'kode_matkul' => 'TPL1107',
                'nama_matkul' => 'Matematika Terapan',
                'sks_teori' => '2',
                'sks_praktik' => '1',
                'semester' => 2,
            ],
            [
                'kode_matkul' => 'TPL1109',
                'nama_matkul' => 'Algoritma dan Struktur Data',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 2,
            ],
            [
                'kode_matkul' => 'TPL1105',
                'nama_matkul' => 'Teknologi Multimedia',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 2,
            ],
            [
                'kode_matkul' => 'TPL2102',
                'nama_matkul' => 'Perancangan Web',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 2,
            ],
            [
                'kode_matkul' => 'TPL1207',
                'nama_matkul' => 'Probabilitas dan Statistika',
                'sks_teori' => '1',
                'sks_praktik' => '1',
                'semester' => 2,
            ],
            [
                'kode_matkul' => 'SVI1107',
                'nama_matkul' => 'Pendidikan Pancasila',
                'sks_teori' => '1',
                'sks_praktik' => '0',
                'semester' => 2,
            ],
            [
                'kode_matkul' => 'SVI1108',
                'nama_matkul' => 'Pendidikan Kewarganegaraan',
                'sks_teori' => '1',
                'sks_praktik' => '1',
                'semester' => 2,
            ],
            [
                'kode_matkul' => 'MNI1101',
                'nama_matkul' => 'Pertanian Inovatif',
                'sks_teori' => '2',
                'sks_praktik' => '0',
                'semester' => 2,
            ],

            // Semester 3
            [
                'kode_matkul' => 'TPL1112',
                'nama_matkul' => 'Rekayasa Kebutuhan Perangkat Lunak',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 3,
            ],
            [
                'kode_matkul' => 'TPL1202',
                'nama_matkul' => 'Matematika Informatika',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 3,
            ],
            [
                'kode_matkul' => 'TPL1103',
                'nama_matkul' => 'Komunikasi Data dan Jaringan',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 3,
            ],
            [
                'kode_matkul' => 'TPL2201',
                'nama_matkul' => 'Pengalaman Pengguna',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 3,
            ],
            [
                'kode_matkul' => 'TPL1206',
                'nama_matkul' => 'Analisis dan Perancangan Perangkat Lunak',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 3,
            ],
            [
                'kode_matkul' => 'TPL1111',
                'nama_matkul' => 'Sistem Basis Data',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 3,
            ],
            [
                'kode_matkul' => 'TPL2202',
                'nama_matkul' => 'Keamanan Perangkat Lunak',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 3,
            ],
            [
                'kode_matkul' => 'TPL1110',
                'nama_matkul' => 'Pemrograman Berorientasi Objek',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 3,
            ],

            // Semester 4
            [
                'kode_matkul' => 'TPL1209',
                'nama_matkul' => 'Sistem Informasi',
                'sks_teori' => '1',
                'sks_praktik' => '1',
                'semester' => 4,
            ],
            [
                'kode_matkul' => 'TPL1205',
                'nama_matkul' => 'Komputasi Awan',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 4,
            ],
            [
                'kode_matkul' => 'TPL1210',
                'nama_matkul' => 'Teknologi Virtual',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 4,
            ],
            [
                'kode_matkul' => 'TPL1212',
                'nama_matkul' => 'Pengembangan Karakter dan Etika Profesi Bidang Teknologi Informasi',
                'sks_teori' => '1',
                'sks_praktik' => '1',
                'semester' => 4,
            ],
            [
                'kode_matkul' => 'TPL2306',
                'nama_matkul' => 'Technopreneurship',
                'sks_teori' => '1',
                'sks_praktik' => '1',
                'semester' => 4,
            ],
            [
                'kode_matkul' => 'TPL1203',
                'nama_matkul' => 'Pemrograman Web',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 4,
            ],
            [
                'kode_matkul' => 'TPL1204',
                'nama_matkul' => 'Pemrograman Mobile',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 4,
            ],
            [
                'kode_matkul' => 'TPL1301',
                'nama_matkul' => 'Analisis dan Visualisasi Data',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 4,
            ],
            [
                'kode_matkul' => 'TPL1304',
                'nama_matkul' => 'Teknik Penambangan Data',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 4,
            ],

            // Semester 5
            [
                'kode_matkul' => 'TPL1303',
                'nama_matkul' => 'Manajemen Proyek Teknologi Informasi',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 5,
            ],
            [
                'kode_matkul' => 'TPL1302',
                'nama_matkul' => 'Pemrosesan Citra Terapan',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 5,
            ],
            [
                'kode_matkul' => 'TPL1309',
                'nama_matkul' => 'Teknologi Big Data',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 5,
            ],
            [
                'kode_matkul' => 'TPL1211',
                'nama_matkul' => 'Sistem Informasi Geografis',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 5,
            ],
            [
                'kode_matkul' => 'TPL2310',
                'nama_matkul' => 'Visual Komputer Cerdas',
                'sks_teori' => '1',
                'sks_praktik' => '1',
                'semester' => 5,
            ],
            [
                'kode_matkul' => 'TPL1305',
                'nama_matkul' => 'Pengujian dan Penjaminan Perangkat Lunak',
                'sks_teori' => '1',
                'sks_praktik' => '2',
                'semester' => 5,
            ],

            // Semester 6
            [
                'kode_matkul' => 'EC',
                'nama_matkul' => 'Enrichment Course',
                'sks_teori' => '0',
                'sks_praktik' => '22',
                'semester' => 6,
            ],

            // Semester 7
            [
                'kode_matkul' => 'SVI2401',
                'nama_matkul' => 'Immersive Program',
                'sks_teori' => '0',
                'sks_praktik' => '14',
                'semester' => 7,
            ],
            [
                'kode_matkul' => 'SVI24012',
                'nama_matkul' => 'Work Plan',
                'sks_teori' => '0',
                'sks_praktik' => '1',
                'semester' => 7,
            ],

            // Semester 8
            [
                'kode_matkul' => 'SVI2403',
                'nama_matkul' => 'Seminar',
                'sks_teori' => '0',
                'sks_praktik' => '1',
                'semester' => 8,
            ],
            [
                'kode_matkul' => 'SVI2404',
                'nama_matkul' => 'Laporan Proyek Akhir',
                'sks_teori' => '0',
                'sks_praktik' => '6',
                'semester' => 8,
            ],
        ];

        foreach ($courses as $c) {
            MataKuliah::create($c);
        }
    }
}
