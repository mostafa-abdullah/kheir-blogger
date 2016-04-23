@extends('layouts.app')

@section('content')

    @if($edit)
        <h1>Edit the caption of your image</h1>
    @else
        <h1>Add a caption to your image</h1>
    @endif

        {!! Form::model($photo, array( 'method' => 'POST','action' =>array('Event\EventGalleryController@edit',$photo->id))) !!}
        <img src="{{asset($path.$photo->name)}}" style="" width="250" height="250">
        <div class="form-group">
            {!! Form::label('caption','Caption:')!!}
            {!! Form::textArea('caption',null,array('class' => 'form-control'))!!}
        </div>
    {!! Form::submit('Add Caption!') !!}
    {!! Form::close() !!}

    @include('errors')
@stop
