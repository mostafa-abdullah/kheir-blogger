@extends('layouts.app')

@section('content')

    <h1>Add caption to your images</h1>

    {!! Form::open(array('url'=>'store_gallery','method'=>'POST')) !!}
    @foreach($paths as $path)
        <img src="{{asset($path)}}" style="">
        <div class="form-group">
            {!! Form::label('caption','Caption:')!!}
            {!! Form::textArea('captions[]',null,array('class' => 'form-control'))!!}
        </div>
        @endforeach
    {!! Form::submit('Add Captions!') !!}
    {!! Form::close() !!}





    @include('errors')
@stop