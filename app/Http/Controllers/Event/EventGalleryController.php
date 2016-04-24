<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Contracts\Filesystem;

use App\Photo;
use App\Event;

use Validator;
use File;

class EventGalleryController extends Controller
{
    public function __construct()
	{
        $this->middleware('auth_organization', ['only' => [
            'add', 'upload', 'store', 'edit', 'update'
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
        if(auth()->guard('organization')->user()->id == $event->organization()->id)
        {
            $input = $request->all();
            $files = $input['images'];
            $names = array();
            $path = 'storage/app/db/gallery/' . $event->id . '/';

            foreach ($files as $file)
            {
                $rules = array('file' => 'required|image');
                $validator = Validator::make(array('file' => $file), $rules);

                if ($validator->passes())
                {
                    $filename = md5($file->getClientOriginalName(), false);
                    $upload_success = $file->move($path, $filename);
                    if ($upload_success)
                        array_push($names, $filename);
                }
            }


            return view('event.gallery.caption', compact('names','event', 'path'));
        }
        return redirect('/');
    }

    public function store(Request $request, $id)
    {
        $event = Event::findOrFail($id);
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

    /*
     *  edit or add caption to a single photo
     */
    public function edit($id, $photo_id)
    {
        $event = Event::findorfail($id);
        if (auth()->guard('organization')->user()->id == $event->organization()->id)
        {
            $photo = Photo::findorfail($photo_id);
            $path = 'storage/app/db/gallery/' . $event->id . '/';
            return view('event.gallery.edit',compact('photo', 'event', 'path'));
        }
        return redirect('/');
    }

    /*
     * updates the photo with the modified or new caption
     */
    public function update(Request $request, $id, $photo_id)
    {
        $event = Event::findorfail($id);
        if (auth()->guard('organization')->user()->id == $event->organization()->id)
        {
            $photo = Photo::findorfail($photo_id);
            $input = $request->all();
            $caption = $input['caption'];
            $photo->caption = $caption;
            $photo->save();
            return redirect()->action('Event\EventController@show', [$id]);
        }
        return redirect('/');
    }

    /*
     * delete a photo
     */
    public function destroy($id, $photo_id)
    {
        $event = Event::findOrFail($id);
        if(auth()->guard('organization')->user()->id == $event->organization()->id)
        {
            $photo = Photo::findOrFail($photo_id);
            File::delete('storage/app/db/gallery/' . $event->id . '/'.$photo->name);
            $photo->delete();
            return redirect()->action('Event\EventController@show', [$id]);
        }
        return redirect('/');
    }
}
