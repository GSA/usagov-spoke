<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */

$siteName = variable_get('site_name', 'UNKNOWN');

// Determin what language to use with the left-sidebar's title
if ( stripos($siteName, 'Gobi') !== false ) {
    $sidebarTitleText = 'Medios y colaboradores';
    $sidebarTitleLink = '/medios';
} else {
    $sidebarTitleText = 'For Media and Partners';
    $sidebarTitleLink = '/media';
}

// Determin what language to use with the left-sidebar's first item
if ( stripos($siteName, 'Gobi') !== false ) {
    $sidebarItem1Text = 'Colabore con nosotros';
    $sidebarItem1Link = '/colabore-con-nosotros';
} else {
    $sidebarItem1Text = 'Features';
    $sidebarItem1Link = '/features';
}

// Determin what language to use with the left-sidebar's second item
if ( stripos($siteName, 'Gobi') !== false ) {
    $sidebarItem2Text = 'Novedades';
    $sidebarItem2Link = '/novedades';
} else {
    $sidebarItem2Text = 'Partner with Us';
    $sidebarItem2Link = '/partner-with-us';
}

?>
<div class="term-listing-heading">
    <nav aria-label="Topic" class="col-md-3 leftnav">
        <section>
            <div class="mrtp clearfix">
                <button id="leftnav-toggle" type="button">
                    <div class="bttn">
                        <header>
                            <h2 id=""><?php print t('More Topics in this Section'); ?></h2>
                        </header>
                    </div>
                    <div class="mrtpc"></div>
                </button>
            </div>


            <div class="shade dwn" aria-expanded="false">
                <header>
                    <h2 itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                        <a itemprop="url" href="<?php print $sidebarTitleLink; ?>"><span itemprop="title">
              <?php print $sidebarTitleText; ?>
            </span></a>
                    </h2>
                </header>
                <ul>
                    <?php if ( stripos($siteName, 'Gobi') !== false ) : ?>
                <li >
                <a href="<?php print $sidebarItem1Link; ?>">
                    <?php print $sidebarItem1Text; ?>
                </a>
                <?php else: ?>
                    <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" class="slctd">
                        <a href="<?php print $sidebarItem1Link; ?>">
              <span itemprop="title">
                <?php print $sidebarItem1Text; ?>
              </span>
                        </a>
                        <?php endif ?>
                    </li>

                    <?php if ( stripos($siteName, 'Gobi') !== false ) : ?>
                    <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" class="slctd">
                        <a href="<?php print $sidebarItem2Link; ?>">
              <span itemprop="title">
                <?php print $sidebarItem2Text; ?>
              </span>
                        </a>
                        <?php else: ?>
                    <li >
                        <a href="<?php print $sidebarItem2Link; ?>">
                            <?php print $sidebarItem2Text; ?>
                        </a>
                        <?php endif ?>
                    </li>
                </ul>
            </div>
        </section>
    </nav>
    <!---right container-->
    <div class="col-md-9 col-sm-12 rightnav">
        <header>
            <h1><?php print t('Features'); ?></h1>
        </header>
        <p><?php print t('You\'re invited to read and use our bilingual articles covering trusted, timely, and valuable government information.'); ?></p>
        <ul id="features-landing">
            <?php if ($rows): ?>
                <?php print $rows; ?>
            <?php endif; ?>
        </ul>


        <?php if ($pager): ?>
            <?php print $pager; ?>
        <?php endif; ?>

        <p class="volver clearfix"></p>
        <?php print _print_social_media(); ?>
        <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
    </div>
</div>

























