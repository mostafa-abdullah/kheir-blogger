@extends('layouts.app')

@section('content')

<link rel="stylesheet" type="text/css" src="../../../css/dataTables.css">
<script type="text/javascript" charset="utf8" src="../../../js/dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="../../../js/view-organizations.js"></script>

<table id="table_id" class=".table display">
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
