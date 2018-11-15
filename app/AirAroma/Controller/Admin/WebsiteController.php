<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Repository\CountryRepository;
use AirAroma\Repository\TokenRepository;
use AirAroma\Repository\WebsiteRepository;
use AirAroma\Service\FormService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{

	function __construct(FormService $formService, Request $request, WebsiteRepository $websiteRepository, TokenRepository $tokenRepository, CountryRepository $countryRepository)
    {
        $this->FormService = $formService;
        $this->request = $request;
        $this->websiteRepository = $websiteRepository;
        $this->tokenRepository = $tokenRepository;
        $this->countryRepository = $countryRepository;
    }

    public function editWebsite($websiteId)
    {

    	if ($this->request->isMethod('post')) {

    		$valid = $this->FormService->validate([
                'web_title' => 'required',
            ]); 

			if ($valid->fails()) {
				return redirect()->back()->withErrors($valid)->withInput();
			}

			$this->websiteRepository->updateWebsiteById($websiteId);

			return redirect('admin/websites');

    	}
    	$website = $this->websiteRepository->getWebsiteById($websiteId)->first();
       	$countries = $this->countryRepository->getCountries()->lists('cou_name', 'cou_id');

    	return view('admin.websites.form')->with(compact('website', 'countries'));
    }

	/**
	 * get list of websites
	 */
	public function getWebsites()
	{
		$websites = $this->websiteRepository->getWebsitesByStatus([0, 1, 2])->get();
		return view('admin.websites.list')->with(compact('websites'));
	}

	/**
	 * api: push available tokens to websiteId
	 */
	public function pushChangesToWebsite($websiteId) 
	{
		// $pushTokensToWebsite = $this->tokenRepository->pushTokensToWebsite($websiteId);

		// if ($pushTokensToWebsite) {
		// 	$data = json_encode(['tokens' => $pushTokensToWebsite[$websiteId]]);
		// 	return response()->json(['status' => true, 'reason' => 'Translations pushed', 'data' => $data]);
		// } 
	}
}