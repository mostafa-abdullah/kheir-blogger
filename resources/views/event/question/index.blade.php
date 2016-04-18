<div class="tab-body" id="questions" hidden>
    {{-- Volunteer can ask questions --}}
    @if (Auth::user() && Auth::user()->role > 0)
        @include('event.partials.button', ['buttonText' => 'Ask question', 'action' => 'question/create'])
    @endif

    {{--  Organizers can see unanswered questions --}}
    @if($creator)
        @include('event.partials.button', ['buttonText' => 'View unanswered questions', 'action' => 'question/answer'])
    @endif
    @if($questions->count()==0)
        <h3 class="alert-info">This Event has no answered questions</h3>
    @else
    @foreach($questions as $question)
        <?php $volunteer = \App\User::find($question->id); ?>
        <ul>
            <li>
                <h3>
                    {{$question->question_body .'?'}}
                    <small>By {{ $volunteer->first_name }} {{ $volunteer->last_name}}</small>
                </h3>
                <h4>{{$question->answer}}</h4>
            </li>
        </ul>
    @endforeach
    @endif
</div>
