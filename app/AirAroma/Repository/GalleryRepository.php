<?php

namespace AirAroma\Repository;

use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Config\Repository as Config;

class GalleryRepository
{

    public function __construct(Config $config, FilesystemManager $storage, File $file)
    {
        $this->config =$config;
        $this->storage = $storage;
        $this->file = $file;

        $this->websiteId = websiteId();
    }

    public function getBlogImagePath()
    {
        return 'images/blog';
    }
    public function getBannerImagePath()
    {
        return 'images/banners';
    }
    public function getClientImagePath()
    {
        return 'images/clients/featured';
    }

    public function getImages()
    {
		$images = $this->dirToArray(public_path().'/images');

		return $images;
    }

	function dirToArray($dir) {

	    $contents = array();

	    foreach (scandir($dir) as $node) {
	        if ($node == '.' || $node == '..')  continue;

            $filename = $dir.DIRECTORY_SEPARATOR.$node;

	        if (is_dir($filename)) {
	            $contents[$node] = $this->dirToArray($filename);
	        } else {
	            $contents[$node] = [$this->file->lastModified($filename)];
	        }
	    }
	    return $contents;
	}

 }