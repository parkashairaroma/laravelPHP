<?php

namespace AirAroma\Repository;

use AirAroma\Library\API;
use AirAroma\Model\Country;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;

class CountryRepository
{
    /* fixed path for now, to be remedied at a later date */
    protected $countryFlagPath = '/images/flags/';

    public function __construct(Request $request, Config $config, Country $country, API $api)
    {
        $this->request = $request;
        $this->config = $config;
        $this->country = $country;
        $this->api = $api;

        $this->countryId = getConfig('siteConfig', 'web_cou_id');
    }

    public function getCountryFlagPath()
    {
        return $this->countryFlagPath;
    }

    public function getCountries()
    {
        return $this->country->orderBy('cou_name', 'ASC')->get();
    }

    public function getCountryNameFromSiteConfig()
    {
        return $this->country->find($this->countryId)->cou_slug;
    }

    public function getCountryCodeFromGeoLocation()
    {
        if ($this->request->session()->has('geolocation')) {

            $geolocation = $this->request->session()->get('geolocation');

            if ($geolocation['cou_code'] != null && $geolocation['cou_code'] != '') {
                    return $geolocation['cou_code'];
            }
        }
        return $this->country->find($this->countryId)->cou_code;
    }

    public function getCountryNameFromGeoLocation()
    {
        if ($this->request->session()->has('geolocation')) {

            $geolocation = $this->request->session()->get('geolocation');

            if ($geolocation['cou_slug'] != null && $geolocation['cou_slug'] != '') {
                    return $geolocation['cou_slug'];
            }
        }
        return $this->country->find($this->countryId)->cou_slug;
    }

    public function getLocationsByCountryCode($countryCode = null)
    {
        $country = $this->country->where('cou_code', $countryCode)->first();

        if (count($country) == 1) {

            $url = $this->config->get('airaroma.orders_api') . '/locations';
            $params = ['countryCode' => $country->cou_code];

            $this->api->post($url, $params);
            $json = $this->api->response(10240);

            return json_decode($json);
        }
    }

    public function isValidSlug($countrySlug)
    {
        if ($this->country->where('cou_slug', '=', $countrySlug)->count() > 0) {
            return true;
        }
        return false;
    }

    public function getActiveCountries()
    {
        return $this->select('cou_id');
    }

    public function getCountryByCode($countryCode)
    {
        return $this->country
                    ->where('cou_code', $countryCode)
                    ->first();
    }

    public function getCountryById($countryid)
    {
        return $this->country
                    ->where('cou_id', $countryid)
                    ->first();
    }

    public function getCountryBySlug($slugName)
    {
        return $this->country
                    ->where('cou_slug', $slugName)
                    ->first();
    }

    public function getCountryStatesByCountryCode($countryCode)
    {
        $country = $this->country
                        ->where('cou_code', $countryCode)
                        ->first();

        if($country != null) {
             return $country->states()
                            ->orderBy('sta_name', 'ASC')
                            ->get(['sta_name', 'sta_code', 'sta_id']);
        }
        return null;
    }

    public function getContactFormEmails($countryName, $tokenName = '')
    {
        $emailTo = [];

        $country = $this->getCountryBySlug($countryName);
        if($country)
        {
            $reasonEmails = $country->reasonEmails($tokenName)->get();
            $countryEmails = $country->countryEmails()->get();
            $regionEmails = $country->regionEmails()->get();

            if ($reasonEmails->count()) {
                $emailTo = $reasonEmails;
            } elseif ($countryEmails->count()) {
                $emailTo = $countryEmails;
            } elseif ($regionEmails->count()) {
                $emailTo = $regionEmails;
            }
        }
        return $emailTo;
    }
}
