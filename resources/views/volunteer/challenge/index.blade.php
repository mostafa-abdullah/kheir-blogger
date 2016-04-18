@extends('layouts.app')

@section('content')

    <h1>Current Challenge</h1>
    <hr>
    @if ($currentChallenge)
        <p>This year, You attended {{$currentChallenge->attendedEvents()->count()}}/{{$currentChallenge->events}} events</p>

        {!! Form::open(['method' => 'get' , 'url' => 'volunteer/challenge/achieved']) !!}
        <div>
            {!! Form::submit('View Attended Events' , ['class' => 'btn btn-secondary']) !!}
        </div>
        {!! Form::close() !!}
        <br>
        {!! Form::open(['method' => 'get' , 'url' => 'volunteer/challenge/edit']) !!}
        <div>
            {!! Form::submit('Edit Challenge' , ['class' => 'btn btn-secondary']) !!}
        </div>
        {!! Form::close() !!}
    @else
        <h3><a href="/volunteer/challenge/create">Set current year's challenge!</a></h3>
    @endif

    <br><br><br>

    <h1>Previous Challenges</h1>
    <hr>
    @foreach($previousChallenges as $previousChallenge)
        <p> In {{$previousChallenge->year}}: You attended {{$previousChallenge->attendedEvents()->count()}}/{{$previousChallenge->events}} events</p>
    @endforeach

@stop
