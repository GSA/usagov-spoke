
<?php
// setting the meta description
if(@!empty($dirRecords[0]->title)){
    drupal_add_html_head(
        array(
            '#tag' => 'meta',
            '#attributes' => array(
                'name' => 'description',
                'content' =>  'Directory listing for ' . $dirRecords[0]->title,
            )
        ),
        'usa_custom_meta_tag_alphaname'
    );
}


// Get the site name
$siteName = variable_get('site_name', '');

// Determin which site we are running
$siteIsUSA = false;
$siteIsGobierno = false;
if ( strpos(strtolower($siteName), 'gobierno') !== false ) {
    $siteIsGobierno = true;
} else {
    $siteIsUSA = true;
}



?>

<?php if($siteIsUSA == true): ?>
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
                    <h2 itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/agencies" class="url" itemprop="url" onmousedown="_sendEvent('Outbound','/agencies','/',0);"><span itemprop="title">Government Agencies and Elected Officials</span></a></h2>
                </header>
                <ul>
                    <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" class="slctd"><a href="/federal-agencies/a" class="url" onmousedown="_sendEvent('Outbound','/federal-agencies/a','/',0);"><span itemprop="title">A-Z Index of U.S. Government Agencies</span></a></li>
                    <li ><a href="/branches-of-government" class="url" onmousedown="_sendEvent('Outbound','/branches-of-government,'/',0);">Branches of Government</a></li>
                    <li ><a href="/contact-by-topic" class="url" onmousedown="_sendEvent('Outbound','/contact-by-topic','/',0);">Contact Government by Topic</a></li>
                    <li ><a href="/elected-officials" class="url" onmousedown="_sendEvent('Outbound','/elected-officials','/',0);">Elected Officials</a></li>
                    <li ><a href="/state-tribal-governments" class="url" onmousedown="_sendEvent('Outbound','/state-tribal-governments','/',0);">State, Local, and Tribal Governments</a></li>
                </ul>
            </div>
        </section>
    </nav>
<?php else: ?>
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
                    <h2 itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/agencias-gobierno" class="url" itemprop="url" onmousedown="_sendEvent('Outbound','/agencias-gobierno','/',0);"><span itemprop="title">Agencias del Gobierno</span></a></h2>
                </header>
                <ul>
                    <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" class="slctd"><a href="/agencias-federales" class="url" onmousedown="_sendEvent('Outbound','/agencias-federales','/',0);"><span itemprop="title">Agencias federales</span></a></li>
                    <li itemscope="" itemtype="http://data-vocabulary.org/breadcrumb"><a href="/agencias-estatales" class="url" onmousedown="_sendEvent('Outbound','/agencias-estatales','/',0);">Agencias estatales</a></li>
                    <li itemscope="" itemtype="http://data-vocabulary.org/breadcrumb"><a href="/estados-consumidor" class="url" onmousedown="_sendEvent('Outbound','/estados-consumidor','/',0);">Oficinas estatales de protección al consumidor</a></li>
                </ul>
            </div>
        </section>
    </nav>
<?php endif; ?>

<?php $agencyCounter = 1; ?>

<!---right container-->
<div class="col-md-9 rightnav clearfix">

<?php //STATE GOVERNMENT AGENCY ?>

<article>
<header>
    <?php if(!empty($dirRecords[0]->title)): ?>
        <h1><?php print $dirRecords[0]->title; ?></h1>
    <?php endif; ?>
    <?php if(@!empty($dirRecords[0]->field_description['und'][0]['value'])): ?>
        <?php print '<p>' . $dirRecords[0]->field_description['und'][0]['value'] . '</p>'; ?>
    <?php endif; ?>
</header>
<header>
    <h2 ><?php print t('Agency Details'); ?></h2>
