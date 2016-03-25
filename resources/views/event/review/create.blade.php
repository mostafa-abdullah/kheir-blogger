@extends('layouts.app')

        @section('content')

            <h1> create organization review on {{ $event->name }}</h1>

            {!! Form::open(array('action' => array('EventReviewController@store',$event->id))) !!}

            <div class = "form_group">

                {!! Form::label('review','Review') !!}
                {!! Form::text('review',null,['class'=> 'form-control']) !!}
            </div>

            <div class = "form-group">
                {!! Form::label('rate','Rate'); !!}
                {!! Form::selectRange('rate', 1, 5); !!}
            </div>


            <div class="form-group">
                {!! Form::submit('AddReview',['class'=>'btn btn form-control']) !!}


            </div>

            {!! Form::close() !!}


    @if (count($errors) > 0)
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
@stop
