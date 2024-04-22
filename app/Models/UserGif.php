<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserGif extends Model
{
    protected $fillable = [
        'user_id', 
        'alias',
        'gif_id', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
