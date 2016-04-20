<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Photo;
use App\Event;
use Validator;

class EventGalleryController extends Controller
{
    public function __construct()
	{
        $this->middleware('auth_organization', ['only' => [
            'add', 'upload', 'store'
        ]]);
    }

    public function add($id)
    {
        $event = Event::findOrFail($id);
        if(auth()->guard('organization')->user()->id == $event->organization()->id){
            return view('event.gallery.upload', compact('event'));
        }
        return redirect('/');
    }

    public function upload(Request $request,$id)
    {
        $event = Event::findOrFail($id);
        if(auth()->guard('organization')->user()->id == $event->organization()->id) {
            $input = $request->all();
            $files = $input['images'];
            $names = array();
            $path = 'app/storage/db/gallery/' . $event->id . '/';

            foreach ($files as $file) {
                $rules = array('file' => 'required|image');
                $validator = Validator::make(array('file' => $file), $rules);

                if ($validator->passes()) {

                    $filename = md5($file->getClientOriginalName(), false);
                    $upload_success = $file->move($path, $filename);
                    if ($upload_success) {
                        array_push($names, $filename);
                    } else {
                        // return redirect()->action('EventController@test');
                    }
                } else {
                    // return redirect()->action('EventController@test');
                }
            }


            return view('event.gallery.caption', compact('names','event', 'path'));
        }
        return redirect('/');
    }

    public function store(Request $request, $id)
    {
        $event = Event::findorfail($id);
        if (auth()->guard('organization')->user()->id == $event->organization()->id)
        {
            $input = $request->all();
            $captions = $input['captions'];
            $names = $input['names'];

            foreach (array_combine($names, $captions) as $name => $caption)
            {
                $photo = new Photo;
                $photo->name = $name;
                $photo->caption = $caption;
                $photo->event_id = $id;
                $photo->save();
            }
        }
        return redirect()->action('Event\EventController@show', [$id]);

    }
}
