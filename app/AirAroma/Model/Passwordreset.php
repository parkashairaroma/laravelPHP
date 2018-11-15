<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Passwordreset extends Model
{
    
    protected $primaryKey = 'prs_token';

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
    protected $fillable = ['prs_email', 'prs_token'];
}