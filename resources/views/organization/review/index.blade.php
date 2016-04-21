@extends('layouts.app')

    @section('content')


        <h1>{{$organization->name}} reviews</h1>

        @foreach($organization->reviews as $review)
            <h4>
                {{\App\User::find($review->user_id)->name}}
                <small>
                    <a href="/organization/{{$review->organization_id}}/review/{{$review->id}}/report">
                        report
                    </a>
                </small>
            </h4>
            <div class="container">
                <div style="">Rating
                    <span style="font-size: 25px">{{$review->rating}}</span>/10
                </div>
                    <div style="margin-top: 20px">
                        {{$review->review}}
                    </div>
            </div>
            <hr style="clear:both;"/>

        @endforeach
    @endsection
