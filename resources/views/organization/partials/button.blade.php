{!! Form::open(['url' => '/organization/'.$organization->id.'/'. $action,'method'=>'get']) !!}
<div>
   {!! Form::submit($buttonText , array('class' => 'vol-act btn btn-default' )) !!}
</div>
{!! Form::close() !!}
