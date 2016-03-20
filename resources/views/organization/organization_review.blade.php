@extends('layouts.app')

        @section('content')

            //For storing a review

            <h1> create organization review</h1>


            {!! Form::open(array('action' => array('OrganizationReviewController@store',$id))) !!}
            <div class = "form_group">

                {!! Form::label('review','Review') !!}
                {!! Form::text('review',null,['class'=> 'form-control']) !!}
            </div>

            <div class = "form-group">
                {!! Form::label('rate','Rate') !!}
                {!! Form::number('rate', 'value') !!}
            </div>


            <div class="form-group">
                {!! Form::submit('AddReview',['class'=>'btn btn form-control']) !!}


            </div>


            {!! Form::close() !!}

            @include('errors')





        @stop