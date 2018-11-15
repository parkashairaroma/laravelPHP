<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'cli_id';

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
    protected $fillable = ['cli_name','cli_weight','cli_slug','cli_web_id'];
}
