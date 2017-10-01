<?php

namespace App\Repositories;
use Carbon\Carbon;

class League {

	private $repository;

	public function __construct()
	{
		$this->repository = new Openligadb();
	}

	public function nextMatches ()
	{
		return $this->repository->getCurrentMatches('bl1')->where('isFinished', false);
		// return $this->repository->getMatches('bl1', date('Y'))
		// 	->filter(function ($value, $key) use(&$gameDay) {
		// 		if($value['date']->gte(Carbon::now())) {
		// 			if(is_null($gameDay)) {
		// 				$gameDay = $value['date'];
		// 			}
		// 			return true;
		// 		}

		// 		return false;
		// 		return $value['date']->gte(Carbon::now());
		// 	})
		// 	->filter(function($value, $key) use(&$gameDay) {
		// 		return $value['date']->isSameDay($gameDay);
		// 	});
	}

	public function seasonMatches ()
	{
		return $this->repository->getMatches('bl1', date('Y'));
	}

	public function teamsWinLossRatio ()
	{
		$teams = $this->repository->getTeams('bl1', date('Y'))->toArray();


		$this->repository->getMatches('bl1', date('Y'))
			->map(function ($item, $key) use(&$teams) {
			if(!$item['isFinished']) {
				return false;
			}

			$result = $item['results']->last();

			if($result->PointsTeam1 > $result->PointsTeam2) {
				$teams[$item['team1']->TeamId]['win'] += 1;
				$teams[$item['team2']->TeamId]['loss'] += 1;
			} elseif($result->PointsTeam1 < $result->PointsTeam2) {
				$teams[$item['team2']->TeamId]['win'] += 1;
				$teams[$item['team1']->TeamId]['loss'] += 1;
			}
			return false;
		});

		return collect($teams)->transform(function($item, $key) {
			return $item + [
				'ratio' => ($item['win'] - $item['loss']) / ($item['win'] + $item['loss'])
			];
		})
		->sortByDesc('ratio');
	}
}
