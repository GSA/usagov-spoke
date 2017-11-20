<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * A QUICK OVERVIEW OF DRUPAL THEMING
 *
 *   The default HTML for all of Drupal's markup is specified by its modules.
 *   For example, the comment.module provides the default HTML markup and CSS
 *   styling that is wrapped around each comment. Fortunately, each piece of
 *   markup can optionally be overridden by the theme.
 *
 *   Drupal deals with each chunk of content using a "theme hook". The raw
 *   content is placed in PHP variables and passed through the theme hook, which
 *   can either be a template file (which you should already be familiary with)
 *   or a theme function. For example, the "comment" theme hook is implemented
 *   with a comment.tpl.php template file, but the "breadcrumb" theme hooks is
 *   implemented with a theme_breadcrumb() theme function. Regardless if the
 *   theme hook uses a template file or theme function, the template or function
 *   does the same kind of work; it takes the PHP variables passed to it and
 *   wraps the raw content with the desired HTML markup.
 *
 *   Most theme hooks are implemented with template files. Theme hooks that use
 *   theme functions do so for performance reasons - theme_field() is faster
 *   than a field.tpl.php - or for legacy reasons - theme_breadcrumb() has "been
 *   that way forever."
 *
 *   The variables used by theme functions or template files come from a handful
 *   of sources:
 *   - the contents of other theme hooks that have already been rendered into
 *     HTML. For example, the HTML from theme_breadcrumb() is put into the
 *     $breadcrumb variable of the page.tpl.php template file.
 *   - raw data provided directly by a module (often pulled from a database)
 *   - a "render element" provided directly by a module. A render element is a
 *     nested PHP array which contains both content and meta data with hints on
 *     how the content should be rendered. If a variable in a template file is a
 *     render element, it needs to be rendered with the render() function and
 *     then printed using:
 *       <?php print render($variable); ?>
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. With this file you can do three things:
 *   - Modify any theme hooks variables or add your own variables, using
 *     preprocess or process functions.
 *   - Override any theme function. That is, replace a module's default theme
 *     function with one you write.
 *   - Call hook_*_alter() functions which allow you to alter various parts of
 *     Drupal's internals, including the render elements in forms. The most
 *     useful of which include hook_form_alter(), hook_form_FORM_ID_alter(),
 *     and hook_page_alter(). See api.drupal.org for more information about
 *     _alter functions.
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   If a theme hook uses a theme function, Drupal will use the default theme
 *   function unless your theme overrides it. To override a theme function, you
 *   have to first find the theme function that generates the output. (The
 *   api.drupal.org website is a good place to find which file contains which
 *   function.) Then you can copy the original function in its entirety and
 *   paste it in this template.php file, changing the prefix from theme_ to
 *   mars_. For example:
 *
 *     original, found in modules/field/field.module: theme_field()
 *     theme override, found in template.php: mars_field()
 *
 *   where neptune is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_field() function.
 *
 *   Note that base themes can also override theme functions. And those
 *   overrides will be used by sub-themes unless the sub-theme chooses to
 *   override again.
 *
 *   Zen core only overrides one theme function. If you wish to override it, you
 *   should first look at how Zen core implements this function:
 *     theme_breadcrumbs()      in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called theme hook suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node--forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and theme hook suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440 and http://drupal.org/node/1089656
 */

function mars_theme($existing, $type, $theme, $path) {

    return array(
        'blog_sidebar' => array( /* implements: print theme('blog_sidebar'); */
            'template' => 'blog_sidebar', /* template file called blog_sidebar.tpl.php */
            'path' => drupal_get_path('theme', 'mars').'/templates', /* expect this .tpl file to exsist in the template directory */
            'arguments' => array( /* the default values sent to the .tpl file, will be overridden by preprocessor */
                'topics' => array(),
                'postDateOptions' => array(),
            ),
        )
    );

}

