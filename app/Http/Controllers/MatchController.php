<?php

namespace App\Http\Controllers;

use App\Repositories\League;

class MatchController extends Controller
{
    public function index(League $league)
    {
        return view('match.index', [
            'matches' => $league->seasonMatches(),
        ]);
    }
}
