<?php


/* /admin prefix*/
Route::group(['prefix' => 'admin'], function () {

    /* authentication */
    Route::group(['middleware' => 'check.auth:admin'], function () {

        /* admin/ajax prefix */
        Route::group(['prefix' => 'api'], function () {

            // if ajax called from parent page, otherwise displays nothing
            Route::group(['middleware' => 'referrer'], function () {

                Route::match(['put'],     '/users/edit/{id}',                  'Admin\UserController@updateUser');
                Route::match(['put'],     '/emails/edit/{id}/{region}/{emails}',        'Admin\EmailController@updateEmailList');

                Route::match(['put'],     '/links/edit/{id}',                  'Admin\LinkController@updateLinkTranslation');
                Route::match(['put'],     '/tags/edit/{id}',                   'Admin\TagController@updateTagTranslation');
                Route::match(['put'],     '/industries/edit/{id}',             'Admin\IndustryController@updateIndustryTranslation');

                Route::match(['put'],     '/tokens/edit/{id}',                 'Admin\TokenController@editTokenTranslation');
                Route::match(['post'],    '/tokens/create',                    'Admin\TokenController@createToken');
                Route::match(['get'],     '/tokens/view/{id}',                 'Admin\TokenController@getTranslation');
                //Route::match(['put'],     '/tokens/translate',                 'Admin\TokenController@edit');
                Route::match(['delete'],  '/tokens/delete/{id}',               'Admin\TokenController@deleteToken');

                Route::match(['put'],     '/pages/status/{id}',                'Admin\PageController@updatePageStatus');

                Route::match(['put'],     '/banners/order',                    'Admin\BannerController@updateBannerOrder');
                Route::match(['put'],     '/banners/status/{id}',              'Admin\BannerController@updateBannerStatus');
                Route::match(['get'],     '/banners/gallery',                  'Admin\GalleryController@bannerModal');
                Route::match(['post'],    '/banners/gallery',                  'Admin\GalleryController@bannerUploadImage');

                Route::match(['put'],     '/clients/order',                    'Admin\ClientController@updateClientOrder');
                Route::match(['put'],     '/clients/status/{id}',              'Admin\ClientController@updateClientStatus');
                Route::match(['get'],     '/clients/gallery',                  'Admin\GalleryController@clientModal');
                Route::match(['post'],    '/clients/gallery',                  'Admin\GalleryController@clientUploadImage');
                Route::match(['get'],     '/clients/gallery/delete/{id}',      'Admin\GalleryController@clientDeleteImage');

                Route::match(['put'],     '/blog/status/{id}',                 'Admin\BlogController@updateBlogStatus');
                Route::match(['get'],     '/blog/gallery',                     'Admin\GalleryController@blogModal');
                Route::match(['get'],     '/blog/gallery/delete/{id}',         'Admin\GalleryController@blogDeleteImage');
                Route::match(['post'],    '/blog/gallery',                     'Admin\GalleryController@blogUploadImage');

                Route::match(['put'],     '/websites/push/{id}',               'Admin\WebsiteController@pushChangesToWebsite');
            });
        });
    });
});
