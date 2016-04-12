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
      </tr>
      @endforeach
    </tbody>
</table>

@endsection
