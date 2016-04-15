@extends('layouts.app')

@section('content')

    <h1>Editing Event: {{$event->name}}</h1>

    {!! Form::model($event, array( 'method' => 'PATCH','action' =>array('Event\EventController@update',$event->id))) !!}
        @include('event.partials.form', ['submitButtonText' => 'Update Event'])
    {!! Form::close() !!}
    @include('errors')
@stop
