<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\UserGif;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserGifControllerTest extends TestCase
{
    use WithFaker;

    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        $userCredentials = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $loginResponse = $this->json('POST', '/api/login', $userCredentials);

        $loginResponse->assertStatus(200);

        $this->token = $loginResponse->json('token');
    }

     /** @test */
     public function test_it_can_save_favourite_user_gif()
     {
         
        $gifId = 'qjtqEScZudXnnbnbz4';
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', '/api/favourite-gif', ['user_id' => 1, 'gif_id' => $gifId, 'alias' => 'alias_test']);
    
        $response->assertStatus(201);
    
        $response->assertJsonStructure([
            'gif_id',
            'alias',
            'user_id',
            'updated_at',
            'created_at',
            'id',
        ]);
    
        $response->assertJson([
            'gif_id' => $gifId,
            'alias' => 'alias_test',
            'user_id' => 1,
        ]);

        UserGif::where('user_id', 1)->where('gif_id', $gifId)->delete();
    }

    /** @test */
    public function test_it_cannot_save_favourite_user_gif_with_nonexistent_gif_id()
    {
       
        $nonexistentGifId = 'nonexistent_gif_id';
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', '/api/favourite-gif', ['user_id' => 1, 'gif_id' => $nonexistentGifId, 'alias' => 'alias_test']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'gif_id',
            ],
        ]);

        $response->assertJson([
            'message' => 'The gif id does not exist on Giphy.',
            'errors' => [
                'gif_id' => [
                    'The gif id does not exist on Giphy.',
                ],
            ],
        ]);
    }

    public function test_it_cannot_save_favourite_user_gif_with_existing_gif_id()
    {
        $gifId = 'qjtqEScZudXnnbnbz4';

        UserGif::create([
            'user_id' => 1,
            'gif_id' => $gifId,
            'alias' => 'alias_test',
        ]);
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('POST', '/api/favourite-gif', ['user_id' => 1, 'gif_id' => $gifId, 'alias' => 'alias_test']);

        // Verifica el código de estado HTTP 400 para la solicitud fallida
        $response->assertStatus(422);

        // Verifica la estructura de la respuesta de error
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'gif_id',
            ],
        ]);

        // Verifica el mensaje de error específico
        $response->assertJson([
            'message' => 'The gif id already exists for this user.',
            'errors' => [
                'gif_id' => [
                    'The gif id already exists for this user.',
                ],
            ],
        ]);

        UserGif::where('user_id', 1)->where('gif_id', $gifId)->delete();


    }


}