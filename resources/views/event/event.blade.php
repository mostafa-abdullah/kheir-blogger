@extends('layouts.app')
@section('content')
    <div class="container">
       <h1 class="col-md-7">
           {{$event->name}}
       </h1>
        <br>
        <div class="col-md-5">
            @if($event->timing < Carbon\Carbon::now())
                <h3>
                    This event was on  {{$event->timing->format('Y-m-d')}}
                </h3>
                <h4>( {{$event->timing->diffForHumans()}} ).</h4>
            @else
                <h3>
                    the event will be held on  {{$event->timing->format('Y-m-d')}}
                </h3>
                <h4>{{$event->timing->diffForHumans()}}</h4>
            @endif
        </div>
        <br><br>
        <h3 class="text-center"> Description</h3>
        <p class="text-center">
            {{$event->description}}
        </p>
        <div class="col-md-7">
            <h1>Announcements</h1>
             @foreach($announcement as $element)
                 <ul>
                     <li>{{$element}}</li>
                 </ul>
             @endforeach
        </div>
    </div>
@stop