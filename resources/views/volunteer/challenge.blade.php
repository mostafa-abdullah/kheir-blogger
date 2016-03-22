@extends('layouts.app')

@section('content')

    <h1>Challenge Yourself!</h1>
    <hr>

    {!! Form::open(['action' => ['VolunteerController@storeChallenge']]) !!}

    <div class = "form-group">
        {!! Form::label('events' , 'How many events will you attend?') !!}
        {!! Form::number('events' , '0' , ['class' => 'form-control']) !!}
    </div>

    <div class = "form-group">
        {!! Form::label('deadline' , 'Before this date') !!}
        {!! Form::date('deadline' , date('Y-d-m') , ['class' => 'form-control']) !!}
    </div>

    <div>
        {!! Form::submit('Set Challenge' , ['class' => 'form-control']) !!}
    </div>

    {!! Form::close() !!}

    @include('errors')
@stop