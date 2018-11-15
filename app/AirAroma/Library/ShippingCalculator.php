<?php

namespace AirAroma\Library;

use AirAroma\Library\BoxPacker\TheBox;
use AirAroma\Library\BoxPacker\TheItem;
use AirAroma\Model\Country;
use AirAroma\Model\State;
use Beaudierman\Ups\Facades\Ups;
use DVDoug\BoxPacker\Packer;
use GuzzleHttp\Client;

class ShippingCalculator
{

    public function __construct(
        Client $client,
        Country $country,
        State $state
    ) {
        $this->client = $client;
        $this->country = $country;
        $this->state = $state;
    }


    public function setCarrier($id)
    {
        $this->carrier = $id;
        switch ($id) {
            case 'auspost':
                $this->apiToken = ''; // Shippo
                break;
        }
    }



    public function calculateDimensions($products)
    {

        $packer = new Packer();

        foreach (config()->get('airaroma.box_sixes') as $name => $size) {
            $packer->addBox(new TheBox(
                $name,
                $size['length'],
                $size['width'],
                $size['height'],
                0, // min-weight
                $size['length'],
                $size['width'],
                $size['height'],
                $size['weight']
            ));
        }
        foreach ($products as $product) {

            $dimensions = explode('x', $product['dimensions']);
            $weight = $product['quantity'] * $product['weight'];
            list($width, $length, $height) = $dimensions;

            $packer->addItem(new TheItem($product['name'], $width, $length, $height, $weight, true));
        }

        foreach ($packer->pack() as $box) {

            $l = $box->getRemainingLength() / 10; // mm > cm
            $w = $box->getRemainingWidth() / 10; // mm > cm
            $h = $box->getRemainingDepth() / 10; // mm > cm
            $kg = $box->getWeight() / 1000; // grams > kg

            $length = ($l < 10) ? 10 : $l;
            $width = ($w < 10) ? 10 : $w;
            $height = ($h < 10) ? 10 : $h;
            $weight = ($kg < 0.2) ? 0.2 : $kg;

            $package = [
                'metricLength' => $length,
                'metricWidth' => $width,
                'metricHeight' => $height,
                'metricWeight' => $weight,
                'imperialLength' => ceil($length / 2.54),
                'imperialWidth' => ceil($width / 2.54),
                'imperialHeight' => ceil($height / 2.54),
                'imperialWeight' => $weight * 2.2,
            ];

        }

        return $package;
    }


