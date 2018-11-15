<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Productvariations extends Model
{

    protected $primaryKey = 'prv_id';

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
    protected $fillable = ['prv_pro_id','prv_col_id','prv_uni_id','prv_available','prv_image','prv_shippingunits', 'prv_shippingweight', 'prv_imagetile', 'prv_shippingdimensions'];

}