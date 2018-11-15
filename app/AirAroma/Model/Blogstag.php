<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Blogstag extends Model
{
    protected $primaryKey = 'blgtag_id';

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
    protected $fillable = ['blgtag_blg_id', 'blgtag_tag_id'];
}
