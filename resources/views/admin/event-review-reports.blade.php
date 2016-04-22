@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Events Reviews reports</h1>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#unViewed" aria-controls="unViewed" role="tab" data-toggle="tab">Unviewed</a></li>
        <li role="presentation"><a href="#Viewed" aria-controls="Viewed" role="tab" data-toggle="tab">Viewed</a></li>
    </ul>
    <br>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="unViewed">
            @include('admin.partials.event-review-reports',
                    ['event_reviews_reports' => $reported_event_reviews, 'viewed' => 0])
        </div>

        <div role="tabpanel" class="tab-pane" id="Viewed">
            @include('admin.partials.event-review-reports',
                    ['event_reviews_reports' => $reported_event_reviews, 'viewed' => 1])
        </div>
    </div>
</div>
@endsection
