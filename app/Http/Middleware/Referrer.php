<?php

namespace App\Http\Middleware;

use Closure;

class Referrer
{

    /**
     * Create a new filter instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! env('APP_DEBUG')) {
            if ( ! $request->server('HTTP_REFERER')) {
                exit;
            }
        }

        return $next($request);
    }
}
