@extends('layouts.app')
<header>
	<title>View Recommendations</title>
</header>

@section('content')
	<h1>Recommendations From volunteers</h1>
		<ul>

			@foreach($recommendations as $recommend)
				<li><p>{{ $recommend->created_at }}: {{ $recommend->recommendation }}</p></li>
			@endforeach
		</ul>
@stop
