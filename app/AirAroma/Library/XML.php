<?php

namespace AirAroma\Library;

use SimpleXMLElement;

class XML
{

    /**
     * Gererate XML based on input array
     * @param type $array
     * @return $xml
     */
    public function generate($array)
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
        $this->array2XML($array, $xml);

        return $xml;
    }

    /**
     * Iterate and add keys as xml elements
     * @param type $array
     * @param type &$xml
     * @return type
     */
    private function array2XML($array, &$xml)
    {
        foreach ($array as $key => $value) {

            $url = 'http://'.getConfig('siteConfig', 'web_main_domain').$value['url'];

            $loc = $xml->addChild("url");
            $loc->addChild("loc", htmlspecialchars($url));
            $loc->addChild("changefreq", 'weekly');
        }
    }
}
