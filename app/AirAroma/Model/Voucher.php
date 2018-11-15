<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{

    protected $primaryKey = 'vou_id';

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
    protected $fillable = ['vou_code','vou_start','vou_end','vou_website_id','vou_discount','vou_type','vou_threshold'];
}