<?php

$websiteRepository = app('AirAroma\Repository\WebsiteRepository');

$lang = $websiteRepository->language();

/* Admin */
Route::group(['prefix' => $lang], function () {

    Route::group(['prefix' => 'admin'], function () {

        Route::match(['get', 'post'],   '/login',   'Admin\AdminController@login');

        /* authentication */
       Route::group(['middleware' => 'check.auth:admin'], function () {

            Route::match(['get'], '/',       'Admin\AdminController@index');
            Route::match(['get'], '/logout', 'Admin\AdminController@logout');

            Route::group(['middleware' => 'role:manage_users'], function () {
                Route::match(['get'], '/users', 'Admin\UserController@getUsers');
                Route::match(['post', 'get'], '/users/create',       'Admin\UserController@createUser');
            });

            Route::group(['middleware' => 'role:manage_blog'], function () {
                Route::match(['get'],         '/blog',              'Admin\BlogController@getBlogs');
                Route::match(['post', 'get'], '/blog/create',       'Admin\BlogController@createBlog');
                Route::match(['get'],         '/blog/delete/{id}',  'Admin\BlogController@deleteBlog');
                Route::match(['post', 'get'], '/blog/edit/{id}',    'Admin\BlogController@editBlog');
            });

            Route::group(['middleware' => 'role:manage_pages'], function () {
                Route::match(['get'],   '/pages',           'Admin\PageController@getPages');
                Route::match(['get'],   '/pages/edit/{id}', 'Admin\PageController@getPage');
            });

            Route::group(['middleware' => 'role:manage_tags'], function () {
                Route::match(['get'],   '/tags', 'Admin\TagController@getTags');
            });

            Route::group(['middleware' => 'role:manage_industries'], function () {
                Route::match(['get'],   '/industries', 'Admin\IndustryController@getIndustries');
            });

            Route::group(['middleware' => 'role:manage_links'], function () {
                Route::match(['get'],   '/links', 'Admin\LinkController@getLinks');
            });

            Route::group(['middleware' => 'role:manage_websites', 'middleware' => 'check.base'], function () {
                Route::match(['get'],   '/websites', 'Admin\WebsiteController@getWebsites');
                Route::match(['post', 'get'],   '/websites/edit/{id}', 'Admin\WebsiteController@editWebsite');
            });

           Route::group(['middleware' => 'role:manage_orders'], function () {
               Route::match(['get'],   '/orders', 'Admin\OrderController@getOrders');
               Route::match(['post', 'get'],   '/orders/sendTrackingEmail', 'Admin\OrderController@sendTrackingEmail');
               Route::match(['post', 'get'],   '/orders/edit/{id}', 'Admin\OrderController@editOrder');
           });

           Route::group(['middleware' => 'role:manage_products'], function () {
               Route::match(['get'],   '/products', 'Admin\ProductController@getProducts');
               Route::match(['post', 'get'],   '/products/edit/{id}', 'Admin\ProductController@editProduct');
               Route::match(['post', 'get'],   '/products/create', 'Admin\ProductController@createProduct');
           });

           Route::group(['middleware' => 'role:manage_vouchers'], function () {
               Route::match(['get'],   '/vouchers', 'Admin\VoucherController@getVouchers');
               Route::match(['post', 'get'],   '/vouchers/edit/{id}', 'Admin\VoucherController@editVoucher');
               Route::match(['post', 'get'],   '/vouchers/create', 'Admin\VoucherController@createVoucher');
           });

           Route::group(['middleware' => 'role:manage_members'], function () {
               Route::match(['get'],   '/members', 'Admin\AccountController@getMembers');
               Route::match(['post', 'get'],   '/members/edit/{id}', 'Admin\AccountController@editMember');
           });

           Route::group(['middleware' => 'role:manage_emails'], function () {
               Route::match(['get'],   '/emails', 'Admin\EmailController@getEmailsList');
           });

            Route::group(['middleware' => 'role:manage_banners'], function () {
                Route::match(['get'],         '/banners',             'Admin\BannerController@getBanners');
                Route::match(['post', 'get'], '/banners/create',      'Admin\BannerController@createBanner');
                Route::match(['get'],         '/banners/delete/{id}', 'Admin\BannerController@deleteBanner');
                Route::match(['post', 'get'], '/banners/edit/{id}',   'Admin\BannerController@editBanner');
            });

           Route::group(['middleware' => 'role:manage_clients'], function () {
               Route::match(['get'],         '/clients',             'Admin\ClientController@getClients');
               Route::match(['post', 'get'], '/clients/create',      'Admin\ClientController@createClient');
               Route::match(['get'],         '/clients/delete/{id}', 'Admin\ClientController@deleteClient');
               Route::match(['post', 'get'], '/clients/edit/{id}',   'Admin\ClientController@editClient');
           });
        });
    });
});

