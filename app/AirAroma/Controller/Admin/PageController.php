<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Repository\PageRepository;
use AirAroma\Repository\TokenRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{

	function __construct(Request $request, PageRepository $pageRepository, TokenRepository $tokenRepository) {
		$this->request = $request;
		$this->pageRepository = $pageRepository;
		$this->tokenRepository = $tokenRepository;
	}

	/* 
	* show all pages 
	*/
	public function getPages()
	{                
		$links = getConfig('siteTranslations', 'links');
		$pages = $this->pageRepository->getPages(['subsite' => [0, 2]])->get();

		return view('admin.pages.list')->with(compact('pages', 'links'));
	}

	/*
	* show individual page
	*/
	public function getPage($pageId)
	{
		$links = getConfig('siteTranslations', 'links');
		$page = $this->pageRepository->getPageById($pageId);
		$tokens = $this->tokenRepository->getTranslationsByWebsiteAndPageId(websiteId(), $pageId)->get();

		return view('admin.pages.tokens')->with(compact('tokens', 'page', 'links'));
	}

	/*
	* api: update blog status
	*/
	// public function updatePageStatus($pageId)
	// {
	// 	$update = $this->pageRepository->updatePageStatus($this->request->get('status'), $pageId);

 //        if ($update) {
 //        	return response()->json(['status' => true, 'reason' => 'Changed']);
 //        }
	// }
}
