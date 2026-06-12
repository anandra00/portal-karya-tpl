<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $logs = \App\Models\ActivityLog::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.activity.index', compact('logs'));
    }
}
