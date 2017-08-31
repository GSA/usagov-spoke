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

<!-- [Error] Messages (including DSM statements) will only show to the admin  -->
<?php if($is_admin): ?>
  <?php print $messages; ?>
<?php endif; ?>

<?php global $isAtoZ; ?>
<?php if( isset($isAtoZ) || strpos(request_uri(), 'site-index') !== FALSE): ?>
  <main id="content" class="az-page" role="main">
<?php else: ?>
  <main id="content" role="main">
<?php endif; ?>
    <div class="container clearfix">
      <?php print render($page['content']); ?>
    </div>
<aside class="sclmedia">
  <div class="container clearfix">
    <?php if(!empty($term->field_govdelivery_id['und']) && FALSE ): // TURN EMAIL FORM OFF TEMPORARILY?>
    <section class="col-md-6 col-xs-12">
    <?php else: ?>
    <section class="col-md-6 col-xs-12 noemllft">
    <?php endif; ?>
      <div class="nodvdr">
        <header>
        <h2><?php print t('Share This Page'); ?>:</h2>
        </header>
        <ul>
          <li class="col-md-3 col-xs-6"><a href="http://www.facebook.com/sharer/sharer.php?u=<?php print $encodedURL; ?>&v=3" class="sclfcbk" style="display:inline-block;"><span>Facebook</span></a></li>
          <li class="col-md-3 col-xs-6"><a href="http://twitter.com/intent/tweet?source=webclient&text=<?php print $encodedTitleURL; ?>" class="scltwttr" style="display:inline-block;"><span>Twitter</span></a></li>
          <li class="col-md-3 col-xs-6"><a href="https://plus.google.com/share?url=<?php print $encodedURL; ?>" class="sclggle" style="display:inline-block;"><span>Google+</span></a></li>
          <li class="col-md-3 col-xs-6">
            <a href="mailto:?subject=<?php print $title; ?>&amp;body=<?php print "https://".$_SERVER['HTTP_HOST'].htmlentities(rtrim(request_uri(),'/'), ENT_QUOTES, "UTF-8"); ?>" class="scleml"><span>Email</span></a>
          </li>
        </ul>
      </div>
    </section>
    <!--
    <?php if(!empty($term->field_govdelivery_id['und'])): ?>
      <section class="col-md-6 col-xs-12 dvdr">
    <?php else: ?>
      <section class="col-md-6 col-xs-12 dvdr noeml">
    <?php endif; ?>

      <div>
        <header>
          <h2><label for="email-input"><?php print t('Get Email Updates on This Topic'); ?>:</label></h2>
        </header>
        <div class="nowrp">
          <form method="POST" action="<?php print $email_action_path; ?>">
            <p class="txtbx">
              <?php if(@!empty($term->field_govdelivery_id['und'][0]['value'])): ?>
                <input id="topic_id" name="topic_id" type="hidden" value="<?php print $term->field_govdelivery_id['und'][0]['value']; ?>" />
              <?php endif; ?>
              <input id="email-input" class="text" size="38" name="email" type="email">
              <input class="submit" value="<?php print t('Subscribe'); ?>" id="emailSubmit" type="submit">
            </p>
          </form>
        </div>
    </div>
    </section>
    -->
  </div>
</aside>
  </main>
