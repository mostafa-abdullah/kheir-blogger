@extends('layouts.app')

@section('content')

    <h1>Add caption to your images</h1>

    {!! Form::model($paths, array( 'method' => 'POST','action' =>array('EventController@test2'))) !!}
    @foreach($paths as $path)
        <img src="{{asset($path)}}" class="img-responsive" width="300" height="200">
        <div class="form-group">
            {!! Form::label('caption','Caption:')!!}
            {!! Form::textArea('captions[]',null,array('class' => 'form-control'))!!}
        </div>
        {{ Form::hidden('paths[]', $path) }}
    @endforeach
    {!! Form::submit('Add Captions!') !!}
    {!! Form::close() !!}

    @include('errors')
@stop
