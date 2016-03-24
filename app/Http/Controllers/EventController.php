<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    /**
     * show method to show an event
     * @param $id : the id of a certain event
     * @return A view to show a certain event
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        $announcement = ['1st announcement', '2nd announcement', '3rd announcement'];
        $questions = [['question' => 'When the event will be Held', 'answer' => 'In 12 pm sharp'], ['question' => 'When the event will be Held', 'answer' => 'In 12 pm sharp']];
        $reviews=[['writen_by'=>'Hossam','Body'=>'la bla bla'],['writen_by'=>'Ahmed','Body'=>'It is very Best =)']];
        return view('event.event', compact('event', 'announcement', 'questions','reviews'));
    }


    public function create()
    {
        return view('event.create');
    }




}
