<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Oilgroup extends Model
{
    protected $primaryKey = 'olg_id';

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
    protected $fillable = [];

    /**
     * The attributes that are hidden
     *
     * @var array
     *
     */
    protected $hidden = ['pivot'];
}
