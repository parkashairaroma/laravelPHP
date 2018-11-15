<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $primaryKey = 'blg_id';

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
    protected $fillable = ['blg_approved', 'blg_web_id', 'blg_web_id', 'blg_title', 'blg_slug', 'blg_slug_locked', 'blg_date', 'blg_content', 'blg_status', 'blg_hero'];


    public function tags() {
        return $this->hasMany('AirAroma\Model\Blogstag', 'blgtag_blg_id', 'blg_id');
    }
}
