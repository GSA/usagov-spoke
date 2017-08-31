<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
	<nav aria-label="Topic" class="leftnav">
		<section>
			<div class="shade"> 
			  <?php print render($title_prefix); ?>
			  <?php if ($title): ?>
			    <header><h2 itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" <?php print $title_attributes; ?>><label for="postsByDate"><?php print $title; ?></label></h2></header>
			  <?php endif; ?>
			  <?php print render($title_suffix); ?>
			  <?php print $content; ?>
			</div>
		</section>
	</nav>
</div>