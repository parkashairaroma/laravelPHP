<?php

namespace AirAroma\Repository;

use AirAroma\Model\Oilgroup;

class OilgroupRepository
{

    protected $imagePath = '/images/oilgroups/scent-type-%1$s-24.png';

    public function __construct(Oilgroup $oilgroup)
    {
        $this->oilgroup = $oilgroup;

        $this->websiteId = websiteId();
    }

    public function oilgroupTranslations()
    {
        $translations = $this->getTranslatedOilgroups($this->websiteId)->get();

        foreach ($translations as $oilgroup) {
            $name = $oilgroup->ogt_name ?: $oilgroup->olg_name;
            $url = $oilgroup->ogt_url ?: $oilgroup->olg_url;
            $image = sprintf($this->imagePath, $oilgroup->olg_url);

            $oilgroups[$oilgroup->olg_url] = [
                'name' => $name,
                'url' => $url,
                'image' => $image,
            ];
        }

        return $this->oilgroups = $oilgroups;
    }

    public function getTranslatedOilgroups()
    {
        return $this->leftJoin('oilgrouptranslations', function ($join) {
            $join->on('ogt_olg_id', '=', 'olg_id');
            $join->where('ogt_web_id', '=', $this->websiteId);
        });
    }

    public function getOilgroups()
    {
        return $this->oilgroup->get();
    }


    public function getOilGroupsByCategory($categorySlug)
    {
        return $this->oilgroup
            ->join('oilgroupsproducts', function($join) {
                $join->on('olg_id', '=', 'olgpro_olg_id');
            })
            ->join('products', function($join) {
                $join->on('pro_id', '=', 'olgpro_pro_id');
            })
            ->join('category', function($join) {
                $join->on('cat_id', '=', 'pro_cat_id');
            })
            ->where('cat_slug', '=', $categorySlug)
            ->distinct('olg_id')
            ->orderBy('olg_name')
            ->get();
    }
}
