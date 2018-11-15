<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Repository\TagRepository;
use AirAroma\Repository\PageRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagController extends Controller
{

	public function __construct(Request $request, TagRepository $tagRepository) 
	{
		$this->tagRepository =  $tagRepository;
		$this->request = $request;
	}

	/**
	 * show all tags
	 */
	public function getTags()
	{
		$tags = $this->tagRepository->getTagsByWebsiteId(websiteId())->get();
		return view('admin.tags.list')->with(compact('tags'));
	}

	/**
	 * update tag translation
	 */
	public function updateTagTranslation($tagId)
	{
		$update = $this->tagRepository->updateTagTranslation($this->request->all(), $tagId);

		if ($update) {
			return response()->json(['status' => true, 'reason' => 'Saved']);
		}
		return response()->json(['status' => false, 'reason' => 'Name or slug already in use']);
	}
}