<?php

namespace App\Http\Controllers;

use App\Repositories\League;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index (League $league)
    {
    	return view('welcome', [
    		'nextMatch' => $league->nextMatches(),
    		'seasonMatch' => $league->seasonMatches()->slice(0,5),
    		'teamsWinLoss' => $league->teamsWinLossRatio(),
    	]);
    }
}
