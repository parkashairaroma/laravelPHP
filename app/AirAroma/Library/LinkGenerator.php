<?php

namespace AirAroma\Library;

use AirAroma\Library\Translator;
use Illuminate\Config\Repository as Config;

class LinkGenerator
{
    /**
     * Translation Links
     *
     * @var object
     */
    protected $links;

    /**
     * URL
     *
     * @var object
     */
    protected $url;

    public function __construct(Config $config, Translator $translator)
    {
        $this->config = $config;
        $this->translate = $translator;
        $this->defaultLanguage = getConfig('siteConfig', 'web_lang_default');
        $this->webLang = getConfig('siteConfig', 'web_lang');
        $this->links = getConfig('siteTranslations', 'links');
    }

    /**
     * Create link
     *
     * @return $this
     */
    public function create($url, $params = null)
    {
        $this->url = $url;
        $this->lang = null;
        $this->class = null;

        if (! $this->defaultLanguage) {
            $this->lang = $this->webLang;
        }

        if (! isset($this->links[$this->url])) {
            $this->links[$this->url]['url'] = '/page_not_found';
        }

        if ($params) {
            foreach($params as $param => $val) {
                $this->$param = $val;
            }
        }

        return $this;
    }

    /**
     * Generate full href
     *
     * @return string
     */
    public function full($token)
    {
        $translation = $this->translate->token($token);
        if($this->class) {
            $this->class = 'class="' . $this->class . '" ';
        }

        if (preg_match('~(http|https)~', $this->url)) {
            return $this->link = '<a '.$this->class.'href="'.$this->url.'">'.$translation.'</a>';
        }
       
        return $this->link = '<a '.$this->class.'href="'.$this->lang.$this->links[$this->url]['url'].'">'.$translation.'</a>';
    }

    /**
     * Generate url with language switch only
     *
     * @return string
     */
    public function url()
    {
        $this->link = $this->lang.$this->links[$this->url]['url'];

        return  $this->link;
    }

    /**
     * Generate translated name only
     *
     * @return string
     */
    public function name($token)
    {
        $this->link = $this->translate->token($token);
        return  $this->link;
    }

    // public function __toString()
    // {
    //     return $this->link;
    // }
}
