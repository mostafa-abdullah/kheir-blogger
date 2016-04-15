<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event as Event;
use App\Notification as Notification;
use Carbon\Carbon;

define("EVENT_TYPE_CONFIRM_ATTENDANCE", 6);

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
        $start = Carbon::now();
        $start->hour -= 3;
        $end = Carbon::now();

        $EventsList = Event::betweenTiming($start,$end)->get();
        foreach($EventsList as $event)
        {
            $event_notifications = $event->notifications()->get();
            $event_attendees = $event->registrants()->get();
            $sentBefore=false;
            if($event->timing < carbon::now())
            {
                foreach($event_notifications as $notification)
                {
                    $notification_id = $notification->id;
                    $mainNotification = Notification::findOrFail($notification_id);
                    if($mainNotification->type == EVENT_TYPE_CONFIRM_ATTENDANCE)
                    {
                        $sentBefore=true;
                        break;
                    }
                }
                if(!$sentBefore)
                {
                    $description = "Confirm Attendance for ".$event->name;
                    Notification::notify($event_attendees, EVENT_TYPE_CONFIRM_ATTENDANCE,
                                $event, $description, "/event/{$event->id}"); 
                }

            }
        }
    }
}
