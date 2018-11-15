<?php

namespace AirAroma\Repository;

use AirAroma\Model\ShippingCompany;
use AirAroma\Model\Tagstranslation;
use AirAroma\Model\Website;
use Illuminate\Http\Request as Request;

class ShippingServiceRepository
{

    public function __construct(ShippingCompany $shippingcompany)
    {
        $this->shippingcompany = $shippingcompany;
    }

    public function getAllShippingCompanies()
    {
        return $this->shippingcompany->get();
    }

}
