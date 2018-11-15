<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Tagstranslation extends Model
{

    protected $primaryKey = 'tat_tag_id';

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
    protected $fillable = ['tat_tag_id', 'tat_name', 'tat_slug', 'tat_web_id'];
}
