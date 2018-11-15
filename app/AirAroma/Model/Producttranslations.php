<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Producttranslations extends Model
{
    protected $primaryKey = 'prt_pro_id';

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
    protected $fillable = ['prt_pro_id','prt_website_id','prt_pro_name','prt_pro_description','prt_pro_slug'];

}