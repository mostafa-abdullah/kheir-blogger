@extends('layouts.app')

@section('content')
    <h1>Search results for <em>{{ $searchText }}</em></h1>

    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#events" aria-controls="events" role="tab" data-toggle="tab">Events</a></li>
        <li role="presentation"><a href="#organizations" aria-controls="organizations" role="tab" data-toggle="tab">Organizations</a></li>
    </ul>
    <br>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="events">
            @foreach ($events as $event)
                <div class="container">
                <h3>
                    <a href="url('/event/'.{{$event->id}})">{{$event->name}}</a>
                    <small>{{$event->location}}</small>
                </h3>
                    <div class="container">
                        <p>{{$event->description}}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div role="tabpanel" class="tab-pane" id="organizations">
            @foreach ($organizations as $organization)
                <div class="container">
                <h3>
                    <a href="url('/organization/'.{{$organization->id}})">{{$organization->name}}</a>
                    <small>{{$organization->slogan}}</small>
                </h3>
                    <div class="container">
                        <p>email: {{$organization->email}}</p>
                        <p>location: {{$organization->location}}</p>
                        <p>phone: {{$organization->phone}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
