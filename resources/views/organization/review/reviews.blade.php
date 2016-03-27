@extends('layouts.app')

    @section('content')


        <h1>{{$organization_name}} reviews</h1>

        @foreach($reviews as $review)
            <h2>
                <a href="/organization/{{$review->organization_id}}/review/{{$review->id}}/report">
                    {{\App\User::find($review->user_id)->name}}
                </a>
            </h2>
            <div style="">Rating
                <span style="font-size: 25px">{{$review->rate}}</span>/10</div>
                <div style="margin-top: 20px">
                    {{$review->review}}
                </div>

            <hr style="clear:both;"/>

        @endforeach
    @endsection