<?php

namespace App\Http\Controllers\Giphy;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\GiphyService;
use App\Services\GiphyIdService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShowGiphyRequest;
use App\Http\Requests\IndexGiphyRequest;


class GiphyController extends Controller
{
    protected $giphyService;
    protected $giphyIdService;

    public function __construct(GiphyService $giphyService, GiphyIdService $giphyIdService)
    {
        $this->giphyService = $giphyService;
        $this->giphyIdService = $giphyIdService;
    }

    public function index(IndexGiphyRequest $request)
    {
        $query = $request->input('query');
        $limit = $request->input('limit', 10); 
        $offset = $request->input('offset', 0); 

        return response()->json($this->giphyService->searchGifs($query, $limit, $offset));
    }

    public function show(ShowGiphyRequest $request)
    {
        $gifId = $request->input('id');

        return response()->json($this->giphyIdService->getGifById($gifId));
    }
}