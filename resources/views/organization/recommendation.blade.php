@extends('layouts.app')

<header>
    <title>Send Recommendation</title>
</header>

@section('content')

    <h1>Send us a recommendation</h1>

    {!! Form::open(['action' => 'OrganizationController@storeRecommendation']) !!}

        <div class = "form-group">
            {!! Form::label('recommendation' , 'Recommendation') !!}
            {!! Form::textArea('recommendation' , null , array('class' => 'form-control')) !!}
        </div>

        <div class = "form-group">
            {!! Form::submit('Send' , array('class' => 'btn btn-default' )) !!}
        </div>


    {!! Form::close() !!}


@stop