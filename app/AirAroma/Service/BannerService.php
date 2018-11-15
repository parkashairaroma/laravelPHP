<?php

namespace AirAroma\Service;

use Illuminate\Validation\Factory as Validator;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request as Request;

class BannerService
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
    public function validateForm()
    {
        return $this->validator->make(
            $this->request->all(),
            [
                'ban_name' => 'required',
                'ban_title' => 'required',
                'ban_description' => 'required',
            ]
        );
    }
}
