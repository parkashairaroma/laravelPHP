<?php
namespace App\Http\Middleware;

use AirAroma\Repository\WebsiteRepository;
use Closure;

class CheckStore
{

    public function __construct(WebsiteRepository $websiteRepo)
    {
        $this->websiterepo = $websiteRepo;
    }

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
        if (!$this->websiterepo->checkIfStoreEnabled()) {
            return abort(404);
        }
        return $next($request);
    }
}