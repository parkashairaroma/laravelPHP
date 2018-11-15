<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Pagetranslation extends Model
{
    protected $primaryKey = 'pgt_id';

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
    protected $fillable = ['pgt_ptk_id', 'pgt_value', 'pgt_web_id'];
}
