<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    /**
     * Event has many notifications
     */
     public function events(){

         return $this->belongsToMany('App\Event')->withTimestamps();
     }


    /**
     * Get all the not read notifications.
     * @param $query
     * @return mixed
     */
    public function scopeUnread($query)
    {
        return $query->where('read', '=', '0');
    }

    /**
     * Get all the read notifications.
     * @param $query
     * @return mixed
     */
    public function scopeRead($query)
    {
        return $query->where('read', '=', '1');
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
    public function addNotification($inputUsersArray , $event , $Description , $link)
    {


        /**
         * creating new notification and insert it into notification table
         */
        $date_time = Carbon::now();
        $newNotificaton = new Notification;
        $newNotificaton = [
            'date_time' => $date_time,
            'description' => $Description,
            'link' => $link

        ];
        $newNotificaton->save();

        /**
         *  insert record into event_notification table which is the pivot table of many to many relationship between notifications and events
         */
        $lastInsertedNotificationID = $newNotificaton->id;
        $event->notifications()->attach($lastInsertedNotificationID);

        /**
         * insert record into user_notification table which is the pivot table of many to many relationship between notifications and users
         */

        foreach ($inputUsersArray as $user) {
            $user->notifications()->attach($lastInsertedNotificationID, ['read' => 0]);
        }
    }

    public static function notify($usersToNotify, $event, $description, $link){

        $notification = new Notification;
        $notification['description'] = $description;
        $notification['link'] = $link;
        $event->notifications()->save($notification);

        foreach($usersToNotify as $user)
          $user->notifications()->attach($notification, ['read' =>0]);
    }
}
