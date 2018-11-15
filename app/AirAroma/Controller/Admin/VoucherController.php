<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Repository\VoucherRepository;
use AirAroma\Repository\WebsiteRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use AirAroma\Service\VoucherService;

class VoucherController extends Controller
{

    public function __construct(Request $request, VoucherRepository $voucherRepository, WebsiteRepository $websiteRepository, VoucherService $voucherService)
	{
		$this->request = $request;
		$this->voucherRepository = $voucherRepository;
  $this->websiteRepository = $websiteRepository;
  $this->voucherService = $voucherService;
	}

	/**
	 * get list of products
	 */
	public function getVouchers()
	{
        $vouchers = $this->voucherRepository->getVouchers();
        return view('admin.vouchers.list')->with(compact('vouchers'));
	}

 /**
  * view/edit informtion of a voucher
  */
	public function editVoucher($id)
	{
     if ($this->request->isMethod('post')) {

         $fields = [
             'vou_code' => 'required',
             'vou_start' => 'required',
             'vou_starttime' => 'required',
             'vou_end' => 'required',
             'vou_endtime' => 'required',
             'vou_discount' => 'required',
         ];

         $valid = $this->voucherService->validateForm($fields);

         if ($valid->fails()) {
             return redirect()->back()->withErrors($valid)->withInput();
         }

         $this->voucherRepository->updateVoucher($id);
     }
     $voucher = $this->voucherRepository->getVoucherDetails($id);
     $websitesList = $this->websiteRepository->getWebsitesSelectList();
     return view('admin.vouchers.form')->with(compact('voucher','websitesList'));
	}

 /**
  * create a voucher
  */
	public function createVoucher()
	{
     if ($this->request->isMethod('post')) {

         $fields = [
             'vou_code' => 'required',
             'vou_start' => 'required',
             'vou_end' => 'required',
             'vou_discount' => 'required',
         ];

         $valid = $this->voucherService->validateForm($fields);

         if ($valid->fails()) {
             return redirect()->back()->withErrors($valid)->withInput();
         }

         $this->voucherRepository->insertVoucher();

         return redirect('admin/vouchers');
     }
     $websitesList = $this->websiteRepository->getWebsitesSelectList();
     return view('admin.vouchers.form')->with(compact('websitesList'));
	}
}