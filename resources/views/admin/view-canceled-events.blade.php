@extends('layouts.app')

@section('content')



    <table id="table_id" class="display">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Hosted by</th>
            <th>Timing</th>
            <th>Location</th>
            <th>Required Contact info</th>
            <th>Needed Membership</th>
            <th>Rating</th>
            <th>Restore</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($events as $event)
            <tr>
                <td>{{$event->name}}</td>
                <td>{{$event->description}}</td>
                <td>{{\App\Organization::findorfail($event->organization_id)->name}}</td>
                <td>{{$event->timing}}</td>
                <td>{{$event->location}}</td>
                @if($event->required_contact_info)  <td>YES</td>    @else <td>NO</td>   @endif
                @if($event->needed_membership)  <td>YES</td>    @else <td>NO</td>   @endif
                <td>{{$event->rating}}</td>
                <td>
                    <form method="GET" action="{{url('event/'.$event->id.'/restore')}}">
                        {!! csrf_field() !!}
                        <input type="submit" value="Restore Event" class="btn btn-success">
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
