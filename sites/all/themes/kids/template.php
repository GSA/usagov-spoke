<?php

/**
 * Implements menu_link.
 */

function kids_menu_link__menu_block(array $variables) {

	$element = $variables['element'];
	$sub_menu = '';

	// creating a main menu active trail body class
	/*if(in_array('menu_link__menu_block__1', $element['#theme']) && in_array('active-trail', $element['#attributes']['class'])){
		global $bodyClassName;
		$bodyClassName =  drupal_get_path_alias($element['#href']);
		if(strstr($bodyClassName, '/')){
			$bodyClassName = explode("/", $bodyClassName);
			$bodyClassName = $bodyClassName[count($bodyClassName)-2];
			if($bodyClassName == $_SERVER['HTTP_HOST']){
				$bodyClassName = "learn-stuff";
			}
		}
	}*/

	//adding a class to all menu block links of the same name as their path alias name
	$className =  drupal_get_path_alias($element['#href']);
	if(strstr($className, '/')){
		$className = explode("/", $className);
		$className = $className[count($className)-2];
		if($className == $_SERVER['HTTP_HOST']){
			$className = "learn-stuff";
		}
	}
	$element['#attributes']['class'][] = $className;

	if ($element['#below']) {
		$sub_menu = drupal_render($element['#below']);
	}
	$element['#href'] = ltrim( parse_url($element['#href'], PHP_URL_PATH), '/');
	$output = l($element['#title'], $element['#href'], $element['#localized_options']);
	return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}



/**
 * Implements template_preprocess_html().
 */
function kids_preprocess_html(&$variables) {

	// favicon stuff
	$variables['faviconItems'] = '
		<link rel="apple-touch-icon-precomposed" href="/sites/all/themes/kids/images/Kids_Fav_Icon152_default.png">
		<link rel="icon" sizes="16x16" href="/sites/all/themes/kids/images/Kids_Fav_Icon16.ico">
		<link rel="icon" sizes="32x32" href="/sites/all/themes/kids/images/favicon.ico">
		<link rel="icon" sizes="152x152" href="/sites/all/themes/kids/images/Kids_Fav_Icon152_default.png">
	';

	// adding a class to the body tag of the top most parent site building taxonomy term
	$term = menu_get_object('taxonomy_term', 2);
	if (isset($term->tid) && count($term->tid) > 0){
		$parents = taxonomy_get_parents_all($term->tid);
		$bodyClass = "";
		foreach($parents as $parent){
			switch ($parent->name) {
				case "Kids Grade K-5":
					$bodyClass = "kids-trail";
					break 2;
				case "Teens Grades 6-8":
					$bodyClass = "teens-trail";
					break 2;
				case "Teachers":
					$bodyClass = "teachers-trail";
					break 2;
				case "Parents":
					$bodyClass = "parents-trail";
					break 2;
				default:
					$bodyClass = "kids-trail";
			}
		}
		$variables['classes_array'][] = $bodyClass;
	} else {
		$variables['classes_array'][] = 'kids-trail';
		// drupal_add_js(
		// 	"
		// 		jQuery(document).ready( function () {
		// 			jQuery('.menu-block-2 li').eq(0).addClass('active-trail').addClass('active');
		// 		});
		// 	",
		// 	"inline"
		// );
	}

	// adding superfish and hoverintent scripts to the sitemap page
	if($_SERVER['REQUEST_URI'] == "/about-us/site-map/index.shtml"){
		drupal_add_js(drupal_get_path('theme', 'kids') .'/js/hoverIntent.js', 'file');
		drupal_add_js(drupal_get_path('theme', 'kids') .'/js/superfish.js', 'file');
		drupal_add_js(drupal_get_path('theme', 'kids') .'/js/navbar.js', 'file');
	}

}


/**
 * Implements theme_link().
 */

function kids_link($variables) {

	// fix the front page main menu item
	$basePath = "http://" . $_SERVER['HTTP_HOST'] . "/";
	if($variables['path'] == $basePath) {
		$variables['path'] = $basePath . "index.shtml";
	}
	return '<a href="' . check_plain(url($variables['path'], $variables['options'])) . '"' . drupal_attributes($variables['options']['attributes']) . '>' . ($variables['options']['html'] ? $variables['text'] : check_plain($variables['text'])) . '</a>';
}



