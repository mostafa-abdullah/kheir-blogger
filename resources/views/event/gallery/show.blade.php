@extends('layouts.app')

@section('content')
    <div class="panel panel-default">

        <ul class="nav nav-tabs">
            <li role="presentation" class="active" id="posts-tab"><a href="#">Posts</a></li>
            <li role="presentation" id="questions-tab"><a href="#">Questions</a></li>
            <li role="presentation" id="reviews-tab"><a href="#">Reviews</a></li>
            <li role="presentation" id="gallery-tab"><a href="#">Gallery</a></li>
        </ul>

        <div class="container panel-body">
            <div class="tab-body" id="gallery">
                <div id="blueimp-gallery" class="blueimp-gallery">
                    <!-- The container for the modal slides -->
                    <div class="slides"></div>
                    <!-- Controls for the borderless lightbox -->
                    <h3 class="title"></h3>
                    <a class="prev">‹</a>
                    <a class="next">›</a>
                    <a class="close">×</a>
                    <a class="play-pause"></a>
                    <ol class="indicator"></ol>
                    <!-- The modal dialog, which will be used to wrap the lightbox content -->
                    <div class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"></h4>
                                </div>
                                <div class="modal-body next"></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left prev">
                                        <i class="glyphicon glyphicon-chevron-left"></i>
                                        Previous
                                    </button>
                                    <button type="button" class="btn btn-primary next">
                                        Next
                                        <i class="glyphicon glyphicon-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style=" max-width:100% ;display:block; height: auto">
                    @foreach($photos as $photo)
                        <div class="col-sm-4">
                            <a href="{{$photo->path}}" title="{{$photo->caption}}" data-gallery>
                                <img src="{{$photo->path}}" class="thumbnail" style=" max-width:100% ;display:block; height: auto;">
                            </a>
                            @if($photo->caption)
                                <h1>{{$photo->caption}}</h1>
                            @else
                                <h1>......</h1>
                            @endif
                        </div>
                    @endforeach
                </div>

            </div>

        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#posts-tab").click(function(){
                $("li.active").attr("class", null);
                $("#posts-tab").attr("class", "active");
                $(".tab-body").css("display", "none");
                $("#posts").css("display", "block");
            });

            $("#questions-tab").click(function(){
                $("li.active").attr("class", null);
                $("#questions-tab").attr("class", "active");
                $(".tab-body").css("display", "none");
                $("#questions").css("display", "block");
            });

            $("#reviews-tab").click(function(){
                $("li.active").attr("class", null);
                $("#reviews-tab").attr("class", "active");
                $(".tab-body").css("display", "none");
                $("#reviews").css("display", "block");
            });

            $("#gallery-tab").click(function(){
                $("li.active").attr("class", null);
                $("#gallery-tab").attr("class", "active");
                $(".tab-body").css("display", "none");
                $("#gallery").css("display", "block");
            });
        });
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
    <script src="js/bootstrap-image-gallery.min.js"></script>

@endsection
