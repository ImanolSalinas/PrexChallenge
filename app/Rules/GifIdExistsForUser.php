<?php

namespace App\Rules;

use App\Models\UserGif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class GifIdExistsForUser implements Rule
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }
    
    public function passes($attribute, $value)
    {  
        return !UserGif::where('user_id', $this->userId)->where('gif_id', $value)->exists(); 
    }

    public function message()
    {
        return 'The :attribute already exists for this user.';
    }
}