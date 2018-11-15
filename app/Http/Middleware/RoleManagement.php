<?php

namespace App\Http\Middleware;

use Closure;

class RoleManagement
{

    /**
    * Admin role based redirection
    *
    * @param $request
    * @param $next
    * 
    * @return $next
    */
    public function handle($request, Closure $next, $role)
    {
    	if (! auth()->guard('admin')->check()) {
    		return redirect('/admin');
    	}

    	$authRoles = auth()->guard('admin')->user()->roles->lists('rol_token')->toArray();

        if (auth()->guard('admin')->check() && in_array($role, $authRoles)) {
            return $next($request);
        }

        return redirect('/admin');
    }
}