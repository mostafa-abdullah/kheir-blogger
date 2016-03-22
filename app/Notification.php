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
        $event->notifications()->save($notification);

        foreach($usersToNotify as $user)
          $user->notifications()->attach($notification, ['read' => 0 ]);
    }
}
