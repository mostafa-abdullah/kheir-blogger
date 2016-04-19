<?php
    $canReview = Auth::user() && Auth::user()->role > 0 && Auth::user()->attendedEvents()->find($event->id);
?>

<div class="tab-body" id="reviews" hidden>
    @if ($canReview)
        @include('event.partials.button', ['buttonText' => 'Review and Rate!', 'action' => 'review/create'])
    @endif
    @if($reviews->count()==0)
        <h3 class="alert-info">This Event has no Reviews</h3>
    @else
    @foreach($reviews as $review)
        <?php $volunteer = \App\User::findOrFail($review->user_id) ?>
        <div class="jumbotron">
            <h3>
                {{$review->review}}
                <small>{{$volunteer->first_name}} {{$volunteer->last_name}}</small>
            </h3>
            Rate: {{$review->rate}}
            @if (Auth::user())
                <a href="/event/{{$event->id}}/review/{{$review->id}}/report">report</a>
            @endif
            @if (Auth::user()->role == 5)
                <a href="/event/{{$event->id}}/review/{{$review->id}}/destroy">delete</a>
            @endif

        </div>
    @endforeach
    @endif
</div>
