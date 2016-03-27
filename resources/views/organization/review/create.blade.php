@extends('layouts.app')
@section('content')
    <h1>Write a review on {{ $organization->name }}</h1>
    {!! Form::open(array('action' => array('OrganizationReviewController@store',$organization->id))) !!}
    <div class = "form-group">
        {!! Form::label('review','Review'); !!}
        {!! Form::textarea('review',null,['class'=> 'form-control']); !!}
    </div>
    <div class = "form-group">
        {!! Form::label('rate','Rate'); !!}
        {!! Form::selectRange('rate', 1, 5); !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Add Review',['class'=>'btn btn btn-default']) !!}
    </div>
    {!! Form::close() !!}
    @include('errors')
@stop
