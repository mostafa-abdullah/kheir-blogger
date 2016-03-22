@extends('layouts.app')

@section('content')

    <h1>Edit your Challenge</h1>
    <hr>

    {!! Form::model($challenge , ['method' => 'PATCH' ,
                                  'action' => ['VolunteerController@updateChallenge' , $challenge_id]]) !!}

    <div class = "form-group">
        {!! Form::label('events' , 'Edit the number of events') !!}
        {!! Form::number('events' , $challenge->events , ['class' => 'form-control']) !!}
    </div>

    <div class = "form-group">
        {!! Form::label('deadline' , 'Adjust your deadline') !!}
        {!! Form::date('deadline' , $challenge->deadline , ['class' => 'form-control']) !!}
    </div>

    <div>
        {!! Form::submit('Edit Challenge' , ['class' => 'form-control']) !!}
    </div>

    {!! Form::close() !!}


@stop
