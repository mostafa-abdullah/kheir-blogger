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
                            <button class="btn btn-secondary" name="{{ $notification->id}}" type="button">mark as unread</button>
                        </div>
                        <br/>
                    </li>
                @endforeach
            </ul>
        @endif
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
