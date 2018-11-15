<?php

namespace AirAroma\Library;

use Illuminate\Routing\Router;
use Illuminate\Config\Repository as Config;

class RouteGenerator
{
    /**
     * Global configuration
     *
     * @var object
     */
    protected $config;

    /**
     * Router instance
     *
     * @var
     */
    protected $router;


    /**
     * Site configuration
     *
     * @var array
     */
    protected $site;

    /**
     * Site urls and transaltions
     *
     * @var array
     */
    protected $links;

    /**
     * Url string used within routes
     *
     * @var string
     */
    protected $url;

    /**
     * Slug to be used within the routes
     *
     * @var string
     */
    protected $slug;

    public function __construct(Config $config, Router $router)
    {
        $this->config = $config;
        $this->router = $router;

        $this->defaultLanguage = getConfig('siteConfig', 'web_lang_default');
        $this->links = getConfig('siteTranslations', 'links');
    }

    /**
     * Generate routes from array
     *
     * @return $route
     */
    public function route($routes)
    {
        foreach ($routes as $route => $attributes) {
            extract($attributes);
            $this->isDefaultLanguage($route, $this->defaultLanguage);
            $this->route = $this->router->match($request, $this->url, $controller);
        }
        return $this->route;
    }

    /**
     * Generate routes from array with slug attributes
     *
     * @return $route
     */
    public function slug($routes)
    {
        foreach ($routes as $route => $attributes) {
            extract($attributes);
            $this->slug = $slug;

            if (! isset($where)) {
                $where = '[a-zA-Z0-9-]+';
            }

            $regexSlug = str_replace(['{','}','?'], '', $slug); 
            $this->isDefaultLanguage($route, $this->defaultLanguage)->withSlug();
            $this->route = $this->router->match($request, $this->url, $controller)->where($regexSlug, $where); 
        }
        return $this->route;
    }

    /**
     * Generate routes from array with slug attributes
     *
     * @return $route
     */
    // public function redirect($routes)
    // {
    //     foreach ($routes as $route => $attributes) {
    //         extract($attributes);
    //         $this->route = $this->router->get($route, function () use ($redirect) {
    //             return redirect($redirect['url'], $redirect['code']);
    //         });
    //     }
    //     return $this->route;
    // }

    /**
     * Determine if language is the default for domain
     *
     * @return $this
     */
    private function isDefaultLanguage($route, $lang)
    {
        if ($lang) {
            $this->url($route);
        } else {
            $this->url($route)->withLanguage();
        }
        return $this;
    }

    private function url($route)
    {
        if(isset($this->links[$route]['url'])) {
            $this->url = $this->links[$route]['url'];
        }
        else {
            $this->url = '/unknown_url_error-' . rand(10000,20000);
        }
        return $this;
    }

    private function withLanguage()
    {
        $this->url = '{lang}'.$this->url;
        return $this;
    }

    private function withSlug()
    {
        $this->url = $this->url.'/'.$this->slug;
        return $this;
    }
}
