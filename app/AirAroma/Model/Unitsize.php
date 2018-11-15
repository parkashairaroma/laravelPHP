<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Unitsize extends Model
{

    protected $primaryKey = 'uni_id';

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
    protected $fillable = [];
}
