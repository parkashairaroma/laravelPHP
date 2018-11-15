<?php

namespace App\Http\Middleware;

use Closure;

class DetermineBlade
{
    public function __construct()
    {
        $this->app = app();
    	$this->pageRepository = $this->app['AirAroma\Repository\PageRepository'];
    }

    /**
    * Determine which blade to use based on translation
    *
    * @param $request
    * @param $next
    * 
    * @return $next
    */
    public function handle($request, Closure $next)
    {
    	$lang = null;
    	$parameters = $request->route()->parameters();

    	if (array_key_exists('lang', $parameters)) {
    		$lang = $request->route()->parameters()['lang'];
    	}

    	$blade = $this->pageRepository->findBladeTemplate($lang);

    	$request->attributes->add(['blade' => $blade]);

        return $next($request);
    }
}