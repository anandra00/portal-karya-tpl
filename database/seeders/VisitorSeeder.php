<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Visitor;
use Carbon\Carbon;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $uas = [
            // Chrome (Desktop)
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            // Chrome (Mobile)
            'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36',
            // Firefox (Desktop)
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/120.0',
            // Firefox (Mobile)
            'Mozilla/5.0 (Android 10; Mobile; rv:120.0) Gecko/120.0 Firefox/120.0',
            // Safari (Desktop)
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.2 Safari/605.1.15',
            // Safari (Mobile)
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.2 Mobile/15E148 Safari/605.1.15',
            // Edge (Desktop)
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 Edg/120.0.0.0',
            // Opera
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36 OPR/106.0.0.0'
        ];

        $names = [
            'Tamu', 'Rizky Pratama', 'Aulia Fitri', 'Budi Santoso', 'Siti Rahma', 
            'Dewi Lestari', 'Fajar Nugraha', 'Andi Wijaya', 'Mega Utami', 'Hendra Kusuma'
        ];

        $pages = [
            'http://127.0.0.1:8000/',
            'http://127.0.0.1:8000/tentang',
            'http://127.0.0.1:8000/karya',
            'http://127.0.0.1:8000/faq',
            'http://127.0.0.1:8000/dosen',
            'http://127.0.0.1:8000/matakuliah',
            'http://127.0.0.1:8000/berita'
        ];

        // Seed 150 visitors spread across the last 7 days
        for ($i = 0; $i < 150; $i++) {
            $name = $names[array_rand($names)];
            $email = $name === 'Tamu' ? 'guest@tpl.svipb.ac.id' : strtolower(str_replace(' ', '.', $name)) . '@gmail.com';
            $ip = rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255);
            $ua = $uas[array_rand($uas)];
            $page = $pages[array_rand($pages)];
            
            // Random datetime within the last 7 days
            $daysAgo = rand(0, 6);
            $hour = rand(8, 22);
            $minute = rand(0, 59);
            $second = rand(0, 59);
            $visitedAt = Carbon::now()->subDays($daysAgo)->setHour($hour)->setMinute($minute)->setSecond($second);

            Visitor::create([
                'nama' => $name,
                'email' => $email,
                'ip_address' => $ip,
                'user_agent' => $ua,
                'page_visited' => $page,
                'visited_at' => $visitedAt,
                'created_at' => $visitedAt,
                'updated_at' => $visitedAt
            ]);
        }
    }
}
