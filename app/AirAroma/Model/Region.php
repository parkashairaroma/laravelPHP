<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'regions';
    protected $primaryKey = 'reg_id';

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
     *    "reg_id" serial NOT NULL,
     *    "reg_name" character varying,                     //  Region Name
     *    "reg_loc_id" integer,                             //  Regional Head Office Location ID
     *    CONSTRAINT "pk_region" PRIMARY KEY ("reg_id")
     *
     */
    protected $fillable = ['reg_name'];

    public function Countries()
    {
        return $this->hasMany('App\Country', 'cou_reg_id', 'reg_id');
    }
}
