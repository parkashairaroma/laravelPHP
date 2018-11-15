<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class ClientsPageWebsite extends Model
{
    protected $table = 'clientspagewebsites';
    protected $primaryKey = 'clipagweb_id';

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
    protected $fillable = ['clipagweb_cli_id','clipagweb_recent_proj','clipagweb_is_enabled','clipagweb_ord_num'];
}
