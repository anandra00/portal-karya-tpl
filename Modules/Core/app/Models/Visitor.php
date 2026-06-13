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
        if (str_contains($this->user_agent, 'Chrome')) return 'Chrome';
        if (str_contains($this->user_agent, 'Firefox')) return 'Firefox';
        if (str_contains($this->user_agent, 'Safari')) return 'Safari';
        if (str_contains($this->user_agent, 'Edge')) return 'Edge';
        return 'Unknown';
    }
}
