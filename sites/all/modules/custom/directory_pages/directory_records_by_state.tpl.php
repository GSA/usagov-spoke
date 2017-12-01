<?php

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

// set target domain
$ruri = request_uri();

if($siteIsGobierno){

    // setting the meta description
    //if(@!empty($dirRecords['SGA'][0]->title)){
    drupal_add_html_head(
        array(
            '#tag' => 'meta',
            '#attributes' => array(
                'name' => 'description',
                'content' =>  'Agencias estatales de ' . ucwords($stateName),
            )
        ),
        'usa_custom_meta_tag_alphaname'
    );
    //}

    // setting the title
    $upperStateName = ucwords($stateName);
    drupal_set_title("Agencias estatales de {$upperStateName}");

} else {

    // setting the meta description
    //if(@!empty($dirRecords['SGA'][0]->title)){
    drupal_add_html_head(
        array(
            '#tag' => 'meta',
            '#attributes' => array(
                'name' => 'description',
                'content' =>  'Primary contact information along with key agencies and offices for the government of ' . ucwords($stateName),
            )
        ),
        'usa_custom_meta_tag_alphaname'
    );
    //}

    // setting the title
    $upperStateName = ucwords($stateName);
    drupal_set_title("Government of {$upperStateName}");

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
                    <h2 itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/state-tribal-governments" itemprop="url" class="url" onmousedown="_sendEvent('Outbound','/state-tribal-governments','/',0);"><span itemprop="title">State and Tribal Governments</span></a></h2>
                </header>
                <ul>
                    <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/tribes" class="url" onmousedown="_sendEvent('Outbound','/tribes','/',0);">Indian Tribes and Resources for American Indians</a></li>
                    <li itemscope="" itemtype="http://data-vocabulary.org/breadcrumb"><a href="/state-consumer" class="url" onmousedown="_sendEvent('Outbound','/state-consumer,'/',0);">State and Local Consumer Agencies</a></li>
                    <li itemscope="" itemtype="http://data-vocabulary.org/breadcrumb" class="slctd"><a href="/states-and-territories" class="url" onmousedown="_sendEvent('Outbound','/states-and-territories','/',0);"><span itemprop="title">State Governments</span></a></li>
                    <li itemscope="" itemtype="http://data-vocabulary.org/breadcrumb"><a href="/state-governor" class="url" onmousedown="_sendEvent('Outbound','/state-governor,'/',0);">State Governors</a></li>
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
                    <h2 itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/agencias-gobierno" itemprop="url" class="url" onmousedown="_sendEvent('Outbound','/agencias-gobierno','/',0);"><span itemprop="title">Agencias del Gobierno</span></a></h2>
                </header>
                <ul>
                    <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/agencias-federales" class="url" onmousedown="_sendEvent('Outbound','/agencias-federales','/',0);">Agencias federales</a></li>
                    <li itemscope="" itemtype="http://data-vocabulary.org/breadcrumb" class="slctd"><a href="/agencias-estatales" class="url" onmousedown="_sendEvent('Outbound','/agencias-estatales','/',0);"><span itemprop="title">Agencias estatales</span></a></li>
                    <li itemscope="" itemtype="http://data-vocabulary.org/breadcrumb"><a href="/estados-consumidor" class="url" onmousedown="_sendEvent('Outbound','/estados-consumidor','/',0);">Oficinas estatales de protección al consumidor</a></li>
                </ul>
            </div>
        </section>
    </nav>
<?php endif; ?>

<!---right container-->
<div class="col-md-9 rightnav clearfix">

<header>
    <?php if(!empty($dirRecords['SGA'][0]->title)): ?>
        <h1><?php print $dirRecords['SGA'][0]->title; ?></h1>
    <?php endif; ?>

    <?php if($siteIsGobierno): ?>
        <p>Información sobre el Gobierno estatal.</p>
    <?php else: ?>
        <p>Primary contact information along with key agencies and offices for the government of <?php print ucwords($stateName); ?></p>
    <?php endif; ?>
</header>

<div class="wotp">
    <header>
        <h2><?php print t('What\'s on This Page'); ?></h2>
    </header>
    <div class="clearfix">
        <ul>
            <?php if(!empty($dirRecords['SGA'][0]->title)): ?>
                <li>
                    <a href="#state-government" onclick="document.getElementById('state-government').focus();"><?php print t('State Government'); ?></a>
                </li>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['DMV'][0]) ): ?>
                <li>
                    <a href="#state-dmv" onclick="document.getElementById('state-dmv').focus();"><?php print t('U.S. Census Data and Statistics'); ?></a>
                </li>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['StateDetails']) && $siteIsUSA == true): ?>
                <li>
                    <a href="#state-agencies" onclick="document.getElementById('state-agencies').focus();"><?php print t('State Agencies'); ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>





