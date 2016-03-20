@extends('layouts.app')

    @section('content')

        <h1 style="margin-left: 50px">Organizations index</h1>


        @foreach($organizations as $organization)
            <article style="margin-left: 100px">
                <h2>
                    {{--<a href="{{action('OrganizationReviewController@showReviews')--}}
                     {{--, [$organization->id]}}"> {{$organization->name}}--}}
                    {{--</a>--}}

                    {{$organization->name}}

                </h2>

                <div class="body" >{{$organization->bio}}</div>
            </article>
        @endforeach
    @stop
