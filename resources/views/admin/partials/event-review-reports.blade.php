<div class="row">
    <div class="col-sm-2">Reviewer</div>
    <div class="col-sm-2">Event</div>
    <div class="col-sm-2">Review</div>
    <div class="col-sm-2">Action</div>
</div>

@foreach($reported_event_reviews as $reported_event_review)
    <div class="row">
        <div class="col-sm-2">
            <a href="{{url('volunteer',$reported_event_review->volunteer->id)}}">
                {{$reported_event_review->volunteer->first_name}}
                {{$reported_event_review->volunteer->last_name}}
            </a>
        </div>

        <div class="col-sm-2">
            <a href="{{url('event',$reported_event_review->event->id)}}">
                {{$reported_event_review->event->name}}
            </a>
        </div>

        <div class="col-sm-2">
            <a href="{{url('event/'.$reported_event_review->event->id.'/review/'.$reported_event_review->id)}}">
                View review
            </a>
        </div>

        <div class="col-sm-2">
            {!! Form::open(array('action' => array('AdminController@toggleEventReviewReportViewed',
                    $reported_event_review->id))) !!}
                @if(!$reported_event_review->viewed)
                    {!! Form::submit('mark viewed' , array('class' => 'vol-act btn btn-default' )) !!}
                @else
                    {!! Form::submit('mark unviewed' , array('class' => 'vol-act btn btn-default' )) !!}
                @endif
            {!! Form::close() !!}
        </div>
    </div>
@endforeach
