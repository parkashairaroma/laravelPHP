<?php

namespace AirAroma\Repository;

use AirAroma\Model\Website;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;

class WebsiteRepository
{

    public $lang;
    public $domain;

    function __construct(Config $config, Website $website, Request $request, TokenRepository $tokenRepository)
    {
        $this->website = $website;
        $this->config = $config;
        $this->request = $request;
        $this->tokenRepository = $tokenRepository;
    }

    public function setWebsiteId($websiteId) {

        $config['siteConfig']['web_id'] = $websiteId;
        $this->config->set($config);
    }

    /**
     * Set the base URL of the application, depending on the language switch
     */
    public function setBasePath()
    {
        $url = ($this->lang) ? DIRECTORY_SEPARATOR.$this->lang : null;
        return $url;
    }

    /**
     * Set the base URL of the application, depending on the language switch
     */
    public function setTld()
    {
        return substr(strrchr($this->domain, '.'), 1);
    }

    /**
     * Set the interface you're on
     */
    public function setInterfaceId()
    {
        return (preg_match('~(admin)~', $this->request->path(), $match)) ?  $match[0] :  'public';
    }

    /**
     * Set the interface you're on
     */
    public function setAlias()
    {
        $httpHost = $this->request->server('HTTP_HOST');
        return substr($httpHost, 0, strpos($httpHost, '.'));
    }


    /**
     * Determine is the domain complies with policy
     */
    public function isDomainValid()
    {
        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $this->domain)
                && preg_match("/^.{1,253}$/", $this->domain)
                && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $this->domain));
    }

    /**
     * Determine base domain name
     */
    public function domain()
    {
        $appAliases = explode(',', $this->config->get('developer.name'));

        $replacements = array_map(function($name) {
            return "~($name)~";
        }, $appAliases);

        $httpHost = $this->request->server('HTTP_HOST');

        $this->domain = preg_replace($replacements, 'www', $httpHost);

        return $this->domain;
    }

    /**
     * Check if laguage switch is set
     */
    public function language()
    {
        $uri = $this->request->server('REQUEST_URI');
        preg_match('~^/[a-z]{2}(?:/|$)~', $uri, $lang);
        $this->lang = trim(end($lang), '/');

        return $this->lang;
    }


    /**
     * Get website config based on language
     *
     * @param string $domain
     * @param string $lang
     *
     * @return type
     */
    public function getWebsiteConfig($domain)
    {
        return $this->website
        ->join('currency', 'currency.cur_id', '=', 'websites.web_currency')
        ->join('countries', 'countries.cou_id', '=', 'websites.web_cou_id')
        ->join('regions', 'regions.reg_id', '=', 'countries.cou_reg_id')
        ->where('web_main_domain', $domain);
    }

    /**
     * Get website config based on language
     *
     * @param string $domain
     * @param string $lang
     *
     * @return type
     */
    public function getWebsiteConfigByLanguage($lang, $domain)
    {
        return $this->getWebsiteConfig($domain)->where('web_lang', $lang);
    }

    /**
     * Get website config based on default language
     *
     * @param  string $domain
     * @return model
     */
    public function getWebsiteConfigByDefaultLanguage($domain)
    {
        return $this->getWebsiteConfig($domain)->where('web_lang_default', true);
    }

    /**
     * Determine is domain is configured
     *
     * @param  string $domain
     * @return model
     */
    public function isDomainConfigured($domain)
    {
        return $this->website
            ->where('web_main_domain', $domain)
            ->count();
    }

    /**
     *
     */
    public function getFeaturesByWebsiteId($websiteId)
    {
        return $this->website
            ->select('fsw_name')
            ->leftJoin('featureswitchwebsites', function ($join) {
                $join->on('featureswitchwebsites.fswweb_web_id', '=', 'websites.web_id');
            })
            ->leftJoin('featureswitches', function ($join) {
                $join->on('featureswitchwebsites.fswweb_fsw_id', '=', 'featureswitches.fsw_id');
            })
            ->where('websites.web_id', $websiteId);
    }

    /**
     * populate the websites select list with available roles
     */
    public function getWebsitesSelectList()
    {
        // see website model for title_language assessor attribute
        return $this->website->get()->lists('title_language', 'web_id');
    }

    /**
     *
     */
    public function getAuthWebsitesArray($user)
    {
        return $user->websites->lists('web_id')->toArray();
    }



    /**
     * Get list of websites and their country names
     *
     * @param  array $status
     * @return model
     */
    public function getWebsiteAndCountryByStatus($status = [])
    {
        return $this->website
            ->join('countries', 'countries.cou_id', '=', 'websites.web_cou_id')
            ->whereIn('web_status', $status)
            ->orderBy('cou_name', 'asc');
    }

    public function getWebsiteNamesAndDomains()
    {
        foreach ($this->getWebsiteAndCountryByStatus([1, 2])->get() as $details) {
            $websiteDomain = '#';

            if ($details->web_status == 1) {
                if ($details->web_lang_default) {
                    $websiteDomain = $details->web_main_domain;
                } else {
                    $websiteDomain = $details->web_main_domain.DIRECTORY_SEPARATOR.$details->web_lang;
                }
            }

            $name =  ($details->web_native_name) ?: $details->cou_name;

            $status =  ($details->web_status == 1) ? 'online' : 'comingsoon';

            $countries[$status][] = [
                    'code' => strtolower($details->cou_code),
                    'name' => $name,
                    'domain' => $websiteDomain
                ];
        }

        return arrayToObject($countries);
    }


    /**
     * Admin
     * admin: get website based on id
     */
    public function getWebsiteById($websiteId)
    {
        return $this->website->where('web_id', $websiteId);
    }

    /**
     * Admin
     * admin: update website by id
     */
    public function updateWebsiteById($websiteId)
    {
       return $this->website->where('web_id', $websiteId)->update([
            'web_status' => $this->request->get('web_status')
        ]);
    }

    /**
     * admin: get all websites with tokens
     */
    public function getWebsitesByStatus($status = [])
    {
        return $this->getWebsiteAndCountryByStatus($status);
    }

    public function checkIfStoreEnabled()
    {
        $storeflag = $this->website->select('web_shop')->where('web_id', websiteId())->first();

        if ($storeflag->web_shop == 0)        //If store is enabled.
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Get website url
     *
     * @param  none
     * @return website url
     */
    public function setWebsiteUrl(){
      $webDomain =  $this->website->select('web_main_domain')->where('web_id', websiteId())->first();

      return $webDomain->web_main_domain;

    }
}
