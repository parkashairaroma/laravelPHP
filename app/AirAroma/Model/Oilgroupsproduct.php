<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Oilgroupsproduct extends Model
{
    protected $primaryKey = 'olgpro_pro_id';

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
    protected $fillable = ['olgpro_pro_id','olgpro_olg_id'];
}
