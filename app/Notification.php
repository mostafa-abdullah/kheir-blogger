<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    public function events()
    {
        return $this->belongsToMany('App\Event', 'event_notifications')
                    ->withTimestamps();
    }

    public function notifiedVolunteers()
    {
         return $this->belongsToMany('App\User', 'user_notifications')
                     ->withTimestamps()->withPivot('read');
    }

    public function scopeUnread($query)
    {
        return $query->where('read', '=', '0');
    }

    public function scopeRead($query)
    {
        return $query->where('read', '=', '1');
    }

    public static function notify($usersToNotify, $type, $event, $description, $link)
    {
        $notification = new Notification;
        $notification['type'] = $type;
        $notification['description'] = $description;
        $notification['link'] = $link;
        $notification->save();
        if($event)
        {
            $event->notifications()->attach($notification);
            $usersToNotify = Notification::filter($usersToNotify, $event->organization_id);
        }
        foreach($usersToNotify as $user)
            $user->notifications()->attach($notification, ['read' => 0]);
    }

    public static function filter($usersToNotify, $organization_id)
    {
        $organization = Organization::findOrFail($organization_id);

        $filteredUsersToNotify = array();
        foreach($usersToNotify as $user)
        {
            if(!$organization->blockingVolunteers()->find($user->id))
                 $filteredUsersToNotify[] = $user;
        }
        return $filteredUsersToNotify;
    }
}
