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
        @foreach($volunteer->eventReviews as $review)
            <li>{{ $review }}</li>
        @endforeach
        @foreach($volunteer->organizationReviews as $review)
            <li>{{ $review  }}</li>
        @endforeach
    </ul>

</body>
</html>
