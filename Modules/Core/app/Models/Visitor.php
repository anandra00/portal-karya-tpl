<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Visitor extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'ip_address',
        'user_agent',
        'page_visited',
        'visited_at'
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function getTimeAgoAttribute()
    {
        return Carbon::parse($this->visited_at)->diffForHumans();
    }

    public function getBrowserAttribute()
    {
        $ua = $this->user_agent ?? '';
        if (str_contains($ua, 'Edge') || str_contains($ua, 'Edg')) return 'Edge';
        if (str_contains($ua, 'OPR') || str_contains($ua, 'Opera')) return 'Opera';
        if (str_contains($ua, 'Firefox')) return 'Firefox';
        if (str_contains($ua, 'Chrome')) return 'Chrome';
        if (str_contains($ua, 'Safari')) return 'Safari';
        return 'Lainnya';
    }

    public function getDeviceAttribute()
    {
        $ua = $this->user_agent ?? '';
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) {
            return 'Tablet';
        }
        if (preg_match('/(mobi|ipod|iphone|blackberry|opera mini|opera mobi)/i', $ua)) {
            return 'Mobile';
        }
        return 'Desktop';
    }
}