/* Preprocessor for blog_sidebar.tpl.php */
function mars_preprocess_blog_sidebar(&$variables) {

    // Get all terms under the Asset-Topic vocab, which are usd as "Blog Topics" on this site
    $vocab = taxonomy_vocabulary_machine_name_load('asset_topic_taxonomy');
    $terms = taxonomy_get_children(11279);

    // Filter out blog-Topics that are not in use
    foreach ( $terms as $index => $term ) {

        // Get a count of how many nodes use this term in the asset_topic_taxonomy field
        $nodeUsageCount = db_query("
      SELECT COUNT(*) AS 'count'
      FROM field_data_field_asset_topic_taxonomy
      WHERE
        entity_type = 'node'
        AND field_asset_topic_taxonomy_tid = {$term->tid}
    ")->fetchColumn();

        // If no nodes are using this blog-topic (Asset Topic)...
        if ( intval($nodeUsageCount) === 0 ) {

            // ...then remove it from this list
            unset($terms[$index]);
        }
    }

    // Supply this information to the blog_sidebar.tpl.php
    $variables['topics'] = array();
    foreach ( $terms as $term ) {

        // if ( intval($term->depth) > 0 ) { // ignore the root-term ("Blog.USA.Gov")

        $urlFriendlyName = trim( strtolower($term->name) );
        $urlFriendlyName = str_replace(array('_',' ','.','/'), '-', $urlFriendlyName);
        $variables['topics'][] = array(
            'title' => $term->name,
            'url' => '/'.$urlFriendlyName,
        );
        //}
    }

    // Alphabetize the topic-list
    foreach ( $variables['topics'] as $key => $value ) {
        $variables['topics'][$value['title']] = $value;
        unset($variables['topics'][$key]);
    }
    ksort($variables['topics']);
    $variables['topics'] = array_values($variables['topics']);


    // Get all the options to show under the "Posts by Date" dropdown
    $inUsePostDates = db_query("
    SELECT
      MONTH( FROM_UNIXTIME(field_blog_pub_date_value) ) AS 'month',
      YEAR( FROM_UNIXTIME(field_blog_pub_date_value) ) AS 'year'
    FROM node n
    LEFT JOIN field_data_field_blog_pub_date p ON ( p.entity_id = n.nid )
    WHERE n.type = 'text_content_type'
    ORDER BY field_blog_pub_date_value
  ");

    // Supply all the options to show under the "Posts by Date" dropdown to blog_sidebar.tpl.php
    $variables['postDateOptions'] = array();
    foreach ( $inUsePostDates as $inUsePostDate ) {
        if ( !empty($inUsePostDate->month) && !empty($inUsePostDate->year) ) {
            $optionValue = $inUsePostDate->month.'/'.$inUsePostDate->year;
            $optionLabel = date('F', mktime(0, 0, 0, $inUsePostDate->month, 10)) . ', ' . $inUsePostDate->year;
            $variables['postDateOptions'][$optionValue] = $optionLabel;
        }
    }

}

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
function mars_preprocess_html(&$variables, $hook) {
    // Add additional body classes depending upon the layout.
    $layout = theme_get_setting('mars_layout');
    switch ($layout) {
        case '1':
            $variables['classes_array'][] = 'sidebar-right';
            $variables['classes_array'][] = 'multi-column';
            break;
        case '2':
            $variables['classes_array'][] = 'sidebar-left';
            $variables['classes_array'][] = 'multi-column';
            break;
    }
}

/**
 * Override or insert variables in the html_tag theme function.
 *
 * Remove 'type' and 'media="all"' from stylesheet <link>s because:
 * - they are redundant in HTML5
 * - this has the added advantage of counteracting IE8/respond.js's
 *   random mis-parsing of aggregated CSS
 */
function mars_process_html_tag(&$variables) {
    $tag = &$variables['element'];
    if ($tag['#tag'] == 'link' && $tag['#attributes']['rel'] == 'stylesheet') {
        // Remove redundant type attribute.
        unset($tag['#attributes']['type']);
        // Remove media="all" but leave others unaffected.
        if (isset($tag['#attributes']['media']) && $tag['#attributes']['media'] === 'all') {
            unset($tag['#attributes']['media']);
        }
    }
}

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function mars_preprocess_page(&$variables, $hook) {

    // Determin the Description meta-tag to use whith this page
    $ruri = strtok(request_uri(), '?'); // The usage of strtok() strips URL-queries
    $ruriWords = explode('/', trim($ruri, '/'));
    if ( !empty($variables['node']) ) {

        /* then we are on a node landing page, we shall assume we are
        on a Blog-post (text-asset) landing page */

        $node = $variables['node'];
        if ( !empty($node->field_description['und'][0]['value']) ) {
            $metaDescription = $node->field_description['und'][0]['value'];
        } else {
            $metaDescription = $node->title;
        }

    } elseif ( $ruri === '/' || $ruri === '/node' ) {

        // then we are on the front page
        $metaDescription = 'USAGov is working to create the digital front door for the '
            .'United States government. Follow our progress and help us learn as we go.';

    } elseif ( count($ruriWords) === 2 && intval($ruriWords[0]) !== 0 && intval($ruriWords[1]) !== 0 ) {

        // then we are on a month-listing page, like <site>/10/2015
        $humanMonth = date('F', mktime(0, 0, 0, $ruriWords[0], 10));
        $yearSelected = $ruriWords[1];
        $metaDescription = "USAGov blog posts from {$humanMonth}, ".$yearSelected;

    } elseif ( substr(drupal_get_title(), 0, 14) === 'Posts by Topic' ) {

        // then we are on a listing-page that filters by a selected topic
        $selectedTopic = trim($ruri, '/');
        $selectedTopic = str_replace('-', ' ', $selectedTopic);
        $selectedTopic = ucwords($selectedTopic);
        $metaDescription = "Find the latest {$selectedTopic} posts from the USAGov blog";

    } else {

        // then I dunno what to do about a meta-description
        $metaDescription = false;

    }

    // Add the Description meta-tag into this page
    if ( $metaDescription !== false ) {

        drupal_add_html_head(
            array(
                '#tag' => 'meta',
                '#attributes' => array(
                    'name' => 'description',
                    'content' =>  $metaDescription,
                )
            ),
            'usablog_custom_metatag_description'
        );
    }

    // Override the By-Topic View to have a title specifying the selected topic
    if ( substr(drupal_get_title(), 0, 14) === 'Posts by Topic' ) {

        // then we are on a listing-page that filters by a selected topic
        $selectedTopic = trim($ruri, '/');
        $selectedTopic = str_replace('-', ' ', $selectedTopic);
        $selectedTopic = ucwords($selectedTopic);

        drupal_set_title('Posts by Topic: '.$selectedTopic);
    }

    // Retrieve the theme setting value for 'mars_layout'.
    $layout = theme_get_setting('mars_layout');
    // If either the right sidebar or left sidebar layout is selected set
    // multi_column equal to TRUE.
    $variables['multi_column'] = ($layout == '1' || $layout == '2') ? TRUE : FALSE;

    // Retrieve the theme setting value for 'mars_max_width' and construct the
    // max-width HTML.
    $max_width = theme_get_setting('mars_max_width') . 'px';
    $variables['max_width'] = 'style="max-width:' . $max_width . '"';

    // Retrieve the theme setting value for 'mars_display_main_menu'.
    $variables['display_main_menu'] = theme_get_setting('mars_display_main_menu');

    // Default Head-HTML for the site should we fail to retrieve the Head-HTML from a taxonomy-term
    $variables['pageHeadHTML'] = '
    <header id="header" role="banner">
      <h1>Error - No homepage Site-Structure taxonomy-term found in this environment!</h1>
    </header>
  ';

    // Default End-HTML for the site should we fail to retrieve the End-HTML from a taxonomy-term
    $variables['pageEndHTML'] = '
    <header id="header" role="banner">
      <h1>Error - No homepage Site-Structure taxonomy-term found in this environment!</h1>
    </header>
  ';

    // Retrieve the taxonomy-term-ID that represents the entire-site/home-page
    $homeTid = db_query("
    SELECT entity_id
    FROM field_data_field_type_of_page_to_generate
    WHERE
      entity_type = 'taxonomy_term'
      AND field_type_of_page_to_generate_value = 'home'
    LIMIT 1
  ")->fetchColumn();

    // Retrieve the taxonomy-term that represents the entire-site/home-page
    $homeTerm = false;
    if ( $homeTid ) {
        $homeTerm = taxonomy_term_load( intval($homeTid) );
    }

    // Retrieve the Head-HTML from this top-level S.S.-taxonomy-term
    if ( $homeTerm && !empty($homeTerm->field_head_html['und'][0]['value']) ) {
        $variables['pageHeadHTML'] = $homeTerm->field_head_html['und'][0]['value'];
    }

    // Retrieve the End-HTML from this top-level S.S.-taxonomy-term
    if ( $homeTerm && !empty($homeTerm->field_end_html['und'][0]['value']) ) {
        $variables['pageEndHTML'] = $homeTerm->field_end_html['und'][0]['value'];
    }

}

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function mars_preprocess_node(&$variables, $hook) {

    // Override what the template things a node's creation time is
    $node = $variables['node'];
    if ( !empty($node->field_blog_pub_date['und'][0]['value']) ) {
        $variables['node']->created = intval($node->field_blog_pub_date['und'][0]['value']);
        $variables['node']->changed = intval($node->field_blog_pub_date['und'][0]['value']);
    }

    // Modify Zen's default pubdate output.
    $variables['pubdate'] = format_date($variables['node']->created, 'custom', 'jS F, Y');

    // Override the author of this node with the value in the "By-Line" field
    $node = $variables['node'];
    if ( !empty($node->field_blog_owner['und'][0]['value']) ) {
        $variables['name'] = $node->field_blog_owner['und'][0]['value'];
    }

    // Remove 'Submitted by ' and insert a middot.
    if ($variables['display_submitted']) {
        //$variables['submitted'] = t('!username &middot; !datetime', array('!username' => $variables['name'], '!datetime' => $variables['pubdate']));
        $variables['submitted'] = "
      <div class=\"by line\"><strong>By:</strong> {$variables['name']}</div>
      <div class=\"line\"><strong>Date:</strong> {$variables['pubdate']}</div>
    ";
    }

    // Give the node--text-content-type.tpl.php template the image-source fo the related-multimedia item
    $node = $variables['node'];
    $variables['relatedImageSrc'] = false;
    $variables['relatedImageAlt'] = '';
    if ( !empty($node->field_related_multimedia_two['und'][0]['target_id']) ) {
        $mediaNid = intval( $node->field_related_multimedia_two['und'][0]['target_id'] );
        $mediaNode = node_load($mediaNid);
        if ( !empty($mediaNode) ) {
            if ( !empty($mediaNode->field_file_media_url['und'][0]['value']) ) {
                $variables['relatedImageSrc'] = $mediaNode->field_file_media_url['und'][0]['value'];
            }
            if ( !empty($mediaNode->field_alt_text['und'][0]['value']) ) {
                $variables['relatedImageAlt'] = $mediaNode->field_alt_text['und'][0]['value'];
            }
        }
    }


    //get media associated with feature node
    $mediaImage = [];
    $mediaVideo = [];
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
    $variables['mediaImage'] = $mediaImage;
    $variables['mediaVideo'] = $mediaVideo;





    // Heading-check: If there are no H2s in this body-field,but there are H3, they must be converted to H2s
    if ( $node->type === 'text_content_type' ) {
        $body = $node->body['und'][0]['value'];

    } else if ( isset($node->field_html)
        && isset($node->field_html['und'])
        && isset($node->field_html['und'][0])
        && isset($node->field_html['und'][0]['value']) )
    {
        $body = $node->field_html['und'][0]['value'];

    } else {
        $body = '<!-- no content -->';

    }
    if ( stripos($body, '<h2') === false && stripos($body, '<h3') !== false ) {

        // Convert H3s => H2s, H4s => H3s, [etc.]
        for ( $h = 3 ; $h < 10; $h++ ) {
            $body = str_ireplace('<h'.$h, '<h'.($h-1), $body);
            $body = str_ireplace('</h'.$h, '</h'.($h-1), $body);
        }
    }
    if ( $node->type === 'text_content_type' ) {
        $node->body['und'][0]['value'] = $body;
    } else {
        $node->field_html['und'][0]['value'] = $body;
    }

}

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
function mars_preprocess_comment(&$variables, $hook) {
    // Modify Zen's default pubdate output.
    $variables['pubdate'] = '<time pubdate datetime="' . format_date($variables['comment']->created, 'custom', 'c') . '">' . format_date($variables['comment']->created, 'custom', 'jS F, Y') . ' &middot; ' . format_date($variables['comment']->created, 'custom', 'g:ia') . '</time>';

    // Replace 'replied on' with a middot.
    $variables['submitted'] = t('!username &middot; !datetime', array('!username' => $variables['author'], '!datetime' => $variables['pubdate']));
}

/**
 * Override status messages.
 *
 * Insert a 'messages-inner' div.
 */
function mars_status_messages($variables) {
    $display = $variables['display'];
    $output = '';

    $status_heading = array(
        'status' => t('Status message'),
        'error' => t('Error message'),
        'warning' => t('Warning message'),
    );
    foreach (drupal_get_messages($display) as $type => $messages) {
        $output .= "<div class=\"messages $type\"><div class=\"messages-inner\">\n";
        if (!empty($status_heading[$type])) {
            $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
        }
        if (count($messages) > 1) {
            $output .= " <ul>\n";
            foreach ($messages as $message) {
                $output .= '  <li>' . $message . "</li>\n";
            }
            $output .= " </ul>\n";
        }
        else {
            $output .= $messages[0];
        }
        $output .= "</div></div>\n";
    }
    return $output;
}

function mars_menu_link__menu_topics($variables) {
    $element = $variables['element'];
    unset($element['#attributes']['class']);
    $output = l($element['#title'], $element['#href'], $element['#localized_options']);
    return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . "</li>\n";
}

function mars_menu_link__menu_sign_up_for_updates($variables) {
    $element = $variables['element'];
    unset($element['#attributes']['class']);
    $output = l($element['#title'], $element['#href'], $element['#localized_options']);
    return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . "</li>\n";
}

function mars_field__field_text_asset_body__text_asset($variables) {
    $headingsConverted = $variables['items'][0]['#markup'];
    $headingsConverted = str_replace("h3>", "h2>", $headingsConverted);
    $headingsConverted = str_replace("h4>", "h3>", $headingsConverted);
    $variables['items'][0]['#markup'] = $headingsConverted;
    $output = '';

    // Render the label, if it's not hidden.
    if (!$variables ['label_hidden']) {
        $output .= '<div class="field-label"' . $variables ['title_attributes'] . '>' . $variables ['label'] . ':&nbsp;</div>';
    }

    // Render the items.
    $output .= '<div class="field-items"' . $variables ['content_attributes'] . '>';
    foreach ($variables ['items'] as $delta => $item) {
        $classes = 'field-item ' . ($delta % 2 ? 'odd' : 'even');
        $output .= '<div class="' . $classes . '"' . $variables ['item_attributes'][$delta] . '>' . drupal_render($item) . '</div>';
    }
    $output .= '</div>';

    // Render the top-level DIV.
    $output = '<div class="' . $variables ['classes'] . '"' . $variables ['attributes'] . '>' . $output . '</div>';

    return $output;
}

function mars_pager($variables) {
    $tags = $variables['tags'];
    $element = $variables['element'];
    $parameters = $variables['parameters'];
    $quantity = $variables['quantity'];
    global $pager_page_array, $pager_total;

    // Calculate various markers within this pager piece:
    // Middle is used to "center" pages around the current page.
    $pager_middle = ceil($quantity / 2);
    // current is the page we are currently paged to
    $pager_current = $pager_page_array[$element] + 1;
    // first is the first page listed by this pager piece (re quantity)
    $pager_first = $pager_current - $pager_middle + 1;
    // last is the last page listed by this pager piece (re quantity)
    $pager_last = $pager_current + $quantity - $pager_middle;
    // max is the maximum page number
    $pager_max = $pager_total[$element];
    // End of marker calculations.

    // Prepare for generation loop.
    $i = $pager_first;
    if ($pager_last > $pager_max) {
        // Adjust "center" if at end of query.
        $i = $i + ($pager_max - $pager_last);
        $pager_last = $pager_max;
    }
    if ($i <= 0) {
        // Adjust "center" if at start of query.
        $pager_last = $pager_last + (1 - $i);
        $i = 1;
    }
    // End of generation loop preparation.

    $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
    $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));

    if ($pager_total[$element] > 1) {
        if ($li_previous) {
            $items[] = array(
                'class' => array('previous'),
                'data' => $li_previous,
            );
        }

        $current_page_description = "Page " . $pager_current . " of " . $pager_max;
        $items[] = array(
            'class' => array('pager-dscrpt'),
            'data' => $current_page_description,
        );

        // When there is more than one page, create the pager list.
        if ($i != $pager_max) {
            if ($i > 1) {
                $items[] = array(
                    'class' => array('pager-ellipsis'),
                    'data' => '…',
                );
            }
            // Now generate the actual pager piece.
            for (; $i <= $pager_last && $i <= $pager_max; $i++) {
                if ($i < $pager_current) {
                    $items[] = array(
                        'class' => array('pager-item'),
                        'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
                    );
                }
                if ($i == $pager_current) {
                    $items[] = array(
                        'class' => array('current'),
                        'data' => $i,
                    );
                }
                if ($i > $pager_current) {
                    $items[] = array(
                        'class' => array('pager-item'),
                        'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
                    );
                }
            }
            if ($i < $pager_max) {
                $items[] = array(
                    'class' => array('pager-ellipsis'),
                    'data' => '…',
                );
            }
        }
        // End generation.
        if ($li_next) {
            $items[] = array(
                'class' => array('next'),
                'data' => $li_next,
            );
        }
        return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
            'items' => $items,
            'attributes' => array('class' => array('pagination')),
        ));
    }
}

function mars_process_html(&$variables) {
    $url = path_to_theme() . '/js/Universal-Federated-Analytics.1.0.js?agency=GSA&dclink=true';
    $dap_script = array(
        '#type' => 'markup',
        '#markup' => '<script type="text/javascript" src="' . $url . '" id="_fed_an_ua_tag"></script>' . "\r",
    );
    $variables['scripts'] .= drupal_render($dap_script);
}
