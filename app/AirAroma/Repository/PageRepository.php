<?php

namespace AirAroma\Repository;

use AirAroma\Model\Page;
use AirAroma\Model\Tag;
use AirAroma\Model\Website;
use AirAroma\Repository\LinkRepository;
use AirAroma\Repository\TagRepository;
use AirAroma\Repository\TokenRepository;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;

class PageRepository
{
    public $websiteId;
    public $pageId;

    public function __construct(TagRepository $tagRepository, LinkRepository $linkRepository, IndustryRepository $industryRepository, Request $request, Page $page, Tag $tag, Website $website, TokenRepository $tokenRepository)
    {
        $this->request = $request;
        $this->page = $page;
        $this->website = $website;
        $this->tag = $tag;
        $this->linkRepository = $linkRepository;
        $this->tokenRepository = $tokenRepository;
        $this->tagRepository = $tagRepository;
        $this->industryRepository = $industryRepository;
    }

    /*
    * show individual page
    */
    public function getPageById($pageId)
    {
        return $this->page
           ->where('pages.pag_id', $pageId)
           ->first();
    }

    /*
    * get page list
    */
    public function getPages($options = [])
    {
        $defaults = ['subsite' => null];

        if ($options) {
            $defaults = array_merge($defaults, $options);
        }

        extract($defaults);

        return $this->page
           ->whereIn('pages.pag_subsite', $subsite)
           ->orderBy('pages.pag_subsite', 'desc')
           ->orderBy('pages.pag_name', 'asc');
    }

    /**
     *
     */
    public function getTagsByWebsiteId($websiteId)
    {
        $data = $this->tagRepository->getTagsByWebsiteId($websiteId)->get()->toArray();

        foreach ($data as $tag) {

            $baseName = $tag['base_name'];
            $siteName = $tag['site_name'] ?: $baseName;

            $baseSlug = $tag['base_slug'];
            $siteSlug = $tag['site_slug'] ?: $baseSlug;

            $tags[$baseSlug] = [
                'name' => $siteName,
                'slug' => $siteSlug
            ];
        }
        return $tags;
    }

    /**
     *
     */
    public function getIndustriesByWebsiteId($websiteId)
    {
        $data = $this->industryRepository->getIndustriesByWebsiteId($websiteId)->get()->toArray();

        foreach ($data as $industry) {

            $baseName = $industry['base_name'];
            $siteName = $industry['site_name'] ?: $baseName;

            $baseSlug = $industry['base_slug'];
            $siteSlug = $industry['site_slug'] ?: $baseSlug;

            $industries[$baseSlug] = [
                'name' => $siteName,
                'slug' => $siteSlug
            ];
        }

        return $industries;
    }

    /**
     *
     */
    public function getFeaturesByWebsiteId($websiteId)
    {
        // foreach ($this->websiteRepository->getFeaturesByWebsiteId($websiteId)->get()->toArray() as $feature) {
        //     $features[$feature['fsw_name']] = true;
        // }
        // return $features;
    }

    /**
     * Get website links by website id
     */
    public function getLinksByWebsiteId($websiteId)
    {
        $data = $this->linkRepository->getLinksByWebsiteId($websiteId)->get();

        foreach ($data as $link) {

            $baseUrl = $link['base_url'];
            $siteUrl = $link['site_url'] ?: $baseUrl;

            $links[$baseUrl] = [
                'url' => $siteUrl
            ];
        }
        return $links;
    }

    /**
     *
     */
    public function getTranslationsByWebsiteAndPageId($websiteId, $pageId = null)
    {
        $output = [];

        $data = $this->tokenRepository->getTranslationsByWebsiteAndPageId($websiteId, $pageId)->get()->toArray();

        foreach ($data as $translation) {

            $baseTranslation = $translation['base_translation'];
            $siteTranslation = $translation['site_translation'];
            
            $translations[$translation['ptk_token']] = [
                'id' => $translation['ptk_id'],
                'translation' => $siteTranslation
            ];
        }
        return $translations;
    }


    /**
     *
     */
    public function getTemplatesByLink($links)
    {
        if (! $links) {
            return;
        }
        foreach ($links as $baseUrl => $translations) {
            extract($translations);
            $url ?: $url = $baseUrl;
            $templates[$url] = $baseUrl;
        }
        return $templates;
    }

    /**
     * Determine which blade template to use
     *
     * @param string $lang
     * @return string
     */
    function findBladeTemplate($lang = null)
    {
        $templates = getConfig('siteTranslations', 'templates');

        $cleanUrl = $this->cleanQueryStrings($this->request->server('REQUEST_URI'));

        if (getSegmentNumber($lang) == 2) {
            // Remove Initial Slash and Language From URI
            $uri = substr($cleanUrl, strlen($lang) + 1);
        } else {
            $uri = $cleanUrl;
        }
        
        return $templates[$uri];
    }

    /**
     * Get current page ID
     */
    public function getAdminPageId()
    {
        if ($this->request->segment(2) == 'pages' && $this->request->segment(3) == 'edit') {
            return $this->request->segment(4);
        }
    }

    protected function cleanQueryStrings($url) 
    {
        $matchQueryString = preg_match('~\?~', $url); 
        return ($matchQueryString) ? strstr($url, '?', true) : $url;
    }

    /**
     * Get current page ID
     */
    public function getPageId()
    {
        $cleanUrl = null;

        $links = $this->getLinksByWebsiteId(websiteId());
        $templates = $this->getTemplatesByLink($links);

        $urlSegments = explode('/', $this->request->server('REQUEST_URI'));
        array_shift($urlSegments);

        foreach ($urlSegments as $segment) {
            $cleanUrl .= '/'.$this->cleanQueryStrings($segment);
            $urls[] = $cleanUrl;
        }

        rsort($urls);

        foreach ($urls as $url) {
            if (array_key_exists($url, $templates)) {
                $pageUrl = $templates[$url];
                $pageId = $this->page->select('pag_id')->where('pag_url', $pageUrl)->where('pages.pag_subsite', 0);
                return $pageId->first()->pag_id;
            }
        }
    }

    /**
     *
     */
    public function updatePageStatus($status, $pageId)
    {
        return $this->page->where('pag_id', $pageId)->update(['pag_status' => $status]);
    }
}
