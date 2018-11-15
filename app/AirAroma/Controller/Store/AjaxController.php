<?php

namespace AirAroma\Controller\Store;

use AirAroma\Library\ShippingCalculator;
use AirAroma\Repository\Store\CheckoutRepository;
use AirAroma\Repository\Store\StoreRepository;
use AirAroma\Repository\Store\ProductRepository;
use AirAroma\Repository\Store\OrderRepository;
use AirAroma\Service\HmvcService;
use AirAroma\Service\Store\TransformService;
use AirAroma\Transformer\Store\VoucherTransformer;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class AjaxController extends Controller
{
    public function __construct(
        TransformService $transformService,
        HmvcService $hmvcService,
        StoreRepository $storeRepository,
        ProductRepository $productRepository,
        CheckoutRepository $checkoutRepository,
        OrderRepository $orderRepository,
        ShippingCalculator $shippingCalculator,
        Client $client
    ) {

        $this->hmvcService = $hmvcService;
        $this->storeRepository = $storeRepository;
        $this->productrepository = $productRepository;
        $this->checkoutRepository = $checkoutRepository;
        $this->transformService = $transformService;
        $this->shippingCalculator = $shippingCalculator;
        $this->client = $client;
        $this->productrepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }

     /**
     * Description
     * @param type $lang
     * @return type
     */
    public function removeFromCart($productId)
    {
        $prvId = $productId;
        $quantity = session()->forget('cart.products.'.$prvId);

        $sessionCart = session()->get('cart.products')?:[];

        $products = $this->storeRepository->getCart($sessionCart);

        if (auth()->guard('store')->check())
        {
            $order = $this->orderRepository->getlastunpaidOrder(auth()->guard('store')->user()->acc_id);        // Get last unpaid order and push the products into the cart.

            if ($order != null)
            {
                $this->orderRepository->deleteOrderProducts($order->ord_id);
                $this->orderRepository->insertProductsinOrder($order->ord_id, $products);
            }
        }

        return response()->json([
            'status' => true,
            'products' => collect(session()->get('cart.products'))->sum('quantity')
        ]);
    }

     /**
     * Description
     * @param type $lang
     * @return type
     */
    public function updateCart()
    {
        $prvId = request()->get('prvId');
        $quantity = request()->get('quantity');

        $productStock = $this->productrepository->getProductStock($prvId);

        if (count($productStock) > 0 && $quantity < 100)
        {
            if ($productStock[0]->proweb_outofstock == 0 && $productStock[0]->proweb_available == 1)
            {
                session()->put('cart.products.'.$prvId.'.quantity', $quantity);
            }
        }

        $sessionCart = session()->get('cart.products')?:[];

        $products = $this->storeRepository->getCart($sessionCart);

        if (auth()->guard('store')->check())
        {
            $order = $this->orderRepository->getlastunpaidOrder(auth()->guard('store')->user()->acc_id);        // Get last unpaid order and push the products into the cart.

            if ($order != null)
            {
                $this->orderRepository->deleteOrderProducts($order->ord_id);
                $this->orderRepository->insertProductsinOrder($order->ord_id, $products);
            }
        }

        return response()->json([
            'status' => true,
            'products' => collect(session()->get('cart.products'))->sum('quantity')
        ]);
    }


     /**
     * Description
     * @param type $lang
     * @return type
     */
    public function addToCart()
    {

        $prvId = request()->get('prvId');
        $quantity = request()->get('quantity');

        $productStock = $this->productrepository->getProductStock($prvId);

        if (count($productStock) > 0 && $quantity < 100)
        {
            if ($productStock[0]->proweb_outofstock == 0 && $productStock[0]->proweb_available == 1)
            {
                $quantity = session()->get('cart.products.'.$prvId.'.quantity')+$quantity;
                session()->put('cart.products.'.$prvId.'.quantity', $quantity);
            }
        }

        $sessionCart = session()->get('cart.products')?:[];

        $products = $this->storeRepository->getCart($sessionCart);

        if (auth()->guard('store')->check())
        {
            $order = $this->orderRepository->getlastunpaidOrder(auth()->guard('store')->user()->acc_id);        // Get last unpaid order and push the products into the cart.

            if ($order != null)
            {
                $this->orderRepository->deleteOrderProducts($order->ord_id);
                $this->orderRepository->insertProductsinOrder($order->ord_id, $products);
            }
        }

        return response()->json([
            'status' => true,
            'products' => collect(session()->get('cart.products'))->sum('quantity')
        ]);
    }


     /**
     * Description
     * @param type $lang
     * @return type
     */
    public function getStates()
    {
        return $this->storeRepository->getStatesList();
    }

     /**
     * Description
     * @param type $lang
     * @return type
     */
    public function getCounties()
    {
        return $this->storeRepository->getCountiesList();
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function setShippingService($shippingService)
    {
        $shippingCost = $this->shippingCalculator->getPriceForService($shippingService);
        return response()->json([
            'status' => true,
            'shippingservice' => $shippingService,
            'shippingcost' => $shippingCost
        ]);
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function postcodeSearch($countryCode, $postcode)
    {
        $status = false;
        $localities = [];
        if ($countryCode == "AU") {

            $host = 'https://digitalapi.auspost.com.au';
            $endpoint = '/postcode/search.json';
            $api_url = $host . $endpoint;

            $headers = [      'AUTH-KEY' => env('AUSPOST_API')];

            $payload = [      'q' => $postcode,
                              'excludePostBoxFlag' => 'true'
                        ];

            $response = $this->client->get($api_url, ['headers' => $headers, 'query' => $payload]);
            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody());
                if (isset($data->localities->locality) && count($data->localities->locality)) {
                    if (count($data->localities->locality) > 1) {
                        foreach ($data->localities->locality as $locality) {
                            $item = [];
                            $item['city'] = $locality->location;
                            $item['postcode'] = $locality->postcode;
                            $item['state'] = $locality->state;
                            $localities[] = $item;
                        }
                    } else {
                        $locality = $data->localities->locality;
                        $item = [];
                        $item['city'] = $locality->location;
                        $item['postcode'] = $locality->postcode;
                        $item['state'] = $locality->state;
                        $localities[] = $item;
                    }
                }
            }

        }
        $count = count($localities);
        if ($count > 0) {
            $status = true;
        }
        return response()->json([
            'status' => $status,
            'count' => $count,
            'localities' => $localities
        ]);
    }

    public function verifyAddress()
    {

        $street = request()->get('street');
        $suburb = request()->get('suburb');
        $postcode = request()->get('postcode');
        $state = request()->get('state');
        $countryCode = request()->get('countryCode');


        $suggestions = [];
        $status = false;

        if ($countryCode == "US") {

            $host = 'https://wwwcie.ups.com'; // Dev testing, for production change to https://onlinetools.ups.com
            $endpoint = '/ups.app/xml/XAV';
            $api_url = $host . $endpoint;

            $upsAccessKey = env('UPS_ACCESSKEY');
            $upsUserId = env('UPS_USERID');
            $upsPassword = env('UPS_PASSWORD');

            $xmlPayload='<?xml version="1.0"?>
                        <AccessRequest xml:lang="en-US">
                            <AccessLicenseNumber>'.$upsAccessKey.'</AccessLicenseNumber>
                            <UserId>'.$upsUserId.'</UserId>
                            <Password>'.$upsPassword.'</Password>
                        </AccessRequest>
                        <?xml version="1.0"?>
                        <AddressValidationRequest xml:lang="en-US">
                            <Request>
                                <TransactionReference>
                                    <CustomerContext>Address Validation</CustomerContext>
                                    <XpciVersion>1.0</XpciVersion>
                                </TransactionReference>
                                <RequestAction>XAV</RequestAction>
                                <RequestOption>3</RequestOption>
                            </Request>
                            <AddressKeyFormat>
                                <AddressLine>'.$street.'</AddressLine>
                                <Region>'.$suburb.' '.$state.' '.$postcode.'</Region>
                                <PoliticalDivision2>'.$suburb.'</PoliticalDivision2>
                                <PoliticalDivision1>'.$state.'</PoliticalDivision1>
                                <PostcodePrimaryLow>'.$postcode.'</PostcodePrimaryLow>
                                <CountryCode>'.$countryCode.'</CountryCode>
                            </AddressKeyFormat>
                        </AddressValidationRequest>';

            $response = $this->client->post($api_url, ['body' => $xmlPayload]);

            if ($response->getStatusCode() == 200) {
                $data = json_decode(json_encode(simplexml_load_string($response->getBody()->read(100000))));
                if (isset($data->Response->ResponseStatusCode) && $data->Response->ResponseStatusCode == 1) {
                    $status = true;
                }
            }
        }

        $count = count($suggestions);
        if ($count > 0) {
            $status = true;
        }
        return response()->json([
            'status' => $status,
            'count' => $count,
            'suggestions' => $suggestions
        ]);
    }
}
