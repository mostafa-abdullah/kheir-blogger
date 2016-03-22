<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{

    /**
     * Event has many notifications
     */
     public function events(){

         return $this->belongsToMany('App\Event', 'event_notifications')->withTimestamps();
     }


    /**
     *  Users can receive many notifications
     */
    public function users(){

        return $this->belongsToMany('App\User', 'user_notifications')
                    ->withTimestamps()->withPivot('read');
    }

    /**
     *	Send a notification to the specified list of users
     */
    public static function notify($usersToNotify, $event, $description, $link){

        $notification = new Notification;
        $notification['description'] = $description;
        $notification['link'] = $link;
        $event->notifications()->save($notification);

        foreach($usersToNotify as $user)
          $user->notifications()->attach($notification, ['read' =>0]);
    }
}
