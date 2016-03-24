@extends('layouts.app')
<header>
	<title>Ask a Question</title>
</header>
@section('content')

	{!! Form::open(['action' => ['EventController@storeQuestion', $id]]) !!}

        <div class = "form-group">
            {!! Form::label('recommendation' , 'question') !!}
            {!! Form::text('question' , null , array('class' => 'form-control')) !!}
        </div>

        <div class = "form-group">
            {!! Form::label('recommendation' , 'question_body') !!}
            {!! Form::textArea('question_body' , null , array('class' => 'form-control')) !!}
        </div>

        <div class = "form-group">
            {!! Form::submit('Send' , array('class' => 'btn btn-default' )) !!}
        </div>

    {!! Form::close() !!}

    @include('errors')

@stop
