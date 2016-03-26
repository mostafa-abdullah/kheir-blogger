<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event as Event;
use App\Notification;
use Carbon\Carbon;

class sendConfirmations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'confirmations:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Event Confirmations to User.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       
            $EventsList = Event::all();
            foreach($EventsList as $event){
                $EventsList = Event::all();
                if($event->timing < carbon::now()){
                    $description = "Confirm Attendance for ".$event->name;
                    Notification::notify($event->registrants()->get(), $event,
                        $description, action('EventController@confirm',[$event->id]));
                }

            }


    }
}
