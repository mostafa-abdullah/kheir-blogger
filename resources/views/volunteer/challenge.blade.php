@extends('layouts.app')

@section('content')

    <h1>Challenge Yourself!</h1>
    <hr>

    {!! Form::open(['action' => ['VolunteerController@storeChallenge' , $id]]) !!}

    <div class = "form-group">
        {!! Form::label('challenge' , 'How many events will you attend this year?') !!}
        {!! Form::number('challenge' , '0' , ['class' => 'form-control']) !!}
    </div>

    <div>
        {!! Form::submit('Set Challenge' , ['class' => 'form-control']) !!}
    </div>

    {!! Form::close() !!}

    @include('errors')
@stop