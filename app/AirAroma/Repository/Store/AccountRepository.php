<?php

namespace AirAroma\Repository\Store;

use AirAroma\Model\Account;
use Illuminate\Hashing\BcryptHasher as Hash;
use Carbon\Carbon;
use AirAroma\Model\Accountsaddresses;
use AirAroma\Model\Addresses;
use AirAroma\Model\Email;
use Illuminate\Config\Repository as Config;

class AccountRepository
{

    public function __construct(Account $account, Hash $hash, Carbon $carbon,Accountsaddresses $accountsaddresses, Addresses $addresses, Email $email, Config $config)
    {
        $this->account = $account;
        $this->hash = $hash;
        $this->carbon = $carbon;
        $this->accountsaddresses = $accountsaddresses;
        $this->addresses = $addresses;
        $this->email = $email;
        $this->config = $config;
    }


    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function createAccount($user, $fbUserId = null)
    {
        $randomcode = str_random(4) . "-" . str_random(4) . "-" . str_random(4);

        $now = $this->carbon->now();            //current date time
        $newnow = $now->addDays(7);             //add 7 days for expiry

        $create = [
            'acc_firstname' => $user['firstname'],
            'acc_lastname' => $user['lastname'],
            'acc_billfirstname' => $user['firstname'],
            'acc_billlastname' => $user['lastname'],
            'acc_email' => strtolower($user['email']),
            'password' => $this->hash->make($user['password']),
            'acc_website_id' => websiteId(),
            'acc_activationcode' => $randomcode,
            'acc_activated' => 0,
            'acc_activationcodeexpiry' => $newnow->format("Y-m-d H:i:s")
        ];

        $mail = app('Illuminate\Mail\Mailer');

        if ($fbUserId) {
            $create = array_merge($create, ['acc_facebookid' => $fbUserId]);
        }

        $data = [
            'username' => $user['firstname'] . " ". $user['lastname'],
            'email' => $user['email'],
            'activationlink' => websiteUrl()."/store/activation/".$randomcode,
            ];

        if (!$fbUserId) {

            $emailRecipients = $this->SignUpEmailsList();

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

            $mail->send('emails.activation', ['data' => $data], function ($mail) use ($emailTo) {
                $mail->to($emailTo)
                    ->subject('Member Signup Confirmation');
            });

            $mail->send('emails.activation', ['data' => $data], function ($mail) use ($data) {
                $mail->to($data['email'])
                    ->subject('Member Signup Confirmation');
            });
        }

        return $this->account->create($create);
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function updateName($firstname, $lastname)
    {
        return $this->account
        ->where('acc_id', auth()->guard('store')->user()->acc_id)
        ->update([
            'acc_firstname' => $firstname,
            'acc_lastname' => $lastname
        ]);
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function updatePassword($email, $password)
    {
        return $this->account
        ->where('acc_email', strtolower($email))
        ->update([
            'password' => $this->hash->make($password)
        ]);
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function updateOldPassword($email, $password)
    {
        return $this->account
        ->where('acc_email', strtolower($email))
        ->update([
            'password' => $this->hash->make($password),
            'old_password' => null
        ]);
    }

    /**
     * View Account
     * @param type $lang
     * @return type
     */
    public function updateEmail($email)
    {
        return $this->account
        ->where('acc_id', auth()->guard('store')->user()->acc_id)
        ->update([
            'acc_email' => strtolower($email)
        ]);
    }

    /**
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateAddress($type, $address)
    {
        $accountId = auth()->guard('store')->user()->acc_id;

        switch ($type) {
            case 'shipping':
                $update = [
                    'acc_firstname' => $address['firstname'],
                    'acc_lastname' => $address['lastname'],
                    'acc_street' => $address['street'],
                    'acc_city' => $address['city'],
                    'acc_postcode' => $address['postcode'],
                    'acc_cou_id' => $address['country_id'],
                    'acc_state' => $address['state_id'],
                    'acc_isbusinessaddress' => $address['is_business'],
                    'acc_aptsuite' => $address['suite'],
                    'acc_businessname' => $address['businessname'],
                    'acc_phone' => $address['phone']
                ];
            break;
            case 'billing':
                $update = [
                    'acc_billfirstname' => $address['firstname'],
                    'acc_billlastname' => $address['lastname'],
                    'acc_billstreet' => $address['street'],
                    'acc_billcity' => $address['city'],
                    'acc_billpostcode' => $address['postcode'],
                    'acc_billcou_id' => $address['country_id'],
                    'acc_billstate' => $address['state_id'],
                    'acc_billisbusinessaddress' => $address['is_business'],
                    'acc_billaptsuite' => $address['suite'],
                    'acc_billbusinessname' => $address['businessname'],
                    'acc_billphone' => $address['phone']
                ];
            break;
        }

        $this->account->where('acc_id', $accountId)->update($update);
    }

    /**
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateAddressBook($type, $addressid)
    {
        switch ($type) {
            case 'shipping':
                $update = [
                    'acc_firstname' => $address['firstname'],
                    'acc_lastname' => $address['lastname'],
                    'acc_street' => $address['street'],
                    'acc_city' => $address['city'],
                    'acc_postcode' => $address['postcode'],
                    'acc_cou_id' => $address['country_id'],
                    'acc_state' => $address['state_id'],
                    'acc_isbusinessaddress' => $address['is_business'],
                    'acc_aptsuite' => $address['suite'],
                    'acc_businessname' => $address['businessname'],
                    'acc_phone' => $address['phone']
                ];
                break;
            case 'billing':
                $update = [
                    'acc_billfirstname' => $address['firstname'],
                    'acc_billlastname' => $address['lastname'],
                    'acc_billstreet' => $address['street'],
                    'acc_billcity' => $address['city'],
                    'acc_billpostcode' => $address['postcode'],
                    'acc_billcou_id' => $address['country_id'],
                    'acc_billstate' => $address['state_id'],
                    'acc_billisbusinessaddress' => $address['is_business'],
                    'acc_billaptsuite' => $address['suite'],
                    'acc_billbusinessname' => $address['businessname'],
                    'acc_billphone' => $address['phone']
                ];
                break;
        }

        $this->account->where('acc_id', $accountId)->update($update);
    }

    /* Get all the accounts */

    public function getAccounts()
    {
        return $this->account
        ->where('acc_website_id', websiteId())
        ->join('countries', 'countries.cou_id', '=', 'accounts.acc_cou_id')->get();
    }

    /* Get account by activation code */

    public function getAccountbyActivationCode($code)
    {
        return $this->account
        ->where('acc_activationcode', $code)->first();
    }

    /* update activation flag for an account */

    public function updateActivationFlagbyCode($code)
    {
        return $this->account
        ->where('acc_activationcode', $code)->update([
            'acc_activated' => 1
        ]);
    }

    /* Get account by email address */

    public function getAccountbyEmail($email)
    {
        return $this->account
        ->where('acc_email', strtolower($email))->first();
    }

    /* update activation flag for an account by email */

    public function updateActivationFlagbyEmail($email)
    {
        return $this->account
        ->where('acc_email', strtolower($email))->update([
            'acc_activated' => 1
        ]);
    }

    /* update activaition code */

    public function updateActivationCode($email,$code,$date)
    {
        return $this->account
        ->where('acc_email', strtolower($email))->update([
            'acc_activationcode' => $code,
            'acc_activationcodeexpiry' => $date,
            'acc_activated' => 0
        ]);
    }

    public function insertAccountAddress($address , $billingflag)
    {
        $create = [
                    'add_street' => $address['street'],
                    'add_city' => $address['city'],
                    'add_state' => $address['state_id'],
                    'add_postcode' => $address['postcode'],
                    'add_cou_id' => (int) $address['country_id'],
                    'add_firstname' => $address['firstname'],
                    'add_lastname' => $address['lastname'],
                    'add_aptsuite' => $address['suite'],
                    'add_isbusiness' => $address['is_business'],
                    'add_businessname' => $address['businessname'],
                    'add_phone' => $address['phone'],
                  ];


        $address = $this->addresses->create($create);

        if ($billingflag == 1)       //billing default
        {
            $accaddcreate=[
            'acc_id' => (int) auth()->guard('store')->user()->acc_id,
            'add_id' => (int) $address->add_id,
            'acc_add_shipdefault' => true,
            'acc_add_billdefault' => true,
            ];
        }
        else if ($billingflag == 0)
        {
            $accaddcreate=[
            'acc_id' => (int) auth()->guard('store')->user()->acc_id,
            'add_id' => (int) $address->add_id,
            'acc_add_shipdefault' => true,
            'acc_add_billdefault' => false
            ];
        }
        else if ($billingflag == 2)
        {
            $accaddcreate=[
           'acc_id' => (int) auth()->guard('store')->user()->acc_id,
           'add_id' => (int) $address->add_id,
           'acc_add_shipdefault' => false,
           'acc_add_billdefault' => false
           ];
        }

        $this->accountsaddresses->create($accaddcreate);
        return $address->add_id;
    }

    public function updateaccaddrFlag()
    {
        $this->account
        ->where('acc_id', (int) auth()->guard('store')->user()->acc_id)->update([
            'acc_add_flag' => 1
        ]);
    }

    public function updateAccountAddress($address, $addid)
    {
        $create = [
                    'add_street' => $address['street'],
                    'add_city' => $address['city'],
                    'add_state' => $address['state_id'],
                    'add_postcode' => $address['postcode'],
                    'add_cou_id' => (int) $address['country_id'],
                    'add_firstname' => $address['firstname'],
                    'add_lastname' => $address['lastname'],
                    'add_aptsuite' => $address['suite'],
                    'add_isbusiness' => $address['is_business'],
                    'add_businessname' => $address['businessname'],
                    'add_phone' => $address['phone'],
                  ];


         $this->addresses->where('add_id', $addid)->update($create);
    }

    public function searchAccountAddress($accid)
    {
        return $this->accountsaddresses->where('acc_id' , $accid)->first();
    }

    public function deleteAccountAddress($addid)
    {
        $this->accountsaddresses->where('add_id' , $addid)->delete();
        $this->addresses->where('add_id' , $addid)->delete();
    }

    public function getAccountAddress($accid)
    {
        return $this->accountsaddresses->where('acc_id' , $accid)
            ->join('addresses', 'addresses.add_id', '=', 'accountsaddresses.add_id')->get();
    }

    public function getdefaultAccountAddress($accid, $type)
    {
        if ($type == 'shipping')
        {
            return $this->accountsaddresses->where('acc_id' , $accid)
            ->where('acc_add_shipdefault' , true)->first();
        }
        else if ($type == 'billing')
        {
            return $this->accountsaddresses->where('acc_id' , $accid)
            ->where('acc_add_billdefault' , true)->first();
        }
        return null;
    }

    public function updatedefaultAccountAddress($accid, $addid, $type)
    {
        if ($type == 'useaddress-shipping')
        {
            $this->accountsaddresses->where('acc_id', $accid)
            ->update([
            'acc_add_shipdefault' => false              // Reset all to false.
        ]);

            $this->accountsaddresses->where('acc_id', $accid)
            ->where('add_id', $addid)
            ->update([
            'acc_add_shipdefault' => true               // Set an address
        ]);
        }
        else if ($type == 'useaddress-billing')
        {
            $this->accountsaddresses->where('acc_id', $accid)
            ->update([
            'acc_add_billdefault' => false              // Reset all to false.
        ]);

            $this->accountsaddresses->where('acc_id', $accid)
            ->where('add_id', $addid)
            ->update([
            'acc_add_billdefault' => true               // Set an address
        ]);
        }

    }

    public function getAccountAddressAddid($addid)
    {
        $accountAddress =  $this->addresses->where('add_id' , $addid);

        $accountAddress->select(
                    'add_firstname as firstname',
                    'add_lastname as lastname',
                    'add_street as street',
                    'add_city as city',
                    'add_postcode as postcode',
                    'add_cou_id as country_id',
                    'add_state as state_id',
                    'add_isbusiness as is_business',
                    'add_aptsuite as suite',
                    'add_businessname as businessname',
                    'add_phone as phone'
            );

        return $accountAddress->first();
    }

    public function getPasswordResetEmails()
    {
        return $this->email->where('eml_ety_id', '=', 8)->get();
    }

    public function SignUpEmailsList()
    {
        return $this->email->where('eml_ety_id', '=', 10)->get();
    }

}