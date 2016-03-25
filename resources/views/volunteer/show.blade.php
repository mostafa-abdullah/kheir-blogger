<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Volunteer</title>
</head>
<body>
    <h1>{{ $volunteer->name }}</h1>

    <ul>
       <li>{{ $volunteer->email }}</li>
        <li>{{ $volunteer->id}}</li>
    </ul>

    <h1>Events</h1>
    <ul>
        @foreach($volunteer->events as $event)
            <li>{{ $event->name }}</li>
        @endforeach
    </ul>

    <h1>Reviews</h1>
    <ul>
        <h4>On Events:</h4>
        @for ($i = 0; $i < 3 && $i < count($volunteer->eventReviews); $i++)
            <li>{{ $volunteer->eventReviews[$i]->review }},{{  $volunteer->eventReviews[$i]-> rate}}</li>
        @endfor
        <h4>On Organizations:</h4>
        @for ($i = 0; $i < 3 && $i < count($volunteer->organizationReviews); $i++)
            <li>{{ $volunteer->organizationReviews[$i]-> review}}, {{$volunteer->organizationReviews[$i]-> rate  }}</li>
        @endfor
    </ul>

</body>
</html>
