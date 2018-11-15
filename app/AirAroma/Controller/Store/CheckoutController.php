<?php

namespace AirAroma\Controller\Store;

use AirAroma\Library\ShippingCalculator;
use AirAroma\Library\StripePayment;
use AirAroma\Model\Country;
use AirAroma\Model\CountriesWebsite;
use AirAroma\Repository\StateRepository;
use AirAroma\Repository\Store\AccountRepository;
use AirAroma\Repository\Store\CheckoutRepository;
use AirAroma\Repository\Store\OrderRepository;
use AirAroma\Repository\Store\StoreRepository;
use AirAroma\Service\FormService;
use App\Http\Controllers\Controller;
use Mdb\PayPal\Ipn\ListenerBuilder\Guzzle\InputStreamListenerBuilder as ListenerBuilder;
use Mdb\PayPal\Ipn\Event\MessageVerifiedEvent;
use Mdb\PayPal\Ipn\Event\MessageInvalidEvent;
use Mdb\PayPal\Ipn\Event\MessageVerificationFailureEvent;
use AirAroma\Model\Accountsaddresses;
use Illuminate\Console\Scheduling\Schedule;
use Spatie\Newsletter\Newsletter as Newsletter;

class CheckoutController extends Controller
{
    public function __construct(
        FormService $formService,
        ShippingCalculator $shippingCalculator,
        StripePayment $stripePayment,
        OrderRepository $orderRepository,
        CheckoutRepository $checkoutRepository,
        AccountRepository $accountRepository,
        StoreRepository $storeRepository,
        StateRepository $stateRepository,
        Accountsaddresses $accountsaddresses,
        Schedule $schedule,
        Newsletter $newsletter
    ) {
        $this->formService = $formService;
        $this->shippingCalculator = $shippingCalculator;
        $this->stripePayment = $stripePayment;
        $this->orderRepository = $orderRepository;
        $this->checkoutRepository = $checkoutRepository;
        $this->accountRepository = $accountRepository;
        $this->storeRepository = $storeRepository;
        $this->stateRepository = $stateRepository;
        $this->accountsaddresses = $accountsaddresses;
        $this->schedule = $schedule;
        $this->newsletter = $newsletter;

    }

