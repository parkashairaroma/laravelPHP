<?php

namespace AirAroma\Composer;

use AirAroma\Repository\WebsiteRepository;
use Illuminate\Contracts\View\View;

class WebsiteComposer
{
    public function __construct(WebsiteRepository $websiteRepository)
    {
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'websiteStatusNames' => getConfig('airaroma', 'website_status')['names'],
            'websiteStatusColours' => getConfig('airaroma', 'website_status')['colours'],
            'baseTokensCount' => $this->websiteRepository->getWebsiteById(baseId())->first()->tokens->count(),
            'baseTagsCount' => count(getConfig('baseTranslations', 'tags')),
            'baseLinksCount' => count(getConfig('baseTranslations', 'links')),
            'baseIndustriesCount' => count(getConfig('baseTranslations', 'industries')),
        ]);
    }
}
