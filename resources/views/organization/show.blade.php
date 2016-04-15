@extends('layouts.app')

@section('styling')
    <style media="screen">
        .jumbotron h1{
            text-align: center;
        }

        .vol-act{
            float: right;
            background-color: orange;
            width: 120px;
        }
    </style>
@endsection

@section('content')
    @include('errors')
    <div class="jumbotron">
        <h1>{{$organization->name}}</h1>
        @if($state==3)
             {!! Form::open(['url' => '/organization/'.$organization->id.'/subscribe','method'=>'get']) !!}
             <div>
                {!! Form::submit('Subscribe' , array('class' => 'vol-act btn btn-default' )) !!}
             </div>
             {!! Form::close() !!}
        @elseif($state==2)
             {!! Form::open(['url' => '/organization/'.$organization->id.'/unsubscribe','method'=>'get']) !!}
             <div>
                {!! Form::submit('Unsubscribe' , array('class' => 'vol-act btn btn-default' )) !!}
             </div>
             {!! Form::close() !!}
        @endif
        @if($state==2 || $state==3)
            {!! Form::open(['url' => '/organization/'.$organization->id.'/recommend','method'=>'get']) !!}
            <div>
                {!! Form::submit('Recommend' , array('class' => 'vol-act btn btn-default' )) !!}
            </div>
            {!! Form::close() !!}
        @endif
        @if($state >= 2 && !$blocked)
            {!! Form::open(['url' => '/organization/'.$organization->id.'/block','method'=>'get']) !!}
            <div>
                {!! Form::submit('Block' , array('class' => 'vol-act btn btn-default' )) !!}
            </div>
            {!! Form::close() !!}
        @endif

        @if($state >= 2 && $blocked)
            {!! Form::open(['url' => '/organization/'.$organization->id.'/unblock','method'=>'get']) !!}
            <div>
                {!! Form::submit('Unblock' , array('class' => 'vol-act btn btn-default' )) !!}
            </div>
            {!! Form::close() !!}
        @endif

        @if(Auth::guard('organization')->id() == $organization->id)
            {!! Form::open(['url' => '/organization/'.$organization->id.'/edit','method'=>'get']) !!}
            <div>
                {!! Form::submit('Edit Profile' , array('class' => 'vol-act btn btn-default' )) !!}
            </div>
            {!! Form::close() !!}
        @endif

        <p>Slogan: {{$organization->slogan}}</p>
        <p>Bio: {{$organization->bio}}</p>
        <p>Location: {{$organization->location}}</p>
        <p>Phone: {{$organization->phone}}</p>
        <p>Rate:
            @if($organization->rate)
                {{number_format($organization->rate, 1)}}
            @else
                No rate yet!
            @endif
        </p>
        <p>Subscribers: {{count($organization->subscribers)}}</p>
        <p>Events submitted: {{count($organization->events()->withTrashed())}}</p>
        <p>Events held: {{count($organization->events)}}</p>

        <h4>Events</h4>
        <ul>
            @for ($i = 0; $i < 3 && $i < count($organization->events); $i++)
                <li>{{$organization->events[$i]->name}}</li>
            @endfor
            @if(count($organization->events) > 1)
                    <a href="/organization/{{$organization->id}}/events">View More >></a>
            @endif

        </ul>

        <h4>Reviews</h4>
        <ul>
            @for($i = 0; $i < 3 && $i < count($organization->reviews); $i++)
                <li>{{$organization->reviews[$i]->review}}, {{$organization->reviews[$i]->rate}}</li>
            @endfor
            @if(count($organization->reviews) > 3)
                    <a href="/organization/{{$organization->id}}/reviews">View More >></a>
            @endif
        </ul>
    </div>
@stop
