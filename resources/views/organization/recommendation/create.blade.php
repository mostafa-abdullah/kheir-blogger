@extends('layouts.app')

<header>
    <title>Send Recommendation</title>
</header>

@section('content')


    {!! Form::open(['action' => ['OrganizationController@storeRecommendation', $id]]) !!}
        <div class = "form-group">
            {!! Form::label('recommendation' , 'Recommendation') !!}
            {!! Form::textArea('recommendation' , null , array('class' => 'form-control')) !!}
        </div>

        <div class = "form-group">
            {!! Form::submit('Send' , array('class' => 'btn btn-default' )) !!}
        </div>

    {!! Form::close() !!}

    @include('errors')

@stop
