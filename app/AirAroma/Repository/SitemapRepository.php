<?php

namespace AirAroma\Repository;

use AirAroma\Library\XML;
use AirAroma\Model\Page;
use AirAroma\Repository\PageRepository;

class SitemapRepository
{

    public $lang;

    public function __construct(Page $page, PageRepository $pageRepository, XML $xml) {
        $this->page = $page;
        $this->pageRepository = $pageRepository;
        $this->xml = $xml;
    }

    /**
     * fetch list of links from global config to be used with generateXML()
     */
    function getLinks() 
    {
        $links = getConfig('siteTranslations', 'links');

        foreach ($links as $link) {
            $url = $this->lang.$link['url'];
            $output[] = ['url' => $url];
        }

        return $output;
    }

    /**
     * Generates the xml based on list of links available
     */
    public function generateXML() 
    {
        $links = $this->getLinks($this->lang);
        return $this->xml->generate($links)->asXML();
    }


    /**
     * Fetch list of links along with their ordering, used with generateArray()
     */
    public function getPagesByOrder()
    {
        return $this->page
            ->whereNotNull('pag_sitemap_order')
            ->orderby('pag_sitemap_order', 'asc')
            ->get();
    }

    /**
     * Creates the ordered array of pages.
     */
    public function generateArray() { 

    	foreach ($this->getPagesByOrder() as $id => $item) {

    		$order = $item['pag_sitemap_order'];
    		$category = substr($order,0,1);
    		$subcategory = substr($order,0,3);
    		$name = $item['pag_sitemap_title'];
    		$url = $item['pag_url'];	

    		if (strlen($order) == 1) {
    			$parent = $url;
	    		$sitemap[$parent]['sub'] = [];
	    		$sitemap[$parent] = ['name' => $name, 'url' => $this->lang.$url, 'order' => $order];
    		}
    		if (strlen($order) == 3) {
    			$sub = $url;
	    		if (substr($order,0,1) == $category) {
	 				$sitemap[$parent]['sub'][$sub]['sub'] = [];
    				$sitemap[$parent]['sub'][$sub] = ['name' => $name, 'url' => $this->lang.$url, 'order' => $order];
	    		}
    		}

    		if (strlen($order) == 5) {
    			$subsub = $url;
	    		if (substr($order,0,1) == $category) {
	 				$sitemap[$parent]['sub'][$sub]['sub'][$subsub] = ['name' => $name, 'url' => $this->lang.$url, 'order' => $order];
	    		}
    		}
     	}
    	return $sitemap;
    }
}
