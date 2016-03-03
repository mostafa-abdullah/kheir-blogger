@extends('layouts.app')

@section('content')
  //add  'method' => 'put' to action
  {!! Form::model($organization,array( 'method' => 'put','action' =>array('OrganizationController@update',$organization->id))) !!}
    <div class="form-group">
      {!!Form::label('solegan', 'Organization solegan :');!!}
      {!!Form::text('solegan',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('phone', 'Organization phone :');!!}
      {!!Form::text('phone',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('location', 'Organization location :');!!}
      {!!Form::text('location',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('Bio', 'Organization Bio :');!!}
      {!!Form::textarea('Bio',null,array('class' => 'form-control'));!!}
    </div>
     {!!Form::submit('Update', array('class'=>'btn btn-default'));!!}
  {!! Form::close() !!}
@stop