    public function ApplePayCharge()
    {
        //$data = json_decode($_POST['data']);
        //$charge = $this->stripePayment->chargeCardSample('100',99,'usd', $data[0]);
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function checkout($type = null, $addid = null)
    {

        $this->schedule->call(function () {
            $data = [];
            $emailTo = ['parkash.kumar@air-aroma.com'];

            $mail = app('Illuminate\Mail\Mailer');

            $mail->send('emails.password-reset', ['data' => $data], function ($mail) use ($emailTo, $data) {
                $mail->to($emailTo)
                    ->subject('Test Scheduler Email');
            });
        })->everyMinute();

        $shippingAddress = $this->storeRepository->getAddressByType('shipping');
        $billingAddress = $this->storeRepository->getAddressByType('billing');

        $accountAddresses = $this->accountRepository->getAccountAddress(auth()->guard('store')->user()->acc_id);

        if (count($accountAddresses) == 0)
        {
            session()->put('checkout.address.shipping', null);
            session()->put('checkout.address.billing', null);
        }

        if (count($accountAddresses) > 0)
        {
            //if (! session()->has('checkout.address.shipping')) {
            $address_shipping = $this->accountRepository->getdefaultAccountAddress(auth()->guard('store')->user()->acc_id, 'shipping');
            if ($address_shipping != null)
            {
                $addressship = $this->accountRepository->getAccountAddressAddid($address_shipping->add_id);
                session()->put('checkout.address.shipping', $addressship);
            }
            else
            {
                session()->put('checkout.address.shipping', null);
            }
            //}

            //if (! session()->has('checkout.address.billing')) {
            $address_billing = $this->accountRepository->getdefaultAccountAddress(auth()->guard('store')->user()->acc_id, 'billing');
            if ($address_billing != null)
            {
                $addressbill = $this->accountRepository->getAccountAddressAddid($address_billing->add_id);
                session()->put('checkout.address.billing', $addressbill);
            }
            else
            {
                session()->put('checkout.address.billing', null);
            }
            //}
        }

        if (! session()->has('checkout.charges.paymentmethod')) {
            session()->put('checkout.charges.paymentmethod', 'creditcard');
        }

        $paymentMethod = session()->get('checkout.charges.paymentmethod');

        $taxes = $this->checkoutRepository->getTaxes(session()->get('checkout.address.shipping'))->first();

        session()->put('checkout.taxes', $taxes);

        session()->forget('checkout.address.complete');

        $shippingAddressComplete = $this->checkoutRepository->isAddressComplete(session()->get('checkout.address.shipping'));
        $billingAddressComplete = $this->checkoutRepository->isAddressComplete(session()->get('checkout.address.billing'));

        if ($shippingAddressComplete && $billingAddressComplete) {
            session()->put('checkout.address.complete', true);
        }

        $countries = $this->storeRepository->getCountriesList();
        $states = $this->storeRepository->getStatesList();
        $counties = $this->storeRepository->getCountiesList();

        $cart = session()->get('cart.products')?:[];
        $products = $this->storeRepository->getCart($cart);

        if (! $products->count()) {
            return redirect()->to('/store/cart');
        }

        session()->put('checkout.products', $products);

        /* Creating an Order entry for Mailchimp Abandoned Cart - Start */

        $order = null;

        $paymentMethod = request()->get('payment-method');

        if($paymentMethod == null)
        {
            $paymentMethod = 'creditcard';
        }
        session()->put('checkout.charges.paymentmethod', $paymentMethod);

        if (! session()->has('checkout.order.id')) {

            $order = $this->orderRepository->getlastunpaidOrder(auth()->guard('store')->user()->acc_id);        // Find last unprocessed order.

            if ($order == null)
            {
                $order = $this->orderRepository->startOrder();
            }
            else
            {
                $this->orderRepository->deleteOrderProducts($order->ord_id);
            }

            if ($order) {
                session()->put('checkout.order.id', $order->ord_id);
                $this->orderRepository->insertOrderProducts($order->ord_id, session()->get('checkout'));
            }
        }

        if (! $order) {
            $this->orderRepository->deleteOrderProducts(session()->get('checkout.order.id'));
            $this->orderRepository->insertOrderProducts(session()->get('checkout.order.id'), session()->get('checkout'));
            $order = $this->orderRepository->getOrder(auth()->guard('store')->user()->acc_id, session()->get('checkout.order.id'));
        }

        /* Creating an Order entry for Mailchimp Abandoned Cart - Finish */

        if (request()->isMethod('post')) {

            $formType = request()->get('form_type');

            switch ($formType) {

                /* change shipping and billing address */

                case 'shipping':
                case 'billing':
                    if(request()->get('is_businesshidden') === '1')
                    {
                        $validAddress = $this->formService->validate([
                        'address.'.$formType.'.firstname' => 'required',
                        'address.'.$formType.'.lastname' => 'required',
                        'address.'.$formType.'.street' => 'required',
                        'address.'.$formType.'.city' => 'required',
                        'address.'.$formType.'.postcode' => 'required',
                        //'address.'.$formType.'.county_id' => 'required|numeric',
                        //'address.'.$formType.'.state_id' => 'required',
                        'address.'.$formType.'.businessname' => 'required',
                        'address.'.$formType.'.phone' => 'required',
                        //'address.'.$formType.'.county_id' => 'required|numeric',

                    ]);
                    }
                    else
                    {
                        $validAddress = $this->formService->validate([
                        'address.'.$formType.'.firstname' => 'required',
                        'address.'.$formType.'.lastname' => 'required',
                        'address.'.$formType.'.street' => 'required',
                        'address.'.$formType.'.city' => 'required',
                        'address.'.$formType.'.postcode' => 'required',
                        'address.'.$formType.'.phone' => 'required',
                        //'address.'.$formType.'.county_id' => 'required|numeric',
                        //'address.'.$formType.'.state_id' => 'required',
                        //'address.'.$formType.'.county_id' => 'required|numeric',

                    ]);
                    }

                    if ($validAddress->fails()) {
                        $validAddress->getMessageBag()->add('type', $formType);
                        return redirect()->back()->withErrors($validAddress)->withInput();
                    }

                    $address =  request()->get('address')[$formType];

                    $checked = false;

                    if(request()->get('is_businesshidden') === '1')
                    {
                        $checked = true;
                    }
                    else
                    {
                        $checked = false;
                    }

                    $address['is_business'] = $checked;

                    session()->put('checkout.address.is_business', $checked);

                    session()->put('checkout.address.'.$formType, $address);


                    $this->accountRepository->updateAddress($formType, $address);       // Always save the address in the database.

                    if (request()->get('use_address_for_billing'))
                    {

                        $a = $this->accountRepository->insertAccountAddress($address, 1);

                        if (request()->get('address_default')) {
                            $this->accountRepository->updateAddress('billing', $address);
                        }

                        $this->checkoutRepository->useAddressForShipping($address);
                        session()->put('checkout.address.billing', $address);
                    }
                    else
                    {
                        $a = $this->accountRepository->insertAccountAddress($address, 0);
                    }

                    return redirect()->to('/store/checkout')->withInput();

                    break;
                case 'editaddress-cancel':
                    $type = session()->get('checkout.address.editaddresstype');

                    session()->forget('checkout.address.editaddresstype');
                    session()->forget('checkout.address.editaddress');

                    return redirect()->to('/store/checkout')->with('addressBookRetunType', $type);
                    break;

                case 'editaddress':
                    if(request()->get('is_businesshidden') === '1')
                    {
                        $validAddress = $this->formService->validate([
                        'address.'.$formType.'.firstname' => 'required',
                        'address.'.$formType.'.lastname' => 'required',
                        'address.'.$formType.'.street' => 'required',
                        'address.'.$formType.'.city' => 'required',
                        'address.'.$formType.'.postcode' => 'required',
                        //'address.'.$formType.'.county_id' => 'required|numeric',
                        //'address.'.$formType.'.state_id' => 'required',
                        'address.'.$formType.'.businessname' => 'required',
                        'address.'.$formType.'.phone' => 'required',
                        //'address.'.$formType.'.county_id' => 'required|numeric',

                    ]);
                    }
                    else
                    {
                        $validAddress = $this->formService->validate([
                        'address.'.$formType.'.firstname' => 'required',
                        'address.'.$formType.'.lastname' => 'required',
                        'address.'.$formType.'.street' => 'required',
                        'address.'.$formType.'.city' => 'required',
                        'address.'.$formType.'.postcode' => 'required',
                        'address.'.$formType.'.phone' => 'required',
                        //'address.'.$formType.'.county_id' => 'required|numeric',
                        //'address.'.$formType.'.state_id' => 'required',
                        //'address.'.$formType.'.county_id' => 'required|numeric',

                    ]);
                    }

                    $addformtype = request()->get('addressbookForm');

                    if ($validAddress->fails()) {
                        $validAddress->getMessageBag()->add('type', $formType);
                        $validAddress->getMessageBag()->add('addressbookFormtype', $addformtype);
                        return redirect()->back()->withErrors($validAddress)->withInput();
                    }

                    $type = session()->get('checkout.address.editaddresstype');

                    session()->forget('checkout.address.editaddresstype');
                    session()->forget('checkout.address.editaddress');

                    $address =  request()->get('address')[$formType];

                    $checked = false;

                    if(request()->get('is_businesshidden') === '1')
                    {
                        $checked = true;
                    }
                    else
                    {
                        $checked = false;
                    }

                    $address['is_business'] = $checked;

                    $this->accountRepository->updateAccountAddress($address, $addid);

                    return redirect()->to('/store/checkout')->with('addressBookRetunType', $type);
                    break;
                case 'newaddress':

                    if(request()->get('is_businesshidden') === '1')
                    {
                        $validAddress = $this->formService->validate([
                        'address.'.$formType.'.firstname' => 'required',
                        'address.'.$formType.'.lastname' => 'required',
                        'address.'.$formType.'.street' => 'required',
                        'address.'.$formType.'.city' => 'required',
                        'address.'.$formType.'.postcode' => 'required',
                        'address.'.$formType.'.phone' => 'required',
                        //'address.'.$formType.'.county_id' => 'required|numeric',
                        //'address.'.$formType.'.state_id' => 'required',
                        //'address.'.$formType.'.businessname' => 'required',
                        //'address.'.$formType.'.county_id' => 'required|numeric',

                    ]);
                    }
                    else
                    {
                        $validAddress = $this->formService->validate([
                        'address.'.$formType.'.firstname' => 'required',
                        'address.'.$formType.'.lastname' => 'required',
                        'address.'.$formType.'.street' => 'required',
                        'address.'.$formType.'.city' => 'required',
                        'address.'.$formType.'.postcode' => 'required',
                        'address.'.$formType.'.phone' => 'required',
                        //'address.'.$formType.'.county_id' => 'required|numeric',
                        //'address.'.$formType.'.state_id' => 'required',
                        //'address.'.$formType.'.county_id' => 'required|numeric',

                    ]);
                    }

                    $addformtype = request()->get('addressbookForm');

                    if ($validAddress->fails()) {
                        $validAddress->getMessageBag()->add('type', $formType);
                        $validAddress->getMessageBag()->add('addressbookFormtype', $addformtype);
                        return redirect()->back()->withErrors($validAddress)->withInput();
                    }

                    $address =  request()->get('address')[$formType];

                    $checked = false;

                    if(request()->get('is_businesshidden') === '1')
                    {
                        $checked = true;
                    }
                    else
                    {
                        $checked = false;
                    }

                    $address['is_business'] = $checked;

                    $a = $this->accountRepository->insertAccountAddress($address, 2);

                    $addressBookAdd = $this->accountRepository->getAccountAddressAddid($a);

                    if (request()->get('newaddress_type') == 'shipping')
                    {
                        $this->accountRepository->updatedefaultAccountAddress(auth()->guard('store')->user()->acc_id, $a, 'useaddress-shipping');
                        session()->put('checkout.address.shipping', $addressBookAdd);
                    }
                    else if (request()->get('newaddress_type') == 'billing')
                    {
                        $this->accountRepository->updatedefaultAccountAddress(auth()->guard('store')->user()->acc_id, $a, 'useaddress-billing');
                        session()->put('checkout.address.billing', $addressBookAdd);
                    }

                    return redirect()->to('/store/checkout');
                    break;

                case 'useaddress-shipping':
                case 'useaddress-billing':
                    $formtypeex = explode("-", $formType);
                    $radioval = request()->get('addressbookAddress_'.$formtypeex[1]);

                    $addressBookAdd = $this->accountRepository->getAccountAddressAddid($radioval);

                    if ($formType == 'useaddress-shipping')
                    {
                        $this->accountRepository->updatedefaultAccountAddress(auth()->guard('store')->user()->acc_id, $radioval, $formType);
                        session()->put('checkout.address.shipping', $addressBookAdd);
                    }
                    else if ($formType == 'useaddress-billing')
                    {
                        $this->accountRepository->updatedefaultAccountAddress(auth()->guard('store')->user()->acc_id, $radioval, $formType);
                        session()->put('checkout.address.billing', $addressBookAdd);
                    }

                    return redirect()->to('/store/checkout');
                    break;
                /* apply voucher code */
                case 'voucher':
                    session()->forget('checkout.voucher');

                    $validVoucher = $this->formService->validate([
                        'voucher_code' => 'alpha_num_spaces'
                    ]);

                    if ($validVoucher->fails()) {
                        $validVoucher->getMessageBag()->add('type', $formType);
                        return redirect()->back()->withErrors($validVoucher)->withInput();
                    }

                    if (request()->get('voucher_code') != '') {

                        $voucher = $this->checkoutRepository->getVoucherByCode(request()->get('voucher_code'))->first();

                        if (! $voucher) {
                            return redirect()->back()->withErrors(['voucher_code' => 'Voucher is not valid'])->withInput();
                        }

                        if (! $this->checkoutRepository->isVoucherCurrent($voucher)) {
                            return redirect()->back()->withErrors(['voucher_code' => 'Voucher has expired'])->withInput();
                        }

                        if ($voucher->vou_threshold == '0.00' || session()->get('checkout.charges.subtotal') > $voucher->vou_threshold) {

                            session()->put('checkout.voucher.code', $voucher->vou_code);

                            switch ($voucher->vou_type) {
                                case 'percent':
                                    session()->put('checkout.voucher.percent', $voucher->vou_discount);
                                    session()->put('checkout.voucher.message', 'You will receive '.round($voucher->vou_discount).'% off');
                                    break;
                                case 'dollars':
                                    session()->put('checkout.voucher.dollars', $voucher->vou_discount);
                                    session()->put('checkout.voucher.message', 'You will receive '.getConfig('siteConfig', 'cur_symbol') .''.round($voucher->vou_discount).' off');
                                    break;
                            }
                        }
                    }

                    return redirect()->to('/store/checkout')->withInput();

                    break;

                /* place order */
                case 'order':
                    $order = null;

                    $paymentMethod = request()->get('payment-method');
                    session()->put('checkout.charges.paymentmethod', $paymentMethod);

                    if (! session()->has('checkout.order.id')) {

                        $order = $this->orderRepository->createOrder(session()->get('checkout'));

                        if ($order) {
                            session()->put('checkout.order.id', $order->ord_id);
                            $this->orderRepository->insertOrderProducts($order->ord_id, session()->get('checkout'));
                        }
                    }

                    if (! $order) {
                        $this->orderRepository->updateNewOrder(session()->get('checkout'), session()->get('checkout.order.id'));
                        $this->orderRepository->deleteOrderProducts(session()->get('checkout.order.id'));
                        $this->orderRepository->insertOrderProducts(session()->get('checkout.order.id'), session()->get('checkout'));
                        $order = $this->orderRepository->getOrder(auth()->guard('store')->user()->acc_id, session()->get('checkout.order.id'));
                    }

                    switch ($paymentMethod) {
                        case 'GooglePay':
                            // convert to small currency: stripe requirement
                            $amount = number_format(session()->get('checkout')['charges']['total'], 2, "", "");

                            $charge = $this->stripePayment->chargeCardAppleGoogle(
                                    $order->ord_id,
                                    $amount,
                                    getConfig('siteConfig', 'cur_shortname'),
                                    request()->get('token')
                                );

                            break;
                        case 'ApplePay':
                            // convert to small currency: stripe requirement
                            $amount = number_format(session()->get('checkout')['charges']['total'], 2, "", "");

                            $charge = $this->stripePayment->chargeCardAppleGoogle(
                                    $order->ord_id,
                                    $amount,
                                    getConfig('siteConfig', 'cur_shortname'),
                                    request()->get('token')
                                );

                            break;
                        case 'creditcard':
                            $valid = $this->formService->validate([
                                'card_name' => 'required|alpha_num_spaces',
                                'card_type' => 'required',
                                'card_number' => 'required',
                                'card_security' => 'required',
                                'card_expiry_month' => 'required',
                                'card_expiry_year' => 'required'
                            ]);

                            if ($valid->fails()) {
                                return redirect()->back()->withErrors($valid)->withInput();
                            }

                            //$this->stripePayment->setCardAddress(session()->get('checkout.address.billing'), $countries);
                            $this->stripePayment->setCardDetails(request()->all(), $countries);

                            $cardValid = $this->stripePayment->isCardValid();
                            $cvcValid = $this->stripePayment->isCvcValid();
                            $cardExpired = $this->stripePayment->isCardExpired();

                            if (! $cardValid) {
                                $valid->getMessageBag()->add('card_number', 'Card number is invalid');
                            }

                            if (! $cvcValid) {
                                $valid->getMessageBag()->add('card_security', 'CCV number is invalid');
                            }

                            if ($cardExpired) {
                                $valid->getMessageBag()->add('card_date', 'Card expiry is in the past');
                            }

                            if (! $cardValid || ! $cvcValid || $cardExpired) {
                                return redirect()->back()->withErrors($valid)->withInput();
                            }

                            // convert to small currency: stripe requirement
                            $amount = number_format(session()->get('checkout')['charges']['total'], 2, "", "");

                            try {
                                $charge = $this->stripePayment->chargeCard(
                                    $order->ord_id,
                                    $amount,
                                    getConfig('siteConfig', 'cur_shortname')
                                );
                                if ($charge->stripeCode != null)
                                {
                                    if ($charge->stripeCode == 'incorrect_cvc')
                                    {
                                        $valid->getMessageBag()->add('card_security', 'CCV number is invalid');
                                        return redirect()->back()->withErrors($valid)->withInput();
                                    }
                                    else
                                    {
                                        $val = $charge->jsonBody['error'];
                                        $valid->getMessageBag()->add('stripe_payment_error', 'Payment Error: ' . $val['message']);
                                        return redirect()->back()->withErrors($valid)->withInput();
                                    }
                                }
                            }
                            catch (Exception $e) {
                                // do something useful
                            }

                            break;
                        case 'paypal':
                            $billingAddress = session()->get('checkout.address.billing');

                            $regionId = $this->storeRepository->getCountryRegion($billingAddress['country_id'])->reg_loc_id;

                            $stateName = $billingAddress['state_id'];
                            if (is_numeric($stateName)) {
                                $state = $this->stateRepository->getStateById($stateName);
                                if ($state) {
                                    $stateName = $state->sta_name;
                                }
                            }

                            switch ($regionId) {
                                case '4':
                                case '5':
                                case '6':
                                    $paypalAccount = env('PAYPAL_ACC_USA');
                                    break;
                                case '3':
                                    $paypalAccount = env('PAYPAL_ACC_AUS');
                                    break;
                                default:
                                    $paypalAccount = env('PAYPAL_ACC_ROW');
                            }

                            $query = array();
                            $query['notify_url'] = websiteUrl()."/store/paypal/ipnlistener";
                            $query['return'] = websiteUrl()."/store/checkout/successpaypal";
                            $query['cancel_return'] = websiteUrl()."/store/cart";
                            $query['charset'] = 'utf-8';
                            $query['cmd'] = '_cart';
                            $query['upload'] = '1';
                            $query['business'] = $paypalAccount;

                            foreach ($products->all() as $key => $prod) {

                                $itemId = $key + 1;

                                $description = $prod['name'];
                                if ($prod['unit']['name'] != null) {
                                    $description .= ' ' . $prod['unit']['name'];
                                }
                                if ($prod['colour']['name'] != null) {
                                    $description .= ' ' . $prod['colour']['name'];
                                }

                                $query['item_name_'.$itemId] = $description;
                                $query['quantity_'.$itemId] = $prod['quantity'];
                                $query['amount_'.$itemId] = $prod['price'];

                            }

                            $query['address_override'] = 0;
                            $query['no_note'] = 1;
                            $query['first_name'] = $billingAddress['firstname'];
                            $query['last_name'] = $billingAddress['lastname'];
                            $query['email'] = auth()->guard('store')->user()->acc_email;
                            $query['address1'] = $billingAddress['street'];
                            $query['city'] = $billingAddress['city'];
                            $query['state'] = $stateName;
                            $query['country'] = $billingAddress['street'];

                            if (session()->get('checkout.charges.discount') > 0) {
                                $query['discount_amount_cart'] = session()->get('checkout.charges.discount');
                            }
                            if (session()->get('checkout.charges.shipping') > 0) {
                                $query['handling_cart'] = session()->get('checkout.charges.shipping');
                            }
                            if (session()->get('checkout.charges.tax') > 0 && session()->get('checkout.charges.taxincluded') == false) {
                                $query['tax_cart'] = session()->get('checkout.charges.tax');
                            }

                            $query['zip'] = $billingAddress['postcode'];
                            $query['amount'] = session()->get('checkout.charges.total');
                            $query['currency_code'] = app('config')['siteConfig']['cur_shortname'];
                            $query['invoice'] = session()->get('checkout.orderid');
                            $query['custom'] = 'accid=' . auth()->guard('store')->user()->acc_id . ';ordid=' . session()->get('checkout.order.id');

                            return redirect()->to(env('PAYPAL_URL') . '?' . http_build_query($query));

                            break;
                    }

                    switch ($charge->status) {
                        case 'pending':
                            $this->orderRepository->updateOrderPaymentStatus($order->ord_id, 1);
                            break;
                        case 'failed':
                            $this->orderRepository->updateOrderPaymentStatus($order->ord_id, 2);
                            break;
                        case 'succeeded':
                            $this->orderRepository->updateOrderPaymentStatus($order->ord_id, 3);
                            $this->orderRepository->updatePaymentReference($order->ord_id, $charge->id);
                            break;
                    }

                    //Abandoned Cart Delete.


                        $mailchimp = $this->newsletter->getApi();

                        ///* Create new customer object for the abondaned cart */
                        $storeresponse = $mailchimp->get("/ecommerce/stores");

                        /* Delete from Abandoned Cart */
                        $carturl = "/ecommerce/stores/".$storeresponse['stores'][0]['id']."/carts/".$order->ord_id;
                        $response = $mailchimp->delete($carturl);

                        /* Add Order into Mailchimp Order Section */
                        $customerurl = "/ecommerce/stores/".$storeresponse['stores'][0]['id']."/customers";

                        $options=[
                            'id' => (string)auth()->guard('store')->user()->acc_id,
                            'email_address' => auth()->guard('store')->user()->acc_email,
                            'opt_in_status' => false
                            ];

                        $customerresponse = $mailchimp->post($customerurl, $options);

                        $getcustomer = $mailchimp->get($customerurl."/".(string)auth()->guard('store')->user()->acc_id);

                        $producturl = "/ecommerce/stores/".$storeresponse['stores'][0]['id']."/products";

                        $products = session()->get('checkout.products');

                        $linearr = array(array());

                        $count = 0;
                        foreach ($products as $product)
                        {
                            $options=[
                            'id' => (string)$product['id'],
                            'title' => $product['name'],
                            'url' => url($product['link']),
                            'description' => $product['description'],
                            'image_url' => url($product['image']),
                            'variants' => [['id' => (string)$product['id'], 'title' => $product['name'], 'url' => url($product['link']), 'description' => $product['description'], 'image_url' => url($product['image']) ]]
                            ];

                            $linearr[$count]['id'] = (string)($count+1);
                            $linearr[$count]['product_id'] = (string)$product['id'];
                            $linearr[$count]['product_variant_id'] = (string)$product['id'];
                            $linearr[$count]['quantity'] = $product['quantity'];
                            $linearr[$count]['price'] = $product['subtotal'];

                            $productresponse = $mailchimp->post($producturl, $options);
                        }

                 $options=[
                            'id' => (string)$order->ord_id,
                            'customer' => $getcustomer,
                            'currency_code' => 'USD',
                            'order_total' => session()->get('checkout.charges.total'),
                            'lines' => $linearr
                            ];

                  $carturl = "/ecommerce/stores/".$storeresponse['stores'][0]['id']."/orders";

                   $response = $mailchimp->post($carturl, $options);

                    $this->successOrderEmail();

                    if ($paymentMethod == 'ApplePay' || $paymentMethod == 'GooglePay')
                    {
                        return response()->json(array('success' => true, 'order_id'=>$order->ord_id));
                    }
                    else
                    {
                        return redirect()->to('/store/account/orders/'.$order->ord_id);
                    }

            }
        }

        $shippingCountryId = session()->get('checkout.address.shipping.country_id');

        $shippingRestrict = false;

        $shippingserviceError = false;

        if ($shippingCountryId != null)
        {
            $isshippingRestricted = $this->storeRepository->isshippingrestricted($shippingCountryId);

            if ($isshippingRestricted == null)      //If country is valid for shippment from this store.
            {
                $shippingRestrict = true;
            }
        }


        $shipping = 0;

        if ($shippingCountryId) {

            //$regionId = $this->storeRepository->getCountryRegion($shippingCountryId)->reg_loc_id;

            $countrycode = $this->storeRepository->getCountryCode($shippingCountryId)->cou_code;

            switch ($countrycode) {
                case 'AU':             // Only for Australia and Newzealand use Auspost.
                case 'NZ':
                    $this->shippingCalculator->setCarrier('auspost');
                    break;
                default:
                    $this->shippingCalculator->setCarrier('ups');
                    break;
            }


            $shippingServices = $this->shippingCalculator->servicesAvailable(
            session()->get('checkout.products'),
            session()->get('checkout.address.shipping')
            );

            if ($shippingServices == false and $this->shippingCalculator->carrier == 'auspost')
            {
                $shippingserviceError = true;
            }
            else
            {
                session()->put('checkout.shipping.services', $shippingServices);

                $shipping = $this->shippingCalculator->getPriceForService(session()->get('checkout.shipping.service'));

                $shippingServiceSelected = session()->get('checkout.shipping.service');
            }
        }

        $subtotal = $products->sum('subtotal');

        $discount = 0;
        if (session()->get('checkout.voucher.percent') != null)
        {
            $discount = ($subtotal / 100) * session()->get('checkout.voucher.percent');
        }
        else
        {
            $discount = session()->get('checkout.voucher.dollars');
        }

        $subtotalTax = 0;
        $shippingTax = 0;

        if ($taxes['countytax']) {
            $subtotalTax = $this->checkoutRepository->calculateTax($subtotal-$discount, $taxes['countytax']);
            $shippingTax = $this->checkoutRepository->calculateTax($shipping, $taxes['countytax']);
        }
        else {
            if ($taxes['goodstax'] || $taxes['shippingtax']) {
                $subtotalTax = $this->checkoutRepository->calculateTax($subtotal-$discount, $taxes['goodstax']);
                $shippingTax = $this->checkoutRepository->calculateTax($shipping, $taxes['shippingtax']);
            }
        }

        if ($taxes['post_tax_rate']) {
            $tax = $this->checkoutRepository->calculateTax($subtotal-$discount, $taxes['post_tax_rate']);
        }
        else
        {
            $tax = $subtotalTax + $shippingTax;
        }

        $total = ($subtotal - $discount) + $shipping + $tax;

        session()->put('checkout.charges.subtotal', number_format($subtotal, 2, ".", ""));
        session()->put('checkout.charges.discount', number_format($discount, 2, ".", ""));
        session()->put('checkout.charges.shipping', number_format($shipping, 2, ".", ""));
        session()->put('checkout.charges.tax', number_format($tax, 2, ".", ""));
        session()->put('checkout.charges.total', number_format($total, 2, ".", ""));

        $years = range(date('Y'), date('Y', strtotime('+10 years')));
        $years = array_combine($years, $years);
        $months = array_combine(range(1, 12), range(1, 12));

        $addressbookcount = 0;

        $addressbookcount = count($this->accountRepository->searchAccountAddress(auth()->guard('store')->user()->acc_id));

        $accountAddresses = $this->accountRepository->getAccountAddress(auth()->guard('store')->user()->acc_id);

        $editaddressectionflag = 0;     //0 is false, 1 is true.

        if ($addid != null && $type != "delete")     //editaddress-section
        {
            $editaddressectionflag = 1;

            $addressBookAdd = $this->accountRepository->getAccountAddressAddid($addid);

            if (count($addressBookAdd) > 0)
            {
                session()->put('checkout.address.editaddress', $addressBookAdd);
                session()->put('checkout.address.editaddresstype', $type);
            }
        }

        if ($addid != null && $type == "delete")     //deleteaddress
        {
            $address_shipping = $this->accountRepository->getdefaultAccountAddress(auth()->guard('store')->user()->acc_id, 'shipping');
            $address_billing = $this->accountRepository->getdefaultAccountAddress(auth()->guard('store')->user()->acc_id, 'billing');

            if($address_shipping != null)
            {
                if ($address_shipping->add_id == $addid)
                {
                    session()->forget('checkout.address.shipping');
                }
            }

            if ($address_billing != null)
            {
                if ($address_billing->add_id == $addid)
                {
                    session()->forget('checkout.address.billing');
                }
            }

            $this->accountRepository->deleteAccountAddress($addid);

            return redirect()->to('/store/checkout');
        }

        $shippingdefault = 0;
        $billingdefault = 0;
        $addcount = 0;

        $shippingAddressTemp = session()->get('checkout.address.shipping');
        $billingAddressTemp = session()->get('checkout.address.billing');

        foreach ($accountAddresses as $acadd)
        {
            $addcount++;
            if ($acadd->add_firstname == $shippingAddressTemp['firstname'] &&
                $acadd->add_lastname == $shippingAddressTemp['lastname'] &&
                $acadd->add_street == $shippingAddressTemp['street'] &&
                $acadd->add_city == $shippingAddressTemp['city'] &&
                $acadd->add_postcode == $shippingAddressTemp['postcode'] &&
                $acadd->add_cou_id == $shippingAddressTemp['country_id'] &&
                $acadd->add_state == $shippingAddressTemp['state_id'] &&
                $acadd->add_isbusiness == $shippingAddressTemp['is_business'] &&
                $acadd->add_aptsuite == $shippingAddressTemp['suite'])
            {
                $shippingdefault = $addcount;
            }
            if ($acadd->add_firstname == $billingAddressTemp['firstname'] &&
                $acadd->add_lastname == $billingAddressTemp['lastname'] &&
                $acadd->add_street == $billingAddressTemp['street'] &&
                $acadd->add_city == $billingAddressTemp['city'] &&
                $acadd->add_postcode == $billingAddressTemp['postcode'] &&
                $acadd->add_cou_id == $billingAddressTemp['country_id'] &&
                $acadd->add_state == $billingAddressTemp['state_id'] &&
                $acadd->add_isbusiness == $billingAddressTemp['is_business'] &&
                $acadd->add_aptsuite == $billingAddressTemp['suite'])
            {
                $billingdefault = $addcount;
            }
        }

        // Mailchimp Abandoned Cart Section start here.

            $mailchimp = $this->newsletter->getApi();

            /* Create new customer object for the abondaned cart */
            $storeresponse = $mailchimp->get("/ecommerce/stores");

            $customerurl = "/ecommerce/stores/".$storeresponse['stores'][0]['id']."/customers";

            $options=[
                'id' => (string)auth()->guard('store')->user()->acc_id,
                'email_address' => auth()->guard('store')->user()->acc_email,
                'first_name' => auth()->guard('store')->user()->acc_firstname,
                'last_name' => auth()->guard('store')->user()->acc_lastname,
                'opt_in_status' => false
                ];

            $customerresponse = $mailchimp->post($customerurl, $options);

            //Update the Customer
            if (isset($customerresponse['status']))
            {
                $customerresponse = $mailchimp->put($customerurl."/".(string)auth()->guard('store')->user()->acc_id, $options);
            }

            $getcustomer = $mailchimp->get($customerurl."/".(string)auth()->guard('store')->user()->acc_id);

            $producturl = "/ecommerce/stores/".$storeresponse['stores'][0]['id']."/products";

            $products = session()->get('checkout.products');

            $linearr = array(array());

            $count = 0;
            foreach ($products as $product)
            {
                $options=[
                'id' => (string)$product['id'],
                'title' => $product['name'],
                'url' => url('/store'.$product['link']),
                'description' => $product['description'],
                'image_url' => url($product['image']),
                'variants' => [['id' => (string)$product['id'], 'title' => $product['name'], 'url' => url($product['link']), 'description' => $product['description'], 'price' => $product['price']  ,'image_url' => url($product['image']) ]]
                ];

                $linearr[$count]['id'] = (string)($count+1);
                $linearr[$count]['product_id'] = (string)$product['id'];
                $linearr[$count]['product_variant_id'] = (string)$product['id'];
                $linearr[$count]['quantity'] = $product['quantity'];
                $linearr[$count]['price'] = $product['subtotal'];

                $count++;

                $productresponse = $mailchimp->post($producturl, $options);

                //Update the Product
                if (isset($productresponse['status']))
                {
                    $productresponse = $mailchimp->patch($producturl."/".(string)$product['id'], $options);
                }

            }

            $options=[
                'id' => (string)$order->ord_id,
                'customer' => $getcustomer,
                'checkout_url' => url('/store/checkout'),
                'currency_code' => 'USD',
                'order_total' => $total,
                'lines' => $linearr
                ];

            $carturl = "/ecommerce/stores/".$storeresponse['stores'][0]['id']."/carts";

            $response = $mailchimp->post($carturl, $options);

            //Update the Customer
            if (isset($response['status']))
            {
                $response = $mailchimp->patch($carturl."/".(string)$order->ord_id, $options);
            }


        return view('pages.store.checkout')->with(compact('years', 'months', 'countries', 'states', 'counties', 'products', 'cart', 'shippingServices', 'shippingServiceSelected', 'paymentMethod', 'addressbookcount', 'accountAddresses','statesAddressBook', 'editaddressectionflag', 'shippingdefault', 'billingdefault', 'shippingRestrict', 'shippingserviceError'));
    }

    /**
     * On Paypal Success
     */
    public function successOrderEmail()
    {
        /* Order confirmation Email Template */

        $mail = app('Illuminate\Mail\Mailer');

        $billingAddress = session()->get('checkout.address.billing');
        $shippingAddress = session()->get('checkout.address.shipping');
        $order = $this->orderRepository->getOrder(auth()->guard('store')->user()->acc_id, session()->get('checkout.order.id'));
        $countries = $this->storeRepository->getCountriesList();
        $states = $this->storeRepository->getStatesList();
        $products = session()->get('checkout.products');
        $cart = session()->get('cart.products')?:[];

        $this->orderRepository->updateOrderStatus($order->ord_id, 1);   // Change status to NEW.

        $OrderNumber = "";
        if($order->ord_website_id == 1)
        {
            $OrderNumber .= "AA";
        }elseif($order->ord_website_id == 4)
        {
            $OrderNumber .= "AU";
        }else {
            $OrderNumber .= "WW";
        }
        $OrderNumber .= date("Ym", strtotime($order->ord_date));
        $OrderNumber .= $order->ord_id;

        $data = [
            'orderUserName' => $shippingAddress['firstname'],
            'orderNumber' => $OrderNumber,
            'orderDate' => date('d-m-Y', strtotime($order->ord_date)),
            'orderFirstName' => $shippingAddress['firstname'],
            'orderLastName' => $shippingAddress['lastname'],
            'orderEmail' => auth()->guard('store')->user()->acc_email,
            'orderPhone' => auth()->guard('store')->user()->acc_phone,
            'orderFax' => auth()->guard('store')->user()->acc_fax,
            'orderCurrency' => $order->cur_symbol,
            'orderStreet' => $shippingAddress['street'],
            'orderCity' => $shippingAddress['city'],
            'orderApt' => session()->get('checkout.address.'.'shipping'.'.suite'),
            'orderShippingMethod' => session()->get('checkout.shipping.service'),
            'orderPostCode' => session()->get('checkout.address.'.'shipping'.'.postcode'),
            'orderState' => isset($states[session()->get('checkout.address.'.'shipping'.'.country_id')][session()->get('checkout.address.'.'shipping'.'.state_id')]) ? $states[session()->get('checkout.address.'.'shipping'.'.country_id')][session()->get('checkout.address.'.'shipping'.'.state_id')]['name'] : session()->get('checkout.address.'.'shipping'.'.state_id'),
            'orderCountry' => isset($countries[session()->get('checkout.address.'.'shipping'.'.country_id')]) ? $countries[session()->get('checkout.address.'.'shipping'.'.country_id')] : session()->get('checkout.address.'.'shipping'.'.country_id'),
            'orderProducts' => $products,
            'orderVoucherCode' => session()->get('checkout.voucher.code'),
            'orderDiscount' => session()->get('checkout.charges.discount'),
            'orderShippingCost' => session()->get('checkout.charges.shipping'),
            'orderSurchargeCost' => $order->ord_surchargecost,
            'orderTaxCost' => session()->get('checkout.charges.tax'),
            'orderTotalCost' => session()->get('checkout.charges.total'),
            'orderCart' => $cart,
            'orderProductSubtotal'=> session()->get('checkout.charges.subtotal'),
            'orderPaymentType' => session()->get('checkout.charges.paymentmethod'),
            'orderPaymentRef' => $order->ord_paymentreference,
            'orderPaymentDetails' => $order->ord_paymentdetails,
            ];

        $emailRecipients = $this->checkoutRepository->getOrderConEmailList(session()->get('checkout.address.'.'shipping'.'.country_id'));

        $emailTo = [];

        foreach ($emailRecipients as $email) {
            $emails = $email->eml_address;
            $emails = explode(";", $emails);
            foreach ($emails as $em)
            {
                $emailTo[] = $em;
            }

        }

        if (! count($emailTo)) {
            $emailTo[] = $this->config->get('airaroma.admin_email');
        }

        $mail->send('emails.orderconfirmation', ['data' => $data], function ($mail) use ($emailTo, $data) {
            $mail->to($emailTo)
                ->subject('Order Confirmation'. ' - ' . $data['orderNumber'] . ' - ' . date('Y-m-d H:i:s ( P )'));
        });

        $mail->send('emails.orderconfirmation', ['data' => $data], function ($mail) use ($data) {
            $mail->to(auth()->guard('store')->user()->acc_email)
                ->subject('Order Confirmation'. ' - ' . $data['orderNumber'] . ' - ' . date('Y-m-d H:i:s ( P )'));
        });

        session()->forget('checkout');
        session()->forget('cart');

        return redirect()->to('/store/account/orders/'.$order->ord_id);
    }

    public function paypalIpnListener()
    {
        $listenerBuilder = new ListenerBuilder();
        $listenerBuilder->useSandbox(); // use PayPal sandbox
        $listener = $listenerBuilder->build();

        $listener->onVerified(function (MessageVerifiedEvent $event) {
            $ipnMessage = $event->getMessage();
            error_log(print_r($event, true));
            dump($ipnlistener);

            die();
            dd();

            $orderId = 1475;

            $order = $this->orderRepository->order->where('ord_id', '=', $orderId)->first();

            switch ($charge->status) {
                case 'pending':
                    $this->orderRepository->updateOrderPaymentStatus($order->ord_id, 1);
                    break;
                case 'failed':
                    $this->orderRepository->updateOrderPaymentStatus($order->ord_id, 2);
                    break;
                case 'succeeded':
                    $this->orderRepository->updateOrderPaymentStatus($order->ord_id, 3);
                    $this->orderRepository->updateOrderStatus($order->ord_id, 2);
                    $this->orderRepository->updatePaymentReference($order->ord_id, $charge->id);
                    break;
            }

            // IPN message was verified, everything is ok! Do your processing logic here...
        });

        $listener->onInvalid(function (MessageInvalidEvent $event) {
            $ipnMessage = $event->getMessage();
            error_log(print_r($ipnMessage, true));
            dump($ipnMessage);
            // IPN message was was invalid, something is not right! Do your logging here...
        });

        $listener->onVerificationFailure(function (MessageVerificationFailureEvent $event) {
            $error = $event->getError();
            error_log(print_r($error, true));
            dump($error);
            // Something bad happend when trying to communicate with PayPal! Do your logging here...
        });







    }

    public function OldpaypalResponse()
    {
        // STEP 1: read POST data

        // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
        // Instead, read raw POST data from the input stream.
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }
        // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }


        // STEP 2: POST IPN data back to PayPal to validate

        $ch = curl_init(env('PAYPAL_URL'));
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        // In wamp-like environments that do not come bundled with root authority certificates,
        // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set
        // the directory path of the certificate as shown below:
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
        if (!($res = curl_exec($ch))) {
            curl_close($ch);
            exit;
        }
        curl_close($ch);


        // STEP 3: Inspect IPN validation result and act accordingly

        if (strcmp($res, "VERIFIED") == 0) {
            // The IPN is verified, process it:
            // check whether the payment_status is Completed
            // check that txn_id has not been previously processed
            // check that receiver_email is your Primary PayPal email
            // check that payment_amount/payment_currency are correct
            // process the notification

            // assign posted variables to local variables
            $item_name = $_POST['item_name'];
            $item_number = $_POST['item_number'];
            $payment_status = $_POST['payment_status'];
            $payment_amount = $_POST['mc_gross'];
            $payment_currency = $_POST['mc_currency'];
            $txn_id = $_POST['txn_id'];
            $receiver_email = $_POST['receiver_email'];
            $payer_email = $_POST['payer_email'];
            $custom = $_POST["custom"];

            $memberid = 0;
            $orderid = 0;
            if (strpos($custom, ";") !== false) {
                $customparts = explode(";", $custom);
                $memberid = "";
                $payid = "";
                if (count($customparts)>0) {
                    foreach ($customparts as $custompart) {
                        if (substr($custompart, 0, 6) == "memid=") {
                            $memberid = substr($custompart, 6);
                        }
                        if (substr($custompart, 0, 6) == "payid=") {
                            $payid = substr($custompart, 6);
                        }
                    }
                }
            }









            $messages = "Transaction " . $payment_status . ": AAI Paypal Code is " . $payid . ":  Transaction ID is " . $txn_id;

            if (substr($payment_status, 0, 9) == "Completed") {
                $sQuery = ' INSERT INTO "TRANSACTION" ( "TCTN_WEBSITE_ID", "TCTN_MEMBER_ID", "TCTN_PROCESSOR", "TCTN_RESULT", "TCTN_CODE", "TCTN_DATE", "TCTN_COST" )
                            VALUES (@WebsiteID, @MemberID, @Processor, @Result, @Code, @Timestamp, @Cost );';
                $SqlCommand = new SqlCommand($sQuery, Database::GetInstance());
                $SqlCommand->Parameters->Add("@WebsiteID", Website::$ID);
                $SqlCommand->Parameters->Add("@MemberID", $memberid);
                $SqlCommand->Parameters->Add("@Processor", "paypal-usa");
                $SqlCommand->Parameters->Add("@Result", 1);
                $SqlCommand->Parameters->Add("@Code", $messages);
                $SqlCommand->Parameters->Add("@Timestamp", "NOW()");
                $SqlCommand->Parameters->Add("@Cost", $payment_amount);
                $SqlCommand->ExecuteNonQuery();
            }

            // IPN message values depend upon the type of notification sent.
            // To loop through the &_POST array and print the NV pairs to the screen:
            /*  foreach($_POST as $key => $value) {
            echo $key." = ". $value."<br>";
            error_log($key." = ". $value."<br>");
            }*/
        } elseif (strcmp($res, "INVALID") == 0) {
            // IPN invalid, log for manual investigation
            echo "The response from IPN was: <b>" .$res ."</b>";
        }
    }
}
