<?php

namespace App\Http\Middleware;

use Closure;
use App\Event as Event;

class EventPostMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
     
        if(!(auth()->guard('organization')->user())){
            return redirect('login_organization');
        }

        $organization_id = auth()->guard('organization')->user()->id;
        $event_id = $request->id;
        
        $ev = Event::where('id', '=', $event_id)->where('organization_id', '=', 1)->exists();
        if(!$ev){
           return redirect('home');
        }

        return $next($request);
    }
}
