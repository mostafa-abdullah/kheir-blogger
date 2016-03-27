@extends('layouts.app')

@section('content')
    <h1>Did you attend the event?</h1>

    <p>
        <a href="{{ action('EventController@attend', [$id])}}">Yes</a>
        <a href="{{ action('EventController@unattend', [$id])}}">No</a>
    </p>
@endsection
