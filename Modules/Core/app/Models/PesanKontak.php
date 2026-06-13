<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class PesanKontak extends Model
{
    protected $fillable = [
        'nama_pengirim',
        'email_pengirim',
        'isi_pesan',
        'status',
        'tanggal_kirim',
    ];

    protected $casts = [
        'tanggal_kirim' => 'date',
    ];
}
