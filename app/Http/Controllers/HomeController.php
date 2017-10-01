<?php

namespace App\Http\Controllers;

use App\Repositories\League;

class HomeController extends Controller
{
    public function index(League $league)
    {
        return view('welcome', [
            'nextMatch' => $league->nextMatches(),
            'seasonMatch' => $league->seasonMatches()->slice(0, 5),
        ]);
    }
}
