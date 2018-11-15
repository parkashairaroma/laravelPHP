<?php

namespace AirAroma\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    protected $hidden = ['lts_sitemap_title'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     *
     */
    protected $fillable = [];

    public function siteTokens()
    {
        return $this->hasMany('AirAroma\Model\PageToken', 'ptk_pag_id', 'pag_id')
            ->join('pagetranslations', 'pagetranslations.pgt_ptk_id', '=' ,'pagetokens.ptk_id')
            ->where('pgt_value', '!=', '')
            ->where('pgt_web_id', websiteId());
    }
    public function baseTokens()
    {
        return $this->hasMany('AirAroma\Model\PageToken', 'ptk_pag_id', 'pag_id')
            ->join('pagetranslations', 'pagetranslations.pgt_ptk_id', '=' ,'pagetokens.ptk_id')
            ->where('pgt_web_id', baseId());
    }
}
