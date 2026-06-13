<?php

namespace Modules\Core\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $ajuan_karya = \Illuminate\Support\Facades\Cache::remember('dashboard_ajuan', 600, function() {
            return \Modules\Karya\Models\Karya::where('status_validasi', 'submission')->count();
        });

        $karya_terunggah = \Illuminate\Support\Facades\Cache::remember('dashboard_terunggah', 600, function() {
            return \Modules\Karya\Models\Karya::where('status_validasi', 'accepted')->count();
        });

        $pengunjung = \Illuminate\Support\Facades\Cache::remember('dashboard_pengunjung', 600, function() {
            return \Modules\Core\Models\Visitor::count();
        });

        // Data chart karya per kategori (Doughnut Chart)
        $karya_by_kategori = \Illuminate\Support\Facades\Cache::remember('dashboard_chart_kategori', 600, function() {
            return \Modules\Karya\Models\Karya::selectRaw('kategori, count(*) as count')
                ->where('status_validasi', 'accepted')
                ->groupBy('kategori')
                ->get()
                ->toArray();
        });

        // Data chart kunjungan harian 7 hari terakhir (Line Chart)
        $kunjungan_harian = \Illuminate\Support\Facades\Cache::remember('dashboard_chart_kunjungan', 600, function() {
            $data = \Modules\Core\Models\Visitor::selectRaw('DATE(visited_at) as date, count(*) as count')
                ->where('visited_at', '>=', now()->subDays(6))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            
            $chartData = [];
            for ($i = 6; $i >= 0; $i--) {
                $dateStr = now()->subDays($i)->format('Y-m-d');
                $formattedDate = now()->subDays($i)->translatedFormat('d M');
                $match = $data->firstWhere('date', $dateStr);
                $chartData[] = [
                    'label' => $formattedDate,
                    'count' => $match ? $match->count : 0
                ];
            }
            return $chartData;
        });

        $visitor_devices = \Illuminate\Support\Facades\Cache::remember('dashboard_visitor_devices', 600, function() {
            $visitors = \Modules\Core\Models\Visitor::all();
            
            $browsers = [
                'Chrome' => 0,
                'Safari' => 0,
                'Firefox' => 0,
                'Edge' => 0,
                'Opera' => 0,
                'Lainnya' => 0
            ];

            $devices = [
                'Desktop' => 0,
                'Mobile' => 0,
                'Tablet' => 0
            ];

            foreach ($visitors as $v) {
                $browser = $v->browser;
                $device = $v->device;

                if (isset($browsers[$browser])) {
                    $browsers[$browser]++;
                } else {
                    $browsers['Lainnya']++;
                }

                if (isset($devices[$device])) {
                    $devices[$device]++;
                }
            }

            return [
                'browsers' => array_filter($browsers, fn($count) => $count > 0),
                'devices' => array_filter($devices, fn($count) => $count > 0)
            ];
        });

        return view('admin.dashboard', compact(
            'ajuan_karya', 
            'karya_terunggah', 
            'pengunjung',
            'karya_by_kategori',
            'kunjungan_harian',
            'visitor_devices'
        ));
    }

    public function backupDatabase()
    {
        $databaseName = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        
        $filename = "backup_" . $databaseName . "_" . date('Y-m-d_H-i-s') . ".sql";
        $headers = [
            "Content-Type" => "application/octet-stream",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($databaseName) {
            $tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
            $file = fopen('php://output', 'w');
            
            fwrite($file, "-- Database Backup for $databaseName\n");
            fwrite($file, "-- Generated on " . date('Y-m-d H:i:s') . "\n\n");

            foreach ($tables as $table) {
                $tableName = (array) $table;
                $tableName = array_values($tableName)[0];
                
                fwrite($file, "-- Table structure for `$tableName`\n");
                
                $createTable = \Illuminate\Support\Facades\DB::select("SHOW CREATE TABLE `$tableName`");
                $createTableArray = (array) $createTable[0];
                fwrite($file, "DROP TABLE IF EXISTS `$tableName`;\n");
                fwrite($file, $createTableArray['Create Table'] . ";\n\n");

                $rows = \Illuminate\Support\Facades\DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    fwrite($file, "-- Dumping data for table `$tableName`\n");
                    foreach ($rows as $row) {
                        $values = array_map(function ($value) {
                            if (is_null($value)) return "NULL";
                            $value = addslashes($value);
                            return "'$value'";
                        }, (array) $row);
                        
                        fwrite($file, "INSERT INTO `$tableName` VALUES (" . implode(", ", $values) . ");\n");
                    }
                    fwrite($file, "\n");
                }
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
