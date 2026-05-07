<?php

use App\Http\Controllers\ManualSlideController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ScreenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('slides.index');
});

Route::resource('slides', ManualSlideController::class);
Route::resource('screens', ScreenController::class);

Route::get('/player/{screen:slug}', [PlayerController::class, 'show'])
    ->name('player.show');
