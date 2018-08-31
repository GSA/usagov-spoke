<?php

/**
 * @file
 * This file contains the main theme functions hooks and overrides.
 */


/**
 * Implements template_preprocess_page().
 */
function usa_preprocess_page(&$variables)
{
    //getting the term variable when needed
    $term = menu_get_object('taxonomy_term', 2);
    $variables['term'] = $term;

    // Get the site name
    $siteName = variable_get('site_name', '');

    // Determin which site we are running
    $siteIsUSA = false;
    $siteIsGobierno = false;
    if ( strpos(strtolower($siteName), 'gobierno') !== false ) {
        $siteIsGobierno = true;
    } else {
        $siteIsUSA = true;
    }

    // Add in the print.css reference
    drupal_add_html_head(
        array(
            '#tag' => 'link',
            '#attributes' => array(
                'rel' => 'stylesheet',
                'href' => '/sites/all/themes/usa/css/print.css',
                'media' => 'print'
            )
        ),
        'usa_print_style'
    );

    //_usa_load_necessary_cssjs_resource();

    // Decide which search to print on the front page
    /*
    if( $siteIsUSA ){
        $variables['frontPageSearch'] = '<div class="row">
                <div id="searchcontainer" class="col-md-12">
                    <div class="searchbkgnd">
                     <div class="container">
                     <div class="searchttl" role="search"><p><label for="query">' . t('Search the Government') . '</label></p></div>
                       <div id="search" aria-expanded="true" aria-hidden="false">
                        <div>
                          <form action="https://search.usa.gov/search" method="get" name="search_form" accept-charset="UTF-8">
                            <input id="affiliate" name="affiliate" type="hidden" value="usagov">
                            <input type="text" maxlength="50" name="query" size="38" id="query" class="text search_bg usagov-search-autocomplete ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                            <button type="submit" class="submit" value="Search" id="buscarSubmit"><span class="icon-search">' . t('Search') . '</span></button>
                          </form>
                        </div>
                      </div>
                      </div>
                    </div>
                </div>
            </div>';
    } elseif ( $siteIsGobierno ){
        $variables['frontPageSearch'] = '<div class="row">
                <div id="searchcontainer" class="col-md-12">
                    <div class="searchbkgnd">
                     <div class="container">
                     <div class="searchttl" role="search"><p><label for="query">' . t('Search the Government') . '</label></p></div>
                       <div id="search" aria-expanded="true" aria-hidden="false">
                        <div>
                          <form action="https://search.usa.gov/search" method="get" name="search_form" accept-charset="UTF-8">
                            <input id="affiliate" name="affiliate" type="hidden" value="gobiernousa">
                            <input type="text" maxlength="50" name="query" size="38" id="query" class="text search_bg usagov-search-autocomplete ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                            <button type="submit" class="submit" value="Search" id="buscarSubmit"><span class="icon-search">' . t('Search') . '</span></button>
                          </form>
                        </div>
                      </div>
                      </div>
                    </div>
                </div>
            </div>';
    }
    */

    //Decide Email Signup Action in Page.tpl
    $variables['email_action_path'] = '';
    if( $siteIsUSA ) {
        $variables['email_action_path'] = 'https://public.govdelivery.com/accounts/USAGOV/subscribers/qualify';
    } elseif( $siteIsGobierno ) {
        $variables['email_action_path'] = 'https://public.govdelivery.com/accounts/GOBIERNOUSA/subscribers/qualify';
    }

    // remove the annoying "There is currently no content classified with this term."
    if(isset($variables['page']['content']['system_main']['no_content'])) {
        unset($variables['page']['content']['system_main']['no_content']);
    }

    // If this is the front page, then we load and supply the top-most taxonomy term
    if ( request_uri_path() === '/' ) {

        // Find the home-page taxonomy-term on this site
        $tltTid = db_query("
        	SELECT t.entity_id
        	FROM field_data_field_type_of_page_to_generate t
        	LEFT JOIN field_data_field_generate_page g ON ( g.entity_id = t.entity_id )
        	WHERE
        		t.field_type_of_page_to_generate_value = 'home'
        		AND g.field_generate_page_value = 'yes'
        	LIMIT 1
    	")->fetchColumn();
        $topLvlTerm = taxonomy_term_load($tltTid);

        $variables['term'] = $topLvlTerm;
        $variables['pagetypeddl'] = 'home';
        // Alert node
        $variables['alertNid'] = false;
        $variables['alertNode'] = false;
        if ( !empty($topLvlTerm->field_home_alert_asset['und'][0]['target_id']) ) {
            $variables['alertNid'] = $topLvlTerm->field_home_alert_asset['und'][0]['target_id'];
            $variables['alertNode'] = node_load($variables['alertNid']);
        }
        $variables['howdoiAssets'] = array();
        if ( !empty($topLvlTerm->field_home_howdoi_assets['und']) ) {
            foreach ( $topLvlTerm->field_home_howdoi_assets['und'] as $targContainer ) {
                $targNid = $targContainer['target_id'];
                $variables['howdoiAssets'][] = node_load($targNid);
            }
        }
        $variables['whatsnewAssets'] = array();
        if ( !empty($topLvlTerm->field_home_whats_new_asset['und']) ) {
            foreach ( $topLvlTerm->field_home_whats_new_asset['und'] as $targContainer ) {
                $targNid = $targContainer['target_id'];
                $variables['whatsnewAssets'][] = node_load($targNid);
            }
        }

        /*
        // The "Most Popular" region
        $variables['mostPopular'] = array();
        $variables['mostPopularImg'] = array();
        if ( !empty($topLvlTerm->field_home_popular_asset['und']) ) {
	        foreach ( $topLvlTerm->field_home_popular_asset['und'] as $targContainer ) {
	        	$targNid = $targContainer['target_id'];
	        	$popNode = node_load($targNid);
	        	$variables['mostPopular'][] = $popNode;
	        	$popImg = false;
	        	if ( !empty($popNode->field_related_multimedia_two['und'][0]['target_id']) ) {
	        		$popImgNid = $popNode->field_related_multimedia_two['und'][0]['target_id'];
	        		$popImg = node_load($popImgNid);
	        	}
	        	$variables['mostPopularImg'][] = $popImg;
	        }
        }

        // Load Quote assets
        $variables['quoteNodes'] = array(false, false, false);
        if ( !empty($topLvlTerm->field_home_quote1_asset['und'][0]['target_id']) ) {
        	$quoteNid = $topLvlTerm->field_home_quote1_asset['und'][0]['target_id'];
        	$variables['quoteNodes'][0] = node_load($quoteNid);
        }
        if ( !empty($topLvlTerm->field_home_quote2_asset['und'][0]['target_id']) ) {
        	$quoteNid = $topLvlTerm->field_home_quote2_asset['und'][0]['target_id'];
        	$variables['quoteNodes'][1] = node_load($quoteNid);
        }
        if ( !empty($topLvlTerm->field_home_quote3_asset['und'][0]['target_id']) ) {
        	$quoteNid = $topLvlTerm->field_home_quote3_asset['und'][0]['target_id'];
        	$variables['quoteNodes'][2] = node_load($quoteNid);
        }

        // The "Browse Categories to Contact" region
		$variables['categoriesToContact'] = array();
		if ( !empty($topLvlTerm->field_home_cat2cont_assets['und']) ) {
			foreach ( $topLvlTerm->field_home_cat2cont_assets['und'] as $targContainer ) {
				$targNid = $targContainer['target_id'];
				$variables['categoriesToContact'][] = node_load($targNid);
			}
		}

		// The "Quick-Find and Contact" region
		$variables['quickFindContact'] = false;
		if ( !empty($topLvlTerm->field_home_quickfindcont_asset['und'][0]['target_id']) ) {
			$qfcNodeId = $topLvlTerm->field_home_quickfindcont_asset['und'][0]['target_id'];
			$variables['quickFindContact'] = node_load($qfcNodeId);
		}
        */
    }

    /* Send encodedURL and encodedTitleURL variables to te page.tpl.php file for
    the "Share This Page" region */
    $variables['encodedURL'] = urlencode( $_SERVER['HTTP_HOST'] . request_uri() );
    if ( substr($_SERVER['HTTP_HOST'],0,4) !== 'http' )
    {
        $variables['encodedURL'] = 'https://'. $variables['encodedURL'];
    }
    if(@!empty($term->field_page_title['und'][0]['safe_value'])){
        if(@!empty($term->field_page_title['und'][0]['safe_value'])){
            $title = $term->field_page_title['und'][0]['safe_value'];
        } else {
            $title = $term->field_page_title['und'][0]['safe_value'];
        }
        $variables['encodedTitleURL'] =  urlencode($title . " ") . $variables['encodedURL'];
    } else {
        if(request_uri() === '/features'){
            $variables['encodedTitleURL'] =  urlencode('Features' . " ") . $variables['encodedURL'];
        } else if (!empty($variables['node']) ) {
            $title = $variables['node']->title;
            $variables['encodedTitleURL'] =  urlencode($title . " ") . $variables['encodedURL'];
        }
    }
    if(!isset($variables['encodedTitleURL'])){
        $variables['encodedTitleURL'] = "";
    }

}

/**
 * Implements template_preprocess_html().
 */
function usa_preprocess_html(&$variables)
{

    $siteName = variable_get('site_name', '');
    $variables['siteID'] = ( strpos(strtolower($siteName), 'gobierno') !== false ) ? 'gobierno' : 'usa';

    _usa_preprocess_html_root_term(   $variables );
    _usa_preprocess_html_page_entity( $variables );

    _usa_preprocess_html_head( $variables );

    $path = request_uri_path();
    $path = trim($path, '/');
    if ( request_uri_path() === '/' )
    {
        _usa_preprocess_html_home_term( $variables );
        if ( !empty($variables['term']) )
        {
            _usa_preprocess_html_toggles(   $variables, $variables['term'] );
        }
    } else if ( !empty($variables['page_entity']) ) {
        _usa_preprocess_html_toggles(   $variables, $variables['page_entity'] );
    }
    else if (!empty($variables['directory-page'])){
        _usa_preprocess_html_toggles(   $variables, $variables['directory-page'] );
    }
    else if (!empty($variables['state-business'])){
        $variables["pagetypeddl"]='state-business';
        _usa_preprocess_html_toggles(   $variables, $variables['state-business'] );
    }
    else if ($path === 'features' || $path === 'novedades'){
        $variables["pagetypeddl"]='feature-landing';
        _usa_preprocess_html_toggles(   $variables, $variables['feature-landing'] );
    }

    _usa_preprocess_html_header_menu(   $variables );
    _usa_preprocess_html_header_extras( $variables );
    _usa_preprocess_html_footer(        $variables );

    _usa_preprocess_html_javascript( $variables );
    _usa_preprocess_html_title(      $variables );

}

function _usa_preprocess_html_root_term( &$variables )
{
    $rootTermName = '';
    if (  $variables['siteID']==='usa'       ) { $rootTermName = 'USA.gov'; }
    if (  $variables['siteID']==='gobierno'  ) { $rootTermName = 'GobiernoUSA.gov'; }
    $rootTerm = taxonomy_get_term_by_name($rootTermName, 'site_strucutre_taxonomy' );
    if ( count($rootTerm) == 0 || $rootTerm === false ) {
        drupal_set_message("Error - No '{$rootTermName}' taxonomy-term was found. This term must exsist!", 'error');
        $rootTerm = null;
    } else {
        // The taxonomy_get_term_by_name() returns an array, grab the 1st (only) item
        $rootTerm = array_values($rootTerm);
        $rootTerm = $rootTerm[0];
    }
    $variables['rootTerm'] = $rootTerm;
}
function _usa_preprocess_html_page_entity( &$variables )
{
    // Get the entity of this current [landing] page
    $currentPath = trim(request_uri_path(), '/');
    $entitySystemPath = drupal_lookup_path('source', $currentPath);
    if ( strpos($entitySystemPath, 'taxonomy') !== false )
    {
        $tid = str_replace('taxonomy/term/', '', $entitySystemPath);
        $variables['page_entity'] = taxonomy_term_load($tid);
    } elseif ( strpos($entitySystemPath, 'node') !== false ) {
        $nid = str_replace('node/', '', $entitySystemPath);
        $variables["pagetypeddl"]='feature';
        $variables['page_entity'] = node_load($nid);
    }
    elseif( strpos($currentPath, 'federal-agencies') !== false || strpos($currentPath, 'agencias-federales') !== false){
        $ar= str_replace('federal-agencies', '', $currentPath);
        $ar= str_replace('agencias-federales', '', $ar);
        $ar=str_replace('/', '', $ar);

        if(strlen($ar) == 1){
            $variables["pagetypeddl"]='directory-letter-page';
        }
        else{
            $variables["pagetypeddl"]='directory-record';
        }

        $variables['directory-page'] = true;
    }
    elseif( strpos($currentPath, 'state-business') !== false ){
        $variables["pagetypeddl"]='state-page';
        $variables['state-business'] = true;
    }
    elseif( strpos($currentPath, 'state-government') !== false || strpos($currentPath, 'gobiernos-estatales') !== false){
        $variables["pagetypeddl"]='state-page';
        $variables['state-government'] = true;
    }
    elseif( strpos($currentPath, 'forms') !== false ){
        $variables["pagetypeddl"]='forms-letter-page';
        $variables['gov-forms'] = true;
    }
    elseif( strpos($currentPath, 'find-government-contracts') !== false ){
        $variables["pagetypeddl"]='find-government-contracts';
        $variables['gov-contracts'] = true;
    }
    elseif( strpos($currentPath, 'state-consumer') !== false || strpos($currentPath, 'organizaciones-consumidor') !== false ){
        $variables["pagetypeddl"]='state-page';
    }
    elseif( strpos($currentPath, 'site-index') !== false ){
        $variables["pagetypeddl"]='site-index';
    }
    elseif( strpos($currentPath, 'judical-agencies') !== false ){
        $variables["pagetypeddl"]='branch-agencies';
    }
}
function _usa_preprocess_html_home_term( &$variables )
{
    $variables["pagetypeddl"] = 'home';
    $tltTid = db_query("
        SELECT t.entity_id
        FROM field_data_field_type_of_page_to_generate t
        LEFT JOIN field_data_field_generate_page g ON ( g.entity_id = t.entity_id )
        WHERE
            t.field_type_of_page_to_generate_value = 'home'
            AND g.field_generate_page_value = 'yes'
        LIMIT 1
    ")->fetchColumn();
    $topLvlTerm = taxonomy_term_load($tltTid);
    $variables['term'] = $topLvlTerm;

    //setting the title
    if( !empty($variables['term'] && !empty($variables['term']->field_browser_title['und'][0]['value']) ) )
    {
        drupal_set_title($variables['term']->field_browser_title['und'][0]['value']);
    }

    //setting the meta description
    if( !empty($variables['term']->field_real_meta_description['und'][0]['value']) )
    {
        drupal_add_html_head(
            array(
                '#tag' => 'meta',
                '#attributes' => array(
                    'name' => 'description',
                    'content' =>  $variables['term']->field_real_meta_description['und'][0]['value'],
                )
            ),
            'usa_custom_meta_tag_descriptionforhome'
        );
        drupal_add_html_head(
            array(
                '#tag' => 'meta',
                '#attributes' => array(
                    'name' => 'og:description',
                    'content' =>  $variables['term']->field_real_meta_description['und'][0]['value'],
                )
            ),
            'usa_custom_meta_tag_descriptionforhome'
        );
    }
}

function _usa_preprocess_html_head(  &$variables )
{
    // favicon stuff
    $variables['faviconItems'] = '
		<link rel="apple-touch-icon-precomposed" href="/sites/all/themes/usa/images/USA_Fav_Icon152_default.png">
		<link rel="icon" sizes="16x16" href="/sites/all/themes/usa/images/USA_Fav_Icon16.ico">
		<link rel="icon" sizes="32x32" href="/sites/all/themes/usa/images/favicon.ico">
		<link rel="icon" sizes="152x152" href="/sites/all/themes/usa/images/USA_Fav_Icon152_default.png">
	';

    // Add Anti-Clickjacking security
    header('X-Frame-Options: SAMEORIGIN');

    //_usa_load_necessary_cssjs_resource();
    // If this is the front page, then we load and supply the top-most taxonomy term
    if ( request_uri_path() === '/' )
    {
        $variables['downlevelStyles'] = '';
        drupal_add_js(path_to_theme().'/js/homepage.js', array('type' => 'file', 'weight' => 999, 'group' => JS_THEME));
    } else {
        // drupal_add_css(
        // 	path_to_theme().'/css/downlvl.css',
        // 	array(
        // 		'weight' => 1,
        // 		'group' => 100
        // 	)
        // );
        $variables['homepageOnly'] = '';
    }
}
function _usa_preprocess_html_header_menu( &$variables )
{
    /// Grab the pre-menu markup from the site's Root-Term
    if ( empty($variables['rootTerm']->field_page_intro['und'][0]['value']) ) {
        drupal_set_message("Error - The root taxonomy-term does not have pre-menu HTML", 'error');
        $preMenuHTML    = '<h1>Page-Intro not set in CMP!</h1>';
        $mobileMenuHTML = '<p>Page-Intro not set in CMP!</p>';
    } else {
        $preMenuHTML    = $variables['rootTerm']->field_page_intro['und'][0]['value'];
        $mobileMenuHTML = $variables['rootTerm']->field_head_html['und'][0]['value'];
        if( request_uri_path() !== '/' )
        {
            $preMenuHTML = str_replace('<div class="cntrlogo">', '<h1><div class="cntrlogo">', $preMenuHTML);
            $preMenuHTML = str_replace('</a></div>', '</a></div></h1>', $preMenuHTML);
        }
    }
    $variables['preMenuHTML']    = $preMenuHTML;
    $variables['mobileMenuHTML'] = $mobileMenuHTML;
}
function _usa_preprocess_html_header_extras( &$variables )
{
    // Decide <html> tag-attributes
    $variables['htmlTagAttribs'] = ''; // Default to empty string
    /// set items next to log in the site header
    if( $variables['siteID']==='usa' )
    {
        $variables['htmlTagAttribs'] = ' lang="en" xml:lang="en" ';
        $variables['popupSurvey'] = '<link rel="stylesheet" href="/sites/all/themes/usa/css/popup-survey.css" media="all">';
        $variables['searchTheWebSite'] = '<div class="searchbkgnd">
				 <div class="container">
				 <div class="searchttl" role="search"><p><label for="query">'. t('Search the Government') .'</label></p></div>
				   <div id="search" aria-expanded="false">
				    <div>
				      <form action="https://search.usa.gov/search" method="get" name="search_form" accept-charset="UTF-8">
				        <input id="affiliate" name="affiliate" type="hidden" value="usagov">
				        <input type="text" maxlength="50" name="query" size="38" id="query" class="text search_bg usagov-search-autocomplete ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
				        <button type="submit" class="submit" value="Search" id="buscarSubmit"><span class="icon-search">' . t('Search') . '</span></button>
				      </form>
				    </div>
				  </div>
				  </div>
				</div>';
    } else if ( $variables['siteID']==='gobierno' ) {
        $variables['htmlTagAttribs'] = ' lang="es" xml:lang="es" ';
        $variables['popupSurvey'] = '<link rel="stylesheet" href="/sites/all/themes/usa/css/popup-survey-gobierno.css" media="all">';
        $variables['searchTheWebSite'] = '<div class="searchbkgnd">
				 <div class="container">
				 <div class="searchttl" role="search"><p><label for="query">'. t('Search the Government') .'</label></p></div>
				   <div id="search" aria-expanded="false">
				    <div>
				      <form action="https://search.usa.gov/search" method="get" name="search_form" accept-charset="UTF-8">
				        <input id="affiliate" name="affiliate" type="hidden" value="gobiernousa">
				        <input type="text" maxlength="50" name="query" size="38" id="query" class="text search_bg usagov-search-autocomplete ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
				        <button type="submit" class="submit" value="Search" id="buscarSubmit"><span class="icon-search">' . t('Search') . '</span></button>
				      </form>
				    </div>
				  </div>
				  </div>
				</div>';
    }
}
function _usa_preprocess_html_footer( &$variables )
{
    // Grab the markup for the footer from the site's Root-Term
    if ( empty($variables['rootTerm']->field_end_html['und'][0]['value']) ) {
        drupal_set_message("Error - The '{$rootTermName}' taxonomy-term does not have footer HTML", 'error');
        $footerHTML = '<h1>End-HTML not set in CMP!</h1>';
    } else {
        $footerHTML = $variables['rootTerm']->field_end_html['und'][0]['value'];
    }
    $variables['footerHTML'] = $footerHTML;
}

function _usa_preprocess_html_toggles( &$variables, $entity )
{

    // Decide Toggle-URL-HTML for this page/site
    global $toggleHTML;
    if ( isset($toggleHTML) ) {
        $variables['toggleHTML'] = $toggleHTML;
    } else {
        $variables['toggleHTML'] = ''; // Default to empty string
    }

    //
    $usagovURL="//www.usa.gov/";
    $gobgovURL="//gobierno.usa.gov/";

    // whether to it is dev or local
    if (strpos($_SERVER["HTTP_HOST"],'usa.dev') !== false){
        $gobgovURL="//gobierno.usa.dev/";
        $usagovURL="//www.usa.dev/";
        drupal_add_html_head(
            array(
                '#tag' => 'meta',
                '#attributes' => array(
                    'name' => 'robots',
                    'content' => 'noindex,nofollow',
                )
            ),
            'usa_custom_meta_tag_descriptionforhome'
        );
    }

    if (strpos($_SERVER["HTTP_HOST"],'test-') !== false){
        $gobgovURL="//test-gobiernogov.ctacdev.com/";
        $usagovURL="//test-usagov.ctacdev.com/";
        drupal_add_html_head(
            array(
                '#tag' => 'meta',
                '#attributes' => array(
                    'name' => 'robots',
                    'content' => 'noindex,nofollow',
                )
            ),
            'usa_custom_meta_tag_descriptionforhome'
        );
    }

    if (strpos($_SERVER["HTTP_HOST"],'stage-') !== false){
        $gobgovURL="//stage-gobiernogov.ctacdev.com/";
        $usagovURL="//stage-usagov.ctacdev.com/";
        drupal_add_html_head(
            array(
                '#tag' => 'meta',
                '#attributes' => array(
                    'name' => 'robots',
                    'content' => 'noindex,nofollow',
                )
            ),
            'usa_custom_meta_tag_descriptionforhome'
        );

    }

    if ( !empty($entity->field_gobiernousa_gov_toggle_url['und'][0]['value']) && $variables['siteID']==='usa' )
    {
        $link = $entity->field_gobiernousa_gov_toggle_url['und'][0]['value'];
        $link = $gobgovURL.ltrim($link, '/');
        $variables['toggleHTML'] .= "
			<li class=\"engtoggle\">
				<a href=\"{$link}\" lang=\"es\" xml:lang=\"es\">
					Espa&ntilde;ol
				</a>
			</li>
		";
    }
    // for feature node
    if ( !empty($entity->field_gob_feature_toggle_url['und'][0]['value']) && $variables['siteID']==='usa' )
    {
        $link = $entity->field_gob_feature_toggle_url['und'][0]['value'];
        $link = $gobgovURL.ltrim($link, '/');
        $variables['toggleHTML'] .= "
			<li class=\"engtoggle\">
				<a href=\"{$link}\" lang=\"es\" xml:lang=\"es\">
					Espa&ntilde;ol
				</a>
			</li>
		";
    }

    if ( !empty($entity->field_usa_gov_toggle_url['und'][0]['value']) && $variables['siteID']==='gobierno' )
    {
        $link = $entity->field_usa_gov_toggle_url['und'][0]['value'];
        $link = $usagovURL.ltrim($link, '/');
        $variables['toggleHTML'] .= "
			<li class=\"engtoggle\">
				<a href=\"{$link}\" lang=\"en\" xml:lang=\"en\">
					English
				</a>
			</li>
		";
    }

    if ( !empty($entity->field_usa_feature_toggle_url['und'][0]['value']) && $variables['siteID']==='gobierno' )
    {
        $link = $entity->field_usa_feature_toggle_url['und'][0]['value'];
        $link = $usagovURL.ltrim($link, '/');
        $variables['toggleHTML'] .= "
			<li class=\"engtoggle\">
				<a href=\"{$link}\" lang=\"en\" xml:lang=\"en\">
					English
				</a>
			</li>
		";
    }

    /// features listing page
    $path = explode("/", request_path());
    $args =arg();
    //$view = views_get_page_view();
    //if(isset($view) && $view->name == 'feature_listing_page')
    if ( in_array($path[0], array('features', 'novedades')) && ($args[0]!='node'))
    {
        if ( $variables['siteID']==='usa' )
        {
            $variables['toggleHTML'] .= "
				<li class=\"engtoggle\">
					<a href=\"".$gobgovURL."novedades\" lang=\"es\" xml:lang=\"es\">
						Espa&ntilde;ol
					</a>
				</li>
			";
        } else if ( $variables['siteID']==='gobierno' ) {
            $variables['toggleHTML'] .= "
				<li class=\"engtoggle\">
					<a href=\"".$usagovURL."features\" lang=\"en\" xml:lang=\"en\">
						English
					</a>
				</li>
			";
        }
    }

    // exclude toggle if it is site index. Block is already handling it

    if ( in_array($path[0], array('site-index', 'sitio-indice')) )
    {
        unset($variables['toggleHTML']);
        $variables["pagetypeddl"]='site-index';
        if ( $variables['siteID']==='usa' )
        {
            drupal_add_html_head(
                array(
                    '#tag' => 'meta',
                    '#attributes' => array(
                        'name' => 'description',
                        'content' => 'Site index of the USA.gov website.',
                    )
                ),
                'usa_custom_meta_tag_descriptionforhome'
            );
            //og:description
            drupal_add_html_head(
                array(
                    '#tag' => 'meta',
                    '#attributes' => array(
                        'name' => 'og:description',
                        'content' => 'Site index of the USA.gov website.',
                    )
                ),
                'usa_custom_meta_tag_descriptionforhome'
            );
        } else if ( $variables['siteID']==='gobierno' ) {
            drupal_add_html_head(
                array(
                    '#tag' => 'meta',
                    '#attributes' => array(
                        'name' => 'description',
                        'content' =>  'Índice del sitio web Gobierno.USA.gov',
                    )
                ),
                'usa_custom_meta_tag_descriptionforhome'
            );
            drupal_add_html_head(
                array(
                    '#tag' => 'meta',
                    '#attributes' => array(
                        'name' => 'og:description',
                        'content' =>  'Índice del sitio web Gobierno.USA.gov',
                    )
                ),
                'usa_custom_meta_tag_descriptionforhome'
            );
        }
    }

    // Setting the toggle links for feature node pages
    if ( in_array($path[0], array('features', 'novedades')) )
    {
        $node = menu_get_object();
        if( !empty($node) && !empty($node->field_feature_toggle['und'][0]['value']) )
        {
            $link = _aliasPathHelper_urlFriendlyString($node->field_feature_toggle['und'][0]['value']);
            if ( $variables['siteID']==='usa' )
            {
                $link = $gobgovURL.'novedades/'.ltrim($link, '/');
                $variables['toggleHTML'] .= "
    				<li class=\"engtoggle\">
    					<a href=\"{$link}\" lang=\"es\" xml:lang=\"es\">
    						Espa&ntilde;ol
    					</a>
    				</li>
    			";
            } else if ( $variables['siteID']==='gobierno' ) {
                $link = $usagovURL.'features/'.ltrim($link, '/');
                $variables['toggleHTML'] .= "
    				<li class=\"engtoggle\">
    					<a href=\"{$link}\" lang=\"en\" xml:lang=\"en\">
    						English
    					</a>
    				</li>
    			";
            }
        }
    }
    $path = explode("/", request_path());
    if ( in_array($path[0], array('federal-agencies', 'agencias-federales')) )
    {
        /*  unset($variables['toggleHTML']);
          if ( $variables['siteID']==='usa' )
          {
              $link = $gobgovURL.'agencias-federales/a';
              $variables['toggleHTML'] .= "
                      <li class=\"engtoggle\">
                          <a href=\"{$link}\" lang=\"es\" xml:lang=\"es\">
                              Espa&ntilde;ol
                          </a>
                      </li>
                  ";
          } else if ( $variables['siteID']==='gobierno' ) {
              $link = $usagovURL.'federal-agencies/a';
              $variables['toggleHTML'] .= "
                      <li class=\"engtoggle\">
                          <a href=\"{$link}\" lang=\"en\" xml:lang=\"en\">
                              English
                          </a>
                      </li>
                  ";
          }*/
    }

}
function _usa_preprocess_html_javascript( &$variables )
{
    // drupal_add_js('https://standards.usa.gov/assets/js/styleguide.js', 'external');

    if( $variables['siteID']==='usa' )
    {

        /*
                 <!-- Begin: VOC survey -->
        <script type=\"text/javascript\" src=\"https://survey.usa.gov/widget/291/invitation.js?target_id=srvyinvt&mobile_target_id=survey-target&stylesheet=https%3A%2F%2Fwww.usa.gov/sites/all/themes/usa/css/popup-survey.css\"></script>
        <!-- End: VOC survey -->

        		<!-- Begin: VOC survey -->
        <script type=\"text/javascript\" src=\"https://survey.usa.gov/widget/301/invitation.js?target_id=srvyinvt&mobile_target_id=survey-target&stylesheet=https%3A%2F%2Fgobierno.usa.gov/sites/all/themes/usa/css/popup-survey-gobierno.css\"></script>
        <!-- End: VOC survey -->
         * */
        if (current_path()!== 'find-government-contracts') {
            $variables['jsScript'] = "<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-28227333-1', 'auto');
			ga('send', 'pageview');
		</script>

		<script type=\"text/javascript\">

		//<![CDATA[
            var usasearch_config = { siteHandle:\"usagov\" };
            var script = document.createElement(\"script\");
            script.type = \"text/javascript\";
            script.src = \"https://search.usa.gov/javascripts/remote.loader.js\";
            document.getElementsByTagName(\"head\")[0].appendChild(script);
		//]]>

		</script>";
        }
        else {
            $variables['jsScript'] = "<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-28227333-1', 'auto');
			ga('send', 'pageview');
		</script>

		<script type=\"text/javascript\">

		//<![CDATA[
            var usasearch_config = { siteHandle:\"usagov\" };
            var script = document.createElement(\"script\");
            script.type = \"text/javascript\";
            script.src = \"https://search.usa.gov/javascripts/remote.loader.js\";
            document.getElementsByTagName(\"head\")[0].appendChild(script);
		//]]>

		</script>";
        }
    } elseif ( $variables['siteID']==='gobierno' ){
        $variables['jsScript'] =  "<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-28227333-1', 'auto');
			ga('send', 'pageview');
		</script>

		<script type=\"text/javascript\">

		//<![CDATA[
			var usasearch_config = { siteHandle:\"gobiernousa\" };
            var script = document.createElement(\"script\");
            script.type = \"text/javascript\";
            script.src = \"https://search.usa.gov/javascripts/remote.loader.js\";
            document.getElementsByTagName(\"head\")[0].appendChild(script);
		//]]>

		</script>";
    }
}
function _usa_preprocess_html_title( &$variables )
{
    // Decide Page Title to print
    $variables['page_title'] = '';
    //$variables['rootTerm']->name
    $brand = 'USAGov';
    if(!empty($variables['page_entity']->field_browser_title['und'][0]['safe_value']))
    {
        $variables['page_title'] =
            $variables['page_entity']->field_browser_title['und'][0]['safe_value'] /* page title */
            ." &#124; " /* a pipe("|") */
            .$brand; /* the name of this WebSite, you can change this from /admin/config/system/site-information */
    } elseif (!empty($variables['gov-forms'])){
        $arg1 = arg(1);
        $l = empty($arg1)? 'A': strtoupper($arg1);

        $variables['page_title'] = $l.' | Government Forms'/* page title */
            ." &#124; " /* a pipe("|") */
            .$brand;

        drupal_add_html_head(
            array(
                '#tag' => 'meta',
                '#attributes' => array(
                    'name' => 'description',
                    'content' =>  'Federal Government Forms, by Agency: '.$l,
                )
            ),
            'usa_custom_meta_tag_descriptionforhome'
        );
        drupal_add_html_head(
            array(
                '#tag' => 'meta',
                '#attributes' => array(
                    'name' => 'og:description',
                    'content' =>  'Federal Government Forms, by Agency: '.$l,
                )
            ),
            'usa_custom_meta_tag_descriptionforhome'
        );
    }
    elseif (!empty($variables['gov-contracts'])){

        $variables['page_title'] = 'Find Opportunities to Contract with the Federal Government (Beta)'/* page title */
            ." &#124; " /* a pipe("|") */
            .$brand;

        drupal_add_html_head(
            array(
                '#tag' => 'meta',
                '#attributes' => array(
                    'name' => 'description',
                    'content' =>  'The Contracting Opportunity Finder can help your small and/or disadvantaged business discover contract opportunities with federal agencies to bid on.',
                )
            ),
            'usa_custom_meta_tag_descriptionforhome'
        );
        drupal_add_html_head(
            array(
                '#tag' => 'meta',
                '#attributes' => array(
                    'name' => 'og:description',
                    'content' =>  'The Contracting Opportunity Finder can help your small and/or disadvantaged business discover contract opportunities with federal agencies to bid on.',
                )
            ),
            'usa_custom_meta_tag_descriptionforhome'
        );
    }
    else{
        $variables['page_title'] =
            drupal_get_title() /* page title */
            ." &#124; " /* a pipe("|") */
            .$brand; /* the name of this WebSite, you can change this from /admin/config/system/site-information */
    }
}

function usa_html_head_alter(&$head_elements) {

    if ( isset($head_elements['system_meta_generator']) ) { unset($head_elements['system_meta_generator']); }

    foreach ( $head_elements as $key => $head_element ) {

        // remove favicon if added via drupal
        if (!empty($head_element['#attributes'])) {
            if (array_key_exists('href', $head_element['#attributes'])) {
                if ($head_element['#attributes']['rel'] == 'shortcut icon')
                {
                    unset($head_elements[$key]);

                }
            }
        }


        // Remove the shortlink, i.e.: <link rel="shortlink" href="/taxonomy/term/10834" />
        if ( strpos($key, 'shortlink') !== false ) {
            unset($head_elements[$key]);
        }

        // Remove Canonical Tags
        if (isset($head_element['#attributes']['rel']) && $head_element['#attributes']['rel'] == 'canonical') {
            unset($head_elements[$key]);
        }
    }
}

/**
 * Implements template_css_alter().
 */
function usa_css_alter(&$css)
{

    // _usa_load_necessary_cssjs_resource();

    // always remove these stylesheets, even when logged in
    unset($css[drupal_get_path('module', 'system') . '/system.theme.css']);
    unset($css[drupal_get_path('module', 'system') . '/system.base.css']);
    unset($css[drupal_get_path('module', 'system') . '/system.menus.css']);


    //removes all the default css files that drupal loads for non logged in users
    global $user;
    if (!$user->uid) {


        unset($css['sites/all/modules/contrib/ctools/css/ctools.css']);
        unset($css['sites/all/modules/contrib/date/date_api/date.css']);
        unset($css['modules/field/theme/field.css']);
        unset($css['modules/node/node.css']);
        unset($css['sites/all/modules/contrib/relation_add/relation_add.css']);
        unset($css['modules/search/search.css']);
        unset($css['modules/user/user.css']);
        unset($css['sites/all/modules/contrib/views/css/views.css']);
        unset($css['modules/taxonomy/taxonomy.css']);
        unset($css['sites/all/modules/contrib/admin_menu/admin_menu.css']);
        unset($css['sites/all/modules/contrib/admin_menu/admin_menu.uid1.css']);
        unset($css['sites/all/modules/contrib/admin_menu/admin_menu_toolbar/admin_menu_toolbar.css']);
        unset($css['modules/shortcut/shortcut.css']);


        /*
          foreach ($css as $key => $value) {
            if ($value['group'] != CSS_THEME) {
              $exclude[$key] = FALSE;
            }
          }
          $css = array_diff_key($css, $exclude);
        */
    }

    //FBO only had to alter via this
    if (current_path()!== 'find-government-contracts') {
        //unset($css['sites/all/themes/usa/css/facetedsearch.css']);
    }
}

/**
 * Implements template_js_alter().
 */
function usa_js_alter(&$javascript) {

    //removes all the default js files that drupal loads for non logged in users
    global $user;
    if ( !$user->uid ) {

        unset($javascript['settings']);
        unset($javascript['misc/drupal.js']);
        unset($javascript['misc/jquery.once.js']);
        unset($javascript['sites/all/modules/contrib/devel/devel_krumo_path.js']);
        unset($javascript['sites/all/modules/contrib/admin_menu/admin_menu.js']);
        unset($javascript['sites/all/modules/contrib/admin_menu/admin_menu_toolbar/admin_menu_toolbar.js']);

    }
    //removing languages js
    foreach ( array_keys($javascript) as $key )
    {
        if ( stristr($key,'languages/es') !== false )
        {
            unset($javascript[$key]);
        }
    }
}

/**
 *
 */
function _usa_load_necessary_cssjs_resource() {

    // load parent first
    $parent_tid = db_query("SELECT tid FROM {taxonomy_term_data} WHERE vid = 42 ORDER BY tid LIMIT 1")->fetchField();

    $sql = " SELECT f.filename, f.uri, f.filemime  FROM field_data_field_layout_file_asset t
            INNER JOIN field_data_field_layout_file n ON field_layout_file_asset_target_id = n.entity_id
            INNER JOIN file_managed f  ON n.field_layout_file_fid = f.fid WHERE t.entity_id = :parent_id ";

    // load parent's css and js
    // taxonomy/term/term_id
    $cur_path = explode('/', current_path());
    if (is_array($cur_path) && $cur_path[0] == 'taxonomy'
        && count($cur_path) == 3 && is_numeric($cur_path[2])) {

        $all_tids = array();
        $all_parent_terms = taxonomy_get_parents_all($cur_path[2]);

        foreach($all_parent_terms as $parent_term) {
            if ($parent_tid != $parent_term->tid) {
                $all_tids[] = $parent_term->tid;
            }
        }

        if (isset($all_tids) && count($all_tids) > 0) {
            $sql .= " UNION
            SELECT f2.filename, f2.uri, f2.filemime  FROM field_data_field_layout_file_asset t2
            INNER JOIN field_data_field_layout_file n2 ON field_layout_file_asset_target_id = n2.entity_id
            INNER JOIN file_managed f2 ON n2.field_layout_file_fid = f2.fid WHERE t2.entity_id IN (" . join(",", $all_tids). ")";
        }
    }

    $res = db_query($sql, array(':parent_id'=>$parent_tid));

    foreach($res as $row) {
        $layout_file = str_replace("s3://", "https://gsa-cmp-fileupload-stage.s3.amazonaws.com/", $row->uri);

        if ($row->filemime == 'application/x-javascript') {
            drupal_add_js($layout_file);
        }
        elseif($row->filemime == 'text/css') {
            drupal_add_css($layout_file, array('type' => 'external'));
        }
    }


}



/**
 * Returns HTML for a query pager.
 *
 * Menu callbacks that display paged query results should call theme('pager') to
 * retrieve a pager control so that users can view other results. Format a list
 * of nearby pages with additional query results.
 *
 * @param $variables
 *   An associative array containing:
 *   - tags: An array of labels for the controls in the pager.
 *   - element: An optional integer to distinguish between multiple pagers on
 *     one page.
 *   - parameters: An associative array of query string parameters to append to
 *     the pager links.
 *   - quantity: The number of pages in the list.
 *
 * @ingroup themeable
 */
function usa_pager($variables) {
    if ( request_uri_path() == '/features' || request_uri_path() == '/features/' || request_uri_path() == '/novedades' || request_uri_path() == '/novedades/') {

        $tags = $variables['tags'];
        $element = $variables['element'];
        $parameters = $variables['parameters'];
        $quantity = $variables['quantity'];
        global $pager_page_array, $pager_total;
        // Calculate various markers within this pager piece:
        // Middle is used to "center" pages around the current page.
        $pager_middle = ceil($quantity / 2);
        // current is the page we are currently paged to
        $pager_current = $pager_page_array[$element] + 1;
        // first is the first page listed by this pager piece (re quantity)
        $pager_first = $pager_current - $pager_middle + 1;
        // last is the last page listed by this pager piece (re quantity)
        $pager_last = $pager_current + $quantity - $pager_middle;
        // max is the maximum page number
        $pager_max = $pager_total[$element];





        // End of marker calculations.
        // Prepare for generation loop.
        $i = $pager_first;
        if ($pager_last > $pager_max) {
            // Adjust "center" if at end of query.
            $i = $i + ($pager_max - $pager_last);
            $pager_last = $pager_max;
        }
        if ($i <= 0) {
            // Adjust "center" if at start of query.
            $pager_last = $pager_last + (1 - $i);
            $i = 1;
        }
        // End of generation loop preparation.
        $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
        $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
        $li_count = 'Page ' . $pager_current . ' of ' . $pager_max;
        if ($pager_total[$element] > 1) {

            if ($li_previous) {
                $items[] = array(
                    'class' => array('previous'),
                    'data' => $li_previous,
                );
            }
            if ($li_count) {
                $items[] = array(
                    'class' => array('pager-dscrpt'),
                    'data' => $li_count,
                );
            }
            // When there is more than one page, create the pager list.
            if ($i != $pager_max) {
                if ($i > 1) {
                    $items[] = array(
                        'class' => array('pager-ellipsis'),
                        'data' => '&nbsp;…',
                    );
                }
                // Now generate the actual pager piece.
                for (; $i <= $pager_last && $i <= $pager_max; $i++) {
                    if ($i < $pager_current) {
                        $items[] = array(
                            'class' => array('pager-item'),
                            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
                        );
                    }
                    if ($i == $pager_current) {
                        $items[] = array(
                            'class' => array('current'),
                            'data' => $i,
                        );
                    }
                    if ($i > $pager_current) {
                        $items[] = array(
                            'class' => array('pager-item'),
                            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
                        );
                    }
                }
                if ($i < $pager_max) {
                    $items[] = array(
                        'class' => array('pager-ellipsis'),
                        'data' => '…',
                    );
                }
            }
            // End generation.
            if ($li_next) {
                $items[] = array(
                    'class' => array('next'),
                    'data' => $li_next,
                );
            }

            return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
                'items' => $items,
                'attributes' => array('class' => array('pagination')),
            ));
        }

    } else {
        return theme_pager($variables);
    }
}

/**
 * Implements template_preprocess_node().
 */
function usa_preprocess_node(&$variables) {

    $siteName = variable_get('site_name', 'UNKNOWN');
    $node = $variables['node'];

    // Determin what language to use with the "By: <author>" label
    if ( stripos($siteName, 'Gobi') !== false ) {
        $variables['labelText_By'] = 'Por:';
    } else {
        $variables['labelText_By'] = 'By:';
    }

    $getpublished_date=db_query("select field_blog_pub_date_value from field_data_field_blog_pub_date
								where entity_id=:nid", array(":nid"=>$node->nid))->fetchCol();


    // Determin what language to use with the "Date: <post-date>" label
    if ( stripos($siteName, 'Gobi') !== false ) {
        if($getpublished_date[0]):
            $variables['labelText_DateLabel'] = 'Fecha:';
            // setlocale(LC_ALL,"es_ES");
            $variables['labelText_DateValue'] = strftime(
                '%e de %B de %G',
                intval($getpublished_date[0])
            );
        endif;
    } else {
        if($getpublished_date[0]):
            $variables['labelText_DateValue'] = date("F j, Y", $getpublished_date[0]);
            $variables['labelText_DateLabel'] = 'Date:';
        endif;
    }
    $variables["pagetypeddl"]='Feature';
    _usa_preprocess_html_toggles(   $variables, $variables['node'] );

}

function _get_whatsnew_nid($nid) {

    $n = node_load($nid);

    //get path alias
    $nodePath = 'node/' . $nid;
    $aliasPath = drupal_get_path_alias($nodePath);

    //get image
    if ( !empty($n->field_related_multimedia_two) ) {
        $imgSrc = false;
        foreach($n->field_related_multimedia_two['und'] as $relMultimedia) {
            $nidMultMedia = $relMultimedia['target_id'];
            $nodeMultMedia = node_load($nidMultMedia);
            if (!empty($nodeMultMedia->field_file_media_url['und'][0]['value'])) {
                $imgSrc = $nodeMultMedia->field_file_media_url['und'][0]['value'];
                break;
            }
        }
    } else {
        $imgSrc = false;
    }

    $ret = '<section class="usa-grid usa-section feature-hvr">
        <a href="'.$aliasPath.'"><ul id="features-landing"><li>'.(($imgSrc)?('<img src="'.$imgSrc.'" class="rel-img" alt="">') :'').'<header>
        <h2>'.$n->title.'</h2></header>'.
        (!empty($n->field_description['und'][0]['value'])?
            $n->field_description['und'][0]['value']:'').'</li></ul></a></section>';

    return $ret;
}

function _print_social_media(){

    $encodedURL = urlencode( $_SERVER['HTTP_HOST'] . request_uri());
    if ( substr($_SERVER['HTTP_HOST'],0,4) !== 'http' )
    {
        $encodedURL = 'https://'. $encodedURL;
    }

    $args = arg();

    if ($args[0] == 'taxonomy'){
        $term = taxonomy_term_load($args[2]);
        $title = $term->field_page_title['und'][0]['safe_value'];
        $encodedTitleURL = urlencode($title . " ") . $encodedURL;
    }
    elseif ($args[0] == 'node') {
        $node = node_load($args[1]);
        $title =$node->title;
        $encodedTitleURL = urlencode($title . " ") . $encodedURL;
    }
    elseif(request_uri() === '/features') {
        $title = 'Features';
        $encodedTitleURL =  urlencode('Features' . " ") . $encodedURL;
    }
    else {
        $encodedTitleURL =  urlencode($encodedURL . " ") . $encodedURL;
    }


    $html = '<div id="sm-share"><span>'.t('Share This Page').':</span>
    <a href="http://www.facebook.com/sharer/sharer.php?u='.$encodedURL.'&v=3"><img src="/sites/all/themes/usa/images/Icon_Connect_Facebook.png" alt="Facebook"></a>
    <a href="http://twitter.com/intent/tweet?source=webclient&amp;text='.$encodedTitleURL.'"><img src="/sites/all/themes/usa/images/Icon_Connect_Twitter.png" alt="Twitter"></a>
    <a href="mailto:?subject='.$title.'&body='.$encodedURL.'"><img src="/sites/all/themes/usa/images/Icon_Connect_Email.png" alt="Email"></a></div>';
    return $html;
}

