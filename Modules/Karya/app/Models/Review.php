<?php

namespace Modules\Karya\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'karya_id',
        'user_id',
        'rating', // 1 - 5
        'comment',
    ];

    public function karya()
    {
        return $this->belongsTo(Karya::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
