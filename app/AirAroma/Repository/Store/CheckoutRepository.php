<?php

namespace AirAroma\Repository\Store;

use AirAroma\Model\Account;
use AirAroma\Model\Country;
use AirAroma\Model\PostCode;
use AirAroma\Model\Voucher;
use AirAroma\Model\Email;

class CheckoutRepository
{
    public function __construct(
        Account $account,
        Country $country,
        Voucher $voucher,
        PostCode $postcode,
        Email $email)
    {
        $this->account = $account;
        $this->country = $country;
        $this->voucher = $voucher;
        $this->postcode = $postcode;
        $this->email = $email;
    }

    /**
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function calculateTax($value, $tax)
    {
        return $value / 100 * $tax;
    }

    /**
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getTaxes($address)
    {
        $taxes = $this->country
            ->select(
                'cou_tax_on_goods as goodstax',
                'cou_tax_on_shipping as shippingtax'
                //'cnt_tax_rate as countytax'
            );
            $taxes->where('cou_id', $address['country_id']);

            if ($address['state_id'] && is_integer($address['state_id'])) {
                $taxes->where('sta_id', $address['state_id']);
            }
            if ($address['postcode']) {
                $post_taxes = $this->postcode->select('post_tax_rate')->where('post_code', $address['postcode']);
                $post_taxrate = $post_taxes->first();
            }

            if (! empty($post_taxrate['post_tax_rate']))
            {
                return $post_taxes;
            }
            else
            {
                $taxes->leftJoin('states', 'states.sta_cou_id', '=', 'countries.cou_id');
                return $taxes;
            }
    }

    /**
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getVoucherByCode($code)
    {
        return $this->voucher
            ->where('vou_code', $code)
            ->where('vou_start', '<=', date('Y-m-d'))
            ->where('vou_end', '>=', date('Y-m-d'))
            ->whereIn('vou_website_id', [0, websiteId()]);
    }

    /**
     *
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function isVoucherCurrent($voucher)
    {
        $start = strtotime($voucher->vou_start);
        $end = strtotime($voucher->vou_end);
        $now = time();
        if($start < $now && $end > $now)
        {
            return true;
        }
        else
        {
            return false;
        }
        return false;
    }

    /**
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function isAddressComplete($address)
    {
        if ($address['firstname'] && $address['street'] && $address['city'] && $address['postcode'] && $address['country_id']) {
            return true;
        }
        return false;
    }


    /**
     * @param  $options output options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function useAddressForShipping($address)
    {
        $accountId = auth()->guard('store')->user()->acc_id;

        $update = [
            'acc_billfirstname' => $address['firstname'],
            'acc_billlastname' => $address['lastname'],
            'acc_billstreet' => $address['street'],
            'acc_billcity' => $address['city'],
            'acc_billpostcode' => $address['postcode'],
            'acc_billcou_id' => $address['country_id'],
            'acc_billstate' => $address['state_id'],
            //'acc_billcounty_id' => $address['county_id'],
        ];

        $this->account->where('acc_id', $accountId)->update($update);
    }

    public function getOrderConEmailList($countryid)
    {
        $regid = $this->country->where('cou_id', $countryid)->first();
        return $this->email->where('eml_ety_id', '=', 11)
                            ->where('eml_reg_id', '=', $regid->cou_reg_id)
                            ->get();
    }


}