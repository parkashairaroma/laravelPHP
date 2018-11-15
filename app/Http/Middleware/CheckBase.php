<?php

namespace App\Http\Middleware;

use Closure;

class CheckBase
{
	/**
    * Determine if url slug is Admin
    *
    * @param $request
    * @param $next
    * 
    * @return validator object
    */
    public function handle($request, Closure $next)
    {
        if (isBase()) {
            return $next($request);
        }

        return redirect('/admin');
    }
}