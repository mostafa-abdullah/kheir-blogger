@extends('layouts.app')
@section('content')
    <div class="container">
       <h1>
           Event {{$event->name}}
       </h1>
        <h2>{{$event->timing->diffForHumans()}}</h2>
        <h3>Description</h3>
        <p>
            {{$event->description}}
        </p>
    </div>
@stop