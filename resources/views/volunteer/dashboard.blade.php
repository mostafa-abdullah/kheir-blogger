@extends('layouts.app')

@section('content')
  <div class="container dashboard" style="display:none">
     <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-6">
          <div class="feed-box">
            @foreach($data as $record)
              @if(property_exists($record, 'name'))
                <div class="panel">
                   <div class="panel-heading">
                      <div class="text-center">
                         <div class="row">
                            <div class="col-sm-9">
                               <h3 class="pull-left">{{$record->name}}</h3>
                            </div>
                            <div class="col-sm-3">
                               <h4 class="pull-right"> <small><em>{{$record->timing}}</em></small> </h4>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="panel-body">{{$record->description}}  <a href="#">subscribe</a> </div>
                </div>
              @else
             <div class="panel">
                <div class="panel-heading">
                   <div class="text-center">
                      <div class="row">
                         <div class="col-sm-9">
                            <h3 class="pull-left">{{$record->title}}</h3>
                         </div>
                         <div class="col-sm-3">
                            <h4 class="pull-right"> <small><em>{{$record->updated_at}}</em></small> </h4>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="panel-body">{{$record->description}}  <a href="#">subscribe</a> </div>
             </div>
            @endif
          @endforeach
        </div>
        <button class="see-more btn btn-default " type="button">see more</button>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-3"> </div>
        <div class="col-md-1"> </div>
     </div>
  </div>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script>
  $(document).ready(function(){
    var size = {{$size}};
    var offset = {{$offset}};
    var com = offset;
    $('.feed-box').children().hide();
    $('.feed-box').children().slice(0,com).show();
    $(".see-more").click(function(){ // click event for load more
              com+=offset;
              $('.feed-box').children().slice(0,com).show();
              if(com>=size){ // check if any hidden divs
                 $(".see-more").replaceWith("There is no more"); // if there are none left
              }

           });
    $(".dashboard").show();
  });
  </script>


@stop
