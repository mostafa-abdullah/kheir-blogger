<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Volunteer</title>
</head>
<body>
    <h1>{{ $volunteer-> name }}</h1>

    <ul>
       <li>{{ $volunteer -> email }}</li>
        <li>{{ $volunteer ->  id}}</li>
    </ul>

    <h1>Events</h1>
    <ul>
        @foreach($events as $event)
            <li>{{ $event }}</li>
        @endforeach
    </ul>

</body>
</html>