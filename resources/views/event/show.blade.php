@extends('layouts.app')

@section('styling')
    <style media="screen">
        #cancel-event{
            float: right;
        }
    </style>
@endsection
@section('content')
    <div class="panel panel-default">
       <div class="panel-heading">

           <h1>
               @if($creator)
                 <form action="{{ url('event/'.$event->id) }}" method="POST">
                      {!! csrf_field() !!}
                      {!! method_field('DELETE') !!}

                      <button type="submit" class="btn btn-danger" id="cancel-event">
                      <i class="fa fa-trash"></i> Cancel
                      </button>
                 </form>
                @endif
            {{$event->name}}
               <small>
                   @if($event->timing < Carbon\Carbon::now())
                        This event was on {{$event->timing}}
                       ({{$event->timing->diffForHumans()}}).
                   @else
                        This event will be held on  {{$event->timing->format('Y-m-d')}}
                        ({{$event->timing->diffForHumans()}}).
                   @endif
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
          <li role="presentation" id="reviews-tab"><a href="#">Gallery</a></li>
       </ul>

        <div class="container panel-body">
            <div class="tab-body" id="posts">
                @if($posts->count()==0)
                 <h3 class="alert-info">This Event has no posts</h3>
                @else
                 @foreach($posts as $post)
                     <ul>
                         <li>{{$post->description}}</li>
                     </ul>
                 @endforeach
                @endif
            </div>

            <div class="tab-body" id="questions" hidden>
                @if($questions->count()==0)
                    <h3 class="alert-info">This Event has no answered Questions</h3>
                @else
                @foreach($questions as $question)
                    <ul>
                        <li>{{$question->question_body .'?'}}</li>
                        <h6>by {{\App\User::findOrFail($question->user_id)->name}}</h6>
                         <h4>{{$question->answer}}</h4>
                    </ul>
                @endforeach
                @endif
            </div>

            <div class="tab-body" id="reviews" hidden>
                @if($reviews->count()==0)
                    <h3 class="alert-info">This Event has no Reviews</h3>
                @else
                @foreach($reviews as $review)
                    <div class="jumbotron">

                        <h3>
                            {{$review->review}}
                        </h3>
                            <h5>By {{\App\User::findOrFail($review->user_id)->name}}</h5>
                    </div>
                @endforeach
                @endif
            </div>
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
        });
    </script>
@endsection
