<?php
    $canReview = Auth::user() && Auth::user()->role > 0
              && Auth::user()->attendedEvents()->find($event->id);
?>

<div class="tab-body" id="reviews" hidden>
    @if ($canReview)
        @include('event.partials.button', ['buttonText' => 'Review and Rate!', 'action' => 'review/create'])
    @endif
    @if(!count($reviews))
        <h3 class="alert-info">This Event has no Reviews</h3>
    @else
    @foreach($reviews as $review)
        <?php $volunteer = \App\User::findOrFail($review->user_id) ?>
        <div class="jumbotron">
            <h3>
                {{$review->review}}
                <small>{{$volunteer->first_name}} {{$volunteer->last_name}}</small>
            </h3>
            Rate: {{$review->rating}}
            @if (Auth::user() && Auth::user()->eventReviews()->find($review->id))
                <a href="/event/{{$event->id}}/review/{{$review->id}}/edit">edit</a>
                .
            @endif
            @if (Auth::user())
                <a href="/event/{{$event->id}}/review/{{$review->id}}/report">report</a>
            @endif
            @if(Auth::user() && Auth::user()->role >= 5)
                <form action="{{ url('event/'.$event->id.'/review/'.$review->id) }}" method="POST">
                     {!! csrf_field() !!}
                     {!! method_field('DELETE') !!}
                     <button type="submit" class="btn btn-danger btn-event">Delete</button>
                </form>
            @endif

        </div>
    @endforeach
    @endif
</div>
