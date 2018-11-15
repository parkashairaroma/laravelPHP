<?php

/* Store */
$routeGenerator = app('AirAroma\Library\RouteGenerator');

/* authentication */

if (websiteId() == 1 || websiteId() == 4)           // apply for US store for now -- temporary check
{

    Route::group(['middleware' => ['check.store','https']], function() use ($routeGenerator) {

        /* ajax */
        Route::group(['middleware' => 'check.ajax'], function () {
            Route::match(['put'], '/ajax/store/address/{type?}',  'Store\AjaxController@updateAddress');
            Route::match(['get'], '/ajax/store/address/postcode/{countrycode}/{postcode}',  'Store\AjaxController@postcodeSearch');
            Route::match(['get'], '/ajax/store/cart/shipping/{serviceCode}',  'Store\AjaxController@setShippingService');
            Route::match(['put'], '/ajax/store/cart',  'Store\AjaxController@updateCart');
            Route::match(['post'], '/ajax/store/cart',  'Store\AjaxController@addToCart');
            Route::match(['get'], '/ajax/store/cart/{productId}',  'Store\AjaxController@removeFromCart');
            Route::match(['get'], '/ajax/store/voucher/{code}',  'Store\AjaxController@getVoucherByCode');
            Route::match(['get'], '/ajax/store/states',  'Store\AjaxController@getStates');
            Route::match(['get'], '/ajax/store/counties',  'Store\AjaxController@getCounties');
        });

        Route::group(['middleware' => ['blade']], function () use ($routeGenerator) {
            $routeGenerator->route([
                '/store' => ['controller' => 'Store\StoreController@showpage', 'request' => ['get']],
                //'/store/activation/{code}' => ['controller' => 'Store\AccountController@activateAccount', 'request' => ['get']],
                '/store/aromax' => ['controller' => 'Store\StoreController@viewAromax', 'request' => ['get']]
            ]);
        });

        Route::match(['get'],         '/store', 'Store\StoreController@viewStore');
        Route::match(['get'],         '/store/cart', 'Store\StoreController@viewCart');
        Route::match(['get'],         '/store/social/facebook/login', 'Store\AccountController@redirectToFacebook');
        Route::match(['get'],         '/store/social/facebook', 'Store\AccountController@handleFacebookCallback');
        Route::match(['get', 'post'], '/store/signin', 'Store\AccountController@signin');
        Route::match(['get', 'post'], '/store/signup', 'Store\AccountController@signup');
        Route::match(['get'],         '/store/signout', 'Store\AccountController@signout');
        Route::match(['get', 'post'], '/store/forgot-password', 'Store\AccountController@passwordReset');
        Route::match(['get', 'post'], '/store/forgot-password/{token}', 'Store\AccountController@passwordCreate');
        Route::match(['get', 'post'], '/store/activation/{code}', 'Store\AccountController@activateAccount');
        Route::match(['get', 'post'], '/store/reactivation', 'Store\AccountController@reactivationCode');
        //Route::match(['get', 'post'], '/store/ecommercestore', 'Store\AccountController@ecommerceStore');

        Route::match(['get', 'post'], '/store/paypal/ipnlistener', 'Store\CheckoutController@paypalIpnListener');

        Route::group(['middleware' => ['check.auth:store']], function () {
            Route::match(['get', 'post'], '/store/account', 'Store\AccountController@viewAccount');
            Route::match(['get', 'post'], '/store/account/address/{addressId}', 'Store\AccountController@viewAccount');
            Route::match(['get', 'post'], '/store/account/address/{type}/{addressId}', 'Store\AccountController@viewAccount');
            Route::match(['get', 'post'], '/store/account/email', 'Store\AccountController@updateEmail');
            Route::match(['get', 'post'], '/store/account/password', 'Store\AccountController@updatePassword');
            Route::match(['get', 'post'], '/store/account/orders', 'Store\AccountController@viewOrders');
            Route::match(['get'],         '/store/account/orders/{orderId}', 'Store\AccountController@viewOrder');
            Route::match(['get', 'post'], '/store/checkout', 'Store\CheckoutController@checkout');
            Route::match(['get', 'post'], '/store/applepaycharge', 'Store\CheckoutController@ApplePayCharge');
            Route::match(['get', 'post'], '/store/checkout/address/{type}/{addressId}', 'Store\CheckoutController@checkout');
            Route::match(['get', 'post'], '/store/addressbook', 'Store\AccountController@viewAddressBook');
            Route::match(['get', 'post'], '/store/checkout/successpaypal', 'Store\CheckoutController@successOrderEmail');
        });

        $routeGenerator->slug([
            '/store' => ['controller' => 'Store\StoreController@viewOils', 'slug' => '{categorySlug}/{productSlug?}/{groupSlug?}', 'request' => ['get']],
        ]);

    });
}


else                  // Need to put https once SSl is on.
{
    Route::group(['middleware' => ['check.store']], function() use ($routeGenerator) {
        Route::match(['get', 'post'], '/store', 'Store\StoreController@showTranslationPage');
        Route::any('/store/{any}', 'Store\StoreController@showTranslationPage')->where('any', '.*');
    });
}