    public function servicesAvailable($products, $address)
    {
        $services = [];

        $customerName = $address['firstname'] . ' ' . $address['lastname'];
        $customerCountry = $this->country->where('cou_id', $address['country_id'])->first();
        $customerCountryCode = $customerCountry->cou_ups_code;
        $customerPostCode = $address['postcode'];
        $customerRegion = $this->country->join('regions', 'regions.reg_id', '=', 'countries.cou_reg_id')->where('cou_id', $address['country_id'])->first();
        $customerRegionCode = $customerRegion->reg_loc_id;

        // added by Byron because of a non-integer states entry.
        $customerState = null;
        $customerStateCode = null;
        if (is_integer($address['state_id'])) {
            $customerState = $this->state->where('sta_id', $address['state_id'])->first();
            $customerStateCode = $customerState->sta_code;
        }

        $shippingDimensions = $this->calculateDimensions($products);

        if ($this->carrier == 'auspost') {
            if ($customerCountry->cou_code == "AU") {
                try
                {
                    $host = 'https://digitalapi.auspost.com.au';
                $endpoint = '/postage/parcel/domestic/service.json';
                $api_url = $host . $endpoint;

                $headers = [
                    'AUTH-KEY' => env('AUSPOST_API')
                ];

                $payload = [
                    'from_postcode' => '3192',
                    'to_postcode' => $customerPostCode,
                    'length' => $shippingDimensions['metricLength'],
                    'width' => $shippingDimensions['metricWidth'],
                    'height' => $shippingDimensions['metricHeight'],
                    'weight' => $shippingDimensions['metricWeight']
                ];


                $response = $this->client->get($api_url, ['headers' => $headers, 'query' => $payload, 'http_errors' => false]);

                if ($response->getStatusCode() == 200) {
                    $data = json_decode($response->getBody());

                    if (count($data->services->service)>0) {
                        if (count($data->services->service) == 1) {
                            if (isset($service->name)) {
                                $services = array_merge($services, $this->transformServiceInformation($data->services->service));
                            }
                        } else {
                            foreach ($data->services->service as $service) {
                                if (isset($service->name)) {
                                      $services = array_merge($services, $this->transformServiceInformation($service));
                                }
                            }
                        }
                    }
                    usort($services, function ($a, $b) {
                        return $a['price'] > $b['price'];
                    });

                    return $services;
                }
                }
                catch (Exception $e) {
                    throw $e;
                }
            } else // Australia Post INTERNATIONAL
            {
                $host = 'https://digitalapi.auspost.com.au';
                $endpoint = '/postage/parcel/international/service.json';
                $api_url = $host . $endpoint;

                $headers = [
                    'AUTH-KEY' => env('AUSPOST_API')
                ];

                $payload = [
                    'length' => $shippingDimensions['metricLength'],
                    'width' => $shippingDimensions['metricWidth'],
                    'height' => $shippingDimensions['metricHeight'],
                    'country_code' => $customerCountry->cou_code,
                    'weight' => $shippingDimensions['metricWeight']
                ];
                $response = $this->client->get($api_url, ['headers' => $headers, 'query' => $payload, 'http_errors' => false]);
                if ($response->getStatusCode() == 200) {
                    $data = json_decode($response->getBody());
                    if (count($data->services->service)>0) {
                        if (count($data->services->service) == 1) {
                              $services = array_merge($services, $this->transformServiceInformation($data->services->service));
                        } else {
                            foreach ($data->services->service as $service) {
                                $services = array_merge($services, $this->transformServiceInformation($service));
                            }
                        }
                    }
                    usort($services, function ($a, $b) {
                        return $a['price'] > $b['price'];
                    });

                    return $services;
                }
            }
        } elseif ($this->carrier == 'ups') {
            $upsAccessKey = env('UPS_ACCESSKEY');
            $upsUserId = env('UPS_USERID');
            $upsPassword = env('UPS_PASSWORD');
            $upsAccount = env('UPS_ACCOUNT');

            try {
                if ($customerRegionCode == 5)
                {
                    $hubAddress = '263 West 38th St - 12th Floor';
                    $hubState = 'New York';
                    $hubStateCode = 'NY';
                    $hubPostCode = '10018';
                    $hubCountryCode = 'US';
                    $measurementunit = 'LBS';
                }
                else if ($customerRegionCode == 4)
                {
                    $hubAddress = 'Ravenswade 212 E Nieuwegein';
                    $hubState = '';
                    $hubStateCode = '';
                    $hubPostCode = '3439 LD';
                    $hubCountryCode = 'NL';
                    $measurementunit = 'KGS';
                }
                else if ($customerRegionCode == 3 || $customerRegionCode == 53)
                {
                    $hubAddress = '26/91-95 Tulip Street Cheltenham';
                    $hubState = 'Victoria';
                    $hubStateCode = 'VIC';
                    $hubPostCode = '3192';
                    $hubCountryCode = 'AU';
                    $measurementunit = 'KGS';
                }

                $response = Ups::getQuote(
                    [
                        'access_key' => $upsAccessKey,
                        'username' => $upsUserId,
                        'password' => $upsPassword,
                        'account_number' => $upsAccount,
                    ],
                    [
                        'from_zip' => $hubPostCode,
                        'from_state' => $hubStateCode, // Optional, may yield a more accurate quote
                        'from_country' => $hubCountryCode, // Optional, defaults to US
                        'to_zip' => $customerPostCode,
                        'to_state' => $customerStateCode, // Optional, may yield a more accurate quote
                        'to_country' => $customerCountryCode, // Optional, defaults to US
                        'packages' => 1,
                        'weight' => $shippingDimensions['imperialWeight'],
                        'measurement' => $measurementunit, // Currently the UPS API will only allow LBS and KG, default is LBS
                        'negotiated_rates' => false // Optional, set true to return negotiated rates from UPS
                    ]
                );

                if (count($response)>0) {
                    foreach ($response as $service) {
                        if (isset($service['service'])) {
                              $services = array_merge($services, $this->transformServiceInformation($service));
                        }
                    }
                }

            } catch (Exception $e) {
                var_dump($e);
            }

            return $services;

        } else {

            $services = [];
            $svc = [];
            $svc['name'] = 'Standard';
            $svc['code'] = 'STANDARD';
            $svc['price'] = 150;
            $services[] = $svc;

            return $services;
        }
        return false;
    }

    private function transformServiceInformation($service)
    {
        $services = [];
        switch ($this->carrier) {
            case "auspost":
                switch ($service->name) {
                    case "Courier Post":
                    case "Parcel Post":
                    case "Express Post":
                    case "Standard":
                    case "Express":
                        $svc = [];
                        $svc['name'] = $service->name;
                        $svc['code'] = $service->code;
                        $svc['price'] = $service->price;
                        $services[] = $svc;
                        break;
                    default:
                        break;
                }
                break;
            case "ups":
                switch ($service['service']) {
                    case "UPS Standard":
                    case "UPS Saver":
                    case "UPS Ground":
                        $svc = [];
                        $svc['name'] = $service['service'];
                        $svc['code'] = strtoupper(str_replace(' ', '', $service['service']));
                        $svc['price'] = $service['rate'];
                        $services[] = $svc;
                        break;
                    default:
                    //dump($service);
                        break;
                }
        }
        return $services;
    }

    public function getPriceForService($shippingServiceSelected)
    {
        session()->put('checkout.shipping.service', $shippingServiceSelected);
        if (! session()->has('checkout.shipping.services')) {
        // recalculate new services
        // Possibly place in here once we behin caching rates.
        //  session()->push('checkout.shipping.services', $shippingServices);
        }
        $shippingServices = session()->get('checkout.shipping.services');
        $shippingCost = null;
        if (count($shippingServices)>0) {
            foreach ($shippingServices as $shipService) {
                if ($shipService['code'] == $shippingServiceSelected) {
                    $shippingCost = $shipService['price'];
                }
            }
        }
        if ($shippingCost == null && count($shippingServices)>0) {
            $firstShippingService = $shippingServices[0];

            session()->put('checkout.shipping.service', $firstShippingService['code']);
            $shippingCost = $firstShippingService['price'];
        }
        return (float) $shippingCost;
    }
}
