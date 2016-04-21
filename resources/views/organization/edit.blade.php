@extends('layouts.app')

@section('content')

  {!! Form::model($organization, array( 'method' => 'PATCH','action' =>array('Organization\OrganizationController@update',$organization->id))) !!}

    <div class="form-group">
      {!!Form::label('name', 'Name');!!}
      {!!Form::text('name',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('email', 'Email');!!}
      {!!Form::text('email',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('bio', 'Bio');!!}
      {!!Form::textarea('bio',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('slogan', 'Slogan');!!}
      {!!Form::text('slogan',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('phone', 'Phone');!!}
      {!!Form::text('phone',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('location', 'Location');!!}
      {!!Form::text('location',null,array('class' => 'form-control'));!!}
    </div>
     {!!Form::submit('Update', array('class'=>'btn btn-default'));!!}
  {!! Form::close() !!}

  @include('errors')

@stop
