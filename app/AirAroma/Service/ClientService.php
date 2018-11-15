<?php

namespace AirAroma\Service;

use Illuminate\Validation\Factory as Validator;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request as Request;

class ClientService
{
    public function __construct(Config $config, Request $request, Validator $validator)
    {
        $this->config = $config;
        $this->request = $request;
        $this->validator = $validator;
    }

    /**
    * Validate Contact Form contents
    *
    * @param null
    * @return validator object
    */
    public function validateForm($fields)
    {
        $rules = [
            'required' => 'Required',
            'unique' => 'Item already exists',
            'min' => 'A minimum of :min required'
            ];
        return $this->validator->make($this->request->all(), $fields, $rules);
    }
}
