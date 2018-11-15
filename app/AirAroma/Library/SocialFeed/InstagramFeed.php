<?php

namespace AirAroma\Library\SocialFeed;

class InstagramFeed extends SocialFeedRepository
{

    public function __construct()
    {
        parent::__construct();

        $this->url = 'https://www.instagram.com/aromagram/';
        $this->filename = 'instagram.txt';
    }

    /**
     * open and fetch the dom elements added to an array
     * @return array
     */
    public function fetch()
    {
        $dom = $this->dom();

        $text = $dom->filter('body')->text();

        preg_match('~window._sharedData = (.+);~', $text, $json);

        // data should be an array
        $this->data = $this->jsonToArray($json[1]);

        return $this;
    }
    public function all()
    {
        return $this;
    }
    public function user()
    {
        $this->data = $this->data['entry_data']['ProfilePage'][0]['user'];
        return $this;
    }
    public function posts()
    {
        $this->data = $this->data['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
        return $this;
    }
}
