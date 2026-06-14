<?php

namespace Modules\Core\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $logs = \Modules\Core\Models\ActivityLog::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.activity.index', compact('logs'));
    }

    public function clearLogs()
    {
        \Modules\Core\Models\ActivityLog::truncate();
        return redirect()->route('activity-logs.index')->with('success', 'Seluruh jejak audit berhasil dibersihkan!');
    }
}
