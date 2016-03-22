@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Send feedback to the Admin</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/sendFeedback') }}">
                        {!! csrf_field() !!}

                        <div class="col-md-4form-group">
                          <label for="subject">subject:</label>
                          <input type="text" class="form-control" id="subject">
                        </div>
                        <div class="col-md-12 form-group">
                          <label for="message">Message:</label>
                          <textarea class="form-control" rows="5" id="message"></textarea>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Send
                                </button>
                            </div>
                        </div>
                        @include('errors')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
