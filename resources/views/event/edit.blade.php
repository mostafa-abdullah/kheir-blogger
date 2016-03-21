@extends('layouts.app)

@section('content')

    <h1>Editing Event</h1>

    {!! Form::model($event, array( 'method' => 'PATCH','action' =>array('EventController@update',$event->id))) !!}

    <div class="form-group">

        {!! Form::label('name','Event Name:');!!}
        {!! Form::text('name',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
        {!! Form::label('description','Description:');!!}
        {!! Form::textArea('description',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
        {!! Form::label('location','Location:');!!}
        {!! Form::text('location',null,array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
        {!! Form::label('timing','Timing:');!!}
        {!! Form::input('timing','timing',date('d-m-Y h:i a'),array('class' => 'form-control'));!!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('required_contact_info', 1); !!}
        {!! Form::label('required_contact_info','Contact Info for volunteers is required');!!}
        <br>
        {!! Form::checkbox('needed_membership', 1); !!}
        {!! Form::label('needed_membership','Specific membership is required');!!}
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
