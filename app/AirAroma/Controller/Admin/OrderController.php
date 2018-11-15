<?php

namespace AirAroma\Controller\Admin;


use AirAroma\Model\Order;
use AirAroma\Repository\Store\OrderRepository;
use AirAroma\Repository\ShippingServiceRepository;
use AirAroma\Service\BlogService;
use Illuminate\Mail\Mailer as Mail;
use AirAroma\Service\FormService;
use Illuminate\Config\Repository as Config;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function __construct(Request $request, OrderRepository $orderRepository, Order $order, ShippingServiceRepository $shippingservices, Mail $mail, FormService $formService, Config $config)
	{
		$this->request = $request;
		$this->orderRepository = $orderRepository;
        $this->shippingservices = $shippingservices;
        $this->order = $order;
        $this->mail = $mail;
        $this->formService = $formService;
        $this->config = $config;
	}

	/**
	 * get list of orders
	 */
	public function getOrders()
	{
        $orders = $this->orderRepository->getOrdersList(websiteId())->get();
        return view('admin.orders.list')->with(compact('orders'));
	}

    /**
     * send Tracking Email
     */
	public function sendTrackingEmail()
	{
        $id = request()->get('orderid');

        $order = $this->orderRepository->getOrdersDetails($id);

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
            'emailAddress' => $order->acc_email,
            'firstName' => $order->ord_firstname,
            'orderNumber' => $OrderNumber,
            'lastName' => $order->ord_lastname,
            'trackingNumber' => request()->get('trackingnumber'),
            'trackingCompany' => request()->get('trackingcompany'),
            'trackingLink' => request()->get('trackinglink')
            ];

        $emailRecipients = $this->orderRepository->getTrackingEmailList();

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

        $this->mail->send('emails.shipping-confirmation', $data, function ($mail) use ($emailTo, $OrderNumber) {
            $mail->to($emailTo);
            $mail->subject('Your Order ' . $OrderNumber .' is on its way! ');
        });

     $this->mail->send('emails.shipping-confirmation', $data, function ($mail) use ($data, $order, $OrderNumber) {
            $mail->to($order->acc_email);
            $mail->subject('Your Order ' . $OrderNumber .' is on its way! ');
        });

        $this->orderRepository->updateOrderShipping($id);

        session()->flash('message', 'An email has been sent to your address with instructions for resetting your password. Please check your Inbox.');

        return response(['msg' => 'Email Successfully Sent'], 200) // 200 Status Code: Standard response for successful HTTP request
          ->header('Content-Type', 'application/json');
	}

    /*
     * edit an existing order
     */
	public function editOrder($id)
	{
        $countryRepository = app('AirAroma\Repository\CountryRepository');
        $countries = $countryRepository->getCountries();
        //$countryCode = null;

		if ($this->request->isMethod('post')) {
            $this->orderRepository->updateOrder($id);
		}

        $order = $this->orderRepository->getOrdersDetails($id);

        $shippingservices = $this->shippingservices->getAllShippingCompanies();

        $orderproducts = $this->orderRepository->getOrderProductsList($id)->get();

        $orderstate = null;

        if (is_numeric($order->ord_state))
        {
            $orderstate = $this->orderRepository->getOrderStateName($order->ord_state)->get();
        }

        $countryCode = $countryRepository->getCountryById($order->ord_cou_id);

        $states = $countryRepository->getCountryStatesByCountryCode($countryCode->cou_code);

		return view('admin.orders.form')->with(compact('order','shippingservices', 'orderproducts', 'orderstate','countries', 'states'));
	}
}