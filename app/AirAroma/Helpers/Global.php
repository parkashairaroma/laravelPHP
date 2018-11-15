<?php


function pageSubsite($type) {
    switch ($type) {
        case 'single':
            return 0;
        break;
        case 'allpages':
            return 2;
        break;
    }
}

function blogStatus($name) {
    switch ($name) {
        case 'draft':
            return 0;
        break;
        case 'submitted':
            return 1;
        break;
        case 'approved':
            return 2;
        break;
    }
}

function websiteStatus($name) {
    switch ($name) {
        case 'translating':
            return 0;
        break;
        case 'enable':
            return 1;
        break;
        case 'disable':
            return 2;
        break;
    }
}


function percCalc($complete, $total) {

    if (! $complete && ! $total) {
        return 0;
    }

    if ($total == 0)        //To ignore division by zero error.
    {
        return 0;
    }

    return number_format(($complete / $total) * 100, 0);
}

/**
 * get any config item from the container
 *
 * @param string $section
 * @param string $name
 *
 * @return array
 */
function getConfig($section, $name = null) {

    $config = app('config');

    if ($name) {
        return $config[$section][$name];
    }

    return $config[$section];
}


/**
 * get websiteId
 *
 * @return string
 */
function websiteId() {
    return app('config')['siteConfig']['web_id'];
}

/**
 * get website url
 *
 * @return string
 */
function websiteUrl() {
    return app('config')['siteConfig']['website_url'];
}

/**
 * get websiteId
 *
 * @return string
 */
function websiteLang() {
    return app('config')['siteConfig']['web_lang'];
}

/**
 * get websitetitle
 *
 * @return string
 */
function websitetitle() {
    return app('config')['siteConfig']['web_title'];
}

/**
 * get websitetitle
 *
 * @return string
 */
function websiteflagcode() {
    $lang =  app('config')['siteConfig']['web_htmllang'];
    $flagcode = explode("-", $lang);
    $flagcodeU = strtolower($flagcode[1]);

    return $flagcodeU;
}

/**
 * get pageId
 *
 * @return string
 */
function pageId() {
    return app('config')['siteTranslations']['pageId'];
}

/**
 * get URL basePath (i.e /fr if french is set)
 *
 * @return string
 */
function basePath() {
    return app('config')['siteConfig']['base_path'];
}

/**
 * get TLD
 *
 * @return string
 */
function tld() {
    return app('config')['siteConfig']['tld'];
}

/**
 * determine if site is base template site. air-aroma.base
 *
 * @return string
 */
function isBase() {
    return (tld() == 'base');
}

/**
 * air-aroma.base database ID
 *
 * @return string
 */
function baseId() {
    return 1000;
}

/**
 * check if language switch is in place
 *
 * @return boolean
 */
function isLanguageSet($lang) {
    return  preg_match('/^[a-z]{2}$/', $lang) ? true : false;
}

/**
 * which url segment to use based if language switch is set
 *
 * @return integer
 */
function getSegmentNumber($lang) {
    return isLanguageSet($lang) ? 2 : 1;
}

/**
 * converts array to object
 *
 * @return object
 */
function arrayToObject($array) {
    return json_decode(json_encode($array));
}

// function getUrlSegment($number) {
//     return Request::segment($number);
// }
