<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProfilProdi;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        // User::create([
        //     'id_user' => 'ADM001',
        //     'username' => 'admin',
        //     'email' => 'admin@tpl.svipb.ac.id',
        //     'password' => Hash::make('password'),
        //     'id_role' => 'admin',
        // ]);

        // Create Mahasiswa User
        // User::create([
        //     'id_user' => 'MHS001',
        //     'username' => 'mahasiswa',
        //     'email' => 'mahasiswa@tpl.svipb.ac.id',
        //     'password' => Hash::make('password'),
        //     'id_role' => 'mahasiswa',
        // ]);

        // Create Profil Prodi
       // ProfilProdi::create([
            //'id_prodi' => 'TPL001',
            //'nama_prodi' => 'Teknologi Rekayasa Perangkat Lunak',
            //'visi' => 'Menjadi program studi yang unggul dalam pengembangan teknologi perangkat lunak',
            //'misi' => 'Menghasilkan lulusan yang kompeten di bidang rekayasa perangkat lunak',
            //'deskripsi' => 'Program Studi Teknologi Rekayasa Perangkat Lunak...',
            //'kontak' => '0251-8320111',
            //'alamat' => 'Jl. Kumbang No.14, Bogor',
        //]);

        // Call other seeders if needed
        $this->call([
            UserSeeder::class,
            KategoriSeeder::class,
            KaryaSeeder::class,
            ProdiSeeder::class,
            VisitorSeeder::class,
            DosenSeeder::class,
            MataKuliahSeeder::class,
            BeritaSeeder::class,
        ]);
    }
}

