<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GiphyService
{
    protected $apiKey;
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.giphy.api_key');
        $this->apiBaseUrl = config('services.giphy.api_base_url');
    }
    public function searchGifs($query, $limit = 10, $offset = 0, $rating = 'g', $lang = 'en', $bundle = 'messaging_non_clips')
    {
        try {
            $url = $this->apiBaseUrl . "/search";
            
            $response = Http::get($url, [
                'api_key' => $this->apiKey,
                'q' => $query,
                'limit' => $limit,
                'offset' => $offset,
                'rating' => $rating,
                'lang' => $lang,
                'bundle' => $bundle,
            ]);
            
            if ($response->ok()) {
                return $response->json()['data']; 
            } 
                
            throw new \Exception('Error fetching GIFs from Giphy API.');
            
        } catch (\Exception $e) {
            throw new \Exception('Error fetching GIFs from Giphy API: ' . $e->getMessage());
        }
    }

}