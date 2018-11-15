<?php

namespace AirAroma\Repository;

use AirAroma\Model\Blogstag;
use AirAroma\Model\Tag;
use AirAroma\Model\Tagstranslation;

class TagRepository
{
     /**
     * Create a respoitory
     *
     * @param  \AirAroma\Model\Blogstag $industry
     * @param  \AirAroma\Model\Tag $tag
     * @param  \AirAroma\Model\Tagstranslation $tagTranslation
     * @return void
     */
    function __construct(Blogstag $blogsTag, Tag $tag, Tagstranslation $tagTranslation)
    {
        $this->blogsTag = $blogsTag;
        $this->tag = $tag;
        $this->tagTranslation = $tagTranslation;
    }

    /**
     * Get list of tags by website id
     *
     * @param  integer $websiteId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getTagsByWebsiteId($websiteId)
    {
        return $this->tag
            ->select(
                'tags.tag_id',
                'tags.tag_name',
                'base.tat_name as base_name',
                'base.tat_slug as base_slug',
                'site.tat_name as site_name',
                'site.tat_slug as site_slug'
            )
           ->leftJoin('tagstranslations as site', function ($join) use ($websiteId) {
                $join->on('site.tat_tag_id', '=', 'tags.tag_id');
                $join->where('site.tat_web_id', '=', $websiteId);
           })
           ->leftJoin('tagstranslations as base', function ($join) {
                $join->on('base.tat_tag_id', '=', 'tags.tag_id');
                $join->where('base.tat_web_id', '=', baseId());
           })
           ->orderBy('tags.tag_name', 'asc');
    }

    /**
     * Get list of tags by blog post
     *
     * @param  \Illuminate\Database\Eloquent\Model $blogId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getTagsByBlogId($blogId)
    {
        return $this->blogsTag
            ->select(
                'base.tat_name as base_name',
                'base.tat_slug as base_slug',
                'site.tat_name as site_name',
                'site.tat_slug as site_slug'
            )
           ->leftJoin('tags', function ($join) {
                $join->on('tags.tag_id', '=', 'blogstags.blgtag_tag_id');
           })
           ->leftJoin('tagstranslations as site', function ($join) {
                $join->on('site.tat_tag_id', '=', 'tags.tag_id');
                $join->where('site.tat_web_id', '=', websiteId());
           })
           ->leftJoin('tagstranslations as base', function ($join) {
                $join->on('base.tat_tag_id', '=', 'tags.tag_id');
                $join->where('base.tat_web_id', '=', baseId());
           })
           ->where('blgtag_blg_id', $blogId);
    }

    /**
     * Update tag translation
     *
     * @param  array $request
     * @param  integer $tagId
     * @return \Illuminate\Database\Eloquent\Model|boolean
     */    
    public function updateTagTranslation($request, $tagId)
    {
        $translationDuplicate = $this->isTranslationDuplicate($request, $tagId)->count();
        
        if ($translationDuplicate) {
            return false;
        }

        $tags = $this->tagTranslation->where('tat_web_id', websiteId())->where('tat_tag_id', $tagId);

        if ($tags->count()) {
            return $tags->update([
                'tat_name' => $request['tat_name'],
                'tat_slug' => $request['tat_slug']
            ]);
        }

        return $this->tagTranslation->create([
            'tat_tag_id' => $tagId,
            'tat_web_id' => websiteId(),
            'tat_name' => $request['tat_name'],
            'tat_slug' => $request['tat_slug']
        ]);
    }

    /**
     * Check if translation already exists
     *
     * @param  array $request
     * @param  integer $tagId
     * @return \Illuminate\Database\Eloquent\Model
     */    
    public function isTranslationDuplicate($request, $tagId)
    {
        return $this->tagTranslation
            ->where('tat_web_id', websiteId())
            ->where('tat_tag_id', '!=', $tagId)
                ->where(function ($query) use ($request) {
                    $query->where('tat_name', $request['tat_name']);
                    $query->where('tat_name', '!=', '')
                    ->orWhere(function ($query) use ($request) {
                        $query->where('tat_slug', $request['tat_slug']);
                        $query->where('tat_slug', '!=', '');
                    });
                });
    }


    /**
     * Get list of available tags
     *
     * @return array
     */  
    public function tagsSelectList()
    {
        $tags = $this->getTagsByWebsiteId(websiteId())->get();
        return $tags->lists('tag_name', 'tag_id')->toArray();
    }
}
