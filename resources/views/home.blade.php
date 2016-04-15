@extends('layouts.app')
@section('content')
@if(Session::has('flash_message'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@if(auth()->guard('organization')->check())
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form method="" action="{{url('event/create')}}">
                <input type="submit" value="Create Event" class="btn btn-success">
            </form>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <form method="" action="{{url('organization/'.auth()->guard('organization')->id().'/recommendations')}}">
                <input type="submit" value="View Recommendations" class="btn btn-success">
            </form>
        </div>
    </div>
</div>
@endif
@endsection
