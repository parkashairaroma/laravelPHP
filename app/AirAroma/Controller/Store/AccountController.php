<?php

namespace AirAroma\Controller\Store;

use AirAroma\Model\Account;
use AirAroma\Repository\WebsiteRepository;
use AirAroma\Model\Passwordreset;
use AirAroma\Repository\Store\AccountRepository;
use AirAroma\Repository\Store\OrderRepository;
use AirAroma\Repository\Store\StoreRepository;
use AirAroma\Repository\Store\ProductRepository;
use AirAroma\Service\FormService;
use App\Http\Controllers\Controller;
use Illuminate\Hashing\BcryptHasher as Hash;
use Illuminate\Mail\Mailer as Mail;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Carbon\Carbon;
use Spatie\Newsletter\Newsletter as Newsletter;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(
        Mail $mail,
        Hash $hash,
        Account $account,
        WebsiteRepository $website,
        Socialite $socialite,
        FormService $formService,
        Passwordreset $passwordreset,
        AccountRepository $accountRepository,
        OrderRepository $orderRepository,
        StoreRepository $storeRepository,
        ProductRepository $productrepository,
        Carbon $carbon,
        Newsletter $newsletter
    ) {

        $this->mail = $mail;
        $this->hash = $hash;
        $this->account = $account;
        $this->socialite = $socialite;
        $this->formService = $formService;
        $this->passwordreset = $passwordreset;
        $this->accountRepository = $accountRepository;
        $this->orderRepository = $orderRepository;
        $this->storeRepository = $storeRepository;
        $this->productrepository = $productrepository;
        $this->carbon = $carbon;
        $this->newsletter = $newsletter;
        $this->website = $website;
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function viewAccount($editdel = null , $addid = null)
    {

        if ($editdel == 'delete')        // delete an address
        {
            $this->accountRepository->deleteAccountAddress($addid);
        }

        $shippingAddress = $this->storeRepository->getAddressByType('shipping');
        $billingAddress = $this->storeRepository->getAddressByType('billing');

        $accountAddresses = $this->accountRepository->getAccountAddress(auth()->guard('store')->user()->acc_id);

        if ($shippingAddress->is_business == false)
        {
            session()->put('account.address.is_business', '0');
        }
        if ($shippingAddress->is_business == true)
        {
            session()->put('account.address.is_business', '1');
        }

        if (request()->isMethod('post')) {

            $formType = request()->get('form_type');

            $website = $this->website->getWebsiteById(websiteId())->first();

            if (request()->get('airaroma_newsletter') == null)
            {
                $this->newsletter->delete(auth()->guard('store')->user()->acc_email);
            }
            else
            {
                $this->newsletter->subscribe(auth()->guard('store')->user()->acc_email,['FNAME'=>auth()->guard('store')->user()->acc_firstname, 'LNAME'=>auth()->guard('store')->user()->acc_lastname, 'WEBSITE'=>$website->web_main_domain]);
            }

            switch ($formType) {
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

                    $type = session()->get('account.address.editaddresstype');

                    session()->forget('account.address.editaddresstype');
                    session()->forget('account.address.editaddress');

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

                    if ($address == $shippingAddress)
                    {
                        $this->accountRepository->updateAddress('shipping', $address);
                    }
                    if ($address == $billingAddress)
                    {
                        $this->accountRepository->updateAddress('billing', $address);
                    }

                    $this->accountRepository->updateAccountAddress($address, $addid);

                    return redirect()->to('/store/account')->with('addressBookRetunType', $type);
                    break;
            }
            $valid = $this->formService->validate([
                'firstname' => 'required',
                'lastname' => 'required',
            ]);

            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }

            $password = $this->accountRepository->updateName(request()->get('firstname'), request()->get('lastname'));

            return redirect('/store/account');
        }

        $countries = $this->storeRepository->getCountriesList();
        $states = $this->storeRepository->getStatesList();
        $counties = $this->storeRepository->getCountiesList();

        $newsletterBool = $this->newsletter->hasMember(auth()->guard('store')->user()->acc_email);

        $accountAddresses = $this->accountRepository->getAccountAddress(auth()->guard('store')->user()->acc_id);

        $editaddressectionflag = 0;

        if ($addid != null && $editdel == 'edit')     //editaddress-section
        {
            $editaddressectionflag = 1;

            $addressBookAdd = $this->accountRepository->getAccountAddressAddid($addid);

            if (count($addressBookAdd) > 0)
            {
                session()->put('account.address.editaddress', $addressBookAdd);
                session()->put('account.address.editaddresstype', 'shipping');
            }
        }

        return view('pages.store.account')->with(compact('newsletterBool','accountAddresses', 'countries', 'states', 'counties', 'editaddressectionflag'));
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function viewOrder($orderId)
    {
        $userId = auth()->guard('store')->user()->acc_id;
        $order = $this->orderRepository->getOrdernoDraft($userId, $orderId);

        $countries = $this->storeRepository->getCountriesList();
        $states = $this->storeRepository->getStatesList();
        $counties = $this->storeRepository->getCountiesList();

        $orderStatus = config('airaroma.order_status');

        return view('pages.store.account-order-details')->with(compact('order', 'products', 'orderStatusColours', 'countries', 'states', 'counties', 'orderStatus'));
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function viewOrders()
    {
        $userId = auth()->guard('store')->user()->acc_id;

        $orders = $this->orderRepository->getOrders($userId);

        $orderStatus = config('airaroma.order_status');

        return view('pages.store.account-orders')->with(compact('orders', 'orderStatus'));
    }


    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function updatePassword()
    {
        if (request()->isMethod('post')) {

            $valid = $this->formService->validate([
                'current_password' => 'required|current_password',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ]);

            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }

            $this->accountRepository->updatePassword(
                auth()->guard('store')->user()->acc_email,
                request()->get('password')
            );

            return redirect('/store/account');
        }

        return view('pages.store.account-password');
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function updateEmail()
    {
        if (request()->isMethod('post')) {

            $userId = auth()->guard('store')->user()->acc_id;

            $valid = $this->formService->validate([
                'current_password' => 'required|current_password',
                'email' => 'required|confirmed|unique:accounts,acc_email,'.$userId.',acc_id',
                'email_confirmation' => 'required',
                ], [
                'unique' => 'This email address is already linked to an account.'
                ]);

            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }

            $this->accountRepository->updateEmail(
                request()->get('email')
            );

            return redirect('/store/account');
        }

        return view('pages.store.account-email');
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function passwordCreate($token)
    {
        $passwordReset = $this->passwordreset->where('prs_token', $token)->first();

        if (! $passwordReset) {
            session()->flash('message', 'Password reset token has expired.');
            return view('pages.store.password-reset');
        }

        if (request()->isMethod('post')) {

            $valid = $this->formService->validate([
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ]);

            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }

            $this->accountRepository->updatePassword($passwordReset->prs_email, request()->get('password'));
            $this->passwordreset->where('prs_token', $token)->delete();

            $data = [
                'emailTo' => $passwordReset->prs_email,
                'emailImageServer' => getenv('EMAIL_IMAGESERVER')
            ];

            $this->mail->send('emails.password-reset', $data, function ($mail) use ($data) {
                $mail->to($data['emailTo']);
                $mail->replyTo('noreply@air-aroma.com');
                $mail->subject('Password has been reset');
            });

            return redirect('/store/signin');
        }
        return view('pages.store.password-reset');
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function passwordReset()
    {
        if (request()->isMethod('post')) {

            $valid = $this->formService->validate([
                'email' => 'email|required',
            ]);

            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }

            $token = md5(date('m-Y-d s:H:s').request()->get('email'));

            $data = [
                'emailTo' => request()->get('email'),
                'token' => $token,
                'resetLink' => $resetLink = url('store/forgot-password/'.$token),
                'emailImageServer' => getenv('EMAIL_IMAGESERVER')
            ];

            $emailCheck = $this->account->where('acc_email', '=', strtolower(request()->get('email')))->first();

            if (! $emailCheck) {
                return redirect()->back()->with('error', 'We could not find this email address in our system.')->withInput();
            }

            $account = $this->passwordreset->firstOrCreate([
                'prs_email' => $data['emailTo'],
                'prs_token' => $data['token']
            ]);

            $account->save();

            $emailRecipients = $this->accountRepository->getPasswordResetEmails();

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

            $this->mail->send('emails.forgot-password', $data, function ($mail) use ($emailTo) {
                $mail->to($emailTo);
                $mail->replyTo('noreply@air-aroma.com');
                $mail->subject('Password reset requested.');
            });

            $this->mail->send('emails.forgot-password', $data, function ($mail) use ($data) {
                $mail->to($data['emailTo']);
                $mail->replyTo('noreply@air-aroma.com');
                $mail->subject('Password reset requested.');
            });

            session()->flash('message', 'An email has been sent to your address with instructions for resetting your password. Please check your Inbox.');
            return redirect('/store/forgot-password');
        }

        return view('pages.store.forgot-password');
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function signin()
    {
        if (auth()->guard('store')->check()) {
            return redirect('/store/account');
        }

        if (request()->isMethod('post')) {

            $valid = $this->formService->validate([
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }

            $userEmail = request()->get('email');
            $userPassword = request()->get('password');

            $account = $this->account->where('acc_email', strtolower($userEmail))
                        ->where('old_password', md5($userPassword))->first();

            if ($account != null)
            {
                $this->accountRepository->updateOldPassword($userEmail,$userPassword);          // md5 to bcrypt password conversion for old accounts.
            }

            if (auth()->guard('store')->attempt(['acc_email' => strtolower($userEmail), 'password' => $userPassword, 'acc_activated' => '1']))      // User authenticated successfully
            {

                $order = $this->orderRepository->getlastunpaidOrder(auth()->guard('store')->user()->acc_id);        // Get last unpaid order and push that into the cart.

                if ($order != null)
                {
                    $productslist = $this->orderRepository->getOrderProductsList($order->ord_id)->get();

                    foreach ($productslist as $product)
                    {
                        $prvId = $product->ordpro_prv_id;
                        $quantity = $product->ordpro_quantity;

                        $productStock = $this->productrepository->getProductStock($prvId);

                        if (count($productStock) > 0 && $quantity < 100)
                        {
                            if ($productStock[0]->proweb_outofstock == 0 && $productStock[0]->proweb_available == 1)
                            {
                                $quantity = session()->get('cart.products.'.$prvId.'.quantity')+$quantity;
                                session()->put('cart.products.'.$prvId.'.quantity', $quantity);
                            }
                        }
                    }
                    return redirect('/store/cart');
                }

                return redirect('/store/checkout');
            }
            else
            {
                $account = $this->account->where('acc_email', strtolower($userEmail))->first();
                if (!$account)
                {
                    return redirect()->back()->withErrors(['error' => 'Your account does not exists in our records. Please create a new account.','error_code' => 1])->withInput();
                }
                else if ($account && !$this->hash->check($userPassword,$account->password))
                {
                    return redirect()->back()->withErrors(['error' => 'Your account password does not match our records. Please try again or recover your forgotten password.','error_code' => 2])->withInput();
                }
                else if ($account && $account->acc_activated != 1)
                {
                    return redirect()->back()->withErrors(['error' => 'Your account is not yet activated. Please check your email inbox (or Junk Mail) to activate your account.','error_code' => 3])->withInput();
                }
            }
        }
        return view('pages.store.signin');
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToFacebook()
    {
        return $this->socialite->driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleFacebookCallback(Request $request)
    {
        if (!$request->has('code') || $request->has('denied')) {
            return redirect('/store/signin');
        }

        try {
            $fbUser = $this->socialite->driver('facebook')->user();
        } catch (Exception $e) {
            dd($e);
        }

        $fbUserId = $fbUser['id'];

        $account = $this->account->where('acc_facebookid', $fbUserId)->first();

        $name = explode(' ', $fbUser['name'], 2);

        if (! $account) {

            $user = [
                'firstname' => $name[0],
                'lastname' => $name[1],
                'email' => $fbUser['email'],
                'password' => date('m-Y-d s:H:i'),
            ];

            $account = $this->accountRepository->createAccount($user, $fbUserId);
        }

        auth()->guard('store')->login($account);

        $order = $this->orderRepository->getlastunpaidOrder(auth()->guard('store')->user()->acc_id);        // Get last unpaid order and push that into the cart.

        if ($order != null)
        {
            $productslist = $this->orderRepository->getOrderProductsList($order->ord_id)->get();

            foreach ($productslist as $product)
            {
                $prvId = $product->ordpro_prv_id;
                $quantity = $product->ordpro_quantity;

                $productStock = $this->productrepository->getProductStock($prvId);

                if (count($productStock) > 0 && $quantity < 100)
                {
                    if ($productStock[0]->proweb_outofstock == 0 && $productStock[0]->proweb_available == 1)
                    {
                        $quantity = session()->get('cart.products.'.$prvId.'.quantity')+$quantity;
                        session()->put('cart.products.'.$prvId.'.quantity', $quantity);
                    }
                }
            }
            return redirect('/store/cart');
        }
        return redirect('/store/checkout');
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function signup()
    {
        $recaptchaSiteKey = getenv('RECAPTCHA_KEY');
        $recaptchaRequired = env('RECAPTCHA_REQUIRED');
        $recaptchaIgnore = explode(',', getenv('RECAPTCHA_IGNORE'));

        if (auth()->guard('store')->check()) {
            return redirect('/store/account');
        }

        if (request()->isMethod('post')) {

            $valid = $this->formService->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|unique:accounts,acc_email',
                'password' => 'required'
            ], [
                'unique' => 'This email address is already linked to an account. <a href="/store/signin">Sign In</a>'
            ]);

            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }

            $contactService = app('AirAroma\Service\ContactService');

            if ($recaptchaRequired) {
                if ($contactService->validateRecaptcha() === false) {
                    $recaptcha = ["recaptchaError" => true];
                    return redirect()->back()->withErrors($recaptcha)->withInput();
                }
            }

            $user = [
                'firstname' => request()->get('firstname'),
                'lastname' => request()->get('lastname'),
                'email' => request()->get('email'),
                'password' => request()->get('password'),
            ];

            $emailaddress = request()->get('email');

            $account = $this->accountRepository->createAccount($user);

            $website = $this->website->getWebsiteById(websiteId())->first();

            //Subscribe to MailChimp
            $this->newsletter->subscribe(request()->get('email'),['FNAME'=>request()->get('firstname'), 'LNAME'=>request()->get('lastname'), 'WEBSITE'=>$website->web_main_domain]);

            return view('pages.store.confirmation')->with(compact('emailaddress'));

        }
        return view('pages.store.signup')->with(compact('recaptchaSiteKey'));
    }

    public function ecommerceStore()
    {

        $mailchimp = $this->newsletter->getApi();

        $options=[
            'id' => 'airaromastore',
            'list_id' => 'b2adf5641a',
            'name' => 'Air Aroma',
            'currency_code' => 'USD'
            ];

        $response = $mailchimp->post("ecommerce/stores", $options);

        return redirect('/store/ecommerceStore');
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function signout()
    {
        session()->flush();
        return redirect('/store/signin');
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function activateAccount($code)
    {
        $account = $this->accountRepository->getAccountbyActivationCode($code);

        if (count($account) == 0)       // Invalid Code
        {
            return view('pages.store.activation')->withErrors(['error_header' => 'Activation Failed','error_msg' => 'There appears to be a problem with your activation code. It does not match any account in our records.','error_code' => 1]);
        }
        else                            //Valid Code
        {
            $now = $this->carbon->now();            //current date time
            $expirydate = Carbon::parse($account->acc_activationcodeexpiry);

            if ($account->acc_activated == 1)   // Account already active
            {
                return view('pages.store.activation')->withErrors(['error_header' => 'Already Activated','error_msg' => 'Hi '.$account->acc_firstname.' '.$account->acc_lastname.', Your account has already been activated in the past. Please sign in with your account details.','error_code' => 2]);
            }
            else                        // Activate User
            {
                if ($now->gt($expirydate))      // Activation Link expired
                {
                    return view('pages.store.activation')->withErrors(['error_header' => 'Activation Failed','error_msg' => 'This activation code has been expired.','error_code' => 3]);
                }
                else
                {
                    $this->accountRepository->updateActivationFlagbyCode($code);

                    auth()->guard('store')->login($account);

                    return view('pages.store.activation')->withErrors(['error_header' => 'Activation Success','error_msg' => 'Congratulations '.$account->acc_firstname.' '.$account->acc_lastname.', Your account is now fully activated and you have been logged in.']);
                }
            }
        }
    }


    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function reactivationCode()
    {
        if (request()->isMethod('post')) {

            $account = $this->accountRepository->getAccountbyEmail(request()->get('email'));

            if (count($account) == 0)       // Invalid Email Address
            {
                return view('pages.store.reactivation')->withErrors(['error_msg' => 'Your email address was not found in our system.']);
            }
            else if ($account->acc_activated == 1)
            {
                return view('pages.store.reactivation')->withErrors(['error_msg' => 'Your account has already been activated in the past. Please sign in with your account details.']);
            }
            else                    // Generate the Activation Link
            {
                $now = $this->carbon->now();            //current date time
                $expirydate = Carbon::parse($account->acc_activationcodeexpiry);

                if ($now->gt($expirydate) || $account->acc_activationcode == "")      // Activation Link expired, or activation code does not exist then generate new code.
                {
                    $randomcode = str_random(4) . "-" . str_random(4) . "-" . str_random(4);

                    $newnow = $now->addDays(7);             //add 7 days for expiry

                    $this->accountRepository->updateActivationCode(request()->get('email'),$randomcode,$newnow->format("Y-m-d H:i:s"));

                    $account = $this->accountRepository->getAccountbyEmail(request()->get('email'));    //Update account object
                }

                $mail = app('Illuminate\Mail\Mailer');

                $data = [
                        'username' => $account->acc_firstname . " ". $account->acc_lastname,
                        'email' => $account->acc_email,
                        'activationlink' => websiteUrl()."/store/activation/".$account->acc_activationcode,
                        ];

                $mail->send('emails.activation', ['data' => $data], function ($mail) use ($data) {
                    $mail->to($data['email'])
                        ->subject('Member Signup Confirmation');
                });

                $emailaddress = $account->acc_email;

                return view('pages.store.confirmation')->with(compact('emailaddress'));
            }
        }
       return view('pages.store.reactivation');
    }

    public function viewAddressBook()
    {
        return view('pages.store.account-addressbook');
    }

}
