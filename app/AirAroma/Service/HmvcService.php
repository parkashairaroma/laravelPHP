<?php

namespace AirAroma\Service;

class HmvcService
{

    public function __construct()
    {
        $this->api = app('hmvc');
        $this->token = getenv('API_TOKEN');
    }

     /**
     * Description
     * @param type $lang
     * @return type
     */
    public function post($url, $params = [])
    {       
        $params = array_merge([
        	'api_token' => $this->token
        ], $params);
              
        $this->json = $this->api->post($url, $params);

        return $this;
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function get($url, $params = [])
    {       
        $params = array_merge([
        	'api_token' => $this->token
        ], $params);
              
        $this->json = $this->api->get($url, $params);

        return $this;
    }

     /**
     * Description
     * @param type $lang
     * @return type
     */
    public function item()
    {       
        return collect($this->json)->first();
    }   

     /**
     * Description
     * @param type $lang
     * @return type
     */
    public function collection()
    {       
        return collect($this->json);
    }   

}