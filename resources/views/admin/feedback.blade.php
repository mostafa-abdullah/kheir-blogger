@extends('layouts.app')

@section('content')
    <h1>Feedbacks from volunteers</h1>
    <hr>
    <div class="container">
        @foreach ($feedbacks as $feedback)
            <h3>{{ $feedback->subject }}</h3>
            <div class="container">
                <p>{{ $feedback->message }}</p>
            </div>
            <br>
        @endforeach
    </div>
@endsection
