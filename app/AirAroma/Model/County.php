<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $primaryKey = 'cnt_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     */
    protected $fillable = ['cnt_sta_id', 'cnt_name', 'cnt_tax_rate'];

    public function state()
    {
        return $this->hasOne('App\State', 'sta_id', 'cnt_sta_id');
    }
}
