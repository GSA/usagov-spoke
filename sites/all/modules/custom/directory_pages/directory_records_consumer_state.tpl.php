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
                'content' =>  'Información sobre programas y servicios locales, obtenga ayuda para presentar una queja, etc.',
            )
        ),
        'usa_custom_meta_tag_consumer'
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
                'content' =>  'State and local consumer agencies in ' . ucwords($stateName) . '. Get advice, help with complaints, and more.',
            )
        ),
        'usa_custom_meta_tag_consumer'
    );
    // }

    // setting the title
    $upperStateName = ucwords($stateName);
    drupal_set_title("State and Local Consumer Agencies in {$upperStateName}");

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
                    <li itemscope="" itemtype="http://data-vocabulary.org/breadcrumb" class="slctd"><a href="/state-consumer" class="url" onmousedown="_sendEvent('Outbound','/state-consumer','/',0);"><span itemprop="title">State and Local Consumer Agencies</span></a></li>
                    <li itemscope="" itemtype="http://data-vocabulary.org/breadcrumb"><a href="/states-and-territories" class="url" onmousedown="_sendEvent('Outbound','/states-and-territories','/',0);">State Governments</a></li>
                    <li itemscope="" itemtype="http://data-vocabulary.org/breadcrumb"><a href="/state-governor" class="url" onmousedown="_sendEvent('Outbound','/state-governor','/',0);">State Governors</a></li>
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
                    <li itemscope="" itemtype="http://data-vocabulary.org/breadcrumb"><a href="/agencias-estatales" class="url" onmousedown="_sendEvent('Outbound','/agencias-estatales','/',0);">Agencias estatales</a></li>
                    <li itemscope="" itemtype="http://data-vocabulary.org/breadcrumb" class="slctd"><a href="/estados-consumidor" class="url" onmousedown="_sendEvent('Outbound','/estados-consumidor','/',0);"><span itemprop="title">Oficinas estatales de protección al consumidor</span></a></li>
                </ul>
            </div>
        </section>
    </nav>
<?php endif; ?>

<?php $agencyCounter = 1; ?>

