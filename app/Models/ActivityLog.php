<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ActivityLog extends Model
{
    protected $fillable = [
        'type',
        'action',
        'judul_karya',
        'deskripsi',
        'pembuat',
        'validasi',
        'status',
        'link',
    ];

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'validated' => '<span class="badge bg-success">Divalidasi</span>',
            'rejected' => '<span class="badge bg-danger">Ditolak</span>',
            'published' => '<span class="badge bg-primary">Dipublikasi</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getTimeAgoAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}