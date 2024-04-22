<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserGif;

class UserGifService
{
    protected $giphyIdService;

    public function __construct(GiphyIdService $giphyIdService)
    {
        $this->giphyIdService = $giphyIdService;
    }


    public function storeUserGif($userId, $gifId, $alias)
    {
        $user = User::find($userId);

        $gifData = $this->giphyIdService->getGifById($gifId);

        $userGif = $user->favouriteGifs()->create([
            'gif_id' => $gifId,
            'alias' => $alias,
        ]);

        return $userGif;
    }
}