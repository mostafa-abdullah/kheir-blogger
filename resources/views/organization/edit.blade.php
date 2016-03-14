@extends('layouts.app')

@section('content')

  {!! Form::model($organization,array( 'method' => 'PATCH','action' =>array('OrganizationController@update',$organization->id))) !!}
    <div class="form-group">
      {!!Form::label('slogan', 'Organization solegan :');!!}
      {!!Form::text('slogan',null,array('class' => 'form-control'));!!}
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
      {!!Form::label('bio', 'Organization Bio :');!!}
      {!!Form::textarea('bio',null,array('class' => 'form-control'));!!}
    </div>
     {!!Form::submit('Update', array('class'=>'btn btn-default'));!!}
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
