<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LogUserActions;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Giphy\GiphyController;
use App\Http\Controllers\UserGif\UserGifController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->get('/get-gifs', [GiphyController::class, 'index'])->name('search_gifs')->middleware(LogUserActions::class);
Route::middleware('auth:api')->get('/get-gif', [GiphyController::class, 'show'])->name('search_gif')->middleware(LogUserActions::class);
Route::middleware('auth:api')->post('/favourite-gif', [UserGifController::class, 'store'])->name('UserGifService')->middleware(LogUserActions::class);
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware(LogUserActions::class);

