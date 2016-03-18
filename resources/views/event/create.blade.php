@extends('layouts.app')
<header>
	<title>Create Event</title>
</header>
@section('content')

	<h1> Create A New Event </h1>
	{!! Form::open() !!}
		<div class="form-group">	
			{!! Form::label('name','Event Name:');!!}
			{!! Form::text('name',null,array('class' => 'form-control'));!!}
		</div>
		<div class="form-group">	
			{!! Form::label('description','Description:');!!}
			{!! Form::textArea('description',null,array('class' => 'form-control'));!!}
		</div>
		<div class="form-group">	
			{!! Form::label('location','Location:');!!}
			{!! Form::text('location',null,array('class' => 'form-control'));!!}
		</div>
		<div class="form-group">	
			{!! Form::label('Timing','Timing:');!!}
			{!! Form::input('datetime','Timing',date('d-m-Y h:i a'),array('class' => 'form-control'));!!}
		</div>
		<div class="form-group">
			{!! Form::submit('Create Event',array('class'=>'btn btn-default'));!!}
		</div>
	{!! Form::close() !!}

@stop
