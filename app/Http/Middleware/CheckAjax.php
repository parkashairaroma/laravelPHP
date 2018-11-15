<?php
namespace App\Http\Middleware;

use Closure;

class CheckAjax
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->ajax()) {
            return response('Unauthorized.', 401);
        }
        return $next($request);
    }
}