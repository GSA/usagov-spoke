<?php

/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site© is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 *
 * @ingroup themeable
 */

//getting the term variable when needed
if ( request_uri() !== '/' ) {
    $term = menu_get_object('taxonomy_term', 2);
}
?><!DOCTYPE html>
<html <?php print $htmlTagAttribs; ?> >

<head>

    <!– Google Tag Manager –>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KV4BZFD');</script>
    <!– End Google Tag Manager –>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="google" value="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print $page_title; ?></title>

    <?php print $faviconItems; ?>

    <?php print $head; ?>
    <?php print $styles; ?>
    <?php print $scripts; ?>

    <!--[if lt IE 9]>
    <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php
    $domain = "www.usa.gov";
    $fb_img='USAGOV.png';
    if ($variables['siteID'] == 'gobierno')
    {
        $domain = "gobierno.usa.gov";
        $fb_img = 'Logo_GobiernoUSA_fb.png';
    }
    $domain = $_SERVER['HTTP_HOST'];

    ?>
    <link rel="canonical" href="https://<?php print strtolower($domain . base_path() . htmlspecialchars(rtrim(request_path(),'/'), ENT_QUOTES, "UTF-8")); ?>" />
    <meta property="og:url"           content="https://<?php print strtolower($domain . base_path() . htmlspecialchars(rtrim(request_path(),'/'), ENT_QUOTES, "UTF-8")); ?>" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="<?php print $page_title; ?>" />
    <meta property="og:image"         content="https://<?php print strtolower($domain . base_path()); ?>sites/all/themes/usa/images/<?php print $fb_img; ?>" />
    <?php
    if ($variables['siteID'] == 'gobierno')
    {
        ?>
        <meta property="og:image:height"         content="630" />
        <meta property="og:image:width"         content="1200" />

    <?php
    }
    // Print the "Head-HTML" field of this S.S.-taxonomy-term
    if ( !empty($term->field_head_html['und'][0]['value']) && !drupal_is_front_page() ) {
        print $term->field_head_html['und'][0]['value'];
    }
    ?>


</head>
<body>
<!– Google Tag Manager (noscript) –>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KV4BZFD"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!– End Google Tag Manager (noscript) –>
<noscript><?php print t('JavaScript must be enabled in your browser in order to use some functions.'); ?></noscript>

