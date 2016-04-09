@extends('layouts.app')

@section('content')
  <div class="container">
     <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-6">
           <div id="postlist">
             @foreach ($supdata as $record)
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
                    <div class="panel-body">{{$record->description}}<a href="#">subscribe</a> </div>
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
                 <div class="panel-body">{{$record->description}}<a href="#">subscribe</a> </div>
              </div>
            @endif
            @endforeach
           </div>
           @if(count($supdata) > 1)
              <div class="text-center"><a href="#" id="loadmore" class="btn btn-primary">{{ $supdata->links() }} tool</a></div>
           @endif
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-3"> </div>
        <div class="col-md-1"> </div>
     </div>
  </div>


@stop
