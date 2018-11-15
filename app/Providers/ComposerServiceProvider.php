<?php

namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', 'AirAroma\Composer\GlobalComposer');
        View::composer('admin/blog/*', 'AirAroma\Composer\BlogComposer');
        View::composer('admin/websites/*', 'AirAroma\Composer\WebsiteComposer');
        View::composer('admin/banners/*', 'AirAroma\Composer\BannerComposer');
        View::composer('admin/clients/*', 'AirAroma\Composer\ClientComposer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(app_path().'/AirAroma/Helpers/*.php') as $filename){
            require_once($filename);
        }
    }
}
