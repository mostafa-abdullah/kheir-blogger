@extends('layouts.app')
@section('content')
    <h1>Write a review on {{ $organization->name }}</h1>
    {!! Form::open(array('action' => array('Organization\OrganizationReviewController@store',$organization->id))) !!}
        @include('organization.review.partials.form', ['submitButtonText' => 'Add Review!'])
    {!! Form::close() !!}
@stop
