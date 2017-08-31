<?php

/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>
<head profile="<?php print $grddl_profile; ?>">
  <?php print $head; ?>
<?php print $faviconItems; ?>
  <?php
    //getting the term variable when needed
    $term = menu_get_object('taxonomy_term', 2);

    //set browser title
    if(!empty($term->field_browser_title['und'][0]['safe_value'])){
      $pageTitle = $term->field_browser_title['und'][0]['safe_value'];
    } else {
      $pageTitle = ( empty($head_title) ? 'Kids.USA.gov' : $head_title );
    }

  ?>
  <title><?php print trim($pageTitle).' | USAGov'; ?></title>
  <?php print $styles; ?>
  <?php print $scripts; ?>

  <link rel="canonical" href="https://<?php print strtolower($_SERVER['HTTP_HOST'] . base_path() . htmlspecialchars(rtrim(request_path(),'/'), ENT_QUOTES, "UTF-8")); ?>" />

  <?php
    if ( !empty($term->field_head_html['und'][0]['value']) ) {
      print $term->field_head_html['und'][0]['value'];
    }
  ?>

<?php if(!user_is_logged_in()): ?>
  <script src="/sites/all/themes/kids/js/jquery.autocomplete.min.js" type="text/javascript"></script>
  <script src="/sites/all/themes/kids/js/jquery.bgiframe.js" type="text/javascript"></script>
  <script src="/sites/all/themes/kids/js/sayt.js" type="text/javascript"></script>
  <script language="javascript" id="_fed_an_ua_tag" src="/sites/all/themes/kids/js/Universal-Federated-Analytics.1.0.js?agency=GSA"></script>
    <script src="/sites/all/themes/kids/js/v2-legacy.js" type="text/javascript"></script>
    <script src="/sites/all/themes/kids/js/v2.js" type="text/javascript"></script>
  <link href="//search.usa.gov/stylesheets/compiled/sayt.css" media="screen" rel="stylesheet" type="text/css" />
<?php endif ?>

</head>
<body class="<?php print $classes ?>" <?php print $attributes;?>>


  <?php
    // printing out the cmp link for the client to be able to go to the site building taxonomy page.
    //if(isset($term->tid)){
    //  print '<a href="http://stage-cmp.ctacdev.com/taxonomy/term/' . $term->tid . '/edit?destination=admin/structure/taxonomy/site_strucutre_taxonomy" id="cmp-edit-link">CLICK HERE TO EDIT THIS PAGE AND ITS ASSETS</a>';
    //}
  ?>

  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>

<?php if(!user_is_logged_in()): ?>
   <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-28227333-1']);
    _gaq.push(['_setDomainName', 'usa.gov']);
    _gaq.push(['_setAllowLinker', true]);
    _gaq.push(['_trackPageview']);
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
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

<?php endif ?>

</body>
</html>
