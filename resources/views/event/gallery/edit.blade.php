@extends('layouts.app')

@section('content')
        @if($photo->caption)
            <h1>Edit the caption of your image</h1>
        @else
            <h1>Add a caption to your image</h1>
        @endif
        {!! Form::model($photo, array( 'method' => 'PATCH','action' =>array('Event\EventGalleryController@update',$event->id,$photo->id))) !!}
        <img src="{{asset($path.$photo->name)}}" style="" width="250" height="250">
        <div class="form-group">
            {!! Form::label('caption','Caption:')!!}
            {!! Form::textArea('caption',$photo->caption,array('class' => 'form-control'))!!}
        </div>
        @if($photo->caption)
            {!! Form::submit('Edit Caption!') !!}
        @else
            {!! Form::submit('Add Caption!') !!}
        @endif
    {!! Form::close() !!}

    @include('errors')
@stop
