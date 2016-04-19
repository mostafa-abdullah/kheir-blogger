@extends('layouts.app')

@section('content')

        <div class="container">

                <!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
<li role="presentation" class="active"><a href="#unViewed" aria-controls="unViewed" role="tab" data-toggle="tab">Unviewed</a></li>
<li role="presentation"><a href="#Viewed" aria-controls="Viewed" role="tab" data-toggle="tab">Viewed</a></li>
</ul>
            @if(!count($event_reviews_reports))
                <h1> No event reviews reports found </h1>
                @else
                <h1> Events Reviews reports</h1>
          <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="unViewed">
               @foreach($event_reviews_reports as $event_review_report)
                           @if($event_review_report->viewed == 0)
                             <div>
                <div class="col-sm-2">
                        {!! Form::open(array('method' => 'GET','action' => array('VolunteerController@show',
                        $event_review_report->user_id))) !!}

                        {!! Form::submit(App\User::find($event_review_report->user_id)->first_name.App\User::find($event_review_report->user_id)->last_name,
                        array('class' => 'btn btn-link' )) !!}

                        {!! Form::close() !!}
                        </div>
                <div class="col-sm-1">

                        {!! Form::open(array('method' => 'GET','action' => array('EventReviewController@show',
                        $event_review_report->event_id,$event_review_report->review_id))) !!}

                        {!! Form::submit(App\Event::find($event_review_report->event_id)->name , array('class' => 'btn btn-link' )) !!}

                        {!! Form::close() !!}
                </div>
                <div class="col-sm-2">

                {!! Form::open(array('action' => array('EventReviewController@reportViewed',$event_review_report->id))) !!}

                {{-- check if this report is viewed  --}}
                @if($event_review_report->viewed == 0)

                    {!! Form::submit('view' , array('class' => 'vol-act btn btn-default' )) !!}


                @endif
                {!! Form::close() !!}
                </div>
                             </div>

                        @endif

                    @endforeach

                </div>

                <div role="tabpanel" class="tab-pane" id="Viewed">
                    @foreach($event_reviews_reports as $event_review_report)
                        @if($event_review_report->viewed == 1)
                            <div class="container">
                            <div class="col-sm-2">
                                {!! Form::open(array('method' => 'GET','action' => array('VolunteerController@show',
                                $event_review_report->user_id))) !!}

                                {!! Form::submit(App\User::find($event_review_report->user_id)->first_name.'  '.
                                App\User::find($event_review_report->user_id)->last_name
                                    , array('class' => 'btn btn-link' )) !!}
                                {!! Form::close() !!}
                            </div>
                            <div class="col-sm-1">

                                {!! Form::open(array('method' => 'GET','action' => array('EventReviewController@show',
                                $event_review_report->event_id,$event_review_report->review_id))) !!}

    {!! Form::submit(App\Event::find($event_review_report->event_id)->name, array('class' => 'btn btn-link' )) !!}
                                {!! Form::close() !!}
                            </div>
                            </div>
                        @endif
                @endforeach
                </div>


                </div>
            @endif
            </div>


    @endsection