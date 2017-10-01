<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class Openligadb {
	
	private $client;
	private $baseUrl = 'https://www.openligadb.de/api/';

	public function __construct()
	{
		// $this->client = new Client();
		$this->client = new Client([
		    'base_uri' => $this->baseUrl,
		    'timeout'  => 20.0,
		    'headers' => [
		    	'Accept'     => 'application/json',
		    ]
		]);
	}

	public function getCurrentMatches (string $league)
	{
		//https://www.openligadb.de/api/getmatchdata/bl1
		return Cache::remember('current_matches', 240, function () use ($league) {
		    $response = $this->client->request('GET', 'getmatchdata/'.$league);

			return collect(
				json_decode(
					(string) $response->getBody()
				)
			)->transform(function ($item, $key) {
				return [
					'id' => $item->MatchID,
					'date' => new Carbon($item->MatchDateTimeUTC, 'UTC'),
					'team1' => $item->Team1,
					'team2' => $item->Team2,
					'isFinished' => (bool) $item->MatchIsFinished,
					'results' => collect($item->MatchResults),
					'goals' => $item->Goals,
					'location' => $item->Location
				];
			});
		});
	}

	public function getMatches (string $league, int $season)
	{
		return Cache::remember('season_matches_'.$league.'_'.$season, 240, function () use ($league, $season) {
		    $response = $this->client->request('GET', 'getmatchdata/'.$league.'/'.$season);

			return collect(
				json_decode(
					(string) $response->getBody()
				)
			)->transform(function ($item, $key) {
				return [
					'id' => $item->MatchID,
					'date' => new Carbon($item->MatchDateTimeUTC, 'UTC'),
					'team1' => $item->Team1,
					'team2' => $item->Team2,
					'isFinished' => (bool) $item->MatchIsFinished,
					'results' => collect($item->MatchResults),
					'goals' => $item->Goals,
					'location' => $item->Location
				];
			});
		});
	}

	public function getTeams(string $league, int $season)
	{
		return Cache::remember('season_teams_'.$league.'_'.$season, 240, function () use ($league, $season) {
		    $response = $this->client->request('GET', 'getavailableteams/'.$league.'/'.$season);

			return collect(
				json_decode(
					(string) $response->getBody()
				)
			)->transform(function ($item, $key) {
				return [
					'id' => $item->TeamId,
					'name' => $item->TeamName,
					'shortName' => $item->ShortName,
					'icon' => $item->TeamIconUrl,
					'win' => 0,
					'loss' => 0,
				];
			})->keyBy('id');
		});
	}
}
