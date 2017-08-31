<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
   <article>
<?php foreach ($rows as $id => $row): ?>
 
        <?php //print $row; ?>

        <?php 
            $row_changed = str_ireplace("<h3>", "<header><h2>", $row);
            $row_changed = str_ireplace("<h3 ", "<header><h2 ", $row_changed);
            $row_changed = str_ireplace("</h3>", "</h2></header>", $row_changed);

            $row_changed = str_ireplace("<h4>", "<h3>", $row_changed);
            $row_changed = str_ireplace("<h4 ", "<h3 ", $row_changed);
            $row_changed = str_ireplace("</h4>", "</h3>", $row_changed);

            print $row_changed;
        ?>

<?php endforeach; ?>
        <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
    </article>