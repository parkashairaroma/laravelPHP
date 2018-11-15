<?php

namespace AirAroma\Composer;

use AirAroma\Library\FeatureSwitch;
use AirAroma\Library\LinkGenerator;
use AirAroma\Library\Translator;
use AirAroma\Repository\UserRepository;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use AirAroma\Repository\WebsiteRepository;

class GlobalComposer
{

    public function __construct(Config $config, Request $request, LinkGenerator $linkGenerator, Translator $translator, FeatureSwitch $featureSwitch, WebsiteRepository $websiterepository)
    {
        $this->config = $config;
        $this->linkGenerator = $linkGenerator;
        $this->translator = $translator;
        $this->featureSwitch = $featureSwitch;
        $this->request = $request;
        $this->websiterepository =  $websiterepository;
   }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $authedStoreUser = [];
        $authedAdminUser = [];
        $authRoles = [];

        if (auth()->guard('admin')->check()) {
            $authedAdminUser = auth()->guard('admin')->user();
            $authRoles = auth()->guard('admin')->user()->roles->lists('rol_token')->toArray();
        }

        if (auth()->guard('store')->check()) {
            $authedStoreUser = auth()->guard('store')->user();
        }

        /* Blade variables required across entire site */
        $view->with([
            'cartProductCount' => collect(session()->get('cart.products'))->sum('quantity'),
            'enableStore' => $this->websiterepository->checkIfStoreEnabled(),
            'authedStoreUser' => $authedStoreUser,
            'authedAdminUser' => $authedAdminUser,
            'authRoles' => $authRoles,
            'link' => $this->linkGenerator,
            'translate' => $this->translator,
            'feature' => $this->featureSwitch,
            'emailImageServer' => 'http://emails.air-aroma.com',
            'branch' => $this->config['branch'],
            'isBase' => isBase(),
            'baseId' => baseId(),
            'basePath' => basePath(),
            'baseTranslations' => getConfig('baseTranslations'),
            'siteTranslations' => getConfig('siteTranslations'),
            'siteConfig' => getConfig('siteConfig'),
            'counter' => 0 //need a better solution for this @byron do not change
        ]);

    }
}