</header>
<?php if(@!empty($dirRecords[0]->field_acronym['und'][0]['value']) ): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  itemprop="name"><?php print t('Acronym:'); ?></h3>
        </header>
        <p><?php print $dirRecords[0]->field_acronym['und'][0]['value'] ?></p>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords[0]->field_website_links['und'][0]['value']) ): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  class="org"><?php print t('Website:'); ?></h3>
        </header>
        <?php print $dirRecords[0]->field_website_links['und'][0]['value']; ?>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords[0]->field_contact_links['und'][0]['value']) ): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  itemprop="name"><?php print t('Contact:'); ?></h3>
        </header>
        <?php print $dirRecords[0]->field_contact_links['und'][0]['value']; ?>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords[0]->field_in_person_links['und'][0]['value']) ): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  class="org"><?php print t('Local Offices:'); ?></h3>
        </header>
        <?php print $dirRecords[0]->field_in_person_links['und'][0]['value']; ?>
    </section>
<?php endif; ?>
<?php if(!empty($dirRecords[0]->field_subdivision['und']) || !empty($dirRecords[0]->field_street_1['und']) || !empty($dirRecords[0]->field_street_2['und']) || !empty($dirRecords[0]->field_city['und']) || !empty($dirRecords[0]->field_state['und']) || !empty($dirRecords[0]->field_zip['und'])): ?>
    <?php if(@!empty($dirRecords[0]->field_street_1['und'][0]['value'])): ?>
        <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
            <header>
                <h3  itemprop="name"><?php print t('Main Address:'); ?></h3>
            </header>
            <?php
            print '<p class="spk street-address">';
            if(@!empty($dirRecords[0]->field_subdivision['und'][0]['value'])){
                print $dirRecords[0]->field_subdivision['und'][0]['value'] . '<br>';
            }
            if(@!empty($dirRecords[0]->field_street_1['und'][0]['value'])){
                print $dirRecords[0]->field_street_1['und'][0]['value'] . '<br>';
            }
            if(@!empty($dirRecords[0]->field_street_2['und'][0]['value'])){
                print $dirRecords[0]->field_street_2['und'][0]['value'] . '<br>';
            }
            if(@!empty($dirRecords[0]->field_city['und'][0]['value'])){
                print '<span class="locality">' . $dirRecords[0]->field_city['und'][0]['value'] . '</span>, ';
            }
            if(@!empty($dirRecords[0]->field_state['und'][0]['value'])){
                print '<span class="region">' . $dirRecords[0]->field_state['und'][0]['value'] . '</span> ';
            }
            if(@!empty($dirRecords[0]->field_zip['und'][0]['value'])){
                print '<span class="postal-code">' . $dirRecords[0]->field_zip['und'][0]['value'] . '</span>';
            }
            print '</p>';
            ?>
        </section>
    <?php endif; ?>
