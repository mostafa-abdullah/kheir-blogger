@extends('layouts.app')

@section('content')
    <div class="container">
        @if (!count($newNotifications))
            <h1>No new notifications</h1>
        @else
            <h1>Your new notifications:-</h1>
            <ul>
                @foreach($newNotifications as $notification)
                    <li>
                        <div>
                            <a href="{{ url($notification->link) }}">{{ $notification->description }}</a>
                            <br/>
                            {{ $notification->date_time }}
                            <br/>
                        </div>
                        <br/>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <hr>
    <div class="container">
        <h1>Older Notifications</h1>
        <ul>
            @foreach($oldNotifications as $notification)
                <li>
                    <div>
                        <a href="{{ url($notification->link) }}">{{ $notification->description }}</a>
                        <br/>
                        {{ $notification->date_time }}
                        <br/>
                        <button class="btn btn-secondary" name="{{ $notification->id}}" type="button">mark as unread</button>
                    </div>
                    <br/>
                </li>
            @endforeach
        </ul>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript">

    $(document).ready(function(){
        $("button").click(function(){
            $(this).hide();
            var notification_id = $(this).attr("name");
            $.ajax({
                type: "POST",
                url: "notifications",
                data: {'notification_id': notification_id},
                success: function(data) {
                       console.log(data);
                }
            });
        });
    });
    </script>
@endsection
