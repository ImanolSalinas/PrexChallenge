<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'user_id', 
        'service',
        'request_body', 
        'http_code', 
        'response_body',
        'ip_origin', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}