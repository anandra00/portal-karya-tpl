<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilProdi extends Model
{
    protected $fillable = [
        'kode_prodi',
        'nama_prodi',
        'deskripsi',
        'visi',
        'misi',
        'tujuan',
        'capaian',
        'link_video',
        'logo'
    ];

    protected $primaryKey = 'kode_prodi';
    public $incrementing = false;       // karena bukan auto-increment
    protected $keyType = 'string';      // biasanya kode prodi string
}