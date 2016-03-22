@extends('layouts.app')
<header>
	<title>Ask a Question</title>
</header>
@section('content')

	{!! Form::open(['action' => ['EventController@answerQuestion', $id, $q_id]]) !!}

	<h1>Questions From volunteers</h1>
		<ul>
		@if
			@foreach($question as $questions)
				<ul>
				<li><p>{{ $question->question }}</p></li>
				<li><p>{{ $question->question_body }}</p></li>
				<li>{!! Form::open(['action' => ['EventController@answerQuestion', $id, $q_id]]) !!}
			<div class = "form-group">
            {!! Form::label('Answer' , 'answer') !!}
            {!! Form::textArea('answer' , null , array('class' => 'form-control')) !!}
       		 </div></li>
       		<li> <div class = "form-group">
            {!! Form::submit('Send' , array('class' => 'btn btn-default' )) !!}
        </div>
				{!! Form::close() !!}
				</li>
			</ul>
		</ul>
@stop