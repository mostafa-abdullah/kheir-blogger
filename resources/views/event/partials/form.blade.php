<div class="form-group">

    {!! Form::label('name','Event Name:');!!}
    {!! Form::text('name',null,array('class' => 'form-control'));!!}
</div>
<div class="form-group">
    {!! Form::label('description','Description:');!!}
    {!! Form::textArea('description',null,array('class' => 'form-control'));!!}
</div>
<div class="form-group">
    {!! Form::label('location','Location:');!!}
    {!! Form::text('location',null,array('class' => 'form-control'));!!}
</div>
<div class="form-group">
    {!! Form::label('timing','Timing:');!!}
    {!! Form::input(null,'timing',Carbon\Carbon::now(new DateTimeZone('Africa/Cairo'))->format('d-m-Y h:i a'),array('class' => 'form-control'));!!}
</div>
<div class="form-group">
    {!! Form::checkbox('required_contact_info', 1); !!}
    {!! Form::label('required_contact_info','Contact Info for volunteers is required');!!}
    <br>
    {!! Form::checkbox('needed_membership', 1); !!}
    {!! Form::label('needed_membership','Specific membership is required');!!}
</div>
<div class="form-group">
    {!! Form::submit($submitButtonText,array('class'=>'btn btn-success'));!!}
</div>
