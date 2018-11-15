<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;

class RedirectToSSL extends Controller
{
    /**
    * Redirect user to SSL
    *
    * @param $request
    * @param $next
    * 
    * @return $next
    */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && env('APP_DEBUGNOSSL') !== true) {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request); 
    }
}