<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Productimages extends Model
{
    protected $table = 'productimages';
    protected $primaryKey = 'pri_id';

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
     *
     */
    protected $fillable = ['pri_id','pri_image','pri_pro_id'];

}