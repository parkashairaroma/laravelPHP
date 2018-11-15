<?php

namespace App\Http\Middleware;

use Closure;

class CheckAuth
{
    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct()
    {
        $this->basePath = getConfig('siteConfig', 'base_path');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (! auth()->guard($guard)->check()) {
            switch($guard) {
                case 'admin':
                    return redirect($this->basePath.'/admin/login');
                break;
                case 'store':
                    return redirect($this->basePath.'/store/signin');
                break;
            }
        }

        return $next($request);
    }
}
