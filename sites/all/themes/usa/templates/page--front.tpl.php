<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>


<?php

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


?>

<!-- Begin Emergency -->
<?php
if(!empty($alertNode)){
    ?>
    <div id="emergency" data-id="201705040949" class="active modal">

        <div class="usa-grid">
            <div>
                <button class="close top" onclick="closeEmergencyPopup()">
                    <?php print ($siteIsUSA)? "Close" : "Cerrar"; ?>
                </button>
                <div class="icon">

                </div>
                <h2><?php print $alertNode->title; ?></h2>
                <p><?php print  $alertNode->body['und']['0']['value']; ?></p>
                <button class="close" onclick="closeEmergencyPopup()">
                    <?php print ($siteIsUSA)? "Close" : "Cerrar"; ?>
                </button>
                <div class="logo"></div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- end Emergency -->

<?php if($is_admin): ?>
    <?php print $messages; ?>
<?php endif; ?>


<main id="main-content">


    <section class="how-do-i">
        <div class="usa-grid">
            <div>
                <h1><?php print t('How Do I ...'); ?></h1>
            </div>
        </div>
    </section>

    <section class="usa-hero">
        <div class="usa-grid">
            <?php
            $howdoiCount = 0;
            if(!empty($howdoiAssets)){
                foreach($howdoiAssets as $howdoiAsset){

                    if($howdoiCount == 0){
                        print '<div class="floating-box-1">';
                        print  $howdoiAsset->body['und']['0']['value'];
                        print '</div>';
                    }
                    if($howdoiCount == 1){
                        print '<div class="floating-box-2 usa-width-one-third">';
                        print  $howdoiAsset->body['und']['0']['value'];
                        print '</div>';
                        break;
                    }
                    $howdoiCount++;
                }
            }
            ?>
        </div>
    </section>

    <div class="usa-grid usa-footer-return-to-top">
    </div>

    <section>
        <div class="usa-grid">
            <div>
                <h1><?php print t("What's New"); ?></h1>
            </div>
        </div>
    </section>


    <?php
    if(!empty($whatsnewAssets)){

        foreach($whatsnewAssets as $whatsnewAsset){
            //$wnassets[] = $whatsnewAsset->nid;
            print(_get_whatsnew_nid($whatsnewAsset->nid));
        }
        //$wnassets = implode("+", $wnassets);
        //print views_embed_view('whats_new_front_page', 'block', $wnassets);
    }

    ?>

    <div class="usa-grid usa-whats-new"><p>
            <?php
            $feature_listing_url = 'features';
            if ($siteIsGobierno) $feature_listing_url = 'novedades';

            print '<a href="/'.$feature_listing_url.'">'.t('View More Featured Articles').'</a>';
            ?></p>
    </div>

    <div class="usa-grid usa-footer-return-to-top">
        <a href="#"><span class="icon-backtotopHP"><?php print t('Back to Top'); ?></span></a>
    </div>



    <!-- end content container -->
</main>


