@extends('layouts.app')

@section('content')

        <h1>Edit/Add a caption to your image</h1>

        {!! Form::model($photo, array( 'method' => 'POST','action' =>array('Event\EventGalleryController@savecaption',$event->id,$photo->id))) !!}
        <img src="{{asset($path.$photo->name)}}" style="" width="250" height="250">
        <div class="form-group">
            {!! Form::label('caption','Caption:')!!}
            {!! Form::textArea('caption',$photo->caption,array('class' => 'form-control'))!!}
        </div>
    {!! Form::submit('Add Caption!') !!}
    {!! Form::close() !!}

    @include('errors')
@stop
