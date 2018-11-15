<?php

namespace App\Providers;

use AirAroma\Library\ConfigGenerator;

use Illuminate\Support\ServiceProvider;
use Hash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(ConfigGenerator $configGenerator)
    {
        $configGenerator->create();

        /* custom form validator */
        validator()->extend('alpha_num_spaces', function($attribute, $value)
        {
            return preg_match('/^[a-zA-Z0-9\s]+$/u', $value);
        });

        validator()->extend('current_password', function($attribute, $value)
        {
            return Hash::check($value, auth()->guard('store')->user()->password);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}