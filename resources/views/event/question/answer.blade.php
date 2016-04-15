@extends('layouts.app')

@section('content')
	<h1>Questions From volunteers on <a href="/event/{{$event->id}}">{{ $event->name }}</a></h1>
		<ul>
			@foreach($questions as $question)
				{!! Form::open(['action' => ['Event\EventQuestionController@answer', $question->event_id, $question->id]]) !!}
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
