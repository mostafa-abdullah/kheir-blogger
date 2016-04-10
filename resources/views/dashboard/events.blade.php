@extends('layouts.app')

@section('content')

    @if ($followedEvents)
        <h1>My Events</h1>
        <hr>
            @foreach($followedEvents as $followedEvent)
            <p>  {{$followedEvent->name}}</p>
            @endforeach
    @endif

@stop
