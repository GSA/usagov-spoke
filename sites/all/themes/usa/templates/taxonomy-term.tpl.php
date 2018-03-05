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

// Tell my debug-helper script what term-id this is (makes jumping to edit pages easier)
if ( !empty($term->tid) ) {
    drupal_add_js("termId = '{$term->tid}';", "inline");
}


if( !empty($term->field_real_meta_description['und'][0]['value']) ) {

    drupal_add_html_head(
        array(
            '#tag' => 'meta',
            '#attributes' => array(
                'name' => 'description',
                'content' =>  $term->field_real_meta_description['und'][0]['value'],
            )
        ),
        'usa_custom_meta_tag_descriptionfromtaxonomy'
    );
}

?>

<?php
// Array of Menu Items
$menuBlock = array();
if(count(buildMenu($term)) > 0){
    $menuBlock = subval_sort(buildMenu($term), 'name');
}
?>


<?php
/***********************************************************
 ***********************************************************
 **                                                       **
 **     print items for MORE GOVERNMENT BY ORGANIZATION   **
 **                                                       **
 ***********************************************************
 **********************************************************/

if (isset($term->field_type_of_page_to_generate['und'][0]['value']) && $term->field_type_of_page_to_generate['und'][0]['value'] == "government-by-organization"):

    ?>

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
                    <?php
                    // get the parent taxonomy term for sidebar
                    $parentTerms = taxonomy_get_parents($term->tid);
                    print '<h2 itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">';
                    foreach($parentTerms as $obj){
                        if(@!empty($obj->field_friendly_url['und'][0]['value'])){
                            print '<a href="' . $obj->field_friendly_url['und'][0]['value'] . '" itemprop="url" ><span itemprop="title">';
                        }
                        print $obj->name;
                        if(@!empty($obj->field_friendly_url['und'][0]['value'])){
                            print '</span></a>';
                        }
                        if(count(buildMenu($obj)) > 0){
                            $menuBlock = subval_sort(buildMenu($obj), 'name');
                        }
                    }
                    print '</h2>';
                    ?>
                </header>
                <ul>
                    <?php
                    foreach($menuBlock as $menuItem){
                        if($menuItem['name'] == $term->name){
                            print '<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" class="slctd">';
                            print '<a>';
                            print '<span itemprop="title">' . $menuItem['name'] . '</span>';
                        } else {
                            print '<li >';
                            print '<a href="' . $menuItem['url'] . '">'.$menuItem['name'];
                        }
                        print '</a>';
                        print '</li>';
                    }
                    ?>
                </ul>
            </div>
        </section>
    </nav>



    <div class="col-md-9 col-sm-12 rightnav">
        <article>
            <header>
                <?php
                if(!empty($term->field_page_title['und'][0]['safe_value'])){
                    print '<h1>' . $term->field_page_title['und'][0]['safe_value'] . '</h1>';
                }
                if(!empty($term->field_page_intro['und'][0]['value'])){
                    print '<p>' . $term->field_page_intro['und'][0]['value'] . '</p>';
                }
                ?>
            </header>


            <?php
            $arg = '';
            if(!empty($term->field_government_branch['und'][0]['value'])){
                $arg = $term->field_government_branch['und'][0]['value'];
            }
            print views_embed_view('federal_government_by_organization', 'block', $arg);
            ?>

            <?php
            print _print_social_media();
            print '<p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl">'.t('Back to Top').'</span></a></p>';
            print do_you_need_help();
            print survey_on_pages();
            ?>

        </article>

    </div>

<?php endif; ?>

<?php
/*********************************************
 **********************************************
 **											**
 **		print items for MORE TOPICS PAGES 	**
 **											**
 **********************************************
 *********************************************/

