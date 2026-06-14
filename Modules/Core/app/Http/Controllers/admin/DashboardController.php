<?php

namespace Modules\Core\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $ajuan_karya = \Modules\Karya\Models\Karya::where('status_validasi', 'submission')->count();

        $karya_terunggah = \Modules\Karya\Models\Karya::where('status_validasi', 'accepted')->count();

        $pengunjung = \Modules\Core\Models\Visitor::count();

        // Data chart karya per kategori (Doughnut Chart)
        $karya_by_kategori = \Modules\Karya\Models\Karya::selectRaw('kategori, count(*) as count')
            ->where('status_validasi', 'accepted')
            ->groupBy('kategori')
            ->get()
            ->toArray();

        // Data chart kunjungan harian 7 hari terakhir (Line Chart)
        $data = \Modules\Core\Models\Visitor::selectRaw('DATE(visited_at) as date, count(*) as count')
            ->where('visited_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $kunjungan_harian = [];
        for ($i = 6; $i >= 0; $i--) {
            $dateStr = now()->subDays($i)->format('Y-m-d');
            $formattedDate = now()->subDays($i)->translatedFormat('d M');
            $match = $data->firstWhere('date', $dateStr);
            $kunjungan_harian[] = [
                'label' => $formattedDate,
                'count' => $match ? $match->count : 0
            ];
        }

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

        $visitor_devices = [
            'browsers' => array_filter($browsers, fn($count) => $count > 0),
            'devices' => array_filter($devices, fn($count) => $count > 0)
        ];

        $latest_karyas = \Modules\Karya\Models\Karya::orderBy('created_at', 'desc')->limit(5)->get();

        $latest_activities = \Modules\Core\Models\ActivityLog::orderBy('created_at', 'desc')->limit(5)->get();

        // Telemetry system check
        $disk_path = base_path();
        $disk_total = @disk_total_space($disk_path);
        $disk_free = @disk_free_space($disk_path);

        if ($disk_total === false || $disk_total <= 0) {
            $disk_total = 100 * 1024 * 1024 * 1024; // fallback 100 GB
            $disk_free = 65 * 1024 * 1024 * 1024;   // fallback 65 GB
        }

        $disk_used = $disk_total - $disk_free;
        $disk_used_percent = round(($disk_used / $disk_total) * 100, 1);

        $format_bytes = function($bytes) {
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
            $bytes = max($bytes, 0);
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $bytes /= pow(1024, $pow);
            return round($bytes, 1) . ' ' . $units[$pow];
        };

        $disk_total_formatted = $format_bytes($disk_total);
        $disk_free_formatted = $format_bytes($disk_free);
        $disk_used_formatted = $format_bytes($disk_used);

        // DB Status Check
        try {
            \Illuminate\Support\Facades\DB::connection()->getPdo();
            $db_status = 'Connected';
        } catch (\Exception $e) {
            $db_status = 'Disconnected';
        }

        $telemetry = [
            'disk_total' => $disk_total_formatted,
            'disk_free' => $disk_free_formatted,
            'disk_used' => $disk_used_formatted,
            'disk_used_percent' => $disk_used_percent,
            'db_status' => $db_status,
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_os' => PHP_OS_FAMILY,
            'laravel_env' => app()->environment()
        ];

        return view('admin.dashboard', compact(
            'ajuan_karya', 
            'karya_terunggah', 
            'pengunjung',
            'karya_by_kategori',
            'kunjungan_harian',
            'visitor_devices',
            'latest_karyas',
            'latest_activities',
            'telemetry'
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
