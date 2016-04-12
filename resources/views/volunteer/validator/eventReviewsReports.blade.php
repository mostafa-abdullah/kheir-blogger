@extends('layouts.app')

@section('content')

        <div class="container">
            @if(!count($event_reviews_reports))
                <h1> No event reviews reports found </h1>
                @else
                <h1> Events Reviews reports</h1>
                @foreach($event_reviews_reports as $event_review_report)
                    <div class="col-sm-2">
                        {!! Form::open(array('method' => 'GET','action' => array('VolunteerController@show',
                        $event_review_report->user_id))) !!}

                        {!! Form::submit('User' , array('class' => 'btn btn-link' )) !!}

                        {!! Form::close() !!}
                        </div>
                <div class="col-sm-1">

                        {!! Form::open(array('method' => 'GET','action' => array('EventReviewController@show',
                        $event_review_report->event_id,$event_review_report->review_id))) !!}

                        {!! Form::submit('review' , array('class' => 'btn btn-link' )) !!}

                        {!! Form::close() !!}
                </div>

                <div>
        {!! Form::open(array('action' => array('EventReviewController@reportViewed',$event_review_report->id))) !!}

                    {{-- check if this report is viewed  --}}
                    @if($event_review_report->viewed == 0)

                            {!! Form::submit('view' , array('class' => 'vol-act btn btn-default' )) !!}


                    @endif
                    {!! Form::close() !!}
                    </div>
                @endforeach
            @endif

        </div>
    @endsection