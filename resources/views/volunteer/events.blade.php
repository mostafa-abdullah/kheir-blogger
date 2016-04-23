@extends('layouts.app')

@section('content')

    @if ($followedAndRegisteredAndReEvents)
        <h1>My Events</h1>
        <hr>
            @foreach($followedAndRegisteredEvents as $followedAndRegisteredEvent)
            <p>  {{$followedAndRegisteredEvent->name}}</p>
            @endforeach
    @endif

@stop
