@extends('layouts.app')

@section('content')
  {!! Form::open(array('url' => '/profile', 'method' => 'put')) !!}
    <div class="form-group">
      {!!Form::label('solegan', 'Organization solegan :');!!}
      {!!Form::text('solegan',$information->slogan,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('phone', 'Organization phone :');!!}
      {!!Form::text('phone',$information->phone,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('location', 'Organization location :');!!}
      {!!Form::text('location',$information->location,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('Bio', 'Organization Bio :');!!}
      {!!Form::textarea('Bio',$information->bio,array('class' => 'form-control'));!!}
    </div>
     {!!Form::submit('Update', array('class'=>'btn btn-default'));!!}
  {!! Form::close() !!}
@stop
