@extends('layouts.app')

@section('content')
    <h1><a href="/organization/{{$organization->id}}">{{$organization->name}}</a>'s Events</h1>
    @foreach($events as $event)
        <div style="float: right;">
            <div>
                {{$event->timing->format('Y-m-d, H:i a')}}
            </div>
            <div>
                {{$event->location}}
            </div>
        </div>
        <h2 style="margin-top: 20px">
            <a href="{{url('event', $event->id)}}">
                {{$event->name}}
            </a>
        </h2>
        <div>{{$event->description}}</div>
        <hr style="clear:both"/>
    @endforeach
@endsection
