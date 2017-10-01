<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class Openligadb
{
    private $client;
    private $baseUrl = 'https://www.openligadb.de/api/';
    private $cacheTime = 180; // 3 hours

    public function __construct()
    {
        // $this->client = new Client();
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 20.0,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Get the full lest of matches in specific league and season.
     *
     * @param string $league
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCurrentMatches(string $league)
    {
        //https://www.openligadb.de/api/getmatchdata/bl1
        return Cache::remember('current_matches', $this->cacheTime, function () use ($league) {
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
                    'location' => $item->Location,
                ];
            });
        });
    }

    /**
     * Get the full lest of matches in specific league and season.
     *
     * @param string $league
     * @param int    $season
     *
     * @return \Illuminate\Support\Collection
     */
    public function getMatches(string $league, int $season = null)
    {
        $season = $season ?? date('Y');

        return Cache::remember('season_matches_'.$league.'_'.$season, $this->cacheTime, function () use ($league, $season) {
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
                    'location' => $item->Location,
                ];
            });
        });
    }

    /**
     * Get the full lest of teams in specific league and season.
     *
     * @param string $league
     * @param int    $season
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTeams(string $league, int $season = null)
    {
        $season = $season ?? date('Y');

        return Cache::remember('season_teams_'.$league.'_'.$season, $this->cacheTime, function () use ($league, $season) {
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
