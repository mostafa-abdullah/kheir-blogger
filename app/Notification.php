<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Notification extends Model
{
    /**
     * Event has many notifications
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function events(){
        return $this->belongsToMany('App\Event')->withTimestamps();
    }

    /**
     *  Users can receive many notifications
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function users(){
        return $this->belongsToMany('App\User')->withTimestamps()->withPivot('read');
    }

    /**
     *
     */
    public function addNotification ($inputUsersArray , $event , $Description , $link){


        /**
         * creating new notification and insert it into notification table
         */
        $date_time =  Carbon::now();
        $newNotificaton = new Notification ;
        $newNotificaton = [
                              'date_time' =>  $date_time,
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

        foreach($inputUsersArray as $user){
          $user->notifications()->attach($lastInsertedNotificationID,['read'=>0]);
        }
    }
}
