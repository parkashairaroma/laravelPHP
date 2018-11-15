<?php

namespace AirAroma\Library;

use Inacho\CreditCard;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token;
use Stripe\Error\Card;

class StripePayment
{

    protected $apiToken;

    public function __construct(Charge $charge, Stripe $stripe, Token $token, CreditCard $creditCard)
    {
        $this->charge = $charge;
        $this->stripe = $stripe;
        $this->token = $token;
        $this->creditCard = $creditCard;

        if (websiteId()==4)
        {
            $this->apiToken = $this->stripe->setApiKey(getenv('STRIPE_SECRET_AUS'));
        }
        else
        {
            $this->apiToken = $this->stripe->setApiKey(getenv('STRIPE_SECRET'));
        }

    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function setCardAddress($cardAddress, $countries)
    {
        //extract($cardAddress);

        //$this->street = $cardAddress->street;
        //$this->city = $cardAddress->city;
       // $this->postcode = $cardAddress->postcode;
        //$this->country = $countries[$cardAddress->country_id];
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function setCardDetails($cardDetails, $countries)
    {
    	extract($cardDetails);
        $cardAddress = session()->get('checkout.address.billing');

    	$this->cardName = $card_name;
    	$this->cardType = $card_type;
    	$this->cardNumber = $card_number;
    	$this->cardCvc = $card_security;
    	$this->cardExpiryMonth = $card_expiry_month;
    	$this->cardExpiryYear = $card_expiry_year;
        $this->street = $cardAddress['street'];
        $this->city =  $cardAddress['city'];
        $this->postcode =  $cardAddress['postcode'];
        $this->country = $countries[$cardAddress['country_id']];
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function isCardValid()
    {
        return $this->creditCard->validCreditCard($this->cardNumber, $this->cardType)['valid'];
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function isCvcValid()
    {
        return $this->creditCard->validCvc($this->cardCvc, $this->cardType);
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function setCardTimestamp()
    {
        return mktime(0, 0, 0, $this->cardExpiryMonth, 1, $this->cardExpiryYear);
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function setCurrentTimestamp()
    {
        return mktime(0, 0, 0, date('n'), 1, date('Y'));
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function isCardExpired()
    {
        return $this->setCurrentTimestamp() > $this->setCardTimestamp();
    }

     /**
     * Description
     * @param type $lang
     * @return type
     */
    protected function getTransationToken()
    {
		return $this->token->create([
			'card' => [
                'address_line1' => $this->street,
                'address_city' => $this->city,
                'address_zip' => $this->postcode,
                'address_country' => $this->country,
                'name' => $this->cardName,
				'number' => $this->cardNumber,
				'exp_month' => $this->cardExpiryMonth,
				'exp_year' => $this->cardExpiryYear,
				'cvc' => $this->cardCvc,
			]
		])->id;
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function chargeCard($orderId, $amount, $currency)
    {
        try
        {
            return $this->charge->create([
           'amount' => $amount,
           'currency' => $currency,
           'source' => $this->getTransationToken(),
           'description' => "Order number: ".$orderId
            ]);
        }
        catch(Card $e) {
            return $e;
        }

    }

    public function chargeCardSample($orderId, $amount, $currency, $token)
    {
        try
        {
            return $this->charge->create([
           'amount' => $amount,
           'currency' => $currency,
           'source' => $token,
           'description' => "Order number: ".$orderId
            ]);
        }
        catch(Card $e) {
            return $e;
        }

    }

    public function chargeCardAppleGoogle($orderId, $amount, $currency, $token)
    {
        try
        {
            return $this->charge->create([
           'amount' => $amount,
           'currency' => $currency,
           'source' => $token,
           'description' => "Order number: ".$orderId
            ]);
        }
        catch(Card $e) {
            return $e;
        }

    }
}
