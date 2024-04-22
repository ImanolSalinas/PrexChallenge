<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserGif;
use Illuminate\Validation\ValidationException;

class UserGifTest extends TestCase
{

    /** @test */
    public function it_can_create_a_user_gif()
    {
        $user = User::all()->random();
  
        $gifId = substr(md5(rand()), 0, 7); 
        $alias = substr(md5(rand()), 0, 7); 

        $userGif = UserGif::create([
            'user_id' => $user->id,
            'gif_id' => $gifId,
            'alias' => $alias,
        ]);

        $this->assertDatabaseHas('user_gifs', [
            'user_id' => $user->id,
            'gif_id' => $gifId,
            'alias' => $alias,
        ]);
    }

}
