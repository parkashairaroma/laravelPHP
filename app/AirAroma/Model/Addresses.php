<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;


class Addresses  extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'addresses';
    protected $primaryKey = 'add_id';

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
     */
    protected $fillable = ['add_street', 'add_city', 'add_state', 'add_postcode', 'add_cou_id', 'add_firstname', 'add_lastname','add_aptsuite','add_isbusiness','add_businessname','add_phone'];
}