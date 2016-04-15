@extends('layouts.app')

@section('styling')
    <style media="screen">
        .btn-event{
            float: right;
            margin: 3px;
        }
    </style>
@endsection
@section('content')
    <div class="panel panel-default">
       <div class="panel-heading">

           <h1>
               {{--  Cancel Event --}}
               @if($creator)
                 <form action="{{ url('event/'.$event->id) }}" method="POST">
                      {!! csrf_field() !!}
                      {!! method_field('DELETE') !!}
                      <button type="submit" class="btn btn-danger btn-event">Cancel</button>
                 </form>
                 @include('event.partials.button', ['buttonText' => 'Edit', 'action' => 'edit'])
                @endif
                {{--  Volunteer Interaction with events --}}
                @if(Auth::user())
                    @if($event->timing >= Carbon\Carbon::now())
                        {{--  Follow --}}
                        @if($volunteerState != 1)
                            @include('event.partials.button', ['buttonText' => 'Follow', 'action' => 'follow'])
                        @else
                            @include('event.partials.button', ['buttonText' => 'Unfollow', 'action' => 'unfollow'])
                        @endif
                         {{-- Register  --}}
                        @if($volunteerState != 2)
                            @include('event.partials.button', ['buttonText' => 'Register', 'action' => 'register'])
                        @else
                            @include('event.partials.button', ['buttonText' => 'Unregister', 'action' => 'unregister'])
                        @endif
                    @else
                        {{--  Confirm Attendance --}}
                        @if($volunteerState == 2 || $volunteerState == 4)
                            @include('event.partials.button', ['buttonText' => 'Attend', 'action' => 'attend'])
                        @endif
                        @if($volunteerState == 3)
                            @include('event.partials.button', ['buttonText' => 'Unattend', 'action' => 'Unattend'])
                        @endif
                    @endif
                @endif
            {{$event->name}}
               <small>
                   <h4>
                       @if($event->timing < Carbon\Carbon::now())
                            This event was on {{$event->timing}}
                           ({{$event->timing->diffForHumans()}}).
                       @else
                            This event will be held on  {{$event->timing->format('Y-m-d')}}
                            ({{$event->timing->diffForHumans()}}).
                       @endif
                   </h4>
                </small>
            </h1>
       </div>
       <div class="container panel-body">
           <h3 class="text-left">Description</h3>
           <p class="text-left container">
               {{$event->description}}
           </p>
       </div>

       <ul class="nav nav-tabs">
          <li role="presentation" class="active" id="posts-tab"><a href="#">Posts</a></li>
          <li role="presentation" id="questions-tab"><a href="#">Questions</a></li>
          <li role="presentation" id="reviews-tab"><a href="#">Reviews</a></li>
          <li role="presentation" id="gallery-tab"><a href="#">Gallery</a></li>
       </ul>

        <div class="panel-body">
            {{--  Event Posts --}}
            @include('event.post.index', ['posts' => $event->posts()->latest()->get()])
            {{--  Event Questions --}}
            @include('event.question.index', ['questions' => $event->questions()->answered()->get()])
            {{--  Event Reviews --}}
            @include('event.review.index', ['reviews' => $event->reviews])
            {{--  Event Gallery --}}
            @include('event.gallery.index')
            {{--   TODO: Kojak  --}}
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#posts-tab").click(function(){
                $("li.active").attr("class", null);
                $("#posts-tab").attr("class", "active");
                $(".tab-body").css("display", "none");
                $("#posts").css("display", "block");
            });

            $("#questions-tab").click(function(){
                $("li.active").attr("class", null);
                $("#questions-tab").attr("class", "active");
                $(".tab-body").css("display", "none");
                $("#questions").css("display", "block");
            });

            $("#reviews-tab").click(function(){
                $("li.active").attr("class", null);
                $("#reviews-tab").attr("class", "active");
                $(".tab-body").css("display", "none");
                $("#reviews").css("display", "block");
            });

            $("#gallery-tab").click(function(){
                $("li.active").attr("class", null);
                $("#gallery-tab").attr("class", "active");
                $(".tab-body").css("display", "none");
                $("#gallery").css("display", "block");
            });
        });
    </script>
@endsection
