<?php

/**
 * @file
 * Default theme implementation to display a term.
 *
 * Available variables:
 * - $name: (deprecated) The unsanitized name of the term. Use $term_name
 *   instead.
 * - $content: An array of items for the content of the term (fields and
 *   description). Use render($content) to print them all, or print a subset
 *   such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $term_url: Direct URL of the current term.
 * - $term_name: Name of the current term.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - taxonomy-term: The current template type, i.e., "theming hook".
 *   - vocabulary-[vocabulary-name]: The vocabulary to which the term belongs to.
 *     For example, if the term is a "Tag" it would result in "vocabulary-tag".
 *
 * Other variables:
 * - $term: Full term object. Contains data that may not be safe.
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $page: Flag for the full page state.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the term. Increments each time it's output.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_taxonomy_term()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>
<div id="taxonomy-term-<?php print $term->tid; ?>" class="<?php print $classes; ?>">

<?php

// If there is a "Meta Description" set for this page, create the meta-tag
if ( !empty($term->field_description_meta['und'][0]['value']) ) {

    drupal_add_html_head(
        array(
            '#tag' => 'meta',
            '#attributes' => array(
                'name' => 'description',
                'content' =>  trim($term->field_description_meta['und'][0]['value']),
                'CoderBookmark' => 'CB-W860YKW-BC'
            )
        ),
        'kids_meta_description'
    );
}

/*********************************************
 **********************************************
 **											**
 **		print items for NAVIGATION PAGES 	**
 **											**
 **********************************************
 *********************************************/

if (isset($term->field_type_of_page_to_generate['und'][0]['value']) && $term->field_type_of_page_to_generate['und'][0]['value'] == "generic-navigation-page"){

    print '<div class="generic-navigation-page">';
    // print out the carousel
    if (isset($term->field_asset_order_carousel) && count($term->field_asset_order_carousel) > 0){
        print '<div class="carousel-block">';
        $sidebarItems = [];
        $rows = $term->field_asset_order_carousel['und'];
        foreach ($rows as $row) {
            $carouselItems[] = $row['target_id'];
        }
        print views_embed_view('carousel_area', 'block', implode('+',$carouselItems));
        print '</div>';
    }


    // print out 3rd level menu elements
    // $block3 = module_invoke('menu_block', 'block_view', '3');
    // print render($block3['content']);
    // ednark
    // print out navigation list of child tax terms
?>
<div class="menu-block-wrapper menu-block-3 menu-name-main-menu menu-level-3">
    <ul class="menu">
<?php
        $children = taxonomy_get_children($term->tid);
        foreach ( $children as $child_tid=>$child ):
            if ( isset($child->field_generate_menu['und'][0]['value'])
              && $child->field_generate_menu['und'][0]['value']!=="yes" )
            {
                continue;
            }
            $className = trim(cssFriendlyString($child->field_page_title['und'][0]['value']),'-');
            $title     = $child->field_page_title['und'][0]['value'];
            $url       = $child->field_friendly_url['und'][0]['value'];
            ?><li class="<?php echo $className ?>"><a href="<?php echo $url ?>"><?php echo $title ?></a></li><?php
        endforeach;
?>
    </ul>
</div>
<?php

// TEMPORARY REMOVAL UNTIL HUBSPOT IS READY TO GO
    // print out the email block for navigation pages
    if (isset($term->field_govdelivery_id['und'][0]['value']) && count($term->field_govdelivery_id['und'][0]['value']) > 0){
        $govDelivID = $term->field_govdelivery_id['und'][0]['value'];
        /*print '<div class="block teacher-parent-email-block">';
        print '<h2 class="gr-mail">Sign up for emails from Kids.gov</h2>';
        print '<div class="mlcntnr-info"><form action="https://public.govdelivery.com/accounts/USFCIC/subscribers/qualify">';
        print '		<input id="topic_id" name="topic_id" type="hidden" value="' . $govDelivID . '">';
        print '		<div style="margin-left: 5px;">';
        print '			<label for="email">Enter Your Email address:</label>';
        print '			<input class="long" id="email" name="email" type="text" size="25">';
        print '			<input class="mlcntnr-email" name="commit" type="submit" value="">';
        print '		</div>';
        print '        </form>';
        print '		</div>';
        print '</div>';*/
        print '<div class="block teacher-parent-email-block">';
        print '<h2 class="gr-mail">Sign up for emails from Kids.gov</h2>';
        print '<br />';
        print '<!--[if lte IE 8]>';
        print '<script charset="utf-8" type="text/javascript" src="/sites/all/themes/kids/js/v2-legacy.js"></script>';
        print '<![endif]-->';
        print '<script charset="utf-8" type="text/javascript" src="/sites/all/themes/kids/js/v2.js"></script>';
        print '<script>';
        print '            hbspt.forms.create({
    portalId: \'532040\',
    formId: \'95b5de3a-6d4a-4729-bebf-07c41268d773\'
  });
