<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\GeoLocate::class,
        \App\Http\Middleware\SessionChange::class,
        \App\Http\Middleware\WebsiteStatus::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'csrf' => \App\Http\Middleware\VerifyCsrfToken::class,
        'blade' => \App\Http\Middleware\DetermineBlade::class,
        'check.store' => \App\Http\Middleware\CheckStore::class,
        'check.auth' => \App\Http\Middleware\CheckAuth::class,
        'check.ajax' => \App\Http\Middleware\CheckAjax::class,
        'check.base' => \App\Http\Middleware\CheckBase::class,
        'referrer' => \App\Http\Middleware\Referrer::class,
        'role' => \App\Http\Middleware\RoleManagement::class,
        'https' => \App\Http\Middleware\RedirectToSSL::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can' => \Illuminate\Foundation\Http\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
