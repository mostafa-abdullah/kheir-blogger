@extends('layouts.app')

<header>
    <title>{{$organization->name}}</title>
</header>
@section('content')
    <div class = "form-group">
        <h1>{{$organization->name}}</h1>
        <h2>slogan:</h2>
        <h3>{{$organization->slogan}}</h3>
        <h2>bio:</h2>
        <h3>{{$organization->bio}}</h3>
        <h2>location:</h2>
        <h3>{{$organization->location}}</h3>
        <h2>phone:</h2>
        <h3>{{$organization->phone}}</h3>
        <h2>rate:</h2>
        @if($organization->rate)
        <h3>{{$organization->rate}}</h3>
            @else
            <h3>No rate yet!</h3>
            @endif
    <div class = "form-group">
    <div></div>
       @if($state==3)
    {!! Form::open(['action' => ['VolunteerController@subscribe',$organization->id],'method'=>'get']) !!}
    <div >
        {!! Form::submit('Subscribe' , array('class' => 'btn btn-default' )) !!}
    </div>

    {!! Form::close() !!}
       @elseif($state==2)
       {!! Form::open(['action' => ['VolunteerController@unsubscribe',$organization->id],'method'=>'get']) !!}
       <div >
           {!! Form::submit('Unsubscribe' , array('class' => 'btn btn-default' )) !!}
       </div>

       {!! Form::close() !!}
       @endif
    </div>
        @if($state==2 || $state==3)
        <div class = "form-group">
            <h1><a href="{{action('OrganizationController@recommend',[$organization->id])}}">Recommend</a></h1>
            </div>
            @endif
    @include('errors')

@stop