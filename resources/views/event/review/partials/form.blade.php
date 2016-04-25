<div class = "form_group">

    {!! Form::label('review', 'Review') !!}
    {!! Form::textarea('review', null, ['class'=> 'form-control']) !!}
</div>

<div class = "form-group">
    {!! Form::label('rating','Rate'); !!}
    {!! Form::selectRange('rating', 1, 5); !!}
</div>


<div class="form-group">
    {!! Form::submit($submitButtonText, ['class'=>'btn btn-default']) !!}
</div>
