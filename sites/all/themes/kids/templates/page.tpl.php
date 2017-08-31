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
<div id="wrapper">
  <div id="innerWrapper">
    <div id="header">
      <h1><a href="/index.shtml">Kids.gov A safe place to learn and play</a></h1>

      <form accept-charset="UTF-8" action="https://search.usa.gov/search" id="search_form" method="get">
        <div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="✓"></div>
        <div>
          <input id="affiliate" name="affiliate" type="hidden" value="kidsgov">
          <label for="query" class="off">I'm looking for: </label>
          <input autocomplete="off" class="usagov-search-autocomplete ac_input" id="query" name="query" type="text" size="31">
          <input type="image" name="sa" src="/sites/all/themes/kids/images/Kids_Search_button.png" style="vertical-align:bottom;" alt="Search">
        </div>
      </form>
      <?php
        // $block1 = module_invoke('menu_block', 'block_view', '1');
        // print render($block1['content']);
?>
<div class="menu-block-wrapper menu-block-1 menu-name-main-menu menu-level-1">
    <ul class="menu">
<?php
        $siteStructureVocab = taxonomy_vocabulary_machine_name_load('site_strucutre_taxonomy');
        $menuTerms = taxonomy_get_tree($siteStructureVocab->vid, 0, 2, TRUE);
        $mainItemsCount = 0;
        $lastItem = '';
        $activeMenuTid = null;
        foreach($menuTerms as $menuTerm)
        {
            if(
                @!empty($menuTerm->field_generate_menu['und'][0]['value'])
                && $menuTerm->field_generate_menu['und'][0]['value'] == 'yes'
                && $menuTerm->depth == 1
                && !empty($menuTerm->field_friendly_url['und'][0]['value'])
                && !empty($menuTerm->name) )
            {
                $className = cssFriendlyString($menuTerm->field_page_title['und'][0]['value']);
                if ( !empty($active_tids[$menuTerm->tid]) )
                {
                    $activeMenuTid = $menuTerm->tid;
                    $className .= ' active-trail';
                }
                $className .= ' menuTerm-'.$menuTerm->tid;
                $title     = $menuTerm->field_page_title['und'][0]['value'];
                $url       = $menuTerm->field_friendly_url['und'][0]['value'];
                ?><li class="<?php echo $className ?>"><a href="<?php echo $url ?>"><?php echo $title ?></a></li><?php
            }
        }
?>
        </ul>
    </div>
</div>


    <div id="main">
        <div class="menu-block-wrapper menu-block-2 menu-level-2">
            <ul class="menu">
    <?php
            $children = taxonomy_get_children($activeMenuTid);
            foreach ( $children as $child_tid=>$child ):
                if ( isset($child->field_generate_menu['und'][0]['value'])
                  && $child->field_generate_menu['und'][0]['value']!=="yes" )
                {
                    continue;
                }
                $className = cssFriendlyString($child->field_page_title['und'][0]['value']);
                if ( !empty($active_tids[$child->tid]) )
                {
                    $className .= ' active-trail';
                }
                $title     = $child->field_page_title['und'][0]['value'];
                $url       = $child->field_friendly_url['und'][0]['value'];
                if ( $url{0}!='/' )
                {
                    $parse = ctac_parse_url($url);
                    if ( empty($parse['scheme']) )
                    {
                        $url = '/'.$url;
                    }
                }
                ?><li class="<?php echo $className ?>"><a href="<?php echo $url ?>"><?php echo $title ?></a></li><?php
            endforeach;
    ?>
            </ul>
        </div>



    <!-- [Error] Messages (including DSM statements) will only show to the admin  -->
    <?php if($is_admin): ?>
      <?php print $messages; ?>
    <?php endif; ?>

      <div id="content" class="column">
        <div class="section">
          <a id="main-content"></a>
          <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
          <?php print render($page['help']); ?>
          <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
          <?php print render($page['content']); ?>
        </div>
      </div>

    </div>


    <div id="footer">
      <div class="section">
        <ul class="logos">
          <li><a href="http://connect.usa.gov/kids-subscribe"><img alt="Logo Email Footer" border="" height="39" imgtype="_full" src="/sites/all/themes/kids/images/Logo_Email_Footer.png" width="41"></a></li>
          <li><a href="https://www.youtube.com/kidsgov" target="_blank" title="Watch Our YouTube Channel"><img alt="Kids.gov YouTube Channel" height="39" src="/sites/all/themes/kids/images/Logo_Youtube_Footer.png" title="Youtube" width="41"></a></li>
          <li><a href="https://twitter.com/kidsgov" target="_blank" title="Follow Kids.gov on Twitter"><img alt="Follow Kids.gov on Twitter" height="39" src="/sites/all/themes/kids/images/Logo_Twitter_Footer.png" title="Twitter" width="41"></a></li>
         <!-- <li><a href="https://www.facebook.com/kidsgov" target="_blank" title="Kids.gov Facebook Page"><img alt="Kids.gov Facebook Page" height="39" src="/sites/all/themes/kids/images/Logo_Facebook_Footer.png" title="Facebook" width="41"></a></li> -->
          <li><a href="https://pinterest.com/kidsgov/"><img alt="Pinterest" height="39" src="/sites/all/themes/kids/images/Logo_Pinterest_Footer.png" title="Pinterest" width="41"></a></li>
        </ul>
        <ul>
          <li><a href="/about-us/index.shtml" title="About Us">About Us</a></li>
          <li><a href="/about-us/contact-us/index.shtml" title="Contact Us">Contact Us</a></li>
          <li><a href="/about-us/site-map/index.shtml" title="Site Map">Site Index</a></li>
          <li><a href="/about-us/link-to-us/index.shtml" title="Link to Us">Link to Us</a></li>
          <li><a href="/about-us/privacy/index.shtml" title="Privacy">Privacy</a></li>
          <li><a href="/about-us/website-policies/index.shtml" title="Website Policies">Website Policies</a></li>
        </ul>
        <p>Government Information for Kids, Parents and Teachers</p>
      </div>
      <div class="poweredby">
        <p><a href="https://www.usa.gov/explore">Brought to you by <img alt="USAgov" src="/sites/all/themes/kids/images/Logo_USAgov_Footer.png"></a></p>
      </div>

    </div>
  </div>
</div>
