<?php

namespace Database\Seeders;

use Modules\Core\Models\ProfilProdi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        ProfilProdi::create([
            'kode_prodi' => 'TPL01',
            'nama_prodi' => 'Teknologi Rekayasa Perangkat Lunak.',
            'visi' => 'Menjadi program studi unggul di bidang rekayasa perangkat lunak.',
            'misi' => 'Menyelenggarakan pendidikan, penelitian, dan pengabdian di bidang rekayasa perangkat lunak yang relevan dengan kebutuhan industri.',
            'deskripsi' => 'Program studi yang berfokus pada pengembangan, analisis, dan implementasi perangkat lunak.',
            'capaian' => 'Lulusan mampu merancang, membuat, dan mengelola sistem perangkat lunak.',
            'tujuan' => 'Menghasilkan lulusan kompeten di bidang rekayasa perangkat lunak.',
            'kontak' => 'Email: trpl@kampus.ac.id | Telp: 0000-0000',
            'alamat' => 'Kampus XYZ, Bogor, Jawa Barat',
        ]);
    }
}
