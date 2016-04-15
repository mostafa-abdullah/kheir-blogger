@extends('layouts.app')

@section('content')

    <h1>Challenge Yourself!</h1>
    <hr>

    {!! Form::open(['action' => ['Volunteer\ChallengeController@store']]) !!}

    <div class = "form-group">
        {!! Form::label('events' , 'How many events will you attend?') !!}
        {!! Form::number('events' , '0' , ['class' => 'form-control']) !!}
    </div>

    <div>
        {!! Form::submit('Set Challenge' , ['class' => 'form-control']) !!}
    </div>

    {!! Form::close() !!}

    @include('errors')
@stop
