<?php $path = 'storage/app/db/gallery/' . $event->id . '/'; ?>
<link href="{{asset('css/lightbox.css')}}" rel="stylesheet">

<div class="tab-body" id="gallery" hidden>
    @if($creator)
            @include('event.partials.button', ['buttonText' => 'Upload photos', 'action' => 'gallery/upload'])

    @endif

    @if($photos->count()==0)
        <h3 class="alert-info">This Event has no gallery</h3>
    @else
        <div>

            <div class="row" style=" max-width:100% ;display:block; height: auto">
                <hr>
                @foreach($photos as $photo)
                    <div class="col-sm-4" style="margin-bottom:30px">
                        <a class="example-image-link"  href="{{asset($path.$photo->name)}}" data-lightbox="roadtrip" data-title="{{$photo->caption}}">
                            <img class="example-image" src="{{asset($path.$photo->name)}}" style="max-width:100%;">
                        </a>
                        @if ($creator || (Auth::user() && Auth::user()->role >= 8))
                            <form action="{{ url('event/'.$event->id.'/deletephoto/'.$photo->id) }}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <button type="submit" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-event">Delete photo</button>
                            </form>
                        @endif
                        @if($creator)
                            <form action="{!! url('event/'.$event->id.'/photo/'.$photo->id.'/edit') !!}" method="get">
                                @if($photo->caption)
                                    <button type="submit" class="btn btn-danger btn-event">Edit caption</button>
                                @else
                                    <button type="submit" class="btn btn-danger btn-event">Add caption</button>
                                @endif
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
