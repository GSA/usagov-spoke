<?php /*

    Allows lower versions of IE to see the favicon.ico file in the root of the site
        
*/

/**
 * Implements HOOK_menu().
 */
hooks_reaction_add("menu",
    function () {

        $menuArr = array();

        // Register http://YourWebSite.com/favicon.ico to return a page generated from faviconRedirect()
        $menuArr['favicon.ico'] = array(
            'title' => 'favicon redirect',
            'description' => 'A redirection for favicon.ico',
            'page callback' => 'faviconRedirect',
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
function faviconRedirect() {

    // Get the site name
    $siteName = variable_get('site_name', '');

    while( @ob_end_clean() );
    header('Content-type: image/png');

    if ( strpos(strtolower($siteName), 'kids') !== false ) {
        readfile('sites/all/themes/kids/images/favicon.ico');
            exit();
    } elseif ( strpos(strtolower($siteName), 'usa') !== false || strpos(strtolower($siteName), 'gobierno') !== false ) {
        readfile('sites/all/themes/usa/images/favicon.ico');
            exit();
    }

}