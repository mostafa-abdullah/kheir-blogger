@extends('layouts.app')

        @section('content')

            <h1> create organization review on {{ $event->name }}</h1>

            {!! Form::open(['url' => 'event/'.$event->id.'/review']) !!}

            <div class = "form_group">

                {!! Form::label('review','Review') !!}
                {!! Form::textarea('review',null,['class'=> 'form-control']) !!}
            </div>

            <div class = "form-group">
                {!! Form::label('rate','Rate'); !!}
                {!! Form::selectRange('rate', 1, 5); !!}
            </div>


            <div class="form-group">
                {!! Form::submit('Add Review',['class'=>'btn btn-default']) !!}


            </div>

            {!! Form::close() !!}


    @include('errors')
@stop
