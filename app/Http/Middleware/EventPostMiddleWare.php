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
            if ($request->ajax() || $request->wantsJson()) {
                        return response('Unauthorized.', 401);
                    } else {
                        return redirect()->guest('login_organization');
            }
        }

        $organization_id = auth()->guard('organization')->user()->id;
        $event_id = $request->event_id;
        
        $ev = Event::where('id', '=', $event_id)->where('organization_id', '=', 1)->exists();
        if(!$ev){
            // echo var_dump($request)."<br />";
            // echo $request->event_id;
            // echo $event_id . " - " . $organization_id;
            // die();
            return redirect('home');
        }

        return $next($request);
    }
}
