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

  <div class="container">
    {!! Form::open(['method'=>'POST','action' => ['Volunteer\VolunteerController@assign_locations']]) !!}
  <div class="form-group">
      @foreach($sentLocations as $location)
          {!!   Form::checkbox('locations[]', $location->id,in_array($location->id,$locationsIDS))!!}
          {!!  Form::label('location', $location->location) !!}
          {!!  Form::label('location', $location->city) !!}<br>
      @endforeach
  </div>
      {!!Form::submit('assign', array('class'=>'btn btn-default'))!!}
      {!! Form::close() !!}
  </div>

  @include('errors')


@stop