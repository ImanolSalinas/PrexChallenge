<?php

namespace App\Http\Controllers\UserGif;

use Illuminate\Http\Request;
use App\Services\UserGifService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserGifRequest;


class UserGifController extends Controller
{
    protected $userGifService;

    public function __construct(UserGifService $userGifService)
    {
        $this->userGifService = $userGifService;
    }

    public function store(StoreUserGifRequest $request)
    {
        $userId = $request->input('user_id');
        
        $alias = $request->input('alias');
    
        $gifId = $request->input('gif_id');
    
        try {
            $userGif = $this->userGifService->storeUserGif($userId, $gifId, $alias);
    
            return response()->json($userGif, 201);
        
        } catch (\Exception $e) {
            // Maneja errores como usuario no encontrado o cualquier otro error
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}