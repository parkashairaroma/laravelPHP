<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'states';
    protected $primaryKey = 'sta_id';

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
     *  sta_id serial NOT NULL,
     *  sta_cou_id integer,
     *  sta_name character varying,
     *  sta_zone character varying,
     *  sta_order integer DEFAULT 100,
     *  sta_code character varying,
     *  CONSTRAINT "pk_state" PRIMARY KEY (sta_id)
     *
     */
    protected $fillable = ['sta_cou_id', 'sta_cou_id', 'sta_name', 'sta_zone', 'sta_order', 'sta_code'];

    public function country()
    {
        return $this->hasOne('App\Country', 'cou_id', 'sta_cou_id');
    }

    public function counties()
    {
        return $this->hasMany('App\County', 'cnt_sta_id', 'sta_id');
    }
}
