<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\EventPostService;

use App\Http\Requests\EventPostRequest;

class EventPostAPIController extends Controller
{
    private $eventPostService;

    public function __construct()
    {
        $this->eventPostService = new EventPostService();
        $this->middleware('auth_organization', ['only' => [
             'store',
        ]]);
    }

    public function store(EventPostRequest $request, $event_id)
    {
        $this->eventPostService($request, $event_id);
    }
}
