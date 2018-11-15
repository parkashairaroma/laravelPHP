<?php

namespace AirAroma\Library;

use GuzzleHttp\Client;

class API
{
    public $url;
    protected $params;
    public $debug = false;

    public function __construct(Client $client) 
    {
        $this->client = $client;
    }

    public function post($url, $params = [])
    {
        $this->response = $this->client->request('POST', $url, $this->params($params));
        return $this;
    }

    public function response($buffer = 1024)
    {
        return $this->response->getBody()->read($buffer);
    }

    protected function params($params = [])
    {
        return [
            'debug' => $this->debug,
            'form_params' => $params
            ];
    }
}