</script>
</div>';
    };

    // print out bottom blocks
    if (isset($term->field_asset_order_bottom) && count($term->field_asset_order_bottom) > 0){
        print '<div class="bottom-block">';
        $sidebarItems = [];
        $rows = $term->field_asset_order_bottom['und'];
        foreach ($rows as $row) {
            $bottomItems[] = $row['target_id'];
        }
        print views_embed_view('content_area', 'block', implode('+',$bottomItems));
        print '</div>';
    }
    print '</div>';

}




/*****************************************
 ******************************************
 **										**
 **		print items for CONTENT PAGES 	**
 **										**
 ******************************************
 *****************************************/

if (isset($term->field_type_of_page_to_generate['und'][0]['value']) && $term->field_type_of_page_to_generate['und'][0]['value'] == "site-index")
{
    $block = module_invoke('all_childsite_misc', 'block_view', 'site_index');
    print render($block['content']);
}
elseif (isset($term->field_type_of_page_to_generate['und'][0]['value']) && $term->field_type_of_page_to_generate['und'][0]['value'] != "generic-navigation-page"){

    print '<div class="' . $term->field_type_of_page_to_generate['und'][0]['value'] . '">';

    // print the breadcrumb
    $drupalBreadcrumbs = drupal_get_breadcrumb();
    print  '<div class="breadcrumb">' . theme('breadcrumb', array('breadcrumb'=>$drupalBreadcrumbs)) . " &gt; " . $term->name . '</div>';

    // print the page title
    if(!empty($term->field_page_title['und'][0]['value'])){
        $className = cssFriendlyString($term->field_page_title['und'][0]['value']);
        print '<h1 class="' . $className  . '" >' . $term->field_page_title['und'][0]['value'] . '</h1>';
    }

    //print out the toggle to usa.gov and gobierno.gov links
    if(!empty($term->field_usa_gov_toggle_url['und'][0]['value']) || !empty($term->field_gobiernousa_gov_toggle_url['und'][0]['value'])){

        $usa_gov_env='https://www.usa.gov';
        $gobierno_gov_env='https://gobierno.usa.gov';

        if ((strlen($_SERVER["HTTP_HOST"]) - strlen(str_replace('ctacdev','',$_SERVER["HTTP_HOST"]))) > 0){
            $usa_gov_env='https://usagov.ctacdev.com';
            $gobierno_gov_env='https://gobiernogov.ctacdev.com';
        }

        if ((strlen($_SERVER["HTTP_HOST"]) - strlen(str_replace('stage-kidsgov','',$_SERVER["HTTP_HOST"]))) > 0){
            $usa_gov_env = 'https://stage-usagov.ctacdev.com';
            $gobierno_gov_env = 'https://stage-gobiernogov.ctacdev.com';
        }

        if ((strlen($_SERVER["HTTP_HOST"]) - strlen(str_replace('test-kidsgov','',$_SERVER["HTTP_HOST"]))) > 0){
            $usa_gov_env = 'https://test-usagov.ctacdev.com';
            $gobierno_gov_env = 'https://test-gobiernogov.ctacdev.com';
        }

        if ((strlen($_SERVER["HTTP_HOST"]) - strlen(str_replace('dev-kidsgov','',$_SERVER["HTTP_HOST"]))) > 0){
            $usa_gov_env = 'https://dev-usagov.ctacdev.com';
            $gobierno_gov_env = 'https://dev-gobiernogov.ctacdev.com';
        }

        print '<div class="feeds clearfix">';

        if(!empty($term->field_usa_gov_toggle_url['und'][0]['value'])){
            $usaGovLink = $term->field_usa_gov_toggle_url['und'][0]['value'];
            print '		<a href="' .$usa_gov_env. $usaGovLink . '">';
            print '			<img alt="See This on USA.gov" height="31" src="/sites/all/themes/kids/images/usa_toggle.png" title="See This on USA.gov" width="153">';
            print '		</a>';
        }

        if(!empty($term->field_gobiernousa_gov_toggle_url['und'][0]['value'])){
            $gobiernoGovLink = $term->field_gobiernousa_gov_toggle_url['und'][0]['value'];
            print '		<a href="' . $gobierno_gov_env. $gobiernoGovLink . '" target="_blank">';
            print '			<img alt="Este tema en GobiernoUSA.gov" src="/sites/all/themes/kids/images/gobierno_usa_toggle.png" title="Este tema en GobiernoUSA.gov">';
            print '		</a>';
        }

        print '</div>';
    }
    /* else {
         print '<div class="feeds clearfix">';
         print '<a href="http://get.adobe.com/reader/" class="reader" ><img  alt="Download Acrobat Reader" height="16" src="/sites/all/themes/kids/images/pdf_icon.png" title="PDF Icon" width="16">&nbsp; Download&nbsp;Reader</a>';
         print '</div>';
     }*/

    // print out the carousel
    if (isset($term->field_asset_order_carousel) && count($term->field_asset_order_carousel) > 0){
        print '<div class="carousel-block">';
        $sidebarItems = [];
        $rows = $term->field_asset_order_carousel['und'];
        foreach ($rows as $row) {
            $carouselItems[] = $row['target_id'];
        }
        print views_embed_view('carousel_area', 'block', implode('+',$carouselItems));
        print '</div>';
    }

    // print out the sidebar
    if (isset($term->field_asset_order_sidebar) && count($term->field_asset_order_sidebar) > 0){
        print '<div class="sidebar-block">';

        // // print out email block in sidebar
        // if (isset($term->field_govdelivery_id['und'][0]['value']) && count($term->field_govdelivery_id['und'][0]['value']) > 0){
        // 	$govDelivID = $term->field_govdelivery_id['und'][0]['value'];
        // 	print '<div class="emails-sidebar">';
        // 	print '	<div class="rght-hdr hdr-email"></div>';
        // 	print '		<div class="rght-email">';
        // 	print '			<form action="https://public.govdelivery.com/accounts/USFCIC/subscribers/qualify">';
        // 	print '				<input id="topic_id" name="topic_id" type="hidden" value="' . $govDelivID . '">';
        // 	print '				<p class="rght_dscrptn">Teachers and Parents, enter your email address to get updates from Kids.gov.</p>';
        // 	print '				<div style="margin-left: 5px; margin-top: 10px" class="rght-input">';
        // 	print '				<label for="email">Email address:</label>';
        // 	print '				<input class="long" id="email" name="email" type="text" size="auto">';
        // 	print '				<input class="grwnup-email" name="commit" type="submit" value="">';
        // 	print '			</form>';
        // 	print '		</div>';
        // 	print '	</div>';
        // 	print '</div>';
        // }

        //get the ids of the sidebar assets
        $sidebarItems = [];
        $rows = $term->field_asset_order_sidebar['und'];
        foreach ($rows as $row) {
            $sidebarItems[] = $row['target_id'];
        }

        //print the sidebar asset view
        print views_embed_view('html_assets', 'block', implode('+',$sidebarItems));

        print '</div>';
    }

    // print out the main content view
    if (isset($term->field_asset_order_content['und'][0]['target_id']) && count($term->field_asset_order_content['und'][0]['target_id']) > 0){
        print '<div class="content-block">';

        // get the ids of the content assets
        $contentIds = [];
        $rows = $term->field_asset_order_content['und'];
        foreach ($rows as $row) {
            $contentIds[] = $row['target_id'];
        }

        // get array of assets to print
        $textItems = views_get_view_result('text_assets', 'block', implode('+',$contentIds));
        $htmlItems = views_get_view_result('html_assets', 'block', implode('+',$contentIds));

        // Prepare to translate S3 links to absolute-links
        $s3Config = variable_get('cmp_s3_config', array('bucket'=>'gsa-cmp-fileupload-stage'));
        $s3BucketName = $s3Config['bucket'];

        // print out text assets
        if(count($textItems) > 1){


            print '<div class="frth_columnbox_container">';
            print '	<h2>Find on This Page</h2>';
            print '	<div class="frth_columnbox_container_content">';
            print '		<ul class="two_clmn_bullets">';
            foreach ($textItems as $textItem){
                print '<li><a href="#jump-' . cssFriendlyString($textItem->node_title) . '">' . $textItem->node_title . '</a></li>';
            }
            print '		</ul>';
            print '	</div>';
            print '</div>';


            foreach ($textItems as $textItem){
                print '<span class="jump-title" id="jump-' . cssFriendlyString($textItem->node_title) . '">' . $textItem->node_title . '</span>';


                if(@!empty($textItem->_field_data['nid']['entity']->field_related_multimedia_two['und'][0]['target_id'])){
                    $imageNode = node_load($textItem->_field_data['nid']['entity']->field_related_multimedia_two['und'][0]['target_id']);
                    if(@!empty($imageNode->field_file_media_url['und'][0]['value'])){
                        $markup = '<img src="' . $imageNode->field_file_media_url['und'][0]['value'] . '" style="float:right" />';
                        $markup .= $textItem->field_body[0]['rendered']['#markup'];
                        $markup = str_replace('s3://', 'http://'.$s3BucketName.'.s3.amazonaws.com/', $markup);
                    } else {
                        $markup = '';
                        $markup .= $textItem->field_body[0]['rendered']['#markup'];
                        $markup = str_replace('s3://', 'http://'.$s3BucketName.'.s3.amazonaws.com/', $markup);
                    }
                } else{
                    $markup = $textItem->field_body[0]['rendered']['#markup'];
                    $markup = str_replace('s3://', 'http://'.$s3BucketName.'.s3.amazonaws.com/', $markup);
                }

                print $markup;
            }
        } else {

            if(isset($textItems[0]->field_body[0]['rendered']['#markup'])){

                if(@!empty($textItems[0]->_field_data['nid']['entity']->field_related_multimedia_two['und'][0]['target_id'])){
                    $imageNode = node_load($textItems[0]->_field_data['nid']['entity']->field_related_multimedia_two['und'][0]['target_id']);

                    if (isset($imageNode->field_media_type['und'][0]['value']) && $imageNode->field_media_type['und'][0]['value'] == 'Video') {
                        $markup = $imageNode->field_embed_code['und'][0]['value'];
                        $markup .= '<DIV CLASS="rxbodyfield" >'.$textItems[0]->field_body[0]['rendered']['#markup'] . '</DIV>';
                    }
                    else {
                        if (@!empty($imageNode->field_file_media_url['und'][0]['value'])) {

                            $markup = '';
                            if (@!empty($term->field_show_social_media_icon['und'][0]['value']) && $term->field_show_social_media_icon['und'][0]['value'] == 'Yes') {
                                $url = "https://kids.usa.gov".$term->field_friendly_url['und'][0]['value'];
                                $image = str_replace('s3://', 'http://' . $s3BucketName . '.s3.amazonaws.com/',$imageNode->field_file_media_url['und'][0]['value']);
                                $desc = $term->field_description_meta['und'][0]['value'].' from @Kidsgov';

                                $markup .= '<div class="rxbodyfield">
                                                <div class="feeds clearfix">&nbsp;&nbsp;&nbsp;&nbsp;';

                                $markup .= '<a href="http://twitter.com/intent/tweet?source=webclient&amp;text='.$desc.$url.'" onmousedown="_sendEvent(\'Outbound\',\'www.twitter.com\',\'/intent/tweet\',0);"><img alt="Twitter Tweet It" height="21" inlinetype="rximage" rxinlineslot="104" src="//gsa-cmp-fileupload.s3.amazonaws.com/3795_Logo_Twitter_Tweet_It.png" style="vertical-align: text-bottom;" sys_contentid="3795" sys_dependentid="3795" sys_dependentvariantid="371" sys_relationshipid="39773" sys_variantid="371" title="Twitter Tweet It" width="22"></a>&nbsp;';
                                $markup .= '<a href="http://twitter.com/intent/tweet?source=webclient&amp;text='.$desc.$url.'" onmousedown="_sendEvent(\'Outbound\',\'www.twitter.com\',\'/intent/tweet\',0);">Tweet it</a> &nbsp;';

                                $markup .= '<a href="http://www.facebook.com/sharer/sharer.php?u='.$url.'&amp;v=3" onmousedown="_sendEvent(\'Outbound\',\'www.facebook.com\',\'/sharer/sharer.php\',0);"><img alt="Facebook Share It" height="21" inlinetype="rximage" rxinlineslot="104" src="//gsa-cmp-fileupload.s3.amazonaws.com/3796_Logo_Facebook_Share_It.png" style="vertical-align: text-bottom;" sys_contentid="3796" sys_dependentid="3796" sys_dependentvariantid="371" sys_relationshipid="39774" sys_variantid="371" title="Facebook Share It" width="22"></a>&nbsp;';
                                $markup .= '<a href="http://www.facebook.com/sharer/sharer.php?u='.$url.'&amp;v=3" onmousedown="_sendEvent(\'Outbound\',\'www.facebook.com\',\'/sharer/sharer.php\',0);">Share it</a>&nbsp;&nbsp;';

                                $markup .= '<a data-pin-config="none" data-pin-do="buttonPin" ';
                                $markup .= 'href="//www.pinterest.com/pin/create/button/?url='.$url.'&amp;media='.$image.'&amp;description='.$desc.'"';
                                $markup .= ' onmousedown="_sendEvent(\'Outbound\',\'www.pinterest.com\',\'/pin/create/button/\',0);"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png"></a>';

                                $markup .= '</div></div>';
                            }
                            $markup .= '<img src="' . $imageNode->field_file_media_url['und'][0]['value'] . '" style="float:right" />';
                            $markup .= $textItems[0]->field_body[0]['rendered']['#markup'];
                            $markup = str_replace('s3://', 'http://' . $s3BucketName . '.s3.amazonaws.com/', $markup);
                        } else {
                            $markup = '';
                            $markup .= $textItems[0]->field_body[0]['rendered']['#markup'];
                            $markup = str_replace('s3://', 'http://' . $s3BucketName . '.s3.amazonaws.com/', $markup);
                        }
                    }
                } else{
                    $markup = $textItems[0]->field_body[0]['rendered']['#markup'];
                    $markup = str_replace('s3://', 'http://'.$s3BucketName.'.s3.amazonaws.com/', $markup);
                }

                print $markup;

            }
        }

        // print out html assets
        if(count($htmlItems) > 0){
            foreach ($htmlItems as $htmlItem){
                $markup = $htmlItem->field_field_html[0]['rendered']['#markup'];
                $markup = str_replace('s3://', 'http://'.$s3BucketName.'.s3.amazonaws.com/', $markup);
                print $markup;
            }
        }


        print '</div>';
    }
    print '</div>';
}

if ( !empty($term) && !empty($term->field_end_html['und'][0]['value']) ) {
    print $term->field_end_html['und'][0]['value'];
}
?>

<?php
$actTrail = menu_get_active_trail();
$actTrail2ndLvl = $actTrail[1]['link_title'];
$jsSurvey = 'https://survey.usa.gov/widget/151/invitation.js?target_id=survey_target';
$cssSurvey = "&stylesheet=https://{$_SERVER['HTTP_HOST']}/sites/all/themes/kids/css/survey.css";
?>

<?php if ( strpos($actTrail2ndLvl, 'Teacher') !== false || strpos($actTrail2ndLvl, 'Parent') !== false ): ?>
    <div id="survey_target"></div>
    <script type="text/javascript" src="<?php print $jsSurvey . $cssSurvey; ?>"></script>
<?php endif; ?>

</div>

<span class="page-last-updated" style="float: right;">
	Page last updated: <?php print $lastUpdated; ?>
    <span>
