@extends('layouts.app')

@section('content')
    @if (!count($notifications))
        <h1>No new notifications</h1>
    @else
        <h1>Your new notifications:-</h1>
        <ul>
            @foreach($notifications as $notification)
                <li>{{ $notification->description }}</li>
            @endforeach
        </ul>
    @endif
@endsection