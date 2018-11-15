<?php

namespace AirAroma\Composer;

use AirAroma\Repository\TagRepository;
use Illuminate\Contracts\View\View;

class ClientComposer
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
            'clientStatusNames' => getConfig('airaroma', 'client_status')['names'],
            'clientStatusColours' => getConfig('airaroma', 'client_status')['colours'],
        ]);

    }
}
