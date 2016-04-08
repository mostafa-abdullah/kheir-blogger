        {{--form for validate/unValidate users from the admin --}}
    {!! Form::open(array('action' => array('AdminController@adminAssignValidator',$volunteer->id))) !!}

        {{-- check if this user is validator  --}}
    @if($volunteer->role == 5)
        <div>
            {!! Form::submit('unValidate' , array('class' => 'vol-act btn btn-default' )) !!}
        </div>
        {{-- else means this user is normal user --}}
    @else

        <div>
            {!! Form::submit('Validate' , array('class' => 'vol-act btn btn-default' )) !!}
        </div>

    @endif
    {!! Form::close() !!}
