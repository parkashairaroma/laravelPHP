<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $primaryKey = 'ind_id';

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
    protected $fillable = ['ind_name', 'ind_link', 'ind_weight'];
}