<article>
<?php //STATE DETAILS & STATE GOVERNMENT AGENCY ?>
<?php $agencyCounter = 1; ?>

<header>
    <h2 id="state-government"><?php print t('State Government'); ?></h2>
</header>
<?php if(@!empty($dirRecords['StateDetails'][0]->title) ): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  itemprop="name"><?php print t('Official Name:'); ?></h3>
        </header>
        <p>
            <?php if(@!empty($dirRecords['StateDetails'][0]->field_state_homepage['und'][0]['url']) ): ?>
            <a href="<?php print $dirRecords['StateDetails'][0]->field_state_homepage['und'][0]['url']; ?>">
                <?php endif; ?>
                <?php print $dirRecords['StateDetails'][0]->title; ?>
                <?php if(@!empty($dirRecords['StateDetails'][0]->field_state_homepage['und'][0]['url']) ): ?>
            </a>
        <?php endif; ?>
        </p>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords['StateDetails'][0]->field_governor['und'][0]['value']) ): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  class="org"><?php print t('Governor:'); ?></h3>
        </header>
        <p>
            <?php if(@!empty($dirRecords['StateDetails'][0]->field_governor_contact['und'][0]['url']) ): ?>
            <a href="<?php print $dirRecords['StateDetails'][0]->field_governor_contact['und'][0]['url']; ?>">
                <?php endif; ?>
                <?php print $dirRecords['StateDetails'][0]->field_governor['und'][0]['value']; ?>
                <?php if(@!empty($dirRecords['StateDetails'][0]->field_governor_contact['und'][0]['url']) ): ?>
            </a>
        <?php endif; ?>
        </p>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords['StateDetails'][0]->field_state_contact['und'][0]['url']) ): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  itemprop="name"><?php print t('Contact the State:'); ?></h3>
        </header>
        <p><a href="<?php print $dirRecords['StateDetails'][0]->field_state_contact['und'][0]['url']; ?>">Contact <?php print ucwords($stateName); ?></a></p>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords['SGA'][0]->field_email['und'][0]['value'])): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  class="org"><?php print t('Email:'); ?></h3>
        </header>
        <p><a href="mailto:<?php print $dirRecords['SGA'][0]->field_email['und'][0]['value']; ?>" target="_top"><?php print $dirRecords['SGA'][0]->field_email['und'][0]['value']; ?></a></p>
    </section>
<?php endif; ?>
<?php if( !empty($dirRecords['SGA'][0]->field_street_1['und']) ): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  itemprop="name"><?php print t('Main Address:'); ?></h3>
        </header>
        <?php
        print '<p>';
        if(@!empty($dirRecords['SGA'][0]->field_subdivision['und'][0]['value'])){
            print $dirRecords['SGA'][0]->field_subdivision['und'][0]['value'] . '<br>';
        }
        if(@!empty($dirRecords['SGA'][0]->field_street_1['und'][0]['value'])){
            print $dirRecords['SGA'][0]->field_street_1['und'][0]['value'] . '<br>';
        }
        if(@!empty($dirRecords['SGA'][0]->field_street_2['und'][0]['value'])){
            print $dirRecords['SGA'][0]->field_street_2['und'][0]['value'] . '<br>';
        }
        if(@!empty($dirRecords['SGA'][0]->field_city['und'][0]['value'])){
            print '<span class="locality">' . $dirRecords['SGA'][0]->field_city['und'][0]['value'] . '</span>, ';
        }
        if(@!empty($dirRecords['SGA'][0]->field_state['und'][0]['value'])){
            print '<span class="region">' . $dirRecords['SGA'][0]->field_state['und'][0]['value'] . '</span>, ';
        }
        if(@!empty($dirRecords['SGA'][0]->field_zip['und'][0]['value'])){
            print '<span class="postal-code">' . $dirRecords['SGA'][0]->field_zip['und'][0]['value'] . '</span>';
        }
        print '</p>';
        ?>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords['SGA'][0]->field_phone_number['und'][0]['value'])): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  itemprop="name"><?php print t('Phone Number:'); ?></h3>
        </header>
        <p class="spk tel"><?php print get_tones($dirRecords['SGA'][0]->field_phone_number['und'][0]['value']); ?></p>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords['SGA'][0]->field_toll_free_number['und'][0]['value'])): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  class="org"><?php print t('Toll Free:'); ?></h3>
        </header>
        <p class="spk tel"><?php print get_tones($dirRecords['SGA'][0]->field_toll_free_number['und'][0]['value']); ?></p>
    </section>
