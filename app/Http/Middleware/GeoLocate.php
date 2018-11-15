<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;

class GeoLocate extends Controller
{
    /**
    * Determine the Geo Location
    *
    * @param $request
    * @param $next
    * 
    * @return $next
    */
    public function handle($request, Closure $next)
    {
        $ipAddress = app('request')->server->get('REMOTE_ADDR');

        if (! $request->session()->has('geolocation')) {    

            $geolocations  = app('AirAroma\Model\Geolocation');   

            $country = $geolocations
                ->select('cou_code', 'cou_name', 'cou_native_name', 'cou_slug')
                ->leftJoin('countries', 'countries.cou_code', '=', 'geolocations.glc_cou_code')
                ->where('glc_range_start', '<', $ipAddress)
                ->where('glc_range_finish', '>', $ipAddress)
                ->whereNotNull('countries.cou_code')
                ->first();

            if ($country) {
                $request->session()->put('geolocation', $country->toArray());
            } 
        }
        return $next($request);
    }
}
