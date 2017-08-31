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

?>

  <?php if ($rows): ?>
        <div id="featurelist">
          <h2><?php print t('You might also like'); ?>&nbsp;…</h2>
    <?php print "<ul>" . $rows . "</ul>"; ?>
        </div>
        <div class="row">
          <div class="col-md-4 col-md-offset-8 col-sm-6 col-sm-offset-6 col-xs-8 col-xs-offset-4"> 
            <?php if ( stripos($siteName, 'gobi') !== false ): ?>
              <a href="/novedades" class="featuremore">
                Ver más novedades<span></span>
              </a>
            <?php else: ?>
              <a href="/features" class="featuremore">
                See More Features<span></span>
              </a>
            <?php endif; ?>
          </div>
        </div>
        <p class="volver clearfix">
          <a href="#skiptarget">
            <span class="icon-backtotop-dwnlvl">
              <?php print t('Back to Top'); ?>
            </span>
          </a>
        </p>
  <?php endif; ?>

