@extends('layouts.app')


@section('content')

{!! Form::open(['action' => ['searchController@searchForEvents']]) !!}

<div class = "form-group">
    {!! Form::label('txtSearch' , 'Search for something') !!}
    {!! Form::text('txtSearch' , null , array('class' => 'form-control')) !!}

</div>

<div class = "form-group">
    {!! Form::submit('Search' , array('class' => 'btn btn-default' )) !!}
</div>
<!-- -->
{!! Form::close() !!}

@include('errors')

@stop
