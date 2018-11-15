<?php

namespace AirAroma\Composer;

use AirAroma\Repository\TagRepository;
use Illuminate\Contracts\View\View;

class BlogComposer
{
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
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
            'approvalNames' => getConfig('airaroma', 'blog_approval')['names'], 
            'approvalColours' => getConfig('airaroma', 'blog_approval')['colours'],
            'statusNames' => getConfig('airaroma', 'blog_status')['names'],
            'statusColours' => getConfig('airaroma', 'blog_status')['colours'],
            'tagsList' =>  $this->tagRepository->tagsSelectList()
        ]);

    }
}