<!---right container-->
<div class="col-md-9 rightnav clearfix">

    <header>
        <?php if($siteIsGobierno): ?>
            <h1>Organizaciones de ayuda al consumidor de <?php print t(ucwords($stateName)); ?></h1>
        <?php else: ?>
            <h1>State and Local Consumer Agencies in  <?php print ucwords($stateName); ?></h1>
            <p>Get advice, help with complaints, and more.</p>
        <?php endif; ?>
    </header>

    <div class="wotp">
        <header>
            <h2><?php print t('What\'s on This Page'); ?></h2>
        </header>
        <div class="clearfix">
            <ul>
                <?php if(@!empty($dirRecords['GCPO']['State']) || @!empty($dirRecords['GCPO']['Regional']) || @!empty($dirRecords['GCPO']['County']) || @!empty($dirRecords['GCPO']['City']) && $siteIsGobierno == true): ?>
                    <li>
                        <a href="#es-1-off-hop" onclick="document.getElementById('es-1-off-hop').focus();"><?php print t('Consumer Protection Offices'); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(@!empty($dirRecords['GCPO']['State']) && $siteIsUSA == true): ?>
                    <li>
                        <a href="#gcpo-state" onclick="document.getElementById('gcpo-state').focus();"><?php print t('State Consumer Protection Offices'); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(@!empty($dirRecords['GCPO']['Regional']) && $siteIsUSA == true): ?>
                    <li>
                        <a href="#gcpo-regional" onclick="document.getElementById('gcpo-regional').focus();"><?php print t('Regional Consumer Protection Offices'); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(@!empty($dirRecords['GCPO']['County']) && $siteIsUSA == true): ?>
                    <li>
                        <a href="#gcpo-county" onclick="document.getElementById('gcpo-county').focus();"><?php print t('County Consumer Protection Offices'); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(@!empty($dirRecords['GCPO']['City']) && $siteIsUSA == true): ?>
                    <li>
                        <a href="#gcpo-city" onclick="document.getElementById('gcpo-city').focus();"><?php print t('City Consumer Protection Offices'); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(@!empty($dirRecords['SBA'])): ?>
                    <li>
                        <a href="#sba" onclick="document.getElementById('sba').focus();"><?php print t('Banking Authorities'); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(@!empty($dirRecords['SIR'])): ?>
                    <li>
                        <a href="#sir" onclick="document.getElementById('sir').focus();"><?php print t('Insurance Regulators'); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(@!empty($dirRecords['SSA'])): ?>
                    <li>
                        <a href="#ssa" onclick="document.getElementById('ssa').focus();"><?php print t('Securities Administrators'); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(@!empty($dirRecords['SUC'])): ?>
                    <li>
                        <a href="#suc" onclick="document.getElementById('suc').focus();"><?php print t('Utility Commissions'); ?></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <article>


        <?php //Rendering the Consumer Protection Offices ?>
        <?php if(@!empty($dirRecords['GCPO']['State']) || @!empty($dirRecords['GCPO']['Regional']) || @!empty($dirRecords['GCPO']['County']) || @!empty($dirRecords['GCPO']['City'])): ?>
            <header>
                <h2 id="es-1-off-hop"><?php print t('Consumer Protection Offices'); ?></h2>
                <p><?php print t('City, county, regional, and state consumer offices offer a variety of important services. They might mediate complaints, conduct investigations, prosecute offenders of consumer laws, license and regulate professional service providers, provide educational materials and advocate for consumer rights. To save time, call before sending a written complaint. Ask if the office handles the type of complaint you have and if complaint forms are provided.'); ?></p>
            </header>
            <?php if(@!empty($dirRecords['GCPO']['State'])): ?>
                <?php if($siteIsUSA == true): ?>
                    <header>
                        <h2 id="gcpo-state"><?php print t('State Consumer Protection Offices'); ?></h2>
                    </header>
                <?php endif; ?>
                <?php buildTables($dirRecords['GCPO']['State']); ?>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['GCPO']['Regional'])): ?>
                <?php if($siteIsUSA == true): ?>
                    <header>
                        <h2 id="gcpo-regional"><?php print t('Regional Consumer Protection Offices'); ?></h2>
                    </header>
                <?php endif; ?>
                <?php buildTables($dirRecords['GCPO']['Regional']); ?>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['GCPO']['County'])): ?>
                <?php if($siteIsUSA == true): ?>
                    <header>
                        <h2 id="gcpo-county"><?php print t('County Consumer Protection Offices'); ?></h2>
                    </header>
                <?php endif; ?>
                <?php buildTables($dirRecords['GCPO']['County']); ?>
            <?php endif; ?>
            <?php if(@!empty($dirRecords['GCPO']['City'])): ?>
                <?php if($siteIsUSA == true): ?>
                    <header>
                        <h2 id="gcpo-city"><?php print t('City Consumer Protection Offices'); ?></h2>
                    </header>
                <?php endif; ?>
                <?php buildTables($dirRecords['GCPO']['City']); ?>
            <?php endif; ?>


        <?php endif; ?>

        <?php //Banking Authorities ?>
        <?php if(@!empty($dirRecords['SBA'])): ?>
            <header>
                <h2 id="sba"><?php print t('Banking Authorities'); ?></h2>
                <p><?php print t('The officials listed in this section regulate and supervise state-chartered banks. Many of them handle or refer problems and complaints about other types of financial institutions as well. Some also answer general questions about banking and consumer credit. If you are dealing with a federally chartered bank, check Federal Agencies.'); ?></p>
            </header>
            <?php buildTables($dirRecords['SBA']); ?>
        <?php endif; ?>

        <?php //State Insurance Regulator ?>
        <?php if(@!empty($dirRecords['SIR'])): ?>
            <header>
                <h2 id="sir"><?php print t('Insurance Regulators'); ?></h2>
                <p><?php print t('Each state has its own laws and regulations for each type of insurance. The officials listed in this section enforce these laws. Many of these offices can also provide you with information to help you make informed insurance buying decisions.'); ?></p>
            </header>
            <?php buildTables($dirRecords['SIR']); ?>
        <?php endif; ?>

        <?php //State Securities Administrator ?>
        <?php if(@!empty($dirRecords['SSA'])): ?>
            <header>
                <h2 id="ssa"><?php print t('Securities Administrators'); ?></h2>
                <p><?php print t('Each state has its own laws and regulations for securities brokers and securities - including stocks, mutual funds, commodities, real estate, etc. The officials and agencies listed in this section enforce these laws and regulations. Many of these offices can also provide information to help you make informed investment decisions.'); ?></p>
            </header>
            <?php buildTables($dirRecords['SSA']); ?>
        <?php endif; ?>

        <?php //State Utility Commission ?>
        <?php if(@!empty($dirRecords['SUC'])): ?>
            <header>
                <h2 id="suc"><?php print t('Utility Commissions'); ?></h2>
                <p><?php print t('State Utility Commissions regulate services and rates for gas, electricity and telephones within your state. In some states, the utility commissions regulate other services such as water, transportation, and the moving of household goods. Many utility commissions handle consumer complaints. Sometimes, if a number of complaints are received about the same utility matter, they will conduct investigations.'); ?></p>
            </header>
            <?php buildTables($dirRecords['SUC']); ?>
        <?php endif; ?>






    </article>

    <?php
    print _print_social_media();
    print survey_on_pages();
    if (isset($timestamp) && !empty($timestamp)) {
        // print last reviewed date
        print "<p class='last'>".t('Last Updated').": " . t(date("F", $timestamp)) . " " .date("d, Y", $timestamp) . '</p>';
    }
    ?>


