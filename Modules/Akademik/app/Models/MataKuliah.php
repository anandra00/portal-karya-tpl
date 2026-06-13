<?php

namespace Modules\Akademik\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'kode_matkul',
        'nama_matkul',
        'sks_teori',
        'sks_praktik',
        'semester'
    ];
}
