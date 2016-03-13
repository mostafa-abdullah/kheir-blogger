@extends('layouts.app')
@section('content')
    <div class="container">
       <h1 class="col-md-7">
           {{$event->name}}
       </h1>
        <br>
        <h3 >the event will be held on  {{$event->timing->format('Y-m-d')}}</h3>
        <br><br>
        <h3 class="text-center"> Description</h3>
        <p class="text-center">
            {{$event->description}}
        </p>
    </div>
@stop