/**
 * Implements theme_breadcrumb().
 */

function kids_breadcrumb($variables) {

	$breadcrumb = $variables['breadcrumb'];

	// changing home breadcrumb wording and adding class

	// altering multiple breadcrumb links

	foreach($breadcrumb as $key => &$crumb){
		if(strip_tags($crumb) === "Home"){
			$breadcrumb[$key] = '<a href="/" class="homelink">Kids.gov Home</a>';
		}
		if(strip_tags($crumb) === "Kids.gov"){
			unset($breadcrumb[$key]);
		}
		if(strip_tags($crumb) === "Kids Grade K-5"){
			unset($breadcrumb[$key]);
		}
		if(strip_tags($crumb) === "Learn Stuff"){
			unset($breadcrumb[$key]);
		}
		if(strip_tags($crumb) === "Teens Grades 6-8"){
			$breadcrumb[$key] = '<a href="/teens/index.html">Teens</a>';
		}
		if(strip_tags($crumb) === "Teachers"){
			$breadcrumb[$key] = '<a href="/teachers/index.shtml">Teachers</a>';
		}
		if(strip_tags($crumb) === "For Teachers"){
			unset($breadcrumb[$key]);
		}
		if(strip_tags($crumb) === "Parents"){
			unset($breadcrumb[$key]);
		}
		if(strip_tags($crumb) === "For Parents"){
			$breadcrumb[$key] = '<a href="/parents/index.shtml">Parents</a>';
		}
	}

	/*
	if(($key = array_search('<a href="/">Home</a>', $breadcrumb)) !== false) {
	    $breadcrumb[$key] = '<a href="/" class="homelink">Kids.gov Home</a>';
	}
	if(($key = array_search('<a href="/taxonomy/term/3072">Kids.gov</a>', $breadcrumb)) !== false) {
	    unset($breadcrumb[$key]);
	}
	if(($key = array_search('<a href="/taxonomy/term/10259">Kids Grade K-5</a>', $breadcrumb)) !== false) {
	    unset($breadcrumb[$key]);
	}
	if(($key = array_search('<a href="/index.shtml">Learn Stuff</a>', $breadcrumb)) !== false) {
	    unset($breadcrumb[$key]);
	}
	if(($key = array_search('<a href="/taxonomy/term/10425">Teens Grades 6-8</a>', $breadcrumb)) !== false) {
	    $breadcrumb[$key] = '<a href="/teens/index.html">Teens</a>';
	}
	if(($key = array_search('<a href="/taxonomy/term/10517">Teachers</a>', $breadcrumb)) !== false) {
	    $breadcrumb[$key] = '<a href="/teachers/index.shtml">Teachers</a>';
	}
	if(($key = array_search('<a href="/teachers/index.shtml">For Teachers</a>', $breadcrumb)) !== false) {
	    unset($breadcrumb[$key]);
	}
	if(($key = array_search('<a href="/taxonomy/term/10595">Parents</a>', $breadcrumb)) !== false) {
	    unset($breadcrumb[$key]);
	}*/


	//printing out breadcrumb after changes
	if (!empty($breadcrumb)) {
		$output = '<span>' . t('You are here') . '</span> ';
		$output .= implode(' &gt; ', $breadcrumb);
		return $output;
	}
}



/**
 * Implements template_preprocess_page().
 */

function kids_preprocess_page(&$vars)
{
    $vars['active_tids'] = array();
	// adding a class to the body tag of the top most parent site building taxonomy term
	$term = menu_get_object('taxonomy_term', 2);
	if (isset($term->tid) && count($term->tid) > 0)
    {
        $vars['active_tids'][$term->tid] = true;
		$parents = taxonomy_get_parents_all($term->tid);
        foreach($parents as $parent)
        {
            $vars['active_tids'][$parent->tid] = true;
		}
        reset($parents);
    }
	// remove the annoying "There is currently no content classified with this term."
	if(isset($vars['page']['content']['system_main']['no_content'])) {
		unset($vars['page']['content']['system_main']['no_content']);
	}
}


