<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php foreach ($rows as $id => $row): ?>
  <article>
    <?php print $row; ?>
    <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
  </article>
<?php endforeach; ?>