<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */

?>
<article class="node-<?php print $node->nid; ?> <?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php if ($title_prefix || $title_suffix || $display_submitted || $unpublished || !$page && $title): ?>
    <header>
      <?php print render($title_prefix); ?>
      <?php if (!$page && $title): ?>
        <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
      <?php endif; ?>
      <?php print render($title_suffix); ?>

      <?php if ($display_submitted): ?>
        <div id="pipe">
          <?php print $user_picture; ?>
          <?php print $submitted; ?>
        </div>
      <?php endif; ?>

      <?php if ($unpublished): ?>
        <mark class="unpublished"><?php print t('Unpublished'); ?></mark>
      <?php endif; ?>
    </header>
  <?php endif; ?>

  <?php if ( $mediaImage ): ?>
    <div class="field field-name-field-image field-type-image field-label-hidden">
      <div class="field-items">
        <div class="field-item even">
          <img typeof="foaf:Image" alt="<?php if($mediaImage['alt']){print $mediaImage['alt'];} ?>" src="<?php if($mediaImage['url']){print $mediaImage['url'];} ?>" />
        </div>
      </div>
    </div>
  <?php endif; ?>

  <?php if ( !empty($node->body['und'][0]['value']) ): ?>
    <div class="field field-name-field-text-asset-body field-type-text-long field-label-hidden">
      <div class="field-items">
        <div class="field-item even">
          <?php
          $row_changed = str_ireplace("<h3>", "<header><h2>", $node->body['und'][0]['value']);
          $row_changed = str_ireplace("<h3 ", "<header><h2 ", $row_changed);
          $row_changed = str_ireplace("</h3>", "</h2></header>", $row_changed);

          $row_changed = str_ireplace("<h4>", "<h3>", $row_changed);
          $row_changed = str_ireplace("<h4 ", "<h3 ", $row_changed);
          $row_changed = str_ireplace("</h4>", "</h3>", $row_changed);

          print $row_changed;
          ?>
        </div>
      </div>
    </div>
  <?php endif; ?>


  <?php if ($mediaVideo['embed_code']): ?>
    <div id="" class="embed"> <!-- video embed -->
      <?php print $mediaVideo['embed_code']; ?>
    </div>
  <?php endif; ?>
  
  <?php if($mediaVideo['transcript']): ?>
    <div class="clearfix">
      <header>
        <h3 id="" class="vidscrpt">
          <button> <span class="arrowDwn"><?php print t('Show the Video Transcript'); ?></span> </button>
        </h3>
      </header>
      <div class="transcript">
        <?php print $mediaVideo['transcript']; ?>
      </div>
    </div>
  <?php endif; ?> 


  <?php print render($content['links']); ?>
  <?php print render($content['comments']); ?>

  <?php
    $domain = 'https://blog.usa.gov';
    $options = array();
    $facebookQuery = array(
      'u' => $domain . htmlentities(rtrim(request_uri(),'/'), ENT_QUOTES, "UTF-8"),
      'v' => '3',
      );
    $options['query'] = $facebookQuery;
    $facebookURL = url('http://www.facebook.com/sharer/sharer.php', $options);
    $twitterQuery = array(
      'source' => 'webclient',
      'text' => $title . ' ' . $domain . htmlentities(rtrim(request_uri(),'/'), ENT_QUOTES, "UTF-8"),
      );
    $options['query'] = $twitterQuery;
    $twitterURL = url('http://twitter.com/intent/tweet', $options);
  ?>

  <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotopHP">Back to Top</span></a></p>

  <div>
 	<aside class="sclmedia">
		<div class="container clearfix">
			<div class="spcing">
			<section class="">
			<div class="">
				<header>
					<h2><?php print t('Share This Post:'); ?></h2>
				</header>
				<ul>
					<li><a href="<?php print $facebookURL; ?>" class="sclfcbk"><span>Facebook</span></a></li>
					<li><a href="<?php print $twitterURL; ?>" class="scltwttr"><span>Twitter</span></a></li>
				</ul>
			</div>
			</section>
			</div>
		</div>
	</aside>
	<br/><br/>
 </div>

</article>
