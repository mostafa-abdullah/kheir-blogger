
@extends('layouts.app')

@section('content')

<h1>{{ $volunteer->first_name }} {{ $volunteer->last_name }}</h1>

    <ul>
       <li>Email: {{ $volunteer->email }}</li>
       @if ($volunteer->phone)
           <li>Phone: {{ $volunteer->phone }}</li>
       @endif
       @if ($volunteer->address)
           <li>Address: {{ $volunteer->address }}</li>
       @endif
       @if ($volunteer->city)
           <li>City: {{ $volunteer->city }}</li>
       @endif
       @if ($volunteer->birth_date)
           <li>Age: {{ \Carbon\Carbon::parse($volunteer->birth_date)->diffInYears() }}</li>
       @endif
    </ul>
    @if ($can_update)
        {!! Form::open(['action' => ['Volunteer\VolunteerController@edit',$volunteer->id],'method'=>'get']) !!}
        <div>
           {!! Form::submit('Edit' , array('class' => 'vol-act btn btn-default' )) !!}
        </div>
        {!! Form::close() !!}
    @endif

    <h1>Events</h1>
    <ul>
        @for ($i = 0; $i < 3 && $i < count($volunteer->events); $i++)
            <li>{{ $volunteer->events[$i]->name }}</li>
        @endfor
        @if (count($volunteer->events) > 3)
                <a href="{{ action('Volunteer\VolunteerController@viewEvents', [$volunteer->id])}}">
                    View More >></a>
        @endif
    </ul>

    <h1>Reviews</h1>
    <ul>
        <h4>On Events:</h4>
        <ul>
            @for ($i = 0; $i < 3 && $i < count($volunteer->eventReviews); $i++)
                <li>{{ $volunteer->eventReviews[$i]->review }}, {{  $volunteer->eventReviews[$i]->rate}}</li>
            @endfor
            @if (count($volunteer->eventReviews) > 3)
                    <a href="{{ action('Volunteer\VolunteerController@viewReviews', [$volunteer->id])}}">View More >></a>
            @endif

        </ul>

        <h4>On Organizations:</h4>
        <ul>
            @for ($i = 0; $i < 3 && $i < count($volunteer->organizationReviews); $i++)
                <li>{{ $volunteer->organizationReviews[$i]->review}}, {{$volunteer->organizationReviews[$i]-> rate  }}</li>
            @endfor
            @if (count($volunteer->organizationReviews) > 3)
                    <a href="{{ action('VolunteerController@viewReviews', [$volunteer->id])}}">View More >></a>
            @endif
        </ul>
    </ul>

    {{--check if the logged in user is admin/validator --}}
    @if( Auth::user()->role >= 8)
            @include('admin.assign-validator')
    @endif

    @if( Auth::user()->role >= 5)
            @include('admin.ban-volunteer')
    @endif

@endsection
