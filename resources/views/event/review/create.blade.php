@extends('layouts.app')

@section('content')
    <h1> create organization review on {{ $event->name }}</h1>
    {!! Form::open(['url' => 'event/'.$event->id.'/review']) !!}
        @include('event.review.partials.form', ['submitButtonText' => 'Add Review!'])
    {!! Form::close() !!}
    
@stop