</div>






<?php
function buildTables($arr){
    foreach($arr as $item){
        $agencyCounter = 1;
        ?>
        <?php if(@!empty($item->title)): ?>
            <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="otlnhdr">
                <header>
                    <h3><?php print $item->title; ?></h3>
                </header>
            </section>
        <?php endif; ?>
        <?php if(@!empty($item->field_website_links['und'][0]['value']) ): ?>
            <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
                <header>
                    <h3  class="org"><?php print t('Website:'); ?></h3>
                </header>
                <?php print $item->field_website_links['und'][0]['value']; ?>
            </section>
        <?php endif; ?>
        <?php if(@!empty($item->field_email['und'][0]['value'])): ?>
            <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
                <header>
                    <h3  class="org"><?php print t('Email:'); ?></h3>
                </header>
                <p><a href="mailto:<?php print $item->field_email['und'][0]['value']; ?>" target="_top"><?php print $item->field_email['und'][0]['value']; ?></a></p>
            </section>
        <?php endif; ?>
        <?php if( !empty($dirRecords['SGA'][0]->field_street_1['und']) ): ?>
            <?php if(@!empty($item->field_street_1['und'][0]['value'])): ?>
                <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
                    <header>
                        <h3  itemprop="name"><?php print t('Main Address:'); ?></h3>
                    </header>
                    <?php
                    print '<p class="spk street-address">';
                    if(@!empty($item->field_subdivision['und'][0]['value'])){
                        print $item->field_subdivision['und'][0]['value'] . '<br>';
                    }
                    if(@!empty($item->field_street_1['und'][0]['value'])){
                        print $item->field_street_1['und'][0]['value'] . '<br>';
                    }
                    if(@!empty($item->field_street_2['und'][0]['value'])){
                        print $item->field_street_2['und'][0]['value'] . '<br>';
                    }
                    if(@!empty($item->field_city['und'][0]['value'])){
                        print '<span class="locality">' . $item->field_city['und'][0]['value'] . '</span>, ';
                    }
                    if(@!empty($item->field_state['und'][0]['value'])){
                        print '<span class="region">' . $item->field_state['und'][0]['value'] . '</span> ';
                    }
                    if(@!empty($item->field_zip['und'][0]['value'])){
                        print '<span class="postal-code">' . $item->field_zip['und'][0]['value'] . '</span>';
                    }
                    print '</p>';
                    ?>
                </section>
            <?php endif; ?>
        <?php endif; ?>
        <?php if(@!empty($item->field_phone_number['und'][0]['value'])): ?>
            <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
                <header>
                    <h3  itemprop="name"><?php print t('Phone Number:'); ?></h3>
                </header>
                <p><?php print get_tones($item->field_phone_number['und'][0]['value']); ?></p>
            </section>
        <?php endif; ?>
        <?php if(@!empty($item->field_toll_free_number['und'][0]['value'])): ?>
            <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
                <header>
                    <h3  class="org"><?php print t('Toll Free:'); ?></h3>
                </header>
                <p><?php print get_tones($item->field_toll_free_number['und'][0]['value']); ?></p>
            </section>
        <?php endif; ?>
        <?php if(@!empty($item->field_tty_number['und'][0]['value'])): ?>
            <section itemscope="" itemtype="http://microformats.org/wiki/hCard" class="<?php echo (($agencyCounter++) % 2 == 0) ? 'otlnrw' : 'otln' ?>">
                <header>
                    <h3  itemprop="name">TTY:</h3>
                </header>
                <p><?php print get_tones($item->field_tty_number['und'][0]['value']); ?></p>
            </section>
        <?php endif; ?>
    <?php

    }
    print '<p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl">' . t('Back to Top') . '</span></a></p>';
}

?>













