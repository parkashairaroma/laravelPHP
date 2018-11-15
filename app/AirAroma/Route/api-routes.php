<?php

/* api routes */
Route::group(['prefix' => 'api'], function () {
	
	Route::match(['get'], '/country/{slug}/states', 'APIController@countryStates');
    
    // Disabled until further notice
    // Route::group(['prefix' => 'social-feed'], function () {
    //     Route::match(['get'],   '/instagram',    'APIController@instagramFeed');
    //     Route::match(['get'],   '/twitter',      'APIController@twitterFeed');
    // });
});