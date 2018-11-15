<?php

namespace AirAroma\Repository\Store;

use AirAroma\Model\Account;
use AirAroma\Model\Country;
use AirAroma\Model\CountriesWebsite;
use AirAroma\Model\County;
use AirAroma\Model\Oilgroup;
use AirAroma\Model\State;
use AirAroma\Model\Voucher;
use AirAroma\Repository\OilgroupRepository;
use AirAroma\Repository\Store\ProductRepository;
use AirAroma\Service\HmvcService;
use AirAroma\Service\Store\TransformService;
use AirAroma\Transformer\Store\VariationTransformer;

class StoreRepository
{

    public function __construct(
        TransformService $transformService,
        ProductRepository $productRepository,
        OilgroupRepository $oilgroupRepository,
        HmvcService $hmvcService,
        Oilgroup $oilgroup,
        State $state,
        Country $country,
        Account $account,
        Voucher $voucher,
        County $county,
        CountriesWebsite $countrieswebsites
        )
    {
        $this->transformService = $transformService;
        $this->hmvcService = $hmvcService;
        $this->state = $state;
        $this->county = $county;
        $this->country = $country;
        $this->account = $account;
        $this->voucher = $voucher;
        $this->oilgroup = $oilgroup;
        $this->productRepository = $productRepository;
        $this->oilgroupRepository = $oilgroupRepository;
        $this->countrieswebsites = $countrieswebsites;
    }

    /**
     * Get product item
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
	public function parsePageName($categorySlug)
	{
		return ucwords(str_replace('-', ' ', $categorySlug));
	}

    /**
     * Get product item
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getCart($sessionCart)
    {
        $products = collect(
            $this->transformService->transformResults(
                $this->productRepository->getProductDetailsById(array_keys($sessionCart)),
                new VariationTransformer
            )->collection()
        );

        return $products->transform(function($item, $key) use ($sessionCart) {

            $subtotal = [
                'quantity' => $sessionCart[$item['id']]['quantity'],
                'subtotal' => $item['price'] * $sessionCart[$item['id']]['quantity'],
            ];

            return array_merge($item, $subtotal);
        });
    }






    /**
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getAddressByType($type)
    {
        $accountId = auth()->guard('store')->user()->acc_id;

        $account = $this->account->where('acc_id', $accountId);

        switch ($type) {
            case 'shipping':
                $account->select(
                    'acc_firstname as firstname',
                    'acc_lastname as lastname',
                    'acc_street as street',
                    'acc_city as city',
                    'acc_postcode as postcode',
                    'acc_cou_id as country_id',
                    'acc_state as state_id',
                    'acc_isbusinessaddress as is_business',
                    'acc_aptsuite as suite'
                );
            break;
            case 'billing':
                $account->select(
                    'acc_billfirstname as firstname',
                    'acc_billlastname as lastname',
                    'acc_billstreet as street',
                    'acc_billcity as city',
                    'acc_billpostcode as postcode',
                    'acc_billcou_id as country_id',
                    'acc_billstate as state_id',
                    'acc_billisbusinessaddress as is_business',
                    'acc_billaptsuite as suite'
                );
            break;
        }

        return $account->first();
    }

    /**
     *
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getOilgroupsList($categorySlug = null)
    {

        if($categorySlug != null) {
            return $this->oilgroupRepository
                ->getOilGroupsByCategory($categorySlug)
                ->lists('olg_name', 'olg_slug')
                ->toArray();
        }
        return $this->oilgroup
            ->lists('olg_name', 'olg_slug')
            ->toArray();
    }

    /**
     *
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getOilGroupBySlug($groupSlug) {
        return $this->oilgroup
            ->where('olg_slug', $groupSlug)
            ->first();
    }


    /**
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getCountryRegion($countryId)
    {
        return $this->country
            ->join('regions', 'regions.reg_id', '=', 'countries.cou_reg_id')
            ->where('cou_id', $countryId)
            ->first();
    }

    /**
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getCountryCode($countryId)
    {
        return $this->country
            ->where('cou_id', $countryId)
            ->first();
    }

    /**
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function isshippingrestricted($countryId)
    {
        return $this->countrieswebsites
               ->where('couweb_cou_id', $countryId)
               ->where('couweb_web_id', websiteId())
               ->first();
    }


    /**
     *
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getStatesList()
    {
        foreach ($this->state->get() as $state) {
            $result[$state->sta_cou_id][$state->sta_id]['name'] = $state->sta_name;
            $result[$state->sta_cou_id][$state->sta_id]['code'] = $state->sta_code;
        }
        return $result;
    }

    /**
     *
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getCountiesList()
    {
        foreach ($this->county->get() as $county) {
            $counties[$county->cnt_sta_id][$county->cnt_id] = $county->cnt_name;
        }

       asort($counties);

       return $counties;
    }

    /**
     *
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getCountriesList()
    {
       $countries = $this->country->get()->lists('cou_name', 'cou_id')->toArray();

       asort($countries);

       return $countries;
    }

    /**
     * Return int number for a product category, used for subnav highlighting
     *
     * @param  $options output options
     *
     * @return int
     */
    public function getCurrentSubNavByCategorySlug($categorySlug) {
        switch($categorySlug) {
            case "aroma-oils":
            case "essential-oils":
            case "fragrances":
            case "arobalance":
                return 1;
            case "candles":
                return 2;
            case "aromax":
                return 3;
            default:
                return null;
        }
    }
}
