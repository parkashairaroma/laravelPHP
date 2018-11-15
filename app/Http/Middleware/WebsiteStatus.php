<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;

class WebsiteStatus extends Controller
{

    /**
    * Enable translating mode 
    *
    * @param $request
    * @param $next
    * 
    * @return $next
    */
    public function handle($request, Closure $next)
    {
        $config = getConfig('siteConfig');

        if ( $config['web_status'] == websiteStatus('translating')) {

            if (! auth()->guard('admin')->check() && $config['interface'] != 'admin') {
                return response()->view('translating', [], 503);
            }
        }
        return $next($request);
    }
}