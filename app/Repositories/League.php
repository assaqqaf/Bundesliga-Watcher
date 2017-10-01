<?php

namespace App\Repositories;

class League
{
    private $repository;

    public function __construct()
    {
        $this->repository = new Openligadb();
    }

    public function nextMatches()
    {
        return $this->repository->getCurrentMatches('bl1')->where('isFinished', false);
    }

    public function seasonMatches()
    {
        return $this->repository->getMatches('bl1');
    }

    public function teamsWinLossRatio()
    {
        $teams = $this->repository->getTeams('bl1')->toArray();

        $this->repository->getMatches('bl1', date('Y'))
            ->map(function ($item, $key) use (&$teams) {
                if (!$item['isFinished']) {
                    return false;
                }

                $result = $item['results']->last();

                if ($result->PointsTeam1 > $result->PointsTeam2) {
                    $teams[$item['team1']->TeamId]['win'] += 1;
                    $teams[$item['team2']->TeamId]['loss'] += 1;
                } elseif ($result->PointsTeam1 < $result->PointsTeam2) {
                    $teams[$item['team2']->TeamId]['win'] += 1;
                    $teams[$item['team1']->TeamId]['loss'] += 1;
                }

                return false;
            });

        return collect($teams)->transform(function ($item, $key) {
            return $item + [
                'ratio' => ($item['win'] - $item['loss']) / ($item['win'] + $item['loss']),
            ];
        })
        ->sortByDesc('ratio');
    }
}
