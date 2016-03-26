@extends('layouts.app')

@section('content')

    	<h3>{{ $event }}</h3>

     @if($creator)
          <form action="{{ url('event/'.$event->id) }}" method="POST">
               {!! csrf_field() !!}
               {!! method_field('DELETE') !!}

               <button type="submit" class="btn btn-danger">
               <i class="fa fa-trash"></i> Delete
               </button>
          </form>
     @endif
@endsection
