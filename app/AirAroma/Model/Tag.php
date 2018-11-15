<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    
    protected $primaryKey = 'tag_id';

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
    protected $fillable = [];

    public function getTagNameAttribute()
    {
        return ($this->site_name) ?: $this->base_name;
    }
}
