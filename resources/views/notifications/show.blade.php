@extends('layouts.app')

@section('content')
    <div class="container">
        @if (!count($notifications))
            <h1>No new notifications</h1>
        @else
            <h1>Your new notifications:-</h1>
            <ul>
                @foreach($notifications as $notification)
                    <li>
                        <div>
                            <a href="{{ $notification->link }}">{{ $notification->description }}</a>
                            <br/>
                            {{ $notification->date_time }}
                            <br/>
                            <button class="btn btn-secondary" onclick="rec({{ $notification->pivot }}, this)" type="button">mark as unread</button>
                        </div>
                        <br/>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <script type="text/javascript">

        function rec(notification, objButton) {
            objButton.style.visibility = 'hidden';
            $.ajax({
                type: "GET",
                url: "notifications/" + notification.notification_id,
                success: function(data) {
                       console.log(data);
                }
            });


//            document.write("clicked<br/>");
//            notification.read = 1;
//            document.write("notifications/" + notification.notification_id + "/" + notification.user_id);
        }
    </script>
@endsection
