<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Linktranslation extends Model
{
    protected $primaryKey = 'lts_id';

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
    protected $fillable = ['lts_pag_id', 'lts_url', 'lts_enabled', 'lts_web_id'];
}
