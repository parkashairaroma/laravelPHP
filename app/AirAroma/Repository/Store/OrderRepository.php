<?php

namespace AirAroma\Repository\Store;

use AirAroma\Model\Order;
use AirAroma\Model\State;
use AirAroma\Model\Account;
use AirAroma\Model\Ordersproduct;
use AirAroma\Model\Tagstranslation;
use AirAroma\Model\Website;
use Illuminate\Http\Request as Request;
use AirAroma\Service\Store\TransformService;
use AirAroma\Transformer\Store\VariationTransformer;
use AirAroma\Model\Email;
use Carbon\Carbon;

class OrderRepository
{

    public function __construct(
        Order $order,
        Ordersproduct $orderProduct,
        TransformService $transformService,
        Request $request, Website $website, State $state, Account $account, Email $email, Carbon $carbon
        )
    {
        $this->order = $order;
        $this->orderProduct = $orderProduct;
        $this->transformService = $transformService;
        $this->request = $request;
        $this->website = $website;
        $this->states = $state;
        $this->account = $account;
        $this->email = $email;
        $this->carbon = $carbon;
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function getProducts($products)
    {
        $products = $this->transformService->transformResults(
            $products->toArray(),
            new VariationTransformer
        )
        ->relation();

        return collect($products);
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function getOrder($userId, $orderId)
    {
        $order = $this->order
        ->where('ord_acc_id', $userId)
        ->where('ord_id', $orderId)
        ->with(['products' => function($query) {
            $query->where('proweb_website_id', websiteId());
        }])->first();

        return $order;
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function getlastunpaidOrder($userId)
    {
        $order = $this->order
        ->where('ord_acc_id', $userId)
        ->where('ord_status', 5)
        ->where('ord_date','>',$this->carbon->now()->subMonths(6))
        ->with(['products' => function($query) {
            $query->where('proweb_website_id', websiteId());
        }])->orderBy('ord_id', 'desc')->first();

        return $order;
    }

    public function getOrdernoDraft($userId, $orderId)
    {
        $order = $this->order
        ->where('ord_acc_id', $userId)
        ->where('ord_id', $orderId)->where('ord_status', '!=', 5)
        ->with(['products' => function($query) {
            $query->where('proweb_website_id', websiteId());
        }])->leftJoin('currency', function ($join) {
                $join->on('currency.cur_id', '=', 'orders.ord_cur_id');
            })->first();
       // var_dump($order);die;
        return $order;
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function getOrders($userId)
    {
        return $this->order->select(
            'ord_date as date',
            'ord_id as number',
            'ord_goodscost as cost',
            'ord_status as status',
            'ord_website_id as website_id',
            'ord_totalcost as total',
            'cur_symbol as currency_symbol'
        )->leftJoin('currency', function ($join) {
        $join->on('currency.cur_id', '=', 'orders.ord_cur_id');
        })->where('ord_acc_id', $userId)->where('ord_status', '!=', 5)->get();
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function insertOrderProducts($orderId, $checkout)
    {
        foreach ($checkout['products'] as $product) {
            $this->orderProduct->create([
                'ordpro_ord_id' => $orderId,
                'ordpro_prv_id' => $product['id'],
                'ordpro_price' => $product['price'],
                'ordpro_quantity' => $product['quantity']
            ]);
        }
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function insertProductsinOrder($orderId, $products)
    {
        foreach ($products as $product) {
            $this->orderProduct->create([
                'ordpro_ord_id' => $orderId,
                'ordpro_prv_id' => $product['id'],
                'ordpro_price' => $product['price'],
                'ordpro_quantity' => $product['quantity']
            ]);
        }
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function deleteOrderProducts($orderId)
    {
        $this->orderProduct->where('ordpro_ord_id' , $orderId)->delete();
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function updatePaymentReference($orderId, $referenceId)
    {
        $this->order->where('ord_id', $orderId)->update([
            'ord_paymentreference' => $referenceId
        ]);
    }


    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function updateOrderStatus($orderId, $status)
    {
        $this->order->where('ord_id', $orderId)->update([
            'ord_status' => $status
        ]);
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function updateOrderPaymentStatus($orderId, $status)
    {
        $this->order->where('ord_id', $orderId)->update([
            'ord_paymentstatus' => $status
        ]);
    }

    public function startOrder()
    {
        return $this->order->create(['ord_date' => date('Y-m-d H:i:s'),
            'ord_website_id' => websiteId(),
            'ord_acc_id' => auth()->user()->acc_id,
            'ord_status' => 5]);
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function createOrder($checkout)
    {
        $voucherCode = null;

        if (isset($checkout['voucher'])) {
            $voucherCode = $checkout['voucher']['code'];
        }

        return $this->order->create([
            'ord_date' => date('Y-m-d H:i:s'),
            'ord_website_id' => websiteId(),
            'ord_acc_id' => auth()->user()->acc_id,
            'ord_status' => 5,
            'ord_cur_id' => getConfig('siteConfig')['cur_id'],
            'ord_goodscost' => $checkout['charges']['subtotal'],
            'ord_shippingmethod' => $checkout['shipping']['service'],
            'ord_shippingcost' =>  round((float) $checkout['charges']['shipping'], 2) ,
            'ord_taxincluded' => (float) $checkout['charges']['tax'],
            'ord_totalcost' => (float) $checkout['charges']['total'] ,
            'ord_vouchercode' => $voucherCode,
            'ord_voucherdiscount' => (float) $checkout['charges']['discount'],
            'ord_paymenttype' => $checkout['charges']['paymentmethod'],
            'ord_paidinfull' => 0,
            'ord_firstname' => $checkout['address']['shipping']['firstname'],
            'ord_lastname' => $checkout['address']['shipping']['lastname'],
            'ord_street' => $checkout['address']['shipping']['street'],
            'ord_city' => $checkout['address']['shipping']['city'],
            'ord_postcode' => $checkout['address']['shipping']['postcode'],
            'ord_cou_id' => $checkout['address']['shipping']['country_id'],
            'ord_aptsuite' => $checkout['address']['shipping']['suite'],
            'ord_state' => $checkout['address']['shipping']['state_id'],
            'ord_phone' => $checkout['address']['shipping']['phone'],
            //'ord_county_id' => $checkout['address']['shipping']['county_id'],
            'ord_billfirstname' => $checkout['address']['billing']['firstname'],
            'ord_billlastname' => $checkout['address']['billing']['lastname'],
            'ord_billstreet' => $checkout['address']['billing']['street'],
            'ord_billcity' => $checkout['address']['billing']['city'],
            'ord_billpostcode' => $checkout['address']['billing']['postcode'],
            'ord_billcou_id' => $checkout['address']['billing']['country_id'],
            'ord_billaptsuite' => $checkout['address']['billing']['suite'],
            'ord_billstate' => $checkout['address']['billing']['state_id'],
            'ord_billphone' => $checkout['address']['billing']['phone'],
            //'ord_billcounty_id' => $checkout['address']['billing']['county_id'],
        ]);
    }

    public function updateNewOrder($checkout, $orderid)
    {
        $voucherCode = null;

        if (isset($checkout['voucher'])) {
            $voucherCode = $checkout['voucher']['code'];
        }

        $this->order
            ->where('ord_id', $orderid)
            ->update([
            'ord_date' => date('Y-m-d H:i:s'),
            'ord_website_id' => websiteId(),
            'ord_acc_id' => auth()->user()->acc_id,
            'ord_status' => 5,
            'ord_cur_id' => getConfig('siteConfig')['cur_id'],
            'ord_goodscost' => $checkout['charges']['subtotal'],
            'ord_shippingmethod' => $checkout['shipping']['service'],
            'ord_shippingcost' =>  round((float) $checkout['charges']['shipping'], 2) ,
            'ord_taxincluded' => (float) $checkout['charges']['tax'],
            'ord_totalcost' => (float) $checkout['charges']['total'] ,
            'ord_vouchercode' => $voucherCode,
            'ord_voucherdiscount' => (float) $checkout['charges']['discount'],
            'ord_paymenttype' => $checkout['charges']['paymentmethod'],
            'ord_paidinfull' => 0,
            'ord_firstname' => $checkout['address']['shipping']['firstname'],
            'ord_lastname' => $checkout['address']['shipping']['lastname'],
            'ord_street' => $checkout['address']['shipping']['street'],
            'ord_city' => $checkout['address']['shipping']['city'],
            'ord_postcode' => $checkout['address']['shipping']['postcode'],
            'ord_cou_id' => $checkout['address']['shipping']['country_id'],
            'ord_aptsuite' => $checkout['address']['shipping']['suite'],
            'ord_state' => $checkout['address']['shipping']['state_id'],
            'ord_phone' => $checkout['address']['shipping']['phone'],
            //'ord_county_id' => $checkout['address']['shipping']['county_id'],
            'ord_billfirstname' => $checkout['address']['billing']['firstname'],
            'ord_billlastname' => $checkout['address']['billing']['lastname'],
            'ord_billstreet' => $checkout['address']['billing']['street'],
            'ord_billcity' => $checkout['address']['billing']['city'],
            'ord_billpostcode' => $checkout['address']['billing']['postcode'],
            'ord_billcou_id' => $checkout['address']['billing']['country_id'],
            'ord_billaptsuite' => $checkout['address']['billing']['suite'],
            'ord_billstate' => $checkout['address']['billing']['state_id'],
            'ord_billphone' => $checkout['address']['billing']['phone'],
            //'ord_billcounty_id' => $checkout['address']['billing']['county_id'],
        ]);
    }

    /**
     * Get all orders
     *
     * @param array $options
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getOrdersList($websiteId)
    {
        return $this->order->select()
            ->leftJoin('currency', function ($join) {
                $join->on('currency.cur_id', '=', 'orders.ord_cur_id');
            })
            ->leftJoin('countries', function ($join) {
                $join->on('countries.cou_id', '=', 'orders.ord_cou_id');
            })
            ->where('ord_website_id', $websiteId)->where('ord_status', '!=', 5);
    }

    /**
     * Get all products of an order
     *
     * @param array $options
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getOrderProductsList($orderId)
    {
        return $this->orderProduct->select()
            ->leftJoin('productvariations', function ($join) {
                $join->on('productvariations.prv_id', '=', 'ordersproducts.ordpro_prv_id');
            })
            ->leftJoin('colours', function ($join) {
                $join->on('colours.col_id', '=', 'productvariations.prv_col_id');
            })
            ->leftJoin('unitsizes', function ($join) {
                $join->on('unitsizes.uni_id', '=', 'productvariations.prv_uni_id');
            })
            ->leftJoin('products', function ($join) {
                $join->on('products.pro_id', '=', 'productvariations.prv_pro_id');
            })
            ->where('ordpro_ord_id', $orderId);
    }

    /**
     * Get state name of a state
     *
     * @param array $options
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getOrderStateName($stateId)
    {
        return $this->states->select()
            ->where('sta_id', $stateId);
    }

    /**
     * Get order Details
     *
     * @param string $Id
     * @return \Illuminate\Database\Eloquent\Model
     */

    public function getOrdersDetails($Id)
    {
        return $this->order->select()
            ->leftJoin('accounts', function ($join) {
                $join->on('accounts.acc_id', '=', 'orders.ord_acc_id');
            })
            ->leftJoin('currency', function ($join) {
                $join->on('currency.cur_id', '=', 'orders.ord_cur_id');
            })
            ->leftJoin('countries', function ($join) {
                $join->on('countries.cou_id', '=', 'orders.ord_cou_id');
            })
            ->where('ord_status', '!=', 5)
            ->find($Id);
    }

    /* Update Order Details by Id */

    public function updateOrder($id)
    {
        $ordAcc = $this->order
            ->join('accounts', 'accounts.acc_id', '=', 'orders.ord_acc_id')
            ->where('ord_id', $id)->get();

        $this->account->where('acc_id', $ordAcc[0]->ord_acc_id)
            ->update([
                'acc_firstname' => $this->request->get('txtFirstName'),
                'acc_lastname' => $this->request->get('txtLastName'),
                'acc_phone' => $this->request->get('txtPhone'),
                'acc_email' => $this->request->get('txtEmail'),
            ]);

        return $this->order->where('ord_id', $id)
            ->update([
                'ord_firstname' => $this->request->get('txtFirstName'),
                'ord_lastname' => $this->request->get('txtLastName'),
                'ord_street' => $this->request->get('txtStreet'),
                'ord_aptsuite' => $this->request->get('txtApt'),
                'ord_city' => $this->request->get('txtCity'),
                'ord_postcode' => $this->request->get('txtPostCode'),
                'ord_state' => $this->request->get('contact-form-state'),
                'ord_cou_id' => $this->request->get('contact-form-country'),
                'ord_phone' => $this->request->get('txtPhone'),
                'ord_trackingemailsent' => $this->request->get('selTrackingEmailSent'),
                'ord_trackingcompany' => $this->request->get('selTrackingCompany'),
                'ord_trackingnumber' => $this->request->get('txtTrackingNumber'),
                'ord_paidinfull' => $this->request->get('selPaidInFull'),
                'ord_status' => $this->request->get('selStatus'),
            ]);
    }

    /* Update Order Shipping Email Sent Status */

    public function updateOrderShipping($id)
    {
        return $this->order->where('ord_id', $id)
            ->update([
                'ord_trackingemailsent' => '1',
                'ord_trackingcompany' => $this->request->get('trackingcompany'),
                'ord_trackingnumber' => $this->request->get('trackingnumber'),
            ]);
    }

    public function getTrackingEmailList()
    {
        return $this->email->where('eml_ety_id', '=', 9)->get();
    }
}