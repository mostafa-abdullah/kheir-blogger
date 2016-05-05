@extends('layouts.app')

@section('content')



    <table id="table_id" class="display">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Slogan</th>
            <th>Phone</th>
            <th>Location</th>
            <th>Number of subscribers</th>
            <th>Events held</th>
            <th>Events cancelled</th>
            <th>Cancellation rate</th>
            <th>Rate</th>
            <th>Readd</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($organizations as $organization)
            <tr>
                <td>{{$organization->name}}</td>
                <td>{{$organization->email}}</td>
                <td>{{$organization->slogan}}</td>
                <td>{{$organization->phone}}</td>
                <td>{{$organization->location}}</td>
                <td>{{$organization->numberOfSubscribers}}</td>
                <td>{{$organization->numberOfEvents}}</td>
                <td>{{$organization->numberOfCancelledEvents}}</td>
                <td>{{$organization->cancellationRate}}</td>
                <td>{{$organization->rate}}</td>
                <td>
                    <form method="POST" action="{{url('readd/'.$organization->id)}}">
                        {!! csrf_field() !!}
                        <input type="submit" value="Readd Organization" class="btn btn-success">
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
