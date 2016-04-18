<div class="tab-body" id="gallery" hidden>
    Here will be the gallery.
    @if($creator)
        @include('event.partials.button', ['buttonText' => 'Upload photos', 'action' => 'gallery/upload'])
    @endif
</div>
