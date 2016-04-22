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
                 <h4>{{$post->title}}  <small>{{$post->created_at}}</small></h4>
                 <p>
                     {{$post->description}}
                 </p>
             </li>
         </ul>
     @endforeach
    @endif
</div>
