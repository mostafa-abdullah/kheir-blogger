<div style="padding: 10px 10px 10px 0px">
    <a href="#demo" class="btn btn-success" data-toggle="collapse">Assign locations</a>
    <div id="demo" class="collapse">

        {!! Form::open(['method'=>'POST','action' => ['Volunteer\VolunteerController@assignLocations']]) !!}
        <div class="form-group">
            @foreach($sentLocations as $location)

                {!!  Form::checkbox('locations[]', $location->id,in_array($location->id,$locationsIDS))!!}
                {!!  Form::label('location', $location->location) !!},
                {!!  Form::label('location', $location->city) !!}<br>
            @endforeach
        </div>
        {!!Form::submit('assign', array('class'=>'btn btn-default'))!!}
        {!!Form::close() !!}
    </div>
</div>
