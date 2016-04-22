<div class="tab-body" id="posts">
    @if($creator)
        @include('event.partials.button', ['buttonText' => 'Add Post', 'action' => 'post/create'])
    @endif
    @if($posts->count()==0)
     <h3 class="alert-info">This Event has no posts</h3>
    @else
     @foreach($posts as $post)
         <ul>
             <li>
                 <form action="{{ url('event/'.$event->id."/post/".$post->id) }}" method="POST">
                      {!! csrf_field() !!}
                      {!! method_field('DELETE') !!}
                      <button type="submit" class="btn btn-danger btn-event">Delete Post</button>
                 </form>
                 <h4>{{$post->title}}  <small>{{$post->created_at}}</small></h4>
                 <p>
                     {{$post->description}}
                 </p>

             </li>
         </ul>
     @endforeach
    @endif
</div>
