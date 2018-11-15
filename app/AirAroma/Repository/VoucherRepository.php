<?php

namespace AirAroma\Repository;

use AirAroma\Model\Voucher;
use Illuminate\Http\Request;

class VoucherRepository
{

    public function __construct(Voucher $voucher, Request $request)
    {
        $this->voucher = $voucher;
        $this->request = $request;
    }

    public function getVouchers()
    {
        return $this->voucher->get();
    }

    public function getVoucherDetails($voucherId)
    {
        return $this->voucher->where('vou_id', '=', $voucherId)->first();
    }

    public function updateVoucher($voucherId)
    {
        return $this->voucher->where('vou_id', $voucherId)
            ->update([
                'vou_code' => $this->request->get('vou_code'),
                'vou_start' => date("Y-m-d H:i:s", strtotime($this->request->get('vou_start') . " " . $this->request->get('vou_starttime'))),
                'vou_end' => date("Y-m-d H:i:s", strtotime($this->request->get('vou_end') . " " . $this->request->get('vou_endtime'))),
                'vou_website_id' => $this->request->get('usr_websites')[0],
                'vou_discount' => $this->request->get('vou_discount'),
                'vou_type' => $this->request->get('vou_type'),
                'vou_threshold' => 0.00,
            ]);
    }

    public function insertVoucher()
    {
        $this->voucher->create([
                'vou_code' => $this->request->get('vou_code'),
                'vou_start' => date("Y-m-d H:i:s", strtotime($this->request->get('vou_start') . " " . $this->request->get('vou_starttime'))),
                'vou_end' => date("Y-m-d H:i:s", strtotime($this->request->get('vou_end') . " " . $this->request->get('vou_endtime'))),
                'vou_website_id' => $this->request->get('usr_websites')[0],
                'vou_discount' => $this->request->get('vou_discount'),
                'vou_type' => $this->request->get('vou_type'),
                'vou_threshold' => 0.00,
            ]);
    }
}
