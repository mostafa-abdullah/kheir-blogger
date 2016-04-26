@extends('layouts.app')

@section('content')
<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#allEvents" aria-controls="allEvents" role="tab" data-toggle="tab">All</a></li>
    <li role="presentation"><a href="#followedAndRegisteredEvents" aria-controls="followedAndRegisteredEvents" role="tab" data-toggle="tab">Followed and Registered Events</a></li>
    <li role="presentation"><a href="#subscribedEvents" aria-controls="subscribedEvents" role="tab" data-toggle="tab">Subscribed</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
  	<!-- Panel for showing all events -->
    <div role="tabpanel" class="tab-pane active" id="allEvents">
        @if ($allEvents)
        <h1>My Events</h1>
        <hr>
            @foreach($allEvents as $event)
            <p>  {{$event->name}}</p>
            @endforeach
    	@endif
    </div>
    <!-- Panel for showing followed/registered events -->
    <div role="tabpanel" class="tab-pane" id="followedAndRegisteredEvents">
    	@if ($followedAndRegisteredEvents)
        <h1>Followed/Registered Events</h1>
        <hr>
            @foreach($followedAndRegisteredEvents as $event)
            <p>  {{$event->name}}</p>
            @endforeach
    	@endif
    </div>
    <!-- Panel for showing events of subscribed organization-->
    <div role="tabpanel" class="tab-pane" id="subscribedEvents">
    	@if ($subscribedOrganizationEvents)
        <h1>Followed/Registered Events</h1>
        <hr>
            @foreach($subscribedOrganizationEvents as $event)
            <p>  {{$event->name}}</p>
            @endforeach
    	@endif
    </div>
  </div>

</div>


@stop
