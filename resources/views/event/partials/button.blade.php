
{!! Form::open(['url' => '/event/'.$event->id.'/'.$action,'method'=>'get']) !!}
<div>
   {!! Form::submit($buttonText , array('class' => 'btn btn-success btn-event' )) !!}
</div>
{!! Form::close() !!}
