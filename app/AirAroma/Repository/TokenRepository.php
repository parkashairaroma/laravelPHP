<?php

namespace AirAroma\Repository;

use AirAroma\Model\Pagetoken;
use AirAroma\Model\Pagetranslation;

class TokenRepository 
{
	function __construct(Pagetranslation $pageTranslation, Pagetoken $pageToken) 
	{
		$this->pageTranslation = $pageTranslation;
		$this->pageToken = $pageToken;
	}

    /**
     * 
     */
    public function getTranslationsByWebsiteAndPageId($websiteId, $pageId = null)
    {
        if (isset($pageId) && ! is_array($pageId)) {
            $pageId = [$pageId];
        }
       return $this->pageToken
   	 	->select(
   	 		'pagetokens.ptk_id', 
   	 		'pagetokens.ptk_token', 
   	 		'base.pgt_value as base_translation', 
   	 		'site.pgt_value as site_translation'
   	 	)
       ->leftJoin('pagetranslations as site', function ($join) use ($websiteId) {
            $join->on('site.pgt_ptk_id', '=', 'pagetokens.ptk_id');
            $join->where('site.pgt_web_id', '=', $websiteId);
        })
       ->leftJoin('pagetranslations as base', function ($join)  {
            $join->on('base.pgt_ptk_id', '=', 'pagetokens.ptk_id');
            $join->where('base.pgt_web_id', '=', baseId());
        })
       ->whereIn('pagetokens.ptk_pag_id', $pageId)
       ->orderBy('pagetokens.ptk_token', 'asc');
    }

	/**
	 * delete token
	 */
	public function deleteToken($id)
	{
		$this->pageToken->find($id)->delete();
		return $this->pageTranslation->where('pgt_ptk_id', $id)->delete();
	}

	/**
	 * create new token translation
	 */
	public function createToken($data)
	{
		$count = $this->pageToken->where('ptk_token', $data['ptk_token'])->where('ptk_pag_id', $data['ptk_pag_id'])->count();

		if ($count) {
			return false;
		}

		$token = $this->pageToken->create(['ptk_token' => $data['ptk_token'], 'ptk_pag_id' => $data['ptk_pag_id']]);	
		$translation = $this->pageTranslation->create(['pgt_ptk_id' => $token->ptk_id, 'pgt_value' => $data['pgt_value'], 'pgt_web_id' => websiteId()]);

		return $token->ptk_id;
	}

	/**
	 * api: update token translation
	 */
	public function editTokenTranslation($data, $tokenId)
	{
		$translation = $this->pageTranslation->firstOrNew(['pgt_ptk_id' => $tokenId, 'pgt_web_id' => websiteId()]);
		$translation->pgt_value = $data['pgt_value'];
		return $translation->save();
    }

	/**
	 * api: get translation for specified token
	 */
	public function getTranslationByTokenId($tokenId)
	{

       $translations = $this->pageToken
		->select(
			'pagetokens.ptk_id', 
			'pagetokens.ptk_token', 
			'base.pgt_value as base_translation', 
			'site.pgt_value as site_translation'
		)
		->leftJoin('pagetranslations as site', function ($join) {
			$join->on('site.pgt_ptk_id', '=', 'pagetokens.ptk_id');
			$join->where('site.pgt_web_id', '=', websiteId());
		})
		->leftJoin('pagetranslations as base', function ($join)  {
			$join->on('base.pgt_ptk_id', '=', 'pagetokens.ptk_id');
			$join->where('base.pgt_web_id', '=', baseId());
		})
		->where('pagetokens.ptk_id', $tokenId)
		->orderBy('pagetokens.ptk_token', 'asc')
		->firstOrFail();

		return $translations;
    }

    public function pushTokensToWebsite($websiteId)
    {
    	$translations = $this->pageTranslation->selectRaw('pgt_ptk_id, null as pgt_value, '.$websiteId.' as pgt_web_id');
    	$translations->where('pgt_web_id', baseId());
    	$translations->whereNotIn('pgt_ptk_id', function($translations) use ($websiteId) {
		   $translations->from('pagetranslations')
		   	->select('pgt_ptk_id')
		    ->where('pgt_web_id', $websiteId);
    	});

    	$tokens = $translations->get()->toArray();

    	$this->pageTranslation->insert($tokens);

    	return $this->websiteTokenCount(['websiteId' => $websiteId]);
    }
}