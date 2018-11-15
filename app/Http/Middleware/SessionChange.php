<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;

class SessionChange extends Controller
{

    /**
    * Destroy session if changed to another domain
    *
    * @param $request
    * @param $next
    * 
    * @return $next
    */
    public function handle($request, Closure $next)
    {
        if (! preg_match('~(admin/login)~', $request->path()) &&  $request->session()->get('websiteId') != websiteId()) {    
        	auth()->guard('admin')->logout();
        }
        return $next($request);
    }
}