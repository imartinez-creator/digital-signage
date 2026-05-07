<?php

namespace App\Http\Controllers;

use App\Models\Screen;

class PlayerController extends Controller
{
    public function show(Screen $screen)
    {
        return view('player.show', compact('screen'));
    }
}


