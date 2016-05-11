<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Middleware\StringHelper as StringHelper;

class InputCleanup
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
        $input = $request->input();

        array_walk_recursive($input, function(&$value) {

            if (is_string($value) && !$value) {
                $value = null;
            }
        });

        $request->replace($input);

        return $next($request);
    }
}
