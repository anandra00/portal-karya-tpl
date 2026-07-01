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
    public function karyas()
    {
        return $this->hasMany(\Modules\Karya\Models\Karya::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(\Modules\Karya\Models\Review::class, 'user_id');
    }

    // Helper methods
    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    public function isMahasiswa()
    {
        return $this->role === 'user';
    }
}