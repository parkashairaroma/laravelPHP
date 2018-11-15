<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Model\Banner;
use AirAroma\Repository\BannerRepository;
use AirAroma\Service\BannerService;
use App\Http\Controllers\Controller;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Routing\ResponseFactory as Reponse;
use Illuminate\Http\Request;


class BannerController extends Controller
{
	public function __construct(Config $config, Request $request, Reponse $response, BannerService $bannerService, BannerRepository $bannerRepository, Banner $banner)
	{
		$this->request = $request;
		$this->response = $response;
		$this->banner = $banner;
		$this->config = $config;
		$this->bannerService = $bannerService;
		$this->bannerRepository = $bannerRepository;

		$this->websiteId = websiteId();
	}

	/*
	* show all banners
	*/
	public function getBanners()
	{
        $banners = $this->bannerRepository->getBannersFromSiteConfig(['order' => 'asc']);

		return view('admin.banners.list', compact('banners'));
	}

	/*
	* create a new banner
	*/
	public function createBanner()
	{
		if ($this->request->isMethod('post')) {

           	$valid = $this->bannerService->validateForm(); 
            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }
			$this->bannerRepository->insertBanner();

			return redirect('/admin/banners');
		}

        $colours = $this->bannerRepository->getColours();

		return view('admin.banners.form', compact('colours', 'banner'));
	}

	/*
	* edit existing banner
	*/
	public function editBanner($bannerId)
	{
		if ($this->request->isMethod('POST')) {

           	$valid = $this->bannerService->validateForm(); 
            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }
			$this->bannerRepository->updateBanner($bannerId);

			return redirect('/admin/banners');
		}

		$banner = $this->banner->find($bannerId);
		$colours = $this->bannerRepository->getColours();

		return view('admin.banners.form', compact('colours', 'banner'));
	}

	/*
	* delete banner
	*/
	public function deleteBanner($bannerId)
	{
        if ($this->bannerRepository->deleteBanner($bannerId)) {
        	return redirect('admin/banners');
        }
	}

	/*
	* api: update banner status
	*/
	public function updateBannerStatus($bannerId)
	{
		 $updateBannerStatus = $this->bannerRepository->updateBannerStatus($bannerId, $this->request->get('status')); 

        if ($updateBannerStatus) {
        	return response()->json(['status' => true, 'reason' => 'Changed']);
        }
	}

	/*
	* api: update banner order
	*/
	public function updateBannerOrder()
	{
		$updateBannerOrder = $this->bannerRepository->updateBannerOrder($this->request->all());

        if ($updateBannerOrder) {
        	return response()->json(['status' => true, 'reason' => 'Saved']);
        }
	}
}