<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Repository\IndustryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndustryController extends Controller
{	
	public function __construct(Request $request, IndustryRepository $industryRepository) 
	{
		$this->industryRepository =  $industryRepository;
		$this->request = $request;
	}

	/**
	 * get list of all industries
	 */
	public function getIndustries() 
	{
		$industries = $this->industryRepository->getIndustriesByWebsiteId(websiteId())->get();
		return view('admin.industries.list')->with(compact('industries'));
	}

	/**
	 * update industry translation
	 */
	public function updateIndustryTranslation($industryId)
	{
		$update = $this->industryRepository->updateIndustryTranslation($this->request->all(), $industryId);

		if ($update) {
			return response()->json(['status' => true, 'reason' => 'Saved']);
		}
		return response()->json(['status' => false, 'reason' => 'Name or slug already in use']);
	}
}