@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-5">
            <h2>Upcoming Matches</h2>
            @foreach ($nextMatch as $match)
                <div class="list-group">
                  <div class="list-group-item">
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <img src="{{ $match['team1']->TeamIconUrl }}"><br>
                            {{ $match['team1']->TeamName }}</div>
                        <div class="col-md-2 text-center">vs</div>
                        <div class="col-md-5 text-center">
                            <img src="{{ $match['team2']->TeamIconUrl }}"><br>
                            {{ $match['team2']->TeamName }}</div>
                    </div>
                    <p class="list-group-item-text text-center">
                        <i class="glyphicon glyphicon-time"></i>
                        {{ $match['date']->toDayDateTimeString() }}
                    </p>
                    <p class="list-group-item-text text-center">
                        <i class="glyphicon glyphicon-map-marker"></i>
                        {{ $match['location']->LocationStadium }}, {{ $match['location']->LocationCity }}
                    </p>
                  </div>
                </div>
            @endforeach
        </div>

        <div class="col-md-5 col-md-offset-2">
            <h2>Season Matches</h2>
            @foreach ($seasonMatch as $match)
                <div class="list-group">
                  <div class="list-group-item">
                    @if($match['isFinished'])
                    <div class="row">
                        <div class="col-md-5 text-center">
                            {{ $match['results']->last()->PointsTeam1 }}
                        </div>
                        <div class="col-md-2 text-center"></div>
                        <div class="col-md-5 text-center">
                            {{ $match['results']->last()->PointsTeam2 }}
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <img src="{{ $match['team1']->TeamIconUrl }}"><br>
                            {{ $match['team1']->TeamName }}</div>
                        <div class="col-md-2 text-center">vs</div>
                        <div class="col-md-5 text-center">
                            <img src="{{ $match['team2']->TeamIconUrl }}"><br>
                            {{ $match['team2']->TeamName }}</div>
                    </div>
                    <p class="list-group-item-text text-center">
                        <i class="glyphicon glyphicon-time"></i>
                        {{ $match['date']->toDayDateTimeString() }}
                    </p>
                    <p class="list-group-item-text text-center">
                        <i class="glyphicon glyphicon-map-marker"></i>
                        {{ $match['location']->LocationStadium }}, {{ $match['location']->LocationCity }}
                    </p>
                  </div>
                </div>
            @endforeach
            <p><a class="btn btn-default" href="{{ url('/matches') }}" role="button">View more »</a></p>
       </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2>Win/Loss Ratio of each team</h2>
            <div class="panel panel-default">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Team Name</th>
                            <th>Win</th>
                            <th>Loss</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teamsWinLoss as $team)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $team['icon'] }}">
                                {{ $team['name'] }}
                            </td>
                            <td>{{ $team['win'] }}</td>
                            <td>{{ $team['loss'] }}</td>
                            <td class="{{ ($team['ratio']>0)?'text-success':'text-danger' }}">{{ round($team['ratio']* 100, 2) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
@endsection
