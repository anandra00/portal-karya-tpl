<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    // Relationships
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'id_user', 'id_user');
    // }

    // public function reviews()
    // {
    //     return $this->hasMany(Review::class, 'id_karya', 'id_karya');
    // }

    // public function ratings()
    // {
    //     return $this->hasMany(Rating::class, 'id_karya', 'id_karya');
    // }

    // Helper methods
    // public function averageRating()
    // {
    //     return $this->ratings()->avg('nilai') ?? 0;
    // }

    // public function totalReviews()
    // {
    //     return $this->reviews()->where('status_moderasi', 'approved')->count();
    // }

    // public function isApproved()
    // {
    //     return $this->status_validasi === 'disetujui';
    // }