@extends('layouts.app')
<header>
	<title>Create Event</title>
</header>
@section('content')

	<h1>Create A New Event</h1>
	{!! Form::open(['url' => 'event']) !!}
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
			{!! Form::label('timing','Timing:');!!}
			{!! Form::input('timing','timing',date('d-m-Y h:i a'),array('class' => 'form-control'));!!}
		</div>
		<div class="form-group">
			{!! Form::checkbox('required_contact_info', 1); !!}
			{!! Form::label('required_contact_info','Contact Info for volunteers is required');!!}
			<br>
			{!! Form::checkbox('needed_membership', 1); !!}
			{!! Form::label('needed_membership','Specific membership is required');!!}
		</div>
		<div class="form-group">
			{!! Form::submit('Create Event',array('class'=>'btn btn-success'));!!}
		</div>
	{!! Form::close() !!}
	@if ($errors->any())
		<div class="alert alert-danger">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</div>
	@endif
@stop
