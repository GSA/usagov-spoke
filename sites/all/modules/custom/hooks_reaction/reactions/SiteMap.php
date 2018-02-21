<?php

/**
 * Implements HOOK_menu().
 */
hooks_reaction_add("menu",
    function () {

        $menuArr = array();

        // Register http://YourWebSite.com/favicon.ico to return a page generated from faviconRedirect()
        $menuArr['sitemap.xml'] = array(
            'title' => 'site-map url hendeler',
            'description' => 'A redirection for favicon.ico',
            'page callback' => 'sitmapHandeler',
            'access arguments' =>  array('access content'),
            'type' => MENU_CALLBACK,
        );
        $menuArr['sitemaps.xml'] = array(
            'title' => 'site-map url hendeler',
            'description' => 'A redirection for favicon.ico',
            'page callback' => 'sitmapHandeler',
            'access arguments' =>  array('access content'),
            'type' => MENU_CALLBACK,
        );

        return $menuArr;
    }
);

/**
 * string faviconRedirect()
 *
 * A callback function for http://YourWebSite.com/favicon.ico
 */
function sitmapHandeler() {

    // Get the site name
    $siteName = variable_get('site_name', '');

    while( @ob_end_clean() );
    header('Content-type: text/xml');

    if ( strpos(strtolower($siteName), 'gobierno') !== false ) {
        //readfile('sites/default/files/sitemap-gobierno.xml');
        readfile(drupal_get_path('module', 'hooks_reaction').'/sitemap-gobierno.xml');
    } elseif ( strpos(strtolower($siteName), 'usa') !== false ) {
        //readfile('sites/default/files/sitemap-usa.xml');
        readfile(drupal_get_path('module', 'hooks_reaction').'/sitemap-usa.xml');
    }

    exit();
}