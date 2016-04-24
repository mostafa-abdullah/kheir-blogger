@extends('layouts.app')

@section('content')

  {!! Form::model($volunteer, array( 'method' => 'PATCH','action' => ['Volunteer\VolunteerController@update',$volunteer->id])) !!}

    <div class="form-group">
      {!!Form::label('first_name', 'First name');!!}
      {!!Form::text('first_name',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('last_name', 'Last name');!!}
      {!!Form::text('last_name',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('email', 'Email');!!}
      {!!Form::text('email',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('phone', 'Phone');!!}
      {!!Form::text('phone',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('birth_date', 'Birth Date');!!}
      {!!Form::input('date', 'birth_date', date('d-m-Y'),array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('address', 'Address');!!}
      {!!Form::text('address',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
      {!!Form::label('city', 'City');!!}
      {!!Form::text('city',null,array('class' => 'form-control'));!!}
    </div>
     {!!Form::submit('Update', array('class'=>'btn btn-default'));!!}
     {!! Form::close() !!}

  @include('volunteer.locations');

  @include('errors')


@stop