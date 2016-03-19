@extends('layouts.app')
@section('content')
{!! Form::open(['action' => 'EventPostController@storePost']) !!}

<div class="form-group">
{!! Form::label("Title") !!}
{!! Form::text("title") !!}
</div>

<div class="form-group">
{!! Form::label("Description") !!}
{!! Form::textarea("description") !!}
</div>

<div class="form-group">
{!! Form::submit("Publish") !!}
{!! Form::close() !!}
</div>
@endsection