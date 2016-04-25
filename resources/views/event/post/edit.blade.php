@extends('layouts.app')
@section('content')
{!! Form::model($post, array( 'method' => 'PATCH','action' =>array('Event\EventPostController@update',$event->id,$post->id))) !!}
<div class="form-group" style="margin-left: 20px;">
<h1>Editing Post: {{$post->title}}</h1>
</div>

<div class="container">
	<div class="form-group">
	{!! Form::label("title", "Title") !!} <br />
	{!! Form::text("title", null, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
	{!! Form::label("description", "Description") !!} <br />
	{!! Form::textarea("description", null, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
	{!! Form::submit("Update post.", ['class' => 'btn btn-default']) !!}
	{!! Form::close() !!}
	</div>

	@include('errors')
</div>

@endsection
