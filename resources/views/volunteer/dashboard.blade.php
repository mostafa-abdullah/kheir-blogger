@extends('layouts.app')

@section('content')

  <div class="container">
     <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-6">
           <div id="postlist">
             @for ($i = 0; $i < 3 && $i < count($events); $i++)
              <div class="panel">
                 <div class="panel-heading">
                    <div class="text-center">
                       <div class="row">
                          <div class="col-sm-9">
                             <h3 class="pull-left">{{$events[$i]->name}}</h3>
                          </div>
                          <div class="col-sm-3">
                             <h4 class="pull-right"> <small><em>{{$events[$i]->timing}}</em></small> </h4>
                          </div>
                       </div>
                    </div>
                 </div>
                 <div class="panel-body">{{$events[$i]->description}}<a href="#">subscribe</a> </div>
              </div>
            @endfor
           </div>
           @if(count($events) > 1)
              <div class="text-center"><a href="#" id="loadmore" class="btn btn-primary">Older Posts...</a></div>
           @endif
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-3"> </div>
        <div class="col-md-1"> </div>
     </div>
  </div>


@stop
