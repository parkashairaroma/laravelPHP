<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class EmailType extends Model
{
    protected $primaryKey = 'ety_id';
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
}
