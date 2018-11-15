<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $primaryKey = 'eml_id';
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
    protected $fillable = ['eml_cou_id', 'eml_reg_id', 'eml_ety_id', 'eml_subject_tag', 'eml_address'];
}
