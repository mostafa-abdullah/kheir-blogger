@extends('layouts.app')

@section('content')

    @if ($allEvents)
        <h1>My Events</h1>
        <hr>
            @foreach($event as $allEvents)
            <p>  {{$event->name}}</p>
            @endforeach
    @endif

@stop
