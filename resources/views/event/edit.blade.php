@extends('layouts.app')

@section('content')

    <h1>Editing Event: {{$event->name}}</h1>

    {!! Form::model($event, array( 'method' => 'PATCH','action' =>array('EventController@update',$event->id))) !!}
        @include('event.form', ['submitButtonText' => 'Update Event'])
    {!! Form::close() !!}
    @include('errors')
@stop