/**
 * Used to remove certain elements from the $head output within html.tpl.php
 *
 * @see http://api.drupal.org/api/drupal/modules--system--system.api.php/function/hook_html_head_alter/7
 * @param array $head_elements
 */
function kids_html_head_alter(&$head_elements) {

    if ( isset($head_elements['system_meta_generator']) ) { unset($head_elements['system_meta_generator']); }

    foreach ($head_elements as $key => $value) {
        if (isset($value['#attributes']))  {
            if(isset($value['#attributes']['rel'])){
            	if(($value['#attributes']['rel'] == 'shortlink' || $value['#attributes']['rel'] == 'canonical' || $value['#attributes']['rel'] == 'alternate')){
            		unset($head_elements[$key]);
            	}
  			}
        }


        // remove favicon if added via drupal
		if (!empty($value['#attributes'])) {
	      if (array_key_exists('href', $value['#attributes'])) {
	        if ($value['#attributes']['rel'] == 'shortcut icon')
	        {
	        	unset($head_elements[$key]);

	        }
	      }
	    }


    }
}

/**
 * Used to add variables shipped to the taxonomy-term.tpl.php file
 *
 * @see https://api.drupal.org/api/drupal/modules%21taxonomy%21taxonomy.module/function/template_preprocess_taxonomy_term/7
 * @param array $variables
 */
function kids_preprocess_taxonomy_term(&$variables) {

	/* Give taxonomy-term.tpl.php the "page last updated" value */
	$term = $variables['term'];

	// Get a list of all assets on this page
	$assetPointerFields = array(
		'field_asset_order_carousel',
		'field_asset_order_content',
		'field_asset_order_sidebar',
		'field_asset_order_bottom'
	);
	$assetNodeIds = array();
	foreach ($assetPointerFields as $assetPointerField) {
		if ( !empty($term->{$assetPointerField}) && !empty($term->{$assetPointerField}['und']) ) {
			foreach ( $term->{$assetPointerField}['und'] as $targContainer ) {
				$assetNodeIds[] = $targContainer['target_id'];
			}
		}
	}

	// Scan all assets for the latest modification-date
	$highestDate = 0;
	foreach ($assetNodeIds as $assetNodeId) {
		$assetNode = node_load($assetNodeId);
		if ( !empty($assetNode->changed) && $highestDate < intval($assetNode->changed) ) {
			$highestDate = intval($assetNode->changed);
		}
	}

	// Take the modification date of this taxonomy-term into consideration
	$termDate = db_query("SELECT changed FROM taxonomy_dates WHERE tid={$term->tid}")->fetchColumn();
	if ( $highestDate < intval($termDate) ) {
		$highestDate = intval($termDate);
	}

	// Pass this information to the taxonomy-term.tpl.php template during render
	$variables['lastUpdated'] = date('M jS, Y', $highestDate);

}

