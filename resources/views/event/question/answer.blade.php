@extends('layouts.app')

<header>
	<title>Ask a Question</title>
</header>

@section('content')
	<h1>Questions From volunteers</h1>
		<ul>
			@foreach($questions as $question)
				{!! Form::open(['action' => ['EventQuestionController@answer', $question->event_id, $question->id]]) !!}
				<div class="container">
					<h4>{{ $question->question }}</h4>
					<p>{{ $question->question_body }}</p>

					<div class = "form-group">
            			{!! Form::label('Answer' , 'answer') !!}
            			{!! Form::textArea('answer' , null , array('class' => 'form-control')) !!}
       		 		</div>

				<div class = "form-group">
            			{!! Form::submit('Answer' , array('class' => 'btn btn-default' )) !!}
        		</div>
				{!! Form::close() !!}
				</div>

			@endforeach
		</ul>
@stop
