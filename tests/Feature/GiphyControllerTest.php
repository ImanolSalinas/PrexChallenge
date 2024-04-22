<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GiphyControllerTest extends TestCase
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
    public function it_can_search_gifs()
    {
        // Realiza la solicitud con el token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/get-gifs', ['query' => 'funny cats', 'limit' => '3']);

        // Verifica la estructura de la respuesta
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => [
                         'type',
                         'id',
                         'url',
                         'slug',
                         'images' => [
                             'original' => [
                                 'url',
                             ],
                         ],
                     ],
                 ]);
    }

    /** @test */
    public function it_can_show_a_single_gif_by_id()
    {
        // ID de un GIF para realizar la solicitud
        $gifId = 'qjtqEScZudXnnbnbz4';

        // Realiza la solicitud con el token y el ID del GIF
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/get-gif', ['id' => $gifId]);

        // Verifica que la respuesta tiene un código de estado 200
        $response->assertStatus(200);

        // Verifica que la respuesta JSON tiene la estructura esperada
        $response->assertJsonStructure([
            'type',
            'id',
            'url',
            'slug',
            'bitly_gif_url',
            'bitly_url',
            'embed_url',
            'username',
            'source',
            'title',
            'rating',
            'content_url',
            'source_tld',
            'source_post_url',
            'is_sticker',
            'import_datetime',
            'trending_datetime',
            'images' => [
                'original' => [
                    'height',
                    'width',
                    'size',
                    'url',
                    'mp4_size',
                    'mp4',
                    'webp_size',
                    'webp',
                    'frames',
                    'hash',
                ],
                'fixed_height',
                'fixed_height_downsampled',
                'fixed_height_small',
                'fixed_width',
                'fixed_width_downsampled',
                'fixed_width_small',
            ],
            'user' => [
                'avatar_url',
                'banner_image',
                'banner_url',
                'profile_url',
                'username',
                'display_name',
                'description',
                'instagram_url',
                'website_url',
                'is_verified',
            ],
            'analytics_response_payload',
            'analytics' => [
                'onload' => [
                    'url',
                ],
                'onclick' => [
                    'url',
                ],
                'onsent' => [
                    'url',
                ],
            ],
            'alt_text',
        ]);
    }

    /** @test */
    public function it_handles_not_found_gif()
    {
        $gifId = 'nonexistent';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/get-gif', ['id' => $gifId]);

        $response->assertStatus(200)->assertJson([
            'meta' => [
                'status' => 404,
                'msg' => "Not Found",
            ]
        ]);
    }


    /** @test */
    public function it_requires_authentication_for_searching_gifs()
    {
        $response = $this->json('GET', '/api/get-gifs', ['query' => 'funny cats']);

        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);
    }
}