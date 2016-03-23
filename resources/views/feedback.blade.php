@extends('layouts.app')


@section('content')

{!! Form::open(['action' => ['HomeController@storeFeedback']]) !!}

    <div class = "form-group">
        {!! Form::label('subject' , 'subject') !!}
        {!! Form::text('subject' , null , array('class' => 'form-control')) !!}
        {!! Form::label('message' , 'message') !!}
        {!! Form::textArea('message' , null , array('class' => 'form-control')) !!}
    </div>

    <div class = "form-group">
        {!! Form::submit('Send' , array('class' => 'btn btn-default' )) !!}
    </div>

{!! Form::close() !!}

@include('errors')

@stop
