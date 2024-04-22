<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GiphyIdService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.giphy.api_key');
        $this->apiBaseUrl = config('services.giphy.api_base_url');
    }

    public function getGifById($gifId)
    {
        try {
            $url = $this->apiBaseUrl . "/{$gifId}";
            
            $response = Http::get($url, [
                'api_key' => $this->apiKey,
                'rating' => 'g' 
            ]);
    
            if ($response->ok()) {
                return $response->json()['data']; 
            } else {
                return $response->json();
            }
        } catch (\Exception $e) {
            throw new \Exception('Error fetching GIF from Giphy API: ' . $e->getMessage());
        }
    }
}