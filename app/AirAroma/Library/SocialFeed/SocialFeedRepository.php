<?php

namespace AirAroma\Library\SocialFeed;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class SocialFeedRepository
{
    protected $url;
    protected $filename;
    protected $data;
    protected $file;

    function __construct()
    {
        $this->crawler = app('Symfony\Component\DomCrawler\Crawler');
        $this->storage = app('Illuminate\Contracts\Filesystem\Factory');
    }

    public function dom()
    {
        $this->crawler->addContent($this->contents());
        return $this->crawler;
    }

    public function contents()
    {
        return file_get_contents($this->url);
    }

    public function pull()
    {
        if(!$this->storage->has('social/' . $this->filename))
        {
            $this->fetch()->posts()->store();
        }
        $json = $this->storage->get('social/' . $this->filename);
        return collect($this->jsonToArray($json));
    }

    /**
     * Convert the array to json so we can store it in a flat file
     * @return response
     */
    public function store()
    {
        $json = json_encode($this->data, true);
        $this->storage->put('social/' . $this->filename, $json);
        return Response::json(['status' => 'completed']);
    }

    public function jsonToArray($json)
    {
        return json_decode($json, true);
    }
}
