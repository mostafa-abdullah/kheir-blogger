@extends('layouts.app')

@section('content')

    <h1>Editing Review on organization: {{$organization_name}}</h1>

    {!! Form::model($organization_review, array( 'method' => 'PATCH',
            'action' => array('Organization\OrganizationReviewController@update', $organization_review->organization_id, $organization_review->id))) !!}

        @include('organization.review.partials.form', ['submitButtonText' => 'Edit Review'])
    {!! Form::close() !!}
@stop