if (isset($term->field_type_of_page_to_generate['und'][0]['value']) && $term->field_type_of_page_to_generate['und'][0]['value'] == "more"):

    ?>
    <article>
        <header>
            <?php
            if(!empty($term->field_page_title['und'][0]['safe_value'])){
                print '<h1>' . $term->field_page_title['und'][0]['safe_value'] . '</h1>';
            }
            if(!empty($term->field_page_intro['und'][0]['value'])){
                print '<p>' . $term->field_page_intro['und'][0]['value'] . '</p>';
            }
            ?>
        </header>
        <section class="infobytpc clearfix row">
            <ul class="topics">
                <?php
                foreach($menuBlock as $menuItem){
                    print '<li class="col-md-4 col-sm-6 col-xs-12">';
                    print '<a href="' . $menuItem['url'] . '" class="topic-' . $menuItem['class'] . '">';
                    print '<span class="mocklink">' . $menuItem['name'] . '</span>';
                    print '<p>' . $menuItem['desc'] . '</p></a>';
                    print '</li>';
                }
                ?>
            </ul>
        </section>
        <?php print _print_social_media(); ?>
        <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
    </article>

<?php endif; ?>




<?php
/*********************************************
 **********************************************
 **											**
 **		print items for NAVIGATION PAGES 	**
 **											**
 **********************************************
 *********************************************/

