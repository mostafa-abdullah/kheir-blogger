@extends('layouts.app')

@section('content')

    <h1>Current Challenge</h1>
    <hr>
    <p>This year, You attended {{$currentChallenge->attendedEvents}}/{{$currentChallenge->events}} events</p>


    {!! Form::open(['method' => 'get' , 'url' => 'volunteer/challenge/attended']) !!}

    <div>
        {!! Form::submit('View Attended Events' , ['class' => 'btn btn-secondary']) !!}
    </div>

    {!! Form::close() !!}


    {!! Form::open(['method' => 'get' , 'url' => 'volunteer/challenge/edit']) !!}

    <div>
        {!! Form::submit('Edit Challenge' , ['class' => 'btn btn-secondary']) !!}
    </div>

    {!! Form::close() !!}


    <br>
    <br>
    <br>

    <h1>Previous Challenges</h1>
    <hr>
    @foreach($previousChallenges as $previousChallenge)
        <p> In {{$previousChallenge->year}}: You attended {{$previousChallenge->attendedEvents}}/{{$previousChallenge->events}} events</p>
    @endforeach

@stop