@extends('layouts.app')

@section('content')
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
                        @foreach($teams as $team)
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
