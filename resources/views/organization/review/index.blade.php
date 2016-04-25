@extends('layouts.app')

    @section('content')


        <h1>{{$organization->name}} reviews</h1>

        @foreach($organization->reviews as $review)
            <h4>
                {{\App\User::find($review->user_id)->name}}
                <small>
                    @if (Auth::user() && Auth::user()->organizationReviews()->find($review->id))
                        <a href="/organization/{{$review->organization_id}}/review/{{$review->id}}/edit">
                            edit
                        </a>
                    .
                    @endif
                    <a href="/organization/{{$review->organization_id}}/review/{{$review->id}}/report">
                        report
                    </a>
                    @if (Auth::user()->role >= 5)
                        <form action="{{ url('organization/'.$review->organization_id.'/review/'.$review->id) }}" method="POST">
                             {!! csrf_field() !!}
                             {!! method_field('DELETE') !!}
                             <button type="submit" class="btn btn-danger btn-event">Delete</button>
                        </form>
                    @endif
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
