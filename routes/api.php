<?php

use App\Http\Controllers\DisplayApiController;
use Illuminate\Support\Facades\Route;

Route::get('/screens/{screen:slug}/content', [DisplayApiController::class, 'show']);
