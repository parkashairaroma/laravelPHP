<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $primaryKey = 'cou_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     *
     */
    protected $fillable = ['cou_name', 'cou_reg_id', 'cou_slug', 'cou_enabled', 'cou_highlight', 'cou_native_name', 'cou_code', 'cou_tax_on_goods', 'cou_tax_on_shipping', 'cou_inner_zone'];

    public function region()
    {
        return $this->hasOne('AirAroma\Model\Region', 'reg_id', 'cou_reg_id');
    }

    public function states()
    {
        return $this->hasMany('AirAroma\Model\State', 'sta_cou_id', 'cou_id');
    }

    public function locations()
    {
        return $this->belongsToMany('AirAroma\Model\Location', 'countrieslocations', 'couloc_cou_id', 'couloc_loc_id');
    }

    public function reasonEmails($tokenName)
    {
        return $this->hasMany('AirAroma\Model\Email', 'eml_reg_id', 'cou_reg_id')->where('eml_ety_id', '=', 7)->where('eml_reason_token', '=', $tokenName);
    }

    public function countryEmails()
    {
        return $this->hasMany('AirAroma\Model\Email', 'eml_cou_id', 'cou_id')->where('eml_ety_id', '=', 2);
    }

    public function regionEmails()
    {
        return $this->hasMany('AirAroma\Model\Email', 'eml_reg_id', 'cou_reg_id')->where('eml_ety_id', '=', 3);
    }
}
