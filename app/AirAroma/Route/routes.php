<?php

$routeGenerator = app('AirAroma\Library\RouteGenerator');

/* Permanent link redirects for non-existent pages */
Route::match(['get'], '/who-scenting/{industry}', function () {
    return redirect('/scenting', 308);
})
->where(['industry' => '(food|entertainment|transport)']);

Route::match(['get'], '/who-scenting/{industry?}', function ($industry = null) {
    return redirect('/scenting/'.$industry, 301);
});

Route::match(['get'], '/scenting/{industry}', function () {
    return redirect('/scenting', 308);
})
->where(['industry' => '(food|entertainment|transport)']);


Route::match(['get'], '/our-clients/{client?}', function ($client = null) {
    return redirect('/clients/'.$client, 301);
});
Route::match(['get'], '/essentialoils', function () {
    return redirect('/essential-oils', 301);
});
Route::match(['get'], '/aromaoils', function () {
    return redirect('/aroma-oils', 301);
});

    Route::group(['middleware' => ['csrf', 'blade', 'https']], function () use ($routeGenerator) {

        /* Routes (translated) */
        $routeGenerator->route([
            '/about' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/aroma-oils' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/aromax' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/aromax/techspecs' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/aropromo/how-it-works' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/aroscent' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/aroscent/techspecs' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/aroslim' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/aroslim/techspecs' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/aroslim/techspecs' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/arotec' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/buyer-beware' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/diffusers' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/ecoscent' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/ecoscent/techspecs' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/environment' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/essential-oils' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/legal' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/no-stress-arobalance' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/no-stress-arobalance/how-it-works' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/products' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/scent-marketing' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/scents' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/services' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/signature-scent' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            '/why-air-aroma' => ['controller' => 'PageController@showPage', 'request' => ['get']],
            ]);

        /* Routes to be redirected (translated) */
        // $routeGenerator->redirect([
        //     '/who-scenting' => ['redirect' => ['url' => '/scenting', 'code' => '301']],
        //     '/our-clients' => ['redirect' => ['url' => '/clients', 'code' => '301']],
        //     '/external' => ['redirect' => ['url' => 'http://google.com', 'code' => '301']],
        //     ]);

    });

    if (websiteId() == 5)           // Disabling Blog Area for Dutch site
    {
        Route::group(['middleware' => ['csrf','https']], function () use ($routeGenerator) {

            $routeGenerator->route([
                '/' => ['controller' => 'PageController@index', 'request' => ['get']],
                '/aropromo' => ['controller' => 'PageController@aropromo', 'request' => ['get']],
                //'/blog' => ['controller' => 'PageController@blogList', 'request' => ['get']],
                '/clients' => ['controller' => 'PageController@clients', 'request' => ['get']],
                '/contact' => ['controller' => 'PageController@contact', 'request' => ['get', 'post']],
                '/country' => ['controller' => 'PageController@country', 'request' => ['get']],
                '/locations' => ['controller' => 'PageController@locations', 'request' => ['get']],
                '/scenting' => ['controller' => 'PageController@scenting', 'request' => ['get']],
                '/sitemap' => ['controller' => 'PageController@sitemap', 'request' => ['get']],
            ]);

            $routeGenerator->slug([
                //'/blog' => ['controller' => 'PageController@blogPost', 'slug' => '{post?}', 'request' => ['get']],
                //'/blog/page' => ['controller' => 'PageController@blogList', 'slug' => '{page?}', 'request' => ['get']],
                //'/blog/tag' => ['controller' => 'PageController@blogTag', 'slug' => '{category?}', 'request' => ['get']],
                '/clients' => ['controller' => 'PageController@clients', 'slug' => '{client?}', 'request' => ['get', 'post']],
                '/locations' => ['controller' => 'PageController@locations', 'slug' => '{countrycode?}', 'request' => ['get']],
                '/scenting' => ['controller' => 'PageController@scenting', 'slug' => '{industry?}', 'request' => ['get']],
                '/sitemap' => ['controller' => 'PageController@sitemapXML', 'slug' => '{xml}', 'request' => ['get']],
            ]);
        });
    }
    else
    {
        Route::group(['middleware' => ['csrf','https']], function () use ($routeGenerator) {

            $routeGenerator->route([
                '/' => ['controller' => 'PageController@index', 'request' => ['get']],
                '/aropromo' => ['controller' => 'PageController@aropromo', 'request' => ['get']],
                '/blog' => ['controller' => 'PageController@blogList', 'request' => ['get']],
                '/clients' => ['controller' => 'PageController@clients', 'request' => ['get']],
                '/contact' => ['controller' => 'PageController@contact', 'request' => ['get', 'post']],
                '/country' => ['controller' => 'PageController@country', 'request' => ['get']],
                '/locations' => ['controller' => 'PageController@locations', 'request' => ['get']],
                '/scenting' => ['controller' => 'PageController@scenting', 'request' => ['get']],
                '/sitemap' => ['controller' => 'PageController@sitemap', 'request' => ['get']],
            ]);

            $routeGenerator->slug([
                '/blog' => ['controller' => 'PageController@blogPost', 'slug' => '{post?}', 'request' => ['get']],
                '/blog/page' => ['controller' => 'PageController@blogList', 'slug' => '{page?}', 'request' => ['get']],
                '/blog/tag' => ['controller' => 'PageController@blogTag', 'slug' => '{category?}', 'request' => ['get']],
                '/clients' => ['controller' => 'PageController@clients', 'slug' => '{client?}', 'request' => ['get', 'post']],
                '/locations' => ['controller' => 'PageController@locations', 'slug' => '{countrycode?}', 'request' => ['get']],
                '/scenting' => ['controller' => 'PageController@scenting', 'slug' => '{industry?}', 'request' => ['get']],
                '/sitemap' => ['controller' => 'PageController@sitemapXML', 'slug' => '{xml}', 'request' => ['get']],
            ]);
        });
    }

/* Redirecting office.com/outlook autodiscover */
Route::match(['get', 'post'], '/autodiscover/autodiscover.xml', function () {
    return redirect('http://autodiscover.air-aroma.com/autodiscover/autodiscover.xml', 301);
});
