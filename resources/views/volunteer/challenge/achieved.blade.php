@extends('layouts.app')

@section('content')

    <h1>Attended Events</h1>
    <hr>

    @foreach($events as $event)
        <p>{{ $event->name }}</p>
    @endforeach

@stop
