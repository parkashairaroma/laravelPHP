<?php

function blogCheckDate($blogDate)
{
    return (date('Y-m-d', strtotime($blogDate)) <= date('Y-m-d'));
}

function blogConvertDate($blogDate)
{
    return date('Y-m-d', strtotime($blogDate));
}


/**
* display the first paragraph in a blog post, and shorten if too long.
 *
 * @param string $content
 * @param integer $paragraph number
 *
 * @return string
 */
function paragraph($content, $paragraph = 0)
{
    $len = 250;

    if (! preg_match_all('~<div id="summary" class="block text-block"(.*?)>(\s+)?<p>(.+?)<\/p><\/div>~', str_replace(array("\n", "\r"), "", $content), $matches)) {
        return 'No Paragraph Tag';
    }

    $string = $matches[3][$paragraph];

    if (strlen($string) > $len) {
        $string = substr($string, 0, $len);
        return shorten($string);
    } else {
        return $string;
    }
}

function paragraphClient($content, $paragraph = 0)
{
    //$len = 1;

    if (! preg_match_all('~<p>(.+?)<\/p>~', str_replace(array("\n", "\r"), "", $content), $matches)) {
        return 'No Paragraph Tag';
    }

    $string = $matches[1][$paragraph];

    return $string;
}

function shorten($string)
{
    $pos = strrpos($string, " ");
    return substr($string, 0, $pos).'...';
}
