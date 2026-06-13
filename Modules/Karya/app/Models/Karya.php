<?php

namespace Modules\Karya\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Karya extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'kategori',
        'tahun',
        'file_karya',
        'preview_karya',
        'link_pengumpulan', // ✅ TAMBAHKAN INI
        'tim_pembuat',
        'status_validasi',
        'tanggal_upload',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