<a class="usa-skipnav" href="#skiptarget" onclick="document.getElementById('#skiptarget').focus();"><?php print t('Skip to main content'); ?></a>
<header class="usa-header usa-header-extended" role="banner">


    <div class="usa-banner">
        <div class="usa-accordion">
            <header class="usa-banner-header">
                <div class="usa-grid usa-banner-inner">
                    <img src="/sites/all/themes/usa/images/favicon-57.png" alt="U.S. flag">
                    <p><?php print t('An official website of the United States government'); ?></p>
                    <button class="usa-accordion-button usa-banner-button" aria-expanded="false" aria-controls="gov-banner">
                        <span class="usa-banner-button-text"><?php print t('Here\'s how you know'); ?></span>
                    </button>
                </div>
            </header>
            <div class="usa-banner-content usa-grid usa-accordion-content" id="gov-banner" aria-hidden="true">
                <div class="usa-banner-guidance-gov usa-width-one-half">
                    <img class="usa-banner-icon usa-media_block-img" src="/sites/all/themes/usa/images/icon-dot-gov.svg" alt="Dot gov">
                    <div class="usa-media_block-body">
                        <p>
                            <strong><?php print t('The .gov means it\'s official.'); ?></strong>
                            <br>
                            <?php print t('Federal government websites often end in .gov or .mil. Before sharing sensitive information, make sure you\'re on a federal government site.'); ?>
                        </p>
                    </div>
                </div>
                <div class="usa-banner-guidance-ssl usa-width-one-half">
                    <img class="usa-banner-icon usa-media_block-img" src="/sites/all/themes/usa/images/icon-https.svg" alt="SSL">
                    <div class="usa-media_block-body">
                        <p>
                            <strong><?php print t('This site is secure.'); ?></strong>
                            <br>
                            <?php print t('The <strong>https://</strong> ensures that you are connecting to the official website and that any information you provide is encrypted and transmitted securely.'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="usa-navbar">
        <?php print $preMenuHTML; ?>
        <button class="usa-menu-btn"><?php if ($variables['siteID'] == 'gobierno') print ('MENÚ'); else print ('MENU'); ?></button>
    </div>
    <nav role="navigation" class="usa-nav">
        <div class="usa-nav-inner">
            <?php print $mobileMenuHTML; ?>

            <ul class="usa-nav-primary usa-accordion">
                <?php
                #for https://ctac.myjetbrains.com/youtrack/issue/usagov-102110
                if ($variables['siteID'] == 'gobierno')
                {
                    print '<li><a class="usa-nav-link" href="/servicios-informacion"><span>Todos los temas y servicios</span></a></li>';
                }
                else {
                    print '<li><a class="usa-nav-link" href="/topics"><span>All Topics and Services</span></a></li>';
                }

                //Printing out the main menu
                $siteStructureVocab = taxonomy_vocabulary_machine_name_load('site_strucutre_taxonomy');
                $menuTerms = taxonomy_get_tree($siteStructureVocab->vid, 0, 2, TRUE);
                $mainItemsCount = 0;
                $lastItem = '';
                foreach($menuTerms as $menuTerm)
                {
                    if(@!empty($menuTerm->field_generate_menu['und'][0]['value']) && $menuTerm->field_generate_menu['und'][0]['value'] == 'yes'){
                        if($menuTerm->depth == 1){
                            if(!empty($menuTerm->field_friendly_url['und'][0]['value']) && !empty($menuTerm->field_css_class['und'][0]['value']) && !empty($menuTerm->name)){
                                $lastItem = $menuTerm->tid;
                            }
                        }
                    }
                }
                foreach($menuTerms as $menuTerm)
                {
                    if(@!empty($menuTerm->field_generate_menu['und'][0]['value']) && $menuTerm->field_generate_menu['und'][0]['value'] == 'yes'){
                        if($menuTerm->depth == 1){
                            if(!empty($menuTerm->field_friendly_url['und'][0]['value']) && !empty($menuTerm->field_css_class['und'][0]['value']) && !empty($menuTerm->name)){


                                if($menuTerm->tid != $lastItem){
                                    $allChildrenItems = [];
                                    $menuTermChildren = [];
                                    $childItems = taxonomy_get_children($menuTerm->tid);

                                    foreach($childItems as $childItem){
                                        if(@!empty($childItem->field_generate_menu['und'][0]['value']) && $childItem->field_generate_menu['und'][0]['value'] == 'yes'){
                                            $menuTermChildren[] = $childItem;
                                        }
                                    }

                                    $alsoIncludeOnNavPages = [];
                                    if ( !empty($menuTerm->field_also_include_on_nav_page['und']) )
                                    {
                                        foreach($menuTerm->field_also_include_on_nav_page['und'] as $menuTermAlsoNavPages){
                                            $current = taxonomy_term_load($menuTermAlsoNavPages['tid']);
                                            if(@!empty($current->field_generate_menu['und'][0]['value']) && $current->field_generate_menu['und'][0]['value'] == 'yes'){
                                                $alsoIncludeOnNavPages[$current->name] = $current;
                                                ksort($alsoIncludeOnNavPages);
                                            }
                                        }
                                    }

                                    $allChildrenItems = array_merge($menuTermChildren, $alsoIncludeOnNavPages);


                                    print '<li><button class="usa-accordion-button usa-nav-link" aria-expanded="false" aria-controls="megamenu-' . $mainItemsCount . '"><span>' . $menuTerm->name . '</span></button>';
                                    $childrenItemsChunked = array_chunk($allChildrenItems, 3);
                                    if(!empty($childrenItemsChunked))
                                    {
                                        print '<ul class="usa-nav-submenu usa-megamenu usa-grid-full" id="megamenu-' . $mainItemsCount . '">';
                                        foreach($childrenItemsChunked as $chunk)
                                        {
                                            print '<li class="usa-megamenu-col"><ul>';
                                            foreach($chunk as $item)
                                            {
                                                print '<li><a href="' . $item->field_friendly_url['und'][0]['value'] . '">' . $item->name . '</a></li>';
                                            }
                                            print '</ul></li>';
                                        }
                                        print '<li class="topic-link topic-nav-'.$menuTerm->field_css_class['und'][0]['value'].'"><a class="usa-button" href="'.$menuTerm->field_friendly_url['und'][0]['value'].'">'.$menuTerm->name.'</a></li>';
                                        print '</ul>';
                                    }
                                    print '</li>';
                                } else {
                                    $allChildrenItems = [];
                                    $menuTermChildren = taxonomy_get_children($menuTerm->tid);
                                    $self[] = $menuTerm;
                                    $allChildrenItems = array_merge($menuTermChildren, $self);


                                    print '<li><button class="usa-accordion-button usa-nav-link" aria-expanded="false" aria-controls="megamenu-' . $mainItemsCount . '"><span>' . $menuTerm->name . '</span></button>';
                                    $childrenItemsChunked = array_chunk($allChildrenItems, 3);
                                    if(!empty($childrenItemsChunked))
                                    {
                                        print '<ul class="usa-nav-submenu usa-megamenu usa-grid-full" id="megamenu-' . $mainItemsCount . '">';
                                        foreach($childrenItemsChunked as $chunk)
                                        {
                                            print '<li class="usa-megamenu-col"><ul>';
                                            foreach($chunk as $item)
                                            {
                                                if ( !empty($item->field_friendly_url) &&
                                                    !empty($item->field_friendly_url['und']) &&
                                                    !empty($item->field_friendly_url['und'][0]) &&
                                                    !empty($item->field_friendly_url['und'][0]['value']) &&
                                                    $menuTerm->field_friendly_url['und'][0]['value'] != $item->field_friendly_url['und'][0]['value']
                                                )
                                                {
                                                    print '<li><a href="' . $item->field_friendly_url['und'][0]['value'] . '">' . $item->name . '</a></li>';
                                                }
                                            }
                                            print '</ul></li>';
                                        }
                                        print '<li class="topic-link icon-'.$menuTerm->field_css_class['und'][0]['value'].'"><a class="usa-button" href="'.$menuTerm->field_friendly_url['und'][0]['value'].'">'.$menuTerm->name.'</a></li>';
                                        print '</ul>';
                                    }
                                    print '</li>';
                                }




                            }
                        }
                    }
                    $mainItemsCount++;
                }
                ?>
            </ul>

        </div>
    </nav>
</header>
<div class="usa-overlay"></div>
<!-- begin skip link target for main content -->
<div class="clearfix">
    <p id="skiptargetholder"> <a id="skiptarget" class="skip" tabindex="-1"></a> </p>
</div>

<?php //print $searchTheWebSite; ?>
<!-- end skip link target for main content -->
<!-- begin toggle -->
<div id="#skiptarget" class="hptoggles clearfix">
    <div class="container usa-grid">
        <ul>
            <?php
            if (isset($toggleHTML)) {
                ?>

                <?php print $toggleHTML; ?>

            <?php }
            ?>
        </ul>
    </div>
</div>
<!-- end toggle -->

<?php print $page; ?>


<!-- begin footer container -->

<?php print $footerHTML; ?>

<!-- end footer container -->

<?php print $jsScript; ?>

<?php
// Print the "End-HTML" field of this S.S.-taxonomy-term
if ( !empty($term->field_end_html['und'][0]['value']) && !drupal_is_front_page() ) {
    print $term->field_end_html['und'][0]['value'];
}
?>

<?php
//printing the end html field in directory record nodes (global var set in directory_records_by_alphaname.tpl.php)
global $dirEndHtml;
if(@!empty($dirEndHtml)){
    print $dirEndHtml;
}
?>
<!-- Start of Async HubSpot Analytics Code -->
<script type="text/javascript">
    (function(d,s,i,r) {
        if (d.getElementById(i)){return;}
        var n=d.createElement(s),e=d.getElementsByTagName(s)[0];
        n.id=i;n.src='//js.hs-analytics.net/analytics/'+(Math.ceil(new Date()/r)*r)+'/532040.js';
        e.parentNode.insertBefore(n, e);
    })(document,"script","hs-analytics",300000);
</script>
<!-- End of Async HubSpot Analytics Code -->

<script type="text/javascript" src="/sites/all/themes/usa/js/uswds.js"></script>
</body>
</html>
