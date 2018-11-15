<?php

namespace AirAroma\Library\SocialFeed;

class TwitterFeed extends SocialFeedRepository
{

    public function __construct()
    {
        parent::__construct();

        $this->url = 'https://twitter.com/airaroma';
        $this->filename = 'twitter.txt';
    }

    /**
     * open and fetch the dom elements added to an array
     * @return array
     */
    public function fetch()
    {
        $tweets = [];

        $dom = $this->dom();

        $dates = $dom->filter('ol#stream-items-id > li ._timestamp')->each(function ($node) {
            return $node->text();
        });
        $caption = $dom->filter('ol#stream-items-id > li .tweet-text')->each(function ($node) {
            return $node->text();
        });

        foreach ($dates as $i => $date) {
            $tweets[] = ['date' => $date, 'caption' => $caption[$i]];
        }

        // return data as array
        $this->data = $tweets;

        return $this;
    }
    public function posts()
    {
        return $this;
    }
}
