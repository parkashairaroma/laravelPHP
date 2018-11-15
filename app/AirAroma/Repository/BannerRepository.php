<?php

namespace AirAroma\Repository;

use AirAroma\Model\Banner;
use AirAroma\Model\Website;

use Illuminate\Config\Repository as Config;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\Request;

class BannerRepository
{

    protected $colours = ['#000000' => '', '#1f1f1f' => '', '#333333' => '', '#474747' => '', '#5c5c5c' => '', '#707070' => '', '#858585' => '', '#999999' => '', '#adadad' => '', '#c2c2c2' => '', '#d6d6d6' => '', '#ffffff' => ''];
    protected $bannerImagesPath = '/images/banners/';


    public function __construct(Website $website, Request $request, Banner $banner)
    {
        $this->banner = $banner;
        $this->request = $request;
        $this->website = $website;

        $this->websiteId = websiteId();
    }

    /**
     * Get all enabled banners using the relationship
     *
     * @param  string $websiteId
     * @return model
     */

    public function getBannersFromSiteConfig($options = [])
    {

        $defaults = ['status' => null, 'limit' => null, 'order' => 'asc'];

        if ($options) {
            $defaults = array_merge($defaults, $options);
        }

        extract($defaults);

        $banners = $this->website->find($this->websiteId)->getBanners();

        if ($status) {
            $banners->where('ban_status', $status);
        }

        if ($limit) {
            $banners->limit($limit);
        }

        $banners->orderby('ban_order', $order);

        return $banners->get();
    }

    public function getColours()
    {
        return $this->colours;
    }

    /*
    * update banner status
    */
    public function updateBannerStatus($id, $status)
    {
        return $this->banner->where('ban_id', $id)->update(['ban_status' => $status]);
    }

    /*
    * update banner order
    */
    public function updateBannerOrder($banners)
    {
        foreach ($banners['order'] as $order => $bannerId) {
            $this->banner->where('ban_id', $bannerId)->update(['ban_order' => $order]);
        }
        return true;
    }

    public function getBannerImages(FilesystemManager $storage)
    {
        $files = [];

        foreach ($storage->disk('public')->files($this->bannerImagesPath.$this->websiteId) as $file) {
            $files[] = explode('/', $file)[3];
        }

        return $files;
    }

    public function getBannerImagesPath()
    {
        return $this->bannerImagesPath;
    }

    public function insertBanner()
    {
        return $this->banner->create([
            'ban_name' => $this->request->get('ban_name'),
            'ban_title' => $this->request->get('ban_title'),
            'ban_store' => $this->request->get('ban_store'),
            'ban_description' => $this->request->get('ban_description'),
            'ban_title_colour' => $this->request->get('ban_title_colour'),
            'ban_description_colour' => $this->request->get('ban_description_colour'),
            'ban_overflow_colour' => $this->request->get('ban_overflow_colour'),
            'ban_link' => $this->request->get('ban_link'),
            'ban_image' => $this->request->get('ban_image'),
            'ban_text_align' => $this->request->get('ban_text_align'),
            'ban_status' => $this->request->get('ban_status'),
            'ban_web_id' => $this->websiteId
        ]);
    }

    public function updateBanner($id)
    {

        return $this->banner->where('ban_id', $id)
            ->update([
                'ban_name' => $this->request->get('ban_name'),
                'ban_title' => $this->request->get('ban_title'),
                'ban_store' => $this->request->get('ban_store'),
                'ban_description' => $this->request->get('ban_description'),
                'ban_title_colour' => $this->request->get('ban_title_colour'),
                'ban_description_colour' => $this->request->get('ban_description_colour'),
                'ban_overflow_colour' => $this->request->get('ban_overflow_colour'),
                'ban_link' => $this->request->get('ban_link'),
                'ban_image' => $this->request->get('ban_image'),
                'ban_text_align' => $this->request->get('ban_text_align'),
                'ban_status' => $this->request->get('ban_status')
            ]);
    }

    public function deleteBanner($id)
    {
        return $this->banner->where('ban_id', $id)->delete();
    }
}
