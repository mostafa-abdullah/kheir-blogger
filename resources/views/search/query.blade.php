{!! Form::open(['action' => ['SearchController@searchAll'], 'class'=>'form-inline']) !!}
    <div class = "form-group">
        {!! Form::text('searchText' , null , array('class' => 'form-control')) !!}
        {!! Form::submit('Search' , array('class' => 'btn btn-default')) !!}
    </div>
{!! Form::close() !!}
