<?php
function slug($url){

    # Prep string with some basic normalization

    $url = strtolower($url);

    $url = strip_tags($url);

    $url = stripslashes($url);

    $url = html_entity_decode($url);

    # Remove quotes (can't, etc.)

    $url = str_replace('\'', '', $url);

    # Replace non-alpha numeric with hyphens

    $match = '/[^a-z0-9]+/';

    $replace = '-';

    $url = preg_replace($match, $replace, $url);

    $url = trim($url, '-');

    return $url;

}

function setMetaDescription($metaDescription)
{
    // Remove html tags from description if they are present
    $metaDescription = str_replace('<p>', '', $metaDescription);
    $metaDescription = str_replace('</p>', '', $metaDescription);
    $metaDescription = str_replace('&nbsp;', '', $metaDescription);
    $metaDescription = str_replace('</b>', '', $metaDescription);
    $metaDescription = str_replace('</b>', '', $metaDescription);
    $metaDescription = str_replace('<h1>', '', $metaDescription);
    $metaDescription = str_replace('</h1>', '', $metaDescription);

    return $metaDescription;
}