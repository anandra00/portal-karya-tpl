<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function backupDatabase()
    {
        $databaseName = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        
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