{{--form for ban users from validators --}}
{!! Form::open(['action' => array('AdminController@banVolunteer',$volunteer->id), 'method' => 'GET']) !!}
     @if($volunteer->role == 1)
        <div>
            {!! Form::submit('Ban' , array('class' => 'vol-act btn btn-default' )) !!}
        </div>
    @elseif($volunteer->role == 0)
        <div>
            {!! Form::submit('Unban' , array('class' => 'vol-act btn btn-default' )) !!}
        </div>
    @endif
{!! Form::close() !!}
