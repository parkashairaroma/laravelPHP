<?php

namespace AirAroma\Repository;

use AirAroma\Model\Industry;
use AirAroma\Model\Industrytranslation;

class IndustryRepository
{
    /**
     * Create a respoitory
     *
     * @param  \AirAroma\Model\Industry $industry
     * @param  \AirAroma\Model\Industrytranslation $industryTranslation
     * @return void
     */
    public function __construct(Industry $industry, Industrytranslation $industryTranslation)
    {
        $this->industryTranslation = $industryTranslation;
        $this->industry = $industry;
    }

    /**
     * Get list of industries by id
     *
     * @param  integer $websiteId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getIndustriesByWebsiteId($websiteId)
    {
       return $this->industry
            ->select(
                'industries.ind_id',
                'industries.ind_name',
                'industries.ind_order',
                'base.idt_name as base_name',
                'base.idt_slug as base_slug',
                'site.idt_name as site_name',
                'site.idt_slug as site_slug'
            )
           ->leftJoin('industrytranslations as site', function ($join) use ($websiteId) {
                $join->on('site.idt_ind_id', '=', 'industries.ind_id');
                $join->where('site.idt_web_id', '=', $websiteId);
            })
           ->leftJoin('industrytranslations as base', function ($join)  {
                $join->on('base.idt_ind_id', '=', 'industries.ind_id');
                $join->where('base.idt_web_id', '=', baseId());
            })
            ->orderBy('industries.ind_order','asc');
    }

    /**
     * Update industry translation
     *
     * @param  array $request
     * @param  integer $industryId
     * @return \Illuminate\Database\Eloquent\Model|boolean
     */
    public function updateIndustryTranslation($request, $industryId)
    {
        $translationDuplicate = $this->isTranslationDuplicate($request, $industryId)->count();

        if ($translationDuplicate) {
            return false;
        }

        $industries = $this->industryTranslation->where('idt_web_id', websiteId())->where('idt_ind_id', $industryId);

        if ($industries->count()) {
            return $industries->update([
                'idt_name' => $request['idt_name'],
                'idt_slug' => $request['idt_slug']
            ]);
        }

        return $this->industryTranslation->create([
            'idt_ind_id' => $industryId,
            'idt_web_id' => websiteId(),
            'idt_name' => $request['idt_name'],
            'idt_slug' => $request['idt_slug']
        ]);
    }

    /**
     * Determine if translation items exist
     *
     * @param  array $request
     * @param  integer $industryId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function isTranslationDuplicate($request, $industryId)
    {
        return $this->industryTranslation
            ->where('idt_web_id', websiteId())
            ->where('idt_ind_id', '!=', $industryId)
                ->where(function ($query) use ($request, $industryId) {
                    $query->where('idt_name', $request['idt_name']);
                    $query->where('idt_name', '!=', '')
                ->orWhere(function ($query) use ($request, $industryId) {
                    $query->where('idt_slug', $request['idt_slug']);
                    $query->where('idt_slug', '!=', '');
                });
            });
    }

    /**
     * Get clients by industry id
     *
     * @param  integer $industryId
     * @param  array $options
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getClientsByIndustryId($industryId, $options = [])
    {
        $defaults = ['limit' => null, 'diaplyLogo' => true, 'enabled' => true];

        if ($options) {
            $defaults = array_merge($defaults, $options);
        }

        extract($defaults);

        $industries = $this->industry
            ->leftJoin('clientsindustries', 'clientsindustries.cliind_ind_id', '=', 'industries.ind_id')
            ->leftJoin('clients', 'clients.cli_id', '=', 'clientsindustries.cliind_cli_id')
            ->where('clients.cli_display_logo', $diaplyLogo)
            ->where('clients.cli_enabled', $enabled);

        if ($industryId) {
            $industries->where('industries.ind_id', $industryId);
        }

        if ($limit) {
            $industries->limit($limit);
        }

        return $industries;
    }

    /**
     * Get industry by slug
     *
     * @param  string $industryId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getIndustryIdByName($industryName)
    {
        return $this->industryTranslation
            ->leftJoin('industries', 'industrytranslations.idt_ind_id', '=', 'industries.ind_id')
            ->where('idt_slug', $industryName)
            ->first();
    }
}
