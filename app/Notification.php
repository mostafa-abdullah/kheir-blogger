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

    public static function notify($usersToNotify, $event, $description, $link){

        $notification = new Notification;
        $notification['description'] = $description;
        $notification['link'] = $link;
        $notification->save();
        $event->notifications()->attach($notification);

        $filteredUsersToNotify = Notification::filter($usersToNotify,$event);

        foreach($filteredUsersToNotify as $user)
            $user->notifications()->attach($notification, ['read' => 0 ]);


    }

    /**
     *  remove users from user to be notified who blocked the organization created an event
     */
    public static function filter ($usersToNotify, $event){
        $organization_id = $event->organization_id;
        $organization = Organization::find($organization_id);

        $filteredUsersToNotify = array();

        foreach($usersToNotify as $user)
        {
            $result =  $user->blockOrganisation()->where('organization_id','=',$organization_id)->get();
            /*
             * check if the returned result does not contain an result which means that this user does not block the organization that created the event so add it to the filtered users array
             */
             if($result->count() == 0){
                 $filteredUsersToNotify[] = $user;
             }
        }
        return $filteredUsersToNotify;

    }

}
