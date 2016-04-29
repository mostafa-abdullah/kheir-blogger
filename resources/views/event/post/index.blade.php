<div class="tab-body" id="posts">
    @if($creator)
        @include('event.partials.button', ['buttonText' => 'Add Post', 'action' => 'post/create'])
    @endif
    @if(!count($event->posts))
     <h3 class="alert-info">This Event has no posts</h3>
    @else
        <div class="row">
            <hr>
             @foreach($event->posts as $post)
                 <ul>
                     <li>
                         @if($creator)
                             @include('event.partials.button', ['buttonText' => 'Edit Post', 'action' => "post/".$post->id."/edit/"])
                         @endif
                         @if ($creator || (Auth::user() && Auth::user()->role >= 8))
                             <form action="{{ url('event/'.$event->id."/post/".$post->id) }}" method="POST">
                                  {!! csrf_field() !!}
                                  {!! method_field('DELETE') !!}
                                  <button type="submit" class="btn btn-danger btn-event">Delete Post</button>
                             </form>
                        @endif
                         <h4>{{$post->title}}  <small>{{$post->created_at}}</small></h4>
                         <p>
                             {{$post->description}}
                         </p>

                     </li>
                 </ul>
             @endforeach
        </div>
    @endif
</div>
