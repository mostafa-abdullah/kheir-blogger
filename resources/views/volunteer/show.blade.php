@extends('layouts.app')

@section('content')

<h1>{{ $volunteer->name }}</h1>

    <ul>
       <li>Email: {{ $volunteer->email }}</li>
    </ul>

    <h1>Events</h1>
    <ul>
        @for ($i = 0; $i < 3 && $i < count($volunteer->events); $i++)
            <li>{{ $volunteer->events[$i]->name }}</li>
        @endfor
        @if (count($volunteer->events) > 3)
                <a href="{{ action('VolunteerController@viewEvents', [$volunteer->id])}}">
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
                    <a href="{{ action('VolunteerController@viewReviews', [$volunteer->id])}}">View More >></a>
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
@endsection
