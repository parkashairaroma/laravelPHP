<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class ClientTranslation extends Model
{
    protected $table = 'clienttranslations';
    protected $primaryKey = 'clt_cli_id';

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
    protected $fillable = ['clt_cli_id','clt_cli_hero','clt_cli_header','clt_cli_text','clt_cli_scentheader','clt_cli_scenttext','clt_cli_banner','clt_cli_textinner','clt_cli_quote','clt_cli_tile1','clt_cli_tile2','clt_cli_feature','clt_cli_video','clt_cli_tagdescription'];
}
