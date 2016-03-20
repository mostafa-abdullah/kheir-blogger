@extends('layouts.app')
<header>
	<title>View Recommendations</title>
</header>

@section('content')
	<h1>Recommendations From volunteers</h1>
		<ul>
		@if
			@foreach($recommend as $recommendations)
				<li><p>{{ $recommend->recommendation }}</p></li>
			@endforeach
		</ul>
@stop