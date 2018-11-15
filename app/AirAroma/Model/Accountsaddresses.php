<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;


class Accountsaddresses  extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'accountsaddresses';
    protected $primaryKey = 'acc_add_id';

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
    protected $fillable = ['acc_id', 'add_id', 'acc_add_shipdefault', 'acc_add_billdefault'] ;
}