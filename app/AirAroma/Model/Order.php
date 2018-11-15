<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    protected $primaryKey = 'ord_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     */
    protected $fillable = [
            'ord_date',
            'ord_website_id',
            'ord_acc_id',
            'ord_status',
            'ord_paymentstatus',
            'ord_cur_id',
            'ord_goodscost',
            'ord_shippingmethod',
            'ord_shippingcost',
            'ord_taxincluded',
            'ord_totalcost',
            'ord_vouchercode',
            'ord_voucherdiscount',
            'ord_paymenttype',
            'ord_paidinfull',
            'ord_firstname',
            'ord_lastname',
            'ord_street',
            'ord_city',
            'ord_postcode',
            'ord_cou_id',
            'ord_state',
            'ord_county_id',
            'ord_billfirstname',
            'ord_billlastname',
            'ord_billstreet',
            'ord_billcity',
            'ord_billpostcode',
            'ord_billcou_id',
            'ord_billstate',
            'ord_billcounty_id'
        ];

    public function products() 
    {
        return $this->hasMany('AirAroma\Model\Ordersproduct', 'ordpro_ord_id')
        ->join('productvariations', 'productvariations.prv_id', '=', 'ordpro_prv_id')
        ->join('productwebsites', 'productwebsites.proweb_prv_id', '=', 'productvariations.prv_id')
        ->join('products', 'products.pro_id', '=', 'productvariations.prv_pro_id')
        ->join('unitsizes', 'unitsizes.uni_id', '=', 'productvariations.prv_uni_id')
        ->join('colours', 'colours.col_id', '=', 'productvariations.prv_col_id')
        ->orderby('unitsizes.uni_size', 'asc');
    }
}