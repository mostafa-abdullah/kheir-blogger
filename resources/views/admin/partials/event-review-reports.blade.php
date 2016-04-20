@foreach($event_reviews_reports as $event_review_report)
    @if($event_review_report->viewed == $view_state)
        <div>
            <div class="col-sm-2">
                <a href="{{url('volunteer',$event_review_report->volunteer->id)}}">
                    {{$event_review_report->volunteer->first_name}}
                    {{$event_review_report->volunteer->last_name}}
                </a>
            </div>

            <div class="col-sm-1">
                <a href="{{url('event',$event_review_report->event->id)}}">
                    {{$event_review_report->event->name}}
                </a>
            </div>

            <div class="col-sm-2">
                {!! Form::open(array('action' => array('AdminController@toggleEventReviewReportViewed',
                        $event_review_report->id))) !!}
                    @if(!$event_review_report->viewed)
                        {!! Form::submit('mark viewed' , array('class' => 'vol-act btn btn-default' )) !!}
                    @else
                        {!! Form::submit('mark unviewed' , array('class' => 'vol-act btn btn-default' )) !!}
                    @endif
                {!! Form::close() !!}

            </div>
        </div>
    @endif
@endforeach
