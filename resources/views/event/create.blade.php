@extends('layouts.app')
<header>
	<title>Create Event</title>
</header>
@section('content')

	<h1>Create A New Event</h1>
	{!! Form::open(['action' => ['Event\EventController@store']]) !!}
		@include('event.partials.form', ['submitButtonText' => 'Create Event'])
	{!! Form::close() !!}
	@include('errors')
@stop
