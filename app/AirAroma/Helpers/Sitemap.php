<?php

function sitemapList($sitemap, $section) {

	// use laravel html generator
	$output = '<li><strong><a href="'.$sitemap['/'.$section]['url'].'">'.$sitemap['/'.$section]['name'].'</a></strong></li>';

	if (array_key_exists('sub', $sitemap['/'.$section])) {
		foreach ($sitemap['/'.$section]['sub'] as $sub) {

			$output .= '<li class="l2"><a href="'.$sub['url'].'">'.$sub['name'].'</a></li>';
			if (array_key_exists('sub', $sub)) {
				foreach($sub['sub'] as $subsub) {
					$output .= '<li class="l2"><a href="'.$subsub['url'].'">'.$subsub['name'].'</a></li>';
				}
			}
		}
	}
	return $output;
}
	