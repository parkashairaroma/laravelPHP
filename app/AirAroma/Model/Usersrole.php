<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Usersrole extends Model
{
    protected $primaryKey = 'usrrol_id';

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
    protected $fillable = ['usrrol_usr_id', 'usrrol_rol_id'];
}
