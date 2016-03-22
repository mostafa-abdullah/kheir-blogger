@extends('layouts.app')
<header>
	<title>Ask a Question</title>
</header>
@section('content')
	<h1>Questions From volunteers</h1>
		<ul>
		@if
			@foreach($question as $questions)
				{!! Form::open(['action' => ['EventController@answerQuestion', $id, $q_id]]) !!}
				<ul>
				<li><p>{{ $question->question }}</p></li>
				<li><p>{{ $question->question_body }}</p></li>
				<li>
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