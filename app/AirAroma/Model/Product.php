<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $primaryKey = 'pro_id';

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
    protected $fillable = ['pro_cat_id','pro_name','pro_description','pro_slug','pro_image_delete','pro_imagetile_delete','pro_linkprefix','pro_title','pro_weight','pro_characteristics','pro_quality'];

    public function oilgroups()
    {
        return $this->belongsToMany('AirAroma\Model\Oilgroup', 'oilgroupsproducts', 'olgpro_pro_id', 'olgpro_olg_id');
    }

    public function units()
    {
        return $this->hasMany('AirAroma\Model\Unitsize', 'uni_id', 'prv_uni_id');
    }

    public function variations()
    {
        return $this->hasMany('AirAroma\Model\ProductVariations', 'prv_pro_id', 'pro_id')
            ->join('productwebsites', 'productwebsites.proweb_prv_id', '=', 'productvariations.prv_id')
            ->join('unitsizes', 'unitsizes.uni_id', '=', 'productvariations.prv_uni_id')
            ->join('colours', 'colours.col_id', '=', 'productvariations.prv_col_id')
            ->orderby('unitsizes.uni_size', 'asc');
    }
}