<div class="tab-body" id="reviews" hidden>
    @if($reviews->count()==0)
        <h3 class="alert-info">This Event has no Reviews</h3>
    @else
    @foreach($reviews as $review)
        <div class="jumbotron">

            <h3>
                {{$review->review}}
            </h3>
                <h5>By {{\App\User::findOrFail($review->user_id)->name}}</h5>
        </div>
    @endforeach
    @endif
</div>