function ctac_parse_url($url, $strict = false)
{
    $strict_url = "/^(?:(?P<scheme>[^\:\/\?\#]+):\/\/)?(?:(?P<userinfo>(?:(?:[\w\.\-\+!$&'\(\)*\+,;=]|%[0-9a-f]{2})+:)*(?:[\w\.\-\+%!$&'\(\)*\+,;=]|%[0-9a-f]{2})+)@)?(?P<host>(?:[a-z0-9\-\.\_\~]|%[0-9a-f]{2})+)?(?::(?P<port>[0-9]+))?(?P<tail>[\/\?#](?:[\w#!:\.\?\+=&@$'~*,;\/\(\)\[\]\-]|%[0-9a-f]{2})*)?$/xi";
    $simple_url = "/^(?:(?P<scheme>[^\:\/\?\#]+):\/\/)?(?:(?P<userinfo>[^\/@]*)@)?(?P<host>[^\/:?#]*)?(?::(?P<port>[0-9]+))?(?P<tail>(?P<path>[^\?\#]*?(?:\.(?P<format>[^\.\?\#]*))?)?(?:\?(?P<query>[^\#]*))?(?:#(?P<fragment>.*))?)?$/i";

    $parsed = array(
        'valid'    => false,
        'scheme'   => '',
        'userinfo' => '',
        'host'     => '',
        'port'     => '',
        'tail'     => '',
        'path'     => '',
        'format'   => '',
        'query'    => '',
        'fragment' => '',
    );

    if (preg_match(($strict) ? $strict_url : $simple_url, $url, $url_parts)) {
        $parsed['valid'] = true;
        foreach (array_keys($parsed) as $k) {
            if (isset($url_parts[$k])) {
                $parsed[$k] = trim($url_parts[$k]);
            }
        }
    }

    return $parsed;
    //$simple_url = "/^(?:(?P<scheme>[^\:\/\?\#]+):\/\/)(?:(?P<userinfo>[^\/@]*)@)?(?P<host>[^\/:?#]+)(?::(?P<port>[0-9]+))?(?P<tail>.*)?$/i";
}

if ( function_exists('cssFriendlyString') === false ) {
   function cssFriendlyString($inputString, $charactersToRemove = ' -_/!?@#$%^&*()[]{}<>\'"', $forceLowerCase = true, $trimString = true) {
       return getEasyCompareString($inputString, $charactersToRemove, $forceLowerCase, $trimString);
   }
}


/**
* string getEasyCompareString(string inputString[, string/array $charactersToRemove, bool forceLowerCase = true])
*
* Returns the given string with certain characters removed, and converted to lowercase if desiered.
* This makes things easier to compare two strings in certain situations.
*/
if ( function_exists('getEasyCompareString') === false ) {
   function getEasyCompareString($inputString, $charactersToRemove = " -_/\\!?@#$%^&*'\"()[]{}<>", $forceLowerCase = true, $trimString = true, $stripUnicodeCharacters = true, $replaceCharsWith = '-', $killRepeatingReplacements = true) {

       $ret = $inputString;

       if ( is_null($charactersToRemove) ) {
           $charactersToRemove = " -_/\\!?@#$%^&*'\"()[]{}<>";
       }

       if ( !is_array($charactersToRemove) ) {
           $charactersToRemove = str_split($charactersToRemove);
       }
       $charactersToRemove[] = '%20';

       foreach ( $charactersToRemove as $charToRemove ) {
           $ret = str_replace($charToRemove, $replaceCharsWith, $ret);
       }

       if ( $forceLowerCase ) {
           $ret = strtolower( $ret );
       }

       if ( $trimString ) {
           $ret = trim( $ret );
       }

       if ( $stripUnicodeCharacters ) {
           $ret = stripUnicode($ret, $replaceCharsWith);
       }

       if ( $replaceCharsWith !== '' && $killRepeatingReplacements == true ) {
           while ( strpos($ret, $replaceCharsWith . $replaceCharsWith) !== false ) {
               $ret = str_replace($replaceCharsWith . $replaceCharsWith, $replaceCharsWith, $ret);
           }
       }

       return $ret;
   }
}

/**
* string stripUnicode(string $inputString)
*
* Returns $inputString with all Unicode characters stripped
*/
if ( function_exists('stripUnicode') === false ) {
   function stripUnicode($inputString, $replaceUnicodeCharsWith = '') {

       $removeCharacters = array();
       for ( $x = strlen($inputString) - 1 ; $x > -1 ; $x-- ) {
           $thisChar = $inputString[$x];
           $charCode = ord($thisChar);
           if (
               ( 96 < $charCode && $charCode < 123 )
               || ( 64 < $charCode && $charCode < 91 )
               || ( 47 < $charCode && $charCode < 58 )
           ) {
               // Then this is a character, a-z, A-Z, or 0-1
           } else {
               $removeCharacters[$thisChar] = $thisChar;
           }
       }

       $inputString = str_replace(array_values($removeCharacters), $replaceUnicodeCharsWith, $inputString);

       return $inputString;
   }
}
