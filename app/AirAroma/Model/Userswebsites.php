<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Userswebsites extends Model
{
    protected $primaryKey = 'usrweb_id';

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
    protected $fillable = ['usrweb_usr_id', 'usrweb_web_id'];
}
