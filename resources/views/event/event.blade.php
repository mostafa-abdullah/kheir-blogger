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

        <div class="col-md-5">
            <h3>Questions and answers</h3>
            @foreach($questions as $question)
                <ul>
                    <li>{{$question['question'] .'?'}}</li>
                     <h4>{{$question['answer']}}</h4>
                </ul>
            @endforeach
        </div>
        <div class="col-md-5">
            <h3>Reviews</h3>
            @foreach($reviews as $review)
                <div class="jumbotron">

                    <h3>
                        {{$review['Body']}}
                    </h3>
                        <h5>By {{$review['writen_by']}}</h5>

                </div>
            @endforeach
        </div>

        <div class ="col-md-5">

        </div>
    </div>
@stop