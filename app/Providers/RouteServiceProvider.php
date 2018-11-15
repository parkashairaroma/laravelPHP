<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
   // protected $namespace = 'AirAroma\Controller';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
       $router->group(['namespace' => 'AirAroma\Controller'], function ($router)  {

            if (env('APP_ENV') == 'development') {
                require app_path('AirAroma/Route/dev-routes.php'); 
            }

            switch (getConfig('siteConfig', 'interface')) {
                 case 'admin':
                    require app_path('AirAroma/Route/admin-routes.php');
                    require app_path('AirAroma/Route/admin-api-routes.php');
                break;
                default:
                    require app_path('AirAroma/Route/routes.php');
                    require app_path('AirAroma/Route/api-routes.php');
                    require app_path('AirAroma/Route/store-routes.php');
            }

        });
    }
}
