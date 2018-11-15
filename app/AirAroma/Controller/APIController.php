<?php

namespace AirAroma\Controller;

use App\Http\Controllers\Controller;

class APIController extends Controller
{
    public function instagramFeed()
    {
        $instagramFeed = app('AirAroma\Library\SocialFeed\InstagramFeed');
        return $instagramFeed->fetch()->posts()->store();
    }

    public function twitterFeed()
    {
        $twitterFeed = app('AirAroma\Library\SocialFeed\TwitterFeed');
        return $twitterFeed->fetch()->posts()->store();
    }

    public function countryStates($countryCode)
    {
        $countryRepository = app('AirAroma\Repository\CountryRepository');

        $response = app('Illuminate\Http\Response');
        $states = $countryRepository->getCountryStatesByCountryCode($countryCode);
        if($states != null)
        {
            return response()->json(['status' => 'success', 'states' => $states, 'count' => count($states)]);
        }
        return response()->json(['status' => 'error']);        
    }
}