if (isset($term->field_type_of_page_to_generate['und'][0]['value']) && $term->field_type_of_page_to_generate['und'][0]['value'] == "generic-navigation-page")
{
    $parentTerms = taxonomy_get_parents_all($term->tid);
    if(count($parentTerms) > 2 && $parentTerms[1]->field_friendly_url['und'][0]['value'] != '/topics' && $parentTerms[1]->field_friendly_url['und'][0]['value'] != '/servicios-informacion')
    {
        ?>
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
                        <?php
                        // get the parent taxonomy term for sidebar
                        $parentTerms = taxonomy_get_parents($term->tid);
                        print '<h2 itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">';
                        foreach($parentTerms as $obj){
                            if(@!empty($obj->field_friendly_url['und'][0]['value'])){
                                print '<a href="' . $obj->field_friendly_url['und'][0]['value'] . '" itemprop="url" ><span itemprop="title">';
                            }
                            print $obj->name;
                            if(@!empty($obj->field_friendly_url['und'][0]['value'])){
                                print '</span></a>';
                            }
                            if(count(buildMenu($obj)) > 0){
                                $menuBlockSide = subval_sort(buildMenu($obj), 'name');
                            }
                        }
                        print '</h2>';
                        ?>
                    </header>
                    <ul>
                        <?php
                        foreach($menuBlockSide as $menuItemSide){
                            if($menuItemSide['name'] == $term->name){
                                print '<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" class="slctd">';
                                print '<a>';
                                print '<span itemprop="title">' . $menuItemSide['name'] . '</span>';
                            } else {
                                print '<li >';
                                print '<a href="' . $menuItemSide['url'] . '">'.$menuItemSide['name'];
                            }
                            print '</a>';
                            print '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </section>
        </nav>
        <div class="col-md-9 col-sm-12 rightnav">
            <article>
                <header>
                    <?php
                    if(!empty($term->field_page_title['und'][0]['safe_value'])){
                        print '<h1>' . $term->field_page_title['und'][0]['safe_value'] . '</h1>';
                    }
                    if(!empty($term->field_page_intro['und'][0]['value'])){
                        print '<p>' . $term->field_page_intro['und'][0]['value'] . '</p>';
                    }
                    ?>
                </header>
                <section class="infobytpc clearfix row">
                    <ul class="dwnlvl">
                        <?php
                        foreach($menuBlock as $menuItem){
                            // col-md-4 col-sm-6 col-xs-12
                            print '<li class="col-md-6 col-xs-12">';
                            print '<a href="' . $menuItem['url'] . '">';
                            // if ($use_new_nav) {
                            print '<span class="mocklink">' . $menuItem['name'] . '</span>';
                            print '<p>' . html_entity_decode($menuItem['desc']) . '</p></a>';
                            /*}
                            else {
                                print '<span class="mocklink">' . $menuItem['name'] . '</span></a>';
                                print '<p>' . html_entity_decode($menuItem['desc']) . '</p>';
                            }*/
                            print '</li>';
                        }
                        ?>
                    </ul>
                </section>
                <?php print _print_social_media(); ?>
                <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
            </article>
        </div>

    <?php } else { ?>
        <article>
            <header>
                <?php
                if (!empty($term->field_page_title['und'][0]['safe_value'])) {
                    print '<h1>' . $term->field_page_title['und'][0]['safe_value'] . '</h1>';
                }
                if (!empty($term->field_page_intro['und'][0]['value']) && !isset($term->field_asset_order_content['und'][0]['target_id'])  && !is_numeric($term->field_asset_order_content['und'][0]['target_id'])) {
                    print '<p>' . $term->field_page_intro['und'][0]['value'] . '</p>';
                }
                ?>
            </header>
            <?php
            // new nav template check starting
            $use_new_nav = false;
            if (isset($term->field_asset_order_content['und'][0]['target_id']) && is_numeric($term->field_asset_order_content['und'][0]['target_id'])){
                $use_new_nav = true;
                //dpr($term);
                if (isset($term->field_css_class['und'][0]['safe_value'])) {
                    $css = $term->field_css_class['und'][0]['safe_value'];
                }
                else{
                    $css = 'NOT-SET-IN-CMP';
                }
                $text_asset = node_load($term->field_asset_order_content['und'][0]['target_id']);
                ?>
                <div class="usa-grid-full topic-nav">
                    <div class="usa-width-two-thirds topic-nav-box1">
                        <div class="topic-nav-photo topic-nav-photo-<?php print $css; ?>"></div>

                        <?php if (!empty($term->field_description_meta['und'][0]['value'])): ?>
                            <div class="topic-nav-tagline">
                                <span class="topic-nav-<?php print $css; ?>"><p><?php print $term->field_description_meta['und'][0]['value']; ?></p></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="usa-width-one-third how-do-i-topic">
                        <h2><?php print t('How do I'); ?> ...</h2>
                        <?php
                        print $text_asset->body['und'][0]['safe_value'];
                        ?>
                    </div>
                </div>
            <?php } ?>

            <section class="infobytpc clearfix row">
                <ul class="dwnlvl">
                    <?php
                    foreach ($menuBlock as $menuItem) {
                        // col-md-4 col-sm-6 col-xs-12
                        print '<li class="col-md-4 col-sm-6 col-xs-12">';
                        print '<a href="' . $menuItem['url'] . '">';
                        // if ($use_new_nav) {
                        print '<span class="mocklink">' . $menuItem['name'] . '</span>';
                        print '<p>' . html_entity_decode($menuItem['desc']) . '</p></a>';
                        /*}
                        else {
                            print '<span class="mocklink">' . $menuItem['name'] . '</span></a>';
                            print '<p>' . html_entity_decode($menuItem['desc']) . '</p>';
                        }*/
                        print '</li>';
                    }
                    ?>
                </ul>
            </section>
            <?php
            if ($use_new_nav){
                $url = 'topics';
                $siteName = variable_get('site_name', '');
                if ( strpos(strtolower($siteName), 'gobierno') !== false ) {
                    $url = 'servicios-informacion';
                }
                print '<div class="usa-grid explore-topics"><p>';
                print "<a href='/".$url."'>".t('Explore All Topics and Services on USA.gov')."</a>";
                print '</p></div>';
            }
            print _print_social_media();
            ?>
            <p class="volver clearfix"><a href="#skiptarget"><span
                        class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
        </article>

    <?php
    }
}
?>




<?php
/*************************************************
 **************************************************
 **												**
 **		print items for GENERIC CONTENT PAGES 	**
 **												**
 **************************************************
 *************************************************/

if (isset($term->field_type_of_page_to_generate['und'][0]['value']) && $term->field_type_of_page_to_generate['und'][0]['value'] == "generic-content-page"):

    ?>

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
                    <?php
                    // get the parent taxonomy term for sidebar
                    $parentTerms = taxonomy_get_parents($term->tid);
                    print '<h2 itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">';
                    foreach($parentTerms as $obj){
                        if(@!empty($obj->field_friendly_url['und'][0]['value'])){
                            print '<a href="' . $obj->field_friendly_url['und'][0]['value'] . '" itemprop="url" ><span itemprop="title">';
                        }
                        print $obj->name;
                        if(@!empty($obj->field_friendly_url['und'][0]['value'])){
                            print '</span></a>';
                        }
                        if(count(buildMenu($obj)) > 0){
                            $menuBlock = subval_sort(buildMenu($obj), 'name');
                        }
                    }
                    print '</h2>';
                    ?>
                </header>
                <ul>
                    <?php
                    foreach($menuBlock as $menuItem){
                        if($menuItem['name'] == $term->name){
                            print '<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" class="slctd">';
                            print '<a>';
                            print '<span itemprop="title">' . $menuItem['name'] . '</span>';
                        } else {
                            print '<li >';
                            print '<a href="' . $menuItem['url'] . '">'.$menuItem['name'];
                        }
                        print '</a>';
                        print '</li>';
                    }
                    ?>
                </ul>
            </div>
        </section>
    </nav>
    <!---right container-->
    <div class="col-md-9 col-sm-12 rightnav">
        <header>
            <?php
            if(!empty($term->field_page_title['und'][0]['safe_value'])){
                print '<h1>' . $term->field_page_title['und'][0]['safe_value'] . '</h1>';
            }
            //loading views to get count of assets on page, if more than 1 asset then load page intro field
            if (isset($term->field_asset_topic_taxonomy) && count($term->field_asset_topic_taxonomy) > 0){

                // Get the node-IDs (in order) that shall show in this
                $assetNids = array();
                foreach ($term->field_asset_order_content['und'] as $nidContainer) {
                    $assetNids[] = $nidContainer['target_id'];
                }

                if ( count($assetNids) > 0 ) {
                    $viewResult = views_get_view_result('general_content_page_jump', 'block', implode('+',$assetNids));
                    if(count($viewResult) > 1){
                        if(!empty($term->field_page_intro['und'][0]['value'])){
                            print '<p>' . $term->field_page_intro['und'][0]['value'] . '</p>';
                        }
                    }
                }
            }



            ?>
        </header>
        <!-- begin WOTP -->


        <?php
        if (isset($term->field_asset_topic_taxonomy) && count($term->field_asset_topic_taxonomy) > 0){
            $topicIds = array();
            $rows = $term->field_asset_topic_taxonomy['und'];
            foreach ($rows as $row) {
                $topicIds[] = $row['tid'];
            }
            $assetNids = array();

            foreach ($term->field_asset_order_content['und'] as $nidContainer) {
                $assetNids[] = $nidContainer['target_id'];
            }

            $featureNids = db_query("
						select nid
						from
							{node} n
							join {field_data_field_asset_topic_taxonomy} att  on (n.nid=att.entity_id)
						    left join {field_data_field_for_use_by}      fub  on (n.nid=fub.entity_id)
						    left join {field_data_field_for_use_by_text} fubt on (n.nid=fubt.entity_id)
						where
						    (
								fub.field_for_use_by_value       = 'Feature'
						        OR
								fubt.field_for_use_by_text_value = 'Feature'
							)
							AND att.field_asset_topic_taxonomy_tid in (:tid)
			        ",array(':tid'=>join(',',$topicIds)))->fetchCol();

            if ( count($topicIds) > 0 ) {
                $viewResult = views_get_view_result('general_content_page_jump', 'block', implode('+',$assetNids));
                if(count($viewResult) > 1){

                    print views_embed_view('general_content_page_jump', 'block', implode('+',$assetNids));
                    print views_embed_view('general_content_page_sticky', 'block', implode('+',$assetNids));

                    if ( is_array($featureNids) and count($featureNids)>0 ) {
                        print views_embed_view('feature_inline_block', 'block', implode('+',$featureNids));
                    }

                    print views_embed_view('general_content_page', 'block', implode('+',$assetNids));

                } else if (count($viewResult) == 1){

                    if ( is_array($featureNids) and count($featureNids)>0 ) {
                        print views_embed_view('feature_inline_block', 'block', implode('+',$featureNids));
                    }
                    //print views_embed_view('general_content_page_jump', 'block', implode('+',$assetNids));
                    //print views_embed_view('general_content_page_sticky', 'block', implode('+',$assetNids));
                    print views_embed_view('feature_inline_block', 'block', implode('+',$assetNids));
                    print views_embed_view('general_content_page_single_item', 'block', implode('+',$assetNids));

                }
            }
        }
        ?>

        <?php
        //print _print_social_media();

        /*
            if($term->field_usefulness_survey['und'][0]['value'] == 1){
                print survey_on_pages();
          }
        */

        if(strtolower($term->field_friendly_url['und'][0]['value']) != '/unclaimed-money' ) {
            print do_you_need_help();
            print survey_on_pages();
        }
        $timestamp = get_term_lastReviewedDate($term->tid);
        if (isset($timestamp) && !empty($timestamp)) {
            // print last reviewed date
            print "<p class='last'>".t('Last Updated').": " . t(date("F", $timestamp)) . " " .date("d, Y", $timestamp) . '</p>';

        }
        ?>

    </div>
<?php endif; ?>






<?php
/*********************************************
 **********************************************
 **											**
 **		print items for 50 STATE PAGES 		**
 **											**
 **********************************************
 *********************************************/

if (isset($term->field_type_of_page_to_generate['und'][0]['value']) && $term->field_type_of_page_to_generate['und'][0]['value'] == "50-state-page"):

    ?>

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
                    <?php
                    // get the parent taxonomy term for sidebar
                    $parentTerms = taxonomy_get_parents($term->tid);
                    if(@!empty($parentTerms)){
                        print '<h2 itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">';
                        foreach($parentTerms as $obj){
                            if(@!empty($obj->field_friendly_url['und'][0]['value'])){
                                print '<a href="' . $obj->field_friendly_url['und'][0]['value'] . '" itemprop="url"> <span itemprop="title">';
                            }
                            print $obj->name;
                            if(@!empty($obj->field_friendly_url['und'][0]['value'])){
                                print '</span></a>';
                            }
                            if(count(buildMenu($obj)) > 0){
                                $menuBlock = subval_sort(buildMenu($obj), 'name');
                            }
                        }
                        print '</h2>';
                    }
                    ?>
                </header>
                <ul>
                    <?php
                    if(@!empty($menuBlock)){
                        foreach($menuBlock as $menuItem){
                            if($menuItem['name'] == $term->name){
                                print '<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" class="slctd">';
                                print '<a href="' . $menuItem['url'] . '" >';
                                print '<span itemprop="title">' . $menuItem['name'] . '</span>';
                            } else {
                                print '<li>';
                                print '<a href="' . $menuItem['url'] . '" >'.$menuItem['name'] ;
                            }

                            print '</a>';
                            print '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </section>
    </nav>
    <!---right container-->
    <div class="col-md-9 col-sm-12 rightnav">
        <header>
            <?php
            if(!empty($term->field_page_title['und'][0]['safe_value'])){
                print '<h1>' . $term->field_page_title['und'][0]['safe_value'] . '</h1>';
            }
            if(!empty($term->field_page_intro['und'][0]['value'])){
                print '<p>' . $term->field_page_intro['und'][0]['value'] . '</p>';
            }
            ?>
        </header>
        <!-- begin WOTP -->

        <ul id="statelist" class="one_column_bullet">
            <?php
            if (isset($term->field_usa_gov_50_state_category['und'][0]['value'])) {

                // Get the field that you want to aggregate
                $aggregateField = $term->field_usa_gov_50_state_category['und'][0]['value'];


                // Get the site name
                $siteName = variable_get('site_name', '');

                // Create drop down array
                $dropDown = [];

                if ($aggregateField == 'autogenerate') {

                    // Create variables to query for sitename
                    // if ( strpos(strtolower($siteName), 'gobierno') !== false ) {
                    // 	$siteNameQuery = 'GobiernoUSA.gov';
                    // } else {
                    // 	$siteNameQuery = 'USA.gov';
                    // }

                    // Query all States and their aggregate url values
                    $stateQuery = "SELECT
								  n.title, n.nid,
								  cn.field_state_canonical_name_value as canonical
								FROM node n
									 INNER JOIN field_data_field_state_canonical_name cn
								                ON n.nid = cn.entity_id
								WHERE n.type = 'state_details'";
                    $stateAggs = db_query($stateQuery);

                    //module_invoke_all( 'filter_state_details_'.$term->field_usa_gov_50_state_prefix['und'][0]['value'], $stateAggs );
                    //module_invoke_all( 'directory_pages_filter_state_details_state_consumer', $stateAggs );
                    $url_prefix=$term->field_usa_gov_50_state_prefix['und'][0]['value'];
                    $url_prefix=str_replace('/','_',$url_prefix);
                    $url_prefix=str_replace('-','_',$url_prefix);
                    $url_prefix=trim($url_prefix,'_');

                    foreach($stateAggs as $item)
                    {
                        $is_state_has_data  = module_invoke_all( 'filter_state_details_'.$url_prefix, $item->nid );
                        $include_this_state = true;
                        foreach ( $is_state_has_data as $good_state )
                        {
                            if ( $good_state === 0 )
                            {
                                $include_this_state = false;
                                break;
                            }
                        }
                        if($include_this_state)
                        {
                            $stateLink = ucwords($item->canonical);
                            $stateLink = t($stateLink);
                            $stateLink = htmlentities($stateLink);
                            $stateLink = strtolower($stateLink);
                            $stateLink = str_replace(' ', '-', $stateLink);
                            $stateLink = html_entity_decode($stateLink);
                            array_push($dropDown, ['state' => t(_strtoupper($item->canonical)), 'url' => $term->field_usa_gov_50_state_prefix['und'][0]['value'].'/' . $stateLink ]);
                        }
                    }
                } else {

                    // Create variables to query for sitename
                    if ( strpos(strtolower($siteName), 'gobierno') !== false ) {
                        $siteNameQuery = 'GobiernoUSA.gov';
                    } else {
                        $siteNameQuery = 'USA.gov';
                    }

                    // Create variables to query for aggregate field
                    $stateURLTable = 'field_data_' . $aggregateField;
                    $stateURLCol = $aggregateField . '_url';
                    $stateURLTableCol = $stateURLTable . '.' . $stateURLCol;

                    // Query all States and their aggregate url values
                    $stateQuery = "SELECT DISTINCT
							field_data_field_state.field_state_value AS state,
						    {$stateURLTableCol} AS url

							FROM
								field_data_field_directory_type

							INNER JOIN
								field_data_field_state_details
								ON field_data_field_directory_type.entity_id = field_data_field_state_details.entity_id

							INNER JOIN
								field_data_field_state
								ON field_data_field_directory_type.entity_id = field_data_field_state.entity_id

							INNER JOIN
								field_data_field_for_use_by_text
								ON field_data_field_directory_type.entity_id = field_data_field_for_use_by_text.entity_id

							INNER JOIN
								{$stateURLTable}
								ON field_data_field_state_details.field_state_details_nid = {$stateURLTable}.entity_id

							WHERE
								field_data_field_for_use_by_text.field_for_use_by_text_value = '{$siteNameQuery}'
								AND
							    {$stateURLTableCol} IS NOT NULL
							    AND
							    {$stateURLTableCol} != ''
							    AND
								(field_data_field_directory_type.field_directory_type_value = 'State Government Agencies'
								OR field_data_field_directory_type.field_directory_type_value = 'State Government Agency')";

                    $stateAggs = db_query($stateQuery);

                    foreach($stateAggs as $item){
                        array_push($dropDown, ['state' => t(_strtoupper(directory_pages_acronymToStateName($item->state,$item->state))), 'url'=> $item->url]);
                    }
                }


                // Sort drop down array asc alphabetical by state
                $dropDown = subval_sort($dropDown, 'state');

                // Print out drop down markup
                foreach ($dropDown as $item) {
                    if(strpos($item['url'],'http') !== false || strpos($item['url'],"//") !== false) {
                        $url = $item['url'];
                    }
                    else {
                        $url = _sanitzie_path($item['url']);
                    }
                    print '<li><a class="url" href="' . $url . '" >' . _strtoupper($item['state']) . '</a></li>';
                }


            }
            ?>
        </ul>
        <?php print _print_social_media(); ?>
        <p class="statebacktotop clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
    </div>
<?php endif; ?>


<?php
/*************************
 **************************
 **						**
 **		Functions 		**
 **						**
 **************************
 *************************/

function _strtoupper($str) {
    $ret = $str;
    $ret = ucwords($ret);

    $ret = ' '.$ret.' ';
    $ret = str_replace(' Of ', ' of ', $ret);
    $ret = str_replace(' U.s. ', ' U.S. ', $ret);
    $ret = str_replace(' The ', ' the ', $ret);
    $ret = str_replace(' Del ', ' del ', $ret);
    $ret = str_replace(' De ', ' de ', $ret);
    $ret = trim($ret);

    // ugly code
    if ($ret == 'U.s. Virgin Islands')
    {
        $ret = "U.S. Virgin Islands";
    }

    if ($ret == 'Islas Vírgenes, EE. UU.')
    {
        $ret = "Islas Vírgenes, EE. UU.";
    }

    return $ret;
}

function buildMenu($term){
    //build the menu block in the content area
    $menuBlock = [];

    //get the menu items that are child taxonomy terms of the current term
    if(count(taxonomy_get_children($term->tid)) > 0){
        $childrenMenuItems = taxonomy_get_children($term->tid);
        foreach($childrenMenuItems as $key => &$childItem){
            if(@!empty($childItem->field_generate_menu['und'][0]['value']) && $childItem->field_generate_menu['und'][0]['value'] == 'yes'){
                if(empty($childItem->name)){
                    $childrenMenuItems[$key]->name = 'not-set-in-cmp';
                }
                if(empty($childItem->field_friendly_url['und'][0]['safe_value'])){
                    $childrenMenuItems[$key]->field_friendly_url['und'][0]['safe_value'] = 'not-set-in-cmp';
                }
                if(empty($childItem->field_css_class['und'][0]['safe_value'])){
                    $childrenMenuItems[$key]->field_css_class['und'][0]['safe_value'] = 'not-set-in-cmp';
                }
                if(empty($childItem->field_description_meta['und'][0]['value'])){
                    $childrenMenuItems[$key]->field_description_meta['und'][0]['value'] = 'not-set-in-cmp';
                }
                array_push($menuBlock, ['name' => $childItem->name, 'url' => $childItem->field_friendly_url['und'][0]['safe_value'], 'class' => $childItem->field_css_class['und'][0]['safe_value'], 'desc' => $childItem->field_description_meta['und'][0]['value']]);
            }
        }
    }

    //get the menu items that are 'also included on nav pages' of the current term
    if(!empty($term->field_also_include_on_nav_page['und']) && count($term->field_also_include_on_nav_page['und']) > 0){
        $includedTerms = $term->field_also_include_on_nav_page['und'];
        foreach($includedTerms as $key => &$includedTerm){

            if ( !isset($includedTerm['taxonomy_term']) && !empty($includedTerm['tid']) ) {
                $includedTerm['taxonomy_term'] = taxonomy_term_load($includedTerm['tid']);
            }

            if(@!empty($includedTerm['taxonomy_term']->field_generate_menu['und'][0]['value']) && $includedTerm['taxonomy_term']->field_generate_menu['und'][0]['value'] == 'yes'){

                if(empty($includedTerm['taxonomy_term']->name)){
                    $includedTerms[$key]['taxonomy_term']->name = 'not-set-in-cmp';
                }
                if(empty($includedTerm['taxonomy_term']->field_friendly_url['und'][0]['safe_value'])){
                    $includedTerms[$key]['taxonomy_term']->field_friendly_url['und'][0]['safe_value'] = 'not-set-in-cmp';
                }
                if(empty($includedTerm['taxonomy_term']->field_css_class['und'][0]['safe_value'])){
                    $includedTerms[$key]['taxonomy_term']->field_css_class['und'][0]['safe_value'] = 'not-set-in-cmp';
                }
                if(empty($includedTerm['taxonomy_term']->field_description_meta['und'][0]['value'])){
                    $includedTerms[$key]['taxonomy_term']->field_description_meta['und'][0]['value'] = 'not-set-in-cmp';
                }
                array_push($menuBlock, ['name' => $includedTerm['taxonomy_term']->name, 'url' => $includedTerm['taxonomy_term']->field_friendly_url['und'][0]['safe_value'], 'class' => $includedTerm['taxonomy_term']->field_css_class['und'][0]['safe_value'], 'desc' => $includedTerm['taxonomy_term']->field_description_meta['und'][0]['value']]);
            }
        }
    }
    return $menuBlock;
}



function subval_sort($a,$subkey) {
    foreach($a as $k=>$v) {
        $b[$k] = strtolower($v[$subkey]);
    }
    asort($b);
    foreach($b as $key=>$val) {
        $c[] = $a[$key];
    }
    return $c;
}

?>
