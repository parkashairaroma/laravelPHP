<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Pagetoken extends Model
{
    protected $primaryKey = 'ptk_id';

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
    protected $fillable = ['ptk_token', 'ptk_pag_id'];
}