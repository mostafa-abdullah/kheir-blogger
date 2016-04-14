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
                @foreach($photos as $photo)
                    <div class="img">
                        <img src="{{$photo->path}}" class="img-rounded" width="300" height="200">
                        <div class="desc">Add a description of the image here</div>
                    </div>
                    @if($photo->caption)
                        <h1>{{$photo->caption}}</h1>
                    @else
                        <h1>......</h1>
                    @endif
                @endforeach
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
@endsection
