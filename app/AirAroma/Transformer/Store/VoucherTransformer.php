<?php 

namespace AirAroma\Transformer\Store;

use League\Fractal\TransformerAbstract;

class VoucherTransformer extends TransformerAbstract
{
    /**
    * Turn this item object into a generic array
    *
    * @return array
    */
    public function transform($voucher)
    {
        return [
            'id' => $voucher->vou_id,
            'name' => $voucher->vou_code,
            'start' => $voucher->vou_start,
            'end' => $voucher->vou_end,
            'discount' => $voucher->vou_discount,
            'type' => $voucher->vou_type,
            'threshold' => $voucher->vou_threshold,
        ];
    }
}