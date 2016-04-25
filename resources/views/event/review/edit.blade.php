@extends('layouts.app')

@section('content')

    <h1>Editing Review on event: {{$event_name}}</h1>

    {!! Form::model($event_review, array( 'method' => 'PATCH',
            'action' => array('Event\EventReviewController@update', $event_review->event_id, $event_review->id))) !!}

        @include('event.review.partials.form', ['submitButtonText' => 'Edit Review'])
    {!! Form::close() !!}
@stop
