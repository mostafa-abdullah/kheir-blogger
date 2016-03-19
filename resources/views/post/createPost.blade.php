@extends('layouts.app')
@section('content')
{!! Form::open(['action' => 'EventPostController@storePost']) !!}



<div class="form-group" style="margin-left: 20px;">
<h1> Create New Post </h1>
</div>

	@if($errors->has())
		<div class="alert alert-danger" style="width: 50%;margin-left: 20px;">
		<ul>
			<h3>Errors</h3>
		    @foreach($errors->all() as $error)
		        <li class="warning">{{ $error }}</li>
		    @endforeach
		</ul>
		</div>
	@endif

<div class="form-group" style="margin-left: 20px;">
{!! Form::label("Title") !!} <br />
{!! Form::text("title") !!}
</div>

<div class="form-group" style="margin-left: 20px;">
{!! Form::label("Description") !!} <br />
{!! Form::textarea("description") !!}
</div>

<div class="form-group" style="margin-left: 20px;">
{!! Form::submit("Publish") !!}
{!! Form::close() !!}
</div>

@endsection