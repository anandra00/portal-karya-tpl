<?php

namespace Modules\Akademik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\User;

class Berita extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'tanggal_publikasi',
        'user_id',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTanggalRelatifAttribute()
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $diff = Carbon::parse($this->tanggal_publikasi)->diffInDays(now());
        
        if ($diff == 0) {
            return 'Hari ini';
        } elseif ($diff == 1) {
            return '1 hari yang lalu';
        } elseif ($diff < 30) {
            return $diff . ' hari yang lalu';
        } else {
            $date = Carbon::parse($this->tanggal_publikasi);
            return $date->day . ' ' . $months[$date->month] . ' ' . $date->year;
        }
    }

    public function getExcerptAttribute()
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->isi), 150, '...');
    }
}
