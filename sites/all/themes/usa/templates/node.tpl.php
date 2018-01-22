<?php
/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 *
 * @ingroup themeable
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

//translating months to spanish
if ( stripos($siteName, 'Gobi') !== false ) {
    $labelText_DateValue = str_replace("January","enero",$labelText_DateValue);
    $labelText_DateValue = str_replace("February","febrero",$labelText_DateValue);
    $labelText_DateValue = str_replace("March","marzo",$labelText_DateValue);
    $labelText_DateValue = str_replace("April","abril",$labelText_DateValue);
    $labelText_DateValue = str_replace("May","mayo",$labelText_DateValue);
    $labelText_DateValue = str_replace("June","junio",$labelText_DateValue);
    $labelText_DateValue = str_replace("July","julio",$labelText_DateValue);
    $labelText_DateValue = str_replace("August","agosto",$labelText_DateValue);
    $labelText_DateValue = str_replace("September","septiembre",$labelText_DateValue);
    $labelText_DateValue = str_replace("October","octubre",$labelText_DateValue);
    $labelText_DateValue = str_replace("November","noviembre",$labelText_DateValue);
    $labelText_DateValue = str_replace("December","diciembre",$labelText_DateValue);
}

// check to see if node has 'Feature' in the for use by field.
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

if ( ( !empty($node->field_for_use_by_text) && in_array_r('Feature', $node->field_for_use_by_text) )
    || ( !empty($node->field_for_use_by)      && in_array_r('Feature', $node->field_for_use_by) ) ):

    //get media associated with feature node
    $mediaImage = [];
    $mediaVideo = [];
    $mediaLink = false;
    if ( !empty($node->field_related_multimedia_two) ) {
        foreach($node->field_related_multimedia_two['und'] as $mediaItems){

            $mediaItem = node_load($mediaItems['target_id']);

            //create image
            if($mediaItem->field_media_type['und'][0]['value'] == 'Image'){
                if(!empty($mediaItem->field_file_media_url['und'][0]['value'])){
                    $mediaImage['url'] = $mediaItem->field_file_media_url['und'][0]['value'];
                }
                if(!empty($mediaItem->field_alt_text['und'][0]['value'])){
                    $mediaImage['alt'] = $mediaItem->field_alt_text['und'][0]['value'];
                }
            }

            //image
            if($mediaItem->field_media_type['und'][0]['value'] == 'Image'){
                if(!empty($mediaItem->field_file_media_url['und'][0]['value'])){
                    $mediaLink = $mediaItem->field_file_media_url['und'][0]['value'];
                }
            }


            //image caption
            if(!empty($mediaItem->field_image_caption['und'][0]['value'])){
                $mediaCaption = '<figcaption>' . $mediaItem->field_image_caption['und'][0]['value'] . '</figcaption>';
            } else {
                $mediaCaption = '';
            }



            //create video
            if($mediaItem->field_media_type['und'][0]['value'] == 'Video'){
                if(!empty($mediaItem->field_embed_code['und'][0]['value'])){
                    $mediaVideo['embed_code'] = $mediaItem->field_embed_code['und'][0]['value'];
                }
                if(!empty($mediaItem->field_transcript['und'][0]['value'])){
                    $mediaVideo['transcript'] = $mediaItem->field_transcript['und'][0]['value'];
                }
            }
        }
    }

    //get asset terms associated with feature node
    if( !empty($node->field_asset_topic_taxonomy) ){
        $assetTerms = array();
        foreach($node->field_asset_topic_taxonomy['und'] as $item){
            $assetTerms[] = $item['tid'];
        }
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
                        <li >
                            <a href="<?php print $sidebarItem1Link; ?>">

                                <?php print $sidebarItem1Text; ?>

                            </a>
                        </li>
                        <li >
                            <a href="<?php print $sidebarItem2Link; ?>">

                                <?php print $sidebarItem2Text; ?>

                            </a>
                        </li>
                    </ul>
                </div>
            </section>
        </nav>
        <!---right container-->
        <div class="col-md-9 col-sm-12 rightnav">
            <header>
                <?php if(!empty($node->title)): ?>
                    <h1><?php print $node->title; ?></h1>
                <?php endif; ?>
            </header>

            <?php
            $isForTeachers = false;
            if (!empty($node->field_asset_topic_taxonomy['und'])){
                foreach($node->field_asset_topic_taxonomy['und'] as $item){
                    if(!empty($item['tid'])){

                        $assetTerm = taxonomy_term_load($item['tid']);

                        if($assetTerm->name == 'For Teachers Sticker'){
                            $isForTeachers = true;
                        }
                    }
                }
            }
            if($isForTeachers == true){
                print '<span><img src="/sites/all/themes/usa/images/Sticker_Teachers.png" alt="for teachers"></span>';
            }
            ?>

            <div id="pipe">
                <div class="by">
                    <?php if(!empty($node->field_blog_owner['und'][0]['value'])): ?>
                        <div class="line">
            <span class="bylinebld">
              <?php print $labelText_By; ?>
            </span>
                            <?php print $node->field_blog_owner['und'][0]['value']; ?>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($labelText_DateValue)):  ?>
                        <div class="line">
            <span class="bylinebld">
              <?php print $labelText_DateLabel; ?>
            </span>
                            <?php print $labelText_DateValue; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div>


                <?php if ($mediaImage): ?>
                    <?php if($mediaLink != false): ?>
                        <span class="fea-img-cont col-md-6 col-sm-12"><figure class="fea-cntntmddl-img"><a href="<?php print $mediaLink ?>"><img class="fea-img" src="<?php print $mediaImage['url']; ?>" alt="<?php print $mediaImage['alt']; ?>"><?php print $mediaCaption; ?></a></figure></span>
                    <?php else: ?>
                        <span class="fea-img-cont col-md-6 col-sm-12"><figure class="fea-cntntmddl-img"><img class="fea-img" src="<?php print $mediaImage['url']; ?>" alt="<?php print $mediaImage['alt']; ?>"><?php print $mediaCaption; ?></figure></span>
                    <?php endif; ?>
                <?php endif; ?>



                <?php if(!empty($node->body['und'][0]['value'])): ?>
                    <?php
                    $row = $node->body['und'][0]['value'];
                    $row_changed = str_ireplace("<h3>", "<header><h2>", $row);
                    $row_changed = str_ireplace("<h3 ", "<header><h2 ", $row_changed);
                    $row_changed = str_ireplace("</h3>", "</h2></header>", $row_changed);

                    $row_changed = str_ireplace("<h4>", "<h3>", $row_changed);
                    $row_changed = str_ireplace("<h4 ", "<h3 ", $row_changed);
                    $row_changed = str_ireplace("</h4>", "</h3>", $row_changed);

                    print $row_changed;
                    ?>
                <?php endif; ?>
                <?php if (!empty($node->field_html['und'][0]['value'])): ?>
                    <?php print $node->field_html['und'][0]['value']; ?>
                <?php endif; ?>

                <?php if ($mediaVideo['embed_code']): ?>
                    <div id="" class="embed"> <!-- video embed -->
                        <?php print $mediaVideo['embed_code']; ?>
                    </div>
                <?php endif; ?>
            </div>


            <?php if($mediaVideo['transcript']): ?>
                <div class="clearfix">
                    <article>
                        <ul class="usa-accordion-bordered">
                            <li class="transcript_img">
                                <button class="usa-accordion-button" data-toggledtext="Hide the Video Transcript" data-initialtext="Show the Video Transcript" aria-expanded="false" aria-controls="amendment-b-1">
                                    <?php print t('Show the Video Transcript'); ?>
                                </button>
                                <div id="amendment-b-1" class="usa-accordion-content" aria-hidden="true">
                                    <?php print $mediaVideo['transcript']; ?>
                                </div>
                            </li>
                        </ul>
                    </article>
                </div>
            <?php endif; ?>



            <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>

            <?php if(!empty($assetTerms)): ?>

                <?php print views_embed_view('feature_related_block', 'block', implode('+',$assetTerms), $node->nid); ?>

            <?php endif; ?>


            <?php print survey_on_pages(); ?>
        </div>
    </div>

<?php else: ?>

    <div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

        <?php print $user_picture; ?>

        <?php print render($title_prefix); ?>
        <?php if (!$page): ?>
            <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
        <?php endif; ?>
        <?php print render($title_suffix); ?>

        <?php if ($display_submitted): ?>
            <div class="submitted">
                <?php print $submitted; ?>
            </div>
        <?php endif; ?>

        <div class="content"<?php print $content_attributes; ?>>
            <?php
            // We hide the comments and links now so that we can render them later.
            hide($content['comments']);
            hide($content['links']);
            print render($content);
            ?>
        </div>

        <?php print render($content['links']); ?>

        <?php print render($content['comments']); ?>

    </div>
<?php endif; ?>
