<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{

    protected $primaryKey = 'web_id';

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
    protected $fillable = [];



    /**
     * Website and Banner relationship
     *
     * @return model
     */
    public function getBanners()
    {
        return  $this->hasMany('AirAroma\Model\Banner', 'ban_web_id', 'web_id');
    }
    public function blogs()
    {
        return $this->belongsTo('AirAroma\Model\Blog', 'web_id', 'blg_web_id');
    }
    public function getCountries()
    {
        return $this->hasOne('AirAroma\Model\Country', 'cou_id', 'web_cou_id');
    }
    public function getTitleLanguageAttribute()
    {
        return $this->attributes['web_title'].' ('.$this->attributes['web_main_domain'].')';
    }

     public function tokens()
    {
        return $this->hasMany('AirAroma\Model\PageTranslation', 'pgt_web_id', 'web_id')
            ->where('pgt_value', '!=', '');
    }
    public function links()
    {
        return $this->hasMany('AirAroma\Model\LinkTranslation', 'lts_web_id', 'web_id')
            ->where('lts_url', '!=', '');
    }
    public function tags()
    {
        return $this->hasMany('AirAroma\Model\TagsTranslation', 'tat_web_id', 'web_id')
            ->where('tat_name', '!=', '')
            ->where('tat_slug', '!=', '');
    }
    public function industries()
    {
        return $this->hasMany('AirAroma\Model\IndustryTranslation', 'idt_web_id', 'web_id')
            ->where('idt_name', '!=', '')
            ->where('idt_slug', '!=', '');
    }
}