<?php endif; ?>
<?php if(@!empty($dirRecords[0]->field_email['und'][0]['value'])): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  class="org"><?php print t('Email:'); ?></h3>
        </header>
        <?php

        if ( strpos($dirRecords[0]->field_email['und'][0]['value'], ' (en inglés)') !== false ):
            $emailAddress = explode(' ', $dirRecords[0]->field_email['und'][0]['value']);
            ?>
            <p><a href="mailto:<?php print $dirRecords[0]->field_email['und'][0]['value']; ?>" target="_top"><?php print $emailAddress[0]; ?></a> (en inglés)</p>
        <?php else: ?>
            <p><a href="mailto:<?php print $dirRecords[0]->field_email['und'][0]['value']; ?>" target="_top"><?php print $dirRecords[0]->field_email['und'][0]['value']; ?></a></p>
        <?php endif; ?>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords[0]->field_phone_number['und'][0]['value'])): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  itemprop="name"><?php print t('Phone Number:'); ?></h3>
        </header>
        <?php
        foreach($dirRecords[0]->field_phone_number['und'] as $dphone) {
            print '<p>'.get_tones($dphone['value']).'</p>';
        }
        ?>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords[0]->field_toll_free_number['und'][0]['value'])): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  class="org"><?php print t('Toll Free:'); ?></h3>
        </header>
        <?php
        foreach($dirRecords[0]->field_toll_free_number['und'] as $dphone) {
            print '<p>'.get_tones($dphone['value']).'</p>';
        }
        ?>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords[0]->field_tty_number['und'][0]['value'])): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  itemprop="name">TTY:</h3>
        </header>
        <?php
        foreach($dirRecords[0]->field_tty_number['und'] as $dphone) {
            print '<p>'.get_tones($dphone['value']).'</p>';
        }
        ?>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords[0]->field_sms_services['und'][0]['value'])): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  class="org">SMS:</h3>
        </header>
        <p><?php print $dirRecords[0]->field_sms_services['und'][0]['value']; ?></p>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords[0]->field_link_form_links['und'][0]['url'])): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  itemprop="name"><?php print t('Forms:'); ?></h3>
        </header>
        <?php print '<p>'.l($dirRecords[0]->field_link_form_links['und'][0]['title'],$dirRecords[0]->field_link_form_links['und'][0]['url']).'</p>'; ?>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords[0]->field_government_branch['und'][0]['value']) && $siteIsUSA == true): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  class="org">Government branch:</h3>
        </header>
        <p><?php
            $image = field_get_items('node', $dirRecords[0], 'field_government_branch');
            $output = field_view_value('node', $dirRecords[0], 'field_government_branch', $image[0]);
            print render($output); ?></p>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords[0]->field_inventory_url['und'][0]['value'])): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  itemprop="name">Program Inventory:</h3>
        </header>
        <p><?php print $dirRecords[0]->field_inventory_url['und'][0]['value']; ?></p>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords[0]->field_english_translation_name['und'][0]['value'])): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  itemprop="name">Agencia en inglés:</h3>
        </header>
        <p><?php print $dirRecords[0]->field_english_translation_name['und'][0]['value']; ?></p>
    </section>
<?php endif; ?>
<p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>

<?php if(@!empty($dirRecords[0]->field_top_task['und'][0]['value'])): ?>
    <section>
        <header>
            <h2><?php
                if($siteIsGobierno == true){
                    print 'Servicios más buscados ';
                } else {
                    print 'Popular Services from ';
                }
                if(!empty($dirRecords[0]->title)){
                    print $dirRecords[0]->title;
                }
                ?></h2>
        </header>
        <?php print $dirRecords[0]->field_top_task['und'][0]['value']; ?>
    </section>
    <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
<?php endif; ?>

<?php if(@!empty($relatedParentNode)): ?>
    <section>
        <header>
            <h2 id=""><?php print t('Parent Agency'); ?></h2>
        </header>
        <ul>
            <li><a href="<?php print _sanitzie_path($relatedParentNode->title); ?>"><?php print $relatedParentNode->title; ?></a></li>
        </ul>
    </section>
<?php endif; ?>

<?php if(@!empty($relatedChildNode)): ?>
    <section>
        <header>
            <h2 id=""><?php print t('Related Agency'); ?></h2>
        </header>
        <ul>
            <?php foreach($relatedChildNode as $row){?>
                <?php if (!empty($row->title)) { ?>
                <li><a href="<?php print _sanitzie_path($row->title); ?>"><?php print $row->title; ?></a></li>
                <?php } ?>
            <?php } ?>
        </ul>
    </section>
<?php endif; ?>

<?php if(@!empty($relatedParentNode) && @!empty($relatedChildNode)): ?>
    <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
<?php endif; ?>
</article>

<?php
if (isset($timestamp) && !empty($timestamp)) {
    // print last reviewed date
    print "<p class='last'>".t('Last Updated').": " . t(date("F", $timestamp)) . " " .date("d, Y", $timestamp) . '</p>';
}
?>
<?php
print _print_social_media();
?>
<?php print survey_on_pages(); ?>
<?php

if(@!empty($dirRecords[0]->field_dir_end_html['und'][0]['value'])){
    $GLOBALS['dirEndHtml'] = $dirRecords[0]->field_dir_end_html['und'][0]['value'];
}

?>
</div>
