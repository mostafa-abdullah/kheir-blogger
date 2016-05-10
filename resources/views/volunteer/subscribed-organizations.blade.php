@extends('layouts.app')

@section('content')
    @foreach($organizations as $organization)
        <div>
            <a href="{{url('organization', $organization->id)}}">
                <li>{{$organization->name}}</li>
            </a>
            <label>{{$organization->slogan}}</label>
        </div>
    @endforeach
@stop