<?php endif; ?>
<?php if(@!empty($dirRecords['SGA'][0]->field_tty_number['und'][0]['value'])): ?>
    <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
        <header>
            <h3  itemprop="name">TTY:</h3>
        </header>
        <p class="spk tel"><?php print get_tones($dirRecords['SGA'][0]->field_tty_number['und'][0]['value']); ?></p>
    </section>
<?php endif; ?>
<p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>



<?php //DMV ?>
<?php if(@!empty($dirRecords['DMV'][0]) ): ?>
    <?php $agencyCounter2 = 1; ?>

    <header>
        <h2 id="state-dmv"><?php print 'Departamento de Vehículos Motorizados'; ?></h2>
    </header>
    <?php if(@!empty($dirRecords['DMV'][0]->title) ): ?>
        <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter2++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
            <header>
                <h3  itemprop="name"><?php print t('Official Name:'); ?></h3>
            </header>
            <p><?php print $dirRecords['DMV'][0]->title; ?></p>
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
    <?php if(@!empty($dirRecords['DMV'][0]->field_in_person_links['und'][0]['value']) ): ?>
        <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
            <header>
                <h3  class="org"><?php print t('Local Offices:'); ?></h3>
            </header>
            <?php print $dirRecords[0]->field_in_person_links['und'][0]['value']; ?>
        </section>
    <?php endif; ?>
    <?php if(@!empty($dirRecords['DMV'][0]->field_email['und'][0]['value'])): ?>
        <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter2++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
            <header>
                <h3  class="org"><?php print t('Email:'); ?></h3>
            </header>
            <p><a href="mailto:<?php print $dirRecords['DMV'][0]->field_email['und'][0]['value']; ?>" target="_top"><?php print $dirRecords['DMV'][0]->field_email['und'][0]['value']; ?></a></p>
        </section>
    <?php endif; ?>
    <?php if(!empty($dirRecords['DMV'][0]->field_subdivision['und']) || !empty($dirRecords['DMV'][0]->field_street_1['und']) || !empty($dirRecords['DMV'][0]->field_street_2['und']) || !empty($dirRecords['DMV'][0]->field_city['und']) || !empty($dirRecords['DMV'][0]->field_state['und']) || !empty($dirRecords['DMV'][0]->field_zip['und'])): ?>
        <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter2++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
            <header>
                <h3  itemprop="name"><?php print t('Main Address:'); ?></h3>
            </header>
            <?php
            print '<p>';
            if(@!empty($dirRecords['DMV'][0]->field_subdivision['und'][0]['value'])){
                print $dirRecords['DMV'][0]->field_subdivision['und'][0]['value'] . '<br>';
            }
            if(@!empty($dirRecords['DMV'][0]->field_street_1['und'][0]['value'])){
                print $dirRecords['DMV'][0]->field_street_1['und'][0]['value'] . '<br>';
            }
            if(@!empty($dirRecords['DMV'][0]->field_street_2['und'][0]['value'])){
                print $dirRecords['DMV'][0]->field_street_2['und'][0]['value'] . '<br>';
            }
            if(@!empty($dirRecords['DMV'][0]->field_city['und'][0]['value'])){
                print '<span class="locality">' . $dirRecords['DMV'][0]->field_city['und'][0]['value'] . '</span>, ';
            }
            if(@!empty($dirRecords['DMV'][0]->field_state['und'][0]['value'])){
                print '<span class="region">' . $dirRecords['DMV'][0]->field_state['und'][0]['value'] . '</span>, ';
            }
            if(@!empty($dirRecords['DMV'][0]->field_zip['und'][0]['value'])){
                print '<span class="postal-code">' . $dirRecords['DMV'][0]->field_zip['und'][0]['value'] . '</span>';
            }
            print '</p>';
            ?>
        </section>
    <?php endif; ?>
    <?php if(@!empty($dirRecords['DMV'][0]->field_phone_number['und'][0]['value'])): ?>
        <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter2++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
            <header>
                <h3  itemprop="name"><?php print t('Phone Number:'); ?></h3>
            </header>
            <p class="spk tel"><?php print get_tones($dirRecords['DMV'][0]->field_phone_number['und'][0]['value']); ?></p>
        </section>
    <?php endif; ?>
    <?php if(@!empty($dirRecords['DMV'][0]->field_toll_free_number['und'][0]['value'])): ?>
        <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter2++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
            <header>
                <h3  class="org"><?php print t('Toll Free:'); ?></h3>
            </header>
            <p class="spk tel"><?php print get_tones($dirRecords['DMV'][0]->field_toll_free_number['und'][0]['value']); ?></p>
        </section>
    <?php endif; ?>
    <?php if(@!empty($dirRecords['DMV'][0]->field_tty_number['und'][0]['value'])): ?>
        <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter2++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
            <header>
                <h3  itemprop="name">TTY:</h3>
            </header>
            <p class="spk tel"><?php print get_tones($dirRecords['DMV'][0]->field_tty_number['und'][0]['value']); ?></p>
        </section>
    <?php endif; ?>
    <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
