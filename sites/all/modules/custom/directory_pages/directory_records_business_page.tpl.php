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

?>
<nav aria-label="Topic" class="col-md-3 leftnav">
    <section>
        <div class="mrtp">
            <button id="leftnav-toggle" type="button">
                <div class="bttn">
                    <header>
                        <h2 id="">More Topics in this Section</h2>
                    </header>
                </div>
                <div class="mrtpc"> </div>
            </button>
        </div>
        <div class="shade dwn" aria-expanded="false">

            <header>
                <h2 id="" class="test1">
                <span class="arrowLft">
                <a href="/business">Small Business</a>
                </span>
                </h2>
            </header>

            <ul>
                <li><a href="/business-search"><span>Business Keyword Search</span></a></li>
                <li><a href="/business-taxes"><span>Business Tax Information</span></a></li>
                <li><a href="/funding-options"><span>Finance Your Business</span></a></li>
                <li><a href="/expand-business"><span>Grow Your Business</span></a></li>
                <li><a href="/import-export"><span>Importing and Exporting</span></a></li>
                <li><a href="/start-business"><span>Start Your Own Business</span></a></li>
                <li class="slctd"><a href="/state-business"><span>State Business Resources</span></a></li>
            </ul>

        </div>
    </section>
</nav>
<!---right container-->
<div class="col-md-9 col-sm-12 rightnav usa-width-two-thirds">
    <header>
        <h1 id="">Small Business in <?php if ($stateRecords['state_name']!="") : echo ucwords($stateRecords['state_name']); endif; ?></h1>
        <?php
        if($stateRecords['biz_link_url']!="")
        {
            $business_link=$stateRecords['biz_link_url'];
        }
        else{
            $business_link='#';
        }
        ?>
        <p>Find information to help you <a href="<?php echo $business_link; ?>"> do business in <?php if ($stateRecords['state_name']!="") : echo ucwords($stateRecords['state_name']); endif; ?></a>. Learn how to start a business, find funding, win government contracts, and more.</p>
    </header>
    <!-- begin WOTP -->

    <div class="wotp">
        <header>
            <h2 id="">What's on This Page</h2>
        </header>
        <div class="clearfix">
            <ul>
                <?php
                if($stateRecords['opening_biz_links']!="")
                {
                    ?>
                    <li><a href="#opening" onclick="document.getElementById('opening').focus();"><?php print t('Open a Business'); ?></a></li>
                <?php
                }
                if($stateRecords['financing_biz_links']!="")
                {
                    ?>
                    <li><a href="#financing" onclick="document.getElementById('financing').focus();"><?php print t('Access Financing'); ?></a></li>
                <?php
                }
                if($stateRecords['opportunity_biz_links']!="")
                {
                    ?>
                    <li><a href="#stateopps" onclick="document.getElementById('stateopps').focus();"><?php print t('Contracting Opportunities'); ?></a></li>
                <?php
                }
                if($stateRecords['export_biz_links']!="")
                {
                    ?>
                    <li><a href="#export" onclick="document.getElementById('export').focus();"><?php print t('Export your Products'); ?></a></li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <!-- end COTP -->
    <?php
    if($stateRecords['opening_biz_links']!="")
    {
        ?>
        <article>
            <header><h2 id="opening"><?php print t('Open a Business'); ?></h2></header>
            <p>Learn what it takes to start a business in <?php if ($stateRecords['state_name']!="") : echo ucwords($stateRecords['state_name']); endif; ?>.</p>
            <?php echo $stateRecords['opening_biz_links'];?>
            <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
        </article>
    <?php
    }
    ?>

    <?php
    if($stateRecords['financing_biz_links']!="")
    {
        ?>
        <article>
            <header><h2 id="financing"><?php print t('Access Financing'); ?></h2></header>
            <p>Find government-backed loans and other financing programs to start or grow a business in <?php if ($stateRecords['state_name']!="") : echo ucwords($stateRecords['state_name']); endif; ?>.</p>
            <?php echo $stateRecords['financing_biz_links'];?>
            <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
        </article>
    <?php
    }
    ?>

    <?php
    if($stateRecords['opportunity_biz_links']!="")
    {
        ?>
        <article>
            <header><h2 id="stateopps"><?php print t('Contracting Opportunities'); ?></h2></header>
            <p>Learn how to sell to your state or local government.</p>
            <?php echo $stateRecords['opportunity_biz_links'];?>
            <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
        </article>
    <?php
    }
    ?>

    <?php
    if($stateRecords['export_biz_links']!="")
    {
        ?>
        <article>
            <header><h2 id="export"><?php print t('Export your Products'); ?></h2></header>
            <?php echo $stateRecords['export_biz_links'];?>
            <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
        </article>
    <?php
    }
    ?>
    <?php
    if (isset($timestamp) && !empty($timestamp)) {
        // print last reviewed date
        print "<p class='last'>".t('Last Updated').": " . t(date("F", $timestamp)) . " " .date("d, Y", $timestamp) . '</p>';
    }
    ?>
    <?php print survey_on_pages(); ?>
</div>
