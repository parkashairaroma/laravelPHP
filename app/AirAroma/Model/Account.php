<?php

namespace AirAroma\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Account  extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'acc_id';

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
     */
    protected $fillable = ['acc_firstname', 'acc_lastname', 'acc_email', 'password', 'acc_website_id', 'acc_billfirstname', 'acc_billlastname', 'acc_facebookid', 'acc_activated', 'acc_activationcode', 'acc_activationcodeexpiry', 'acc_isbusinessaddress', 'acc_billisbusinessaddress', 'acc_aptsuite', 'acc_billaptsuite' ,'acc_businessname', 'acc_billbusinessname'];
}