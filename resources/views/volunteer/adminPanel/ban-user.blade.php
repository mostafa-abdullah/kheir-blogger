  {{--form for ban users from the admin --}}
    {!! Form::open(array('action' => array('AdminController@adminBanUsers',$volunteer->id))) !!}

         @if($volunteer->role > 0)
        <div>
            {!! Form::submit('Ban' , array('class' => 'vol-act btn btn-default' )) !!}
        </div>


        @endif
    {!! Form::close() !!}
