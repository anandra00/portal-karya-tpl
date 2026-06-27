<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships
    // public function karyas()
    // {
    //     return $this->hasMany(Karya::class, 'id_user', 'id_user');
    // }

    // public function reviews()
    // {
    //     return $this->hasMany(Review::class, 'id_user', 'id_user');
    // }

    // public function ratings()
    // {
    //     return $this->hasMany(Rating::class, 'id_user', 'id_user');
    // }

    // Helper methods
    // public function isAdmin()
    // {
    //     return $this->id_role === 'admin';
    // }

    // public function isMahasiswa()
    // {
    //     return $this->id_role === 'mahasiswa';
    // }
}