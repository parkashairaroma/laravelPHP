<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Repository\LinkRepository;
use AirAroma\Repository\PageRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LinkController extends Controller
{
	public function __construct(Request $request, PageRepository $pageRepository, LinkRepository $linkRepository) 
	{
		$this->pageRepository =  $pageRepository;
		$this->linkRepository =  $linkRepository;
		$this->request = $request;
	}

	/**
	 * show all links
	 */
	public function getLinks() {
		$links = $this->linkRepository->getLinksByWebsiteId(websiteId())->get();
		return view('admin.links.list')->with(compact('links'));
	}

	/**
	 * update link translation
	 */
	public function updateLinkTranslation($linkId)
	{
		$updateLinkTranslation = $this->linkRepository->updateLinkTranslation($this->request->all(), $linkId);

		if ($updateLinkTranslation) {
			return response()->json(['status' => true, 'reason' => 'Saved']);
		}
		return response()->json(['status' => false, 'reason' => 'URL already in use']);
	}
}