<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    
    protected $primaryKey = 'ban_id';

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
    protected $fillable = ['ban_web_id', 'ban_name', 'ban_title', 'ban_order', 'ban_image', 'ban_status', 'ban_title', 'ban_title_colour', 'ban_description', 'ban_description_colour', 'ban_link', 'ban_overflow_colour', 'ban_text_align'];
}