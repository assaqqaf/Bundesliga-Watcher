<?php

namespace App\Http\Controllers;

use App\Repositories\League;

class TeamController extends Controller
{
    public function index(League $league)
    {
        return view('team.index', [
            'teams' => $league->teamsWinLossRatio(),
        ]);
    }
}
