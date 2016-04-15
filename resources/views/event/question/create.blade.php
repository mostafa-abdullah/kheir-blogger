@extends('layouts.app')
<header>
	<title>Ask a Question</title>
</header>
@section('content')

	{!! Form::open(['action' => ['Event\EventQuestionController@store', $id]]) !!}

        <div class = "form-group">
            {!! Form::label('question' , 'question') !!}
            {!! Form::text('question' , null , array('class' => 'form-control')) !!}
        </div>

        <div class = "form-group">
            {!! Form::label('question_body' , 'Question Body') !!}
            {!! Form::textArea('question_body' , null , array('class' => 'form-control')) !!}
        </div>

        <div class = "form-group">
            {!! Form::submit('Ask!' , array('class' => 'btn btn-default' )) !!}
        </div>

    {!! Form::close() !!}

    @include('errors')

@stop
