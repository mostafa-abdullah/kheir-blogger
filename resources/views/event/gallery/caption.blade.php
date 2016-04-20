@extends('layouts.app')

@section('content')

    <h1>Add caption to your images</h1>

    {!! Form::model($names, array( 'method' => 'POST','action' =>array('Event\EventGalleryController@store',$event->id))) !!}
    @foreach($names as $name)
        <img src="{{asset($path.$name)}}" style="" width="250" height="250">
        <div class="form-group">
            {!! Form::label('caption','Caption:')!!}
            {!! Form::textArea('captions[]',null,array('class' => 'form-control'))!!}
        </div>
        {{ Form::hidden('names[]', $name) }}
    @endforeach
    {!! Form::submit('Add Captions!') !!}
    {!! Form::close() !!}

    @include('errors')
@stop
