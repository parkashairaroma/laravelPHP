<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Ordersproduct extends Model
{
    
    protected $primaryKey = 'ordpro_id';

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
    protected $fillable = ['ordpro_ord_id', 'ordpro_prv_id', 'ordpro_price', 'ordpro_quantity'];

}