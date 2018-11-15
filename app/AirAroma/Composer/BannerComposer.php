<?php

namespace AirAroma\Composer;

use AirAroma\Repository\TagRepository;
use Illuminate\Contracts\View\View;

class BannerComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'bannerStatusNames' => getConfig('airaroma', 'banner_status')['names'],
            'bannerStatusColours' => getConfig('airaroma', 'banner_status')['colours'],
        ]);

    }
}
