<?php

namespace Modules\Akademik\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $fillable = [
        'nama',
        'research_interest',
        'prodi',
        'foto',
    ];

    // Relationships
    // public function profilProdi()
    // {
    //     return $this->belongsTo(ProfilProdi::class, 'id_prodi', 'id_prodi');
    // }
}