<?php endif; ?>


<?php //Stage Agencies List ?>
<?php if(@!empty($dirRecords['StateDetails']) && $siteIsUSA == true): ?>
    <section>
        <header>
            <h2 id="state-agencies">State Agencies</h2>
        </header>
        <ul>
            <?php if(@!empty($dirRecords['StateDetails'][0]->field_attorney_general['und'][0]['url']) ): ?>
                <li><a href="<?php print $dirRecords['StateDetails'][0]->field_attorney_general['und'][0]['url']; ?>">Attorney General</a></li>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['StateDetails'][0]->field_consumer_protection_office['und'][0]['url']) ): ?>
                <li><a href="<?php print $dirRecords['StateDetails'][0]->field_consumer_protection_office['und'][0]['url']; ?>">Consumer Protection Offices</a></li>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['StateDetails'][0]->field_corrections_department['und'][0]['url']) ): ?>
                <li><a href="<?php print $dirRecords['StateDetails'][0]->field_corrections_department['und'][0]['url']; ?>">Corrections Department</a></li>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['StateDetails'][0]->field_education_department['und'][0]['url']) ): ?>
                <li><a href="<?php print $dirRecords['StateDetails'][0]->field_education_department['und'][0]['url']; ?>">Education Department</a></li>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['StateDetails'][0]->field_emergency_management_agenc['und'][0]['url']) ): ?>
                <li><a href="<?php print $dirRecords['StateDetails'][0]->field_emergency_management_agenc['und'][0]['url']; ?>">Emergency Management Agency</a></li>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['StateDetails'][0]->field_election_office['und'][0]['url']) ): ?>
                <li><a href="<?php print $dirRecords['StateDetails'][0]->field_election_office['und'][0]['url']; ?>">Election Office</a></li>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['StateDetails'][0]->field_lottery_results['und'][0]['url']) ): ?>
                <li><a href="<?php print $dirRecords['StateDetails'][0]->field_lottery_results['und'][0]['url']; ?>">Lottery Results</a></li>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['StateDetails'][0]->field_motor_vehicle_offices['und'][0]['url']) ): ?>
                <li><a href="<?php print $dirRecords['StateDetails'][0]->field_motor_vehicle_offices['und'][0]['url']; ?>">Motor Vehicle Offices</a></li>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['StateDetails'][0]->field_surplus_property_sales['und'][0]['url']) ): ?>
                <li><a href="<?php print $dirRecords['StateDetails'][0]->field_surplus_property_sales['und'][0]['url']; ?>">Surplus Property Sales</a></li>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['StateDetails'][0]->field_travel_tourism['und'][0]['url']) ): ?>
                <li><a href="<?php print $dirRecords['StateDetails'][0]->field_travel_tourism['und'][0]['url']; ?>">Travel and Tourism</a></li>
            <?php endif; ?>


        </ul>
    </section>
    <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
<?php endif; ?>


</article>

<?php

if (isset($timestamp) && !empty($timestamp)) {
    // print last reviewed date
    print "<p class='last'>".t('Last Updated').": " . t(date("F", $timestamp)) . " " .date("d, Y", $timestamp) . '</p>';
}
?>
<?php print _print_social_media(); ?>
<?php print survey_on_pages(); ?>
</div>

