<?php

namespace AirAroma\Repository;

use AirAroma\Model\Linktranslation;
use AirAroma\Model\Page;

class LinkRepository 
{
	function __construct(Linktranslation $linkTranslations, Page $page) {
		$this->linkTranslations = $linkTranslations;
		$this->page = $page;
	}

	/**
	* get links by website id
	*/
	public function getLinksByWebsiteId($websiteId) 
	{
       return $this->page
       		->select('pages.pag_name', 'pages.pag_id', 'base.lts_url as base_url', 'site.lts_url as site_url')
	       ->leftJoin('linktranslations as site', function ($join) use ($websiteId) {
	            $join->on('site.lts_pag_id', '=', 'pages.pag_id');
	            $join->where('site.lts_web_id', '=', $websiteId);
	        })
	       ->leftJoin('linktranslations as base', function ($join) {
	            $join->on('base.lts_pag_id', '=', 'pages.pag_id');
	            $join->where('base.lts_web_id', '=', baseId());
	        })
	       ->where('pages.pag_subsite', '=', pageSubsite('single'))
	       ->orderBy('pages.pag_name', 'asc');
    }

	/**
	 *  upate link translation
	 */
	public function updateLinkTranslation($data, $linkId)
	{
		$count = $this->isTranslationDuplicate($data, $linkId);

		if ($count) {
			return false;
		}

		$link = $this->linkTranslations->firstOrNew(['lts_pag_id' => $linkId, 'lts_web_id' => websiteId()]);
		$link->lts_url = $data['lts_url'];
		return $link->save();
    }

    /**
     * check is url is duplicated
     */
    public function isTranslationDuplicate($data, $linkId) {
    	return $this->linkTranslations
			->where('lts_web_id', websiteId())
			->where('lts_url', $data['lts_url'])
			->where('lts_url', '!=', '')
			->where('lts_pag_id', '!=', $linkId)
			->count();
    }
}