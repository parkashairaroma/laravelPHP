<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Productwebsite extends Model
{
    
    protected $primaryKey = 'proweb_id';

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
    protected $fillable = ['proweb_prv_id','proweb_price','proweb_available','proweb_website_id','proweb_outofstock'];
}