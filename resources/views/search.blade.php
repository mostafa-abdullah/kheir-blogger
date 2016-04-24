@extends('layouts.app')


@section('content')

{!! Form::open(['action' => ['SearchController@searchAll']]) !!}
    <div class = "form-group">
        {!! Form::label('searchText' , 'Search for something') !!}
        {!! Form::text('searchText' , null , array('class' => 'form-control')) !!}

    </div>

    <div class = "form-group">
        {!! Form::submit('Search' , array('class' => 'btn btn-default')) !!}
    </div>
{!! Form::close() !!}

@include('errors')

@stop
