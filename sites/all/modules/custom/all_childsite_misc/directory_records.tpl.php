<?php
$dir_path = arg(0);
$l = arg(1);
if (isset($l)) {
    $_REQUEST['letter'] = $l;
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

$usagovURL="//www.usa.gov/";
$gobgovURL="//gobierno.usa.gov/";

// whether to it is dev or local
if (strpos($_SERVER["HTTP_HOST"],'usa.dev') !== false){
    $gobgovURL="//gobierno.usa.dev/";
    $usagovURL="//www.usa.dev/";
}

if (strpos($_SERVER["HTTP_HOST"],'test-') !== false){
    $gobgovURL="//test-gobiernogov.ctacdev.com/";
    $usagovURL="//test-usagov.ctacdev.com/";
}

if (strpos($_SERVER["HTTP_HOST"],'stage-') !== false){
    $gobgovURL="//stage-gobiernogov.ctacdev.com/";
    $usagovURL="//stage-usagov.ctacdev.com/";
}
if ( strpos($_SERVER['HTTP_HOST'], 'gobierno') === false ) {
    $toggleURL = $gobgovURL."agencias-federales/a";
    $GLOBALS['toggleHTML'] = "
      <li class=\"engtoggle\">
        <a href=\"{$toggleURL}\" lang=\"es\" xml:lang=\"es\">
          Espa&ntilde;ol
        </a>
      </li>
    ";
} else {
    $toggleURL = $usagovURL."federal-agencies/a";
    $GLOBALS['toggleHTML'] = "
      <li class=\"engtoggle\">
        <a href=\"{$toggleURL}\" lang=\"en\" xml:lang=\"en\">
          English
        </a>
      </li>
    ";
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
                    <h2 itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" ><a href="/agencies" itemprop="url" class="url" onmousedown="_sendEvent('Outbound','/agencies','/',0);"><span itemprop="title">Government Agencies and Elected Officials</span></a></h2>
                </header>
                <ul>
                    <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" class="slctd"><a href="/federal-agencies/a" class="url" onmousedown="_sendEvent('Outbound','/federal-agencies/a','/',0);"><span itemprop="title">A-Z Index of U.S. Government Agencies</span></a></li>
                    <li ><a href="/branches-of-government" class="url" onmousedown="_sendEvent('Outbound','/branches-of-government,'/',0);">Branches of Government</a></li>
                    <li ><a href="/contact-by-topic" class="url" onmousedown="_sendEvent('Outbound','/contact-by-topic','/',0);">Contact Government by Topic</a></li>
                    <li ><a href="/elected-officials" class="url" onmousedown="_sendEvent('Outbound','/elected-officials','/',0);">Elected Officials</a></li>
                    <li ><a href="/forms/a" class="url" onmousedown="_sendEvent('Outbound','/forms/a','/',0);">Government Forms, by Agency</a></li>
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
                    <h2 itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/agencias-gobierno" itemprop="url" class="url" onmousedown="_sendEvent('Outbound','/agencias-gobierno','/',0);"><span itemprop="title">Agencias del Gobierno</span></a></h2>
                </header>
                <ul>
                    <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" class="slctd"><a href="/agencias-federales" class="url" onmousedown="_sendEvent('Outbound','/agencias-federales','/',0);"><span itemprop="title">Agencias federales</span></a></li>
                    <li ><a href="/agencias-estatales" class="url" onmousedown="_sendEvent('Outbound','/agencias-estatales','/',0);">Agencias estatales</a></li>
                    <li ><a href="/estados-consumidor" class="url" onmousedown="_sendEvent('Outbound','/estados-consumidor','/',0);">Oficinas estatales de protección al consumidor</a></li>
                </ul>
            </div>
        </section>
    </nav>
<?php endif; ?>

<div class="col-md-9 col-sm-12 rightnav">
    <header>
        <h1 id=""><?php print t('A-Z Index of U.S. Government Departments and Agencies'); ?></h1>
    </header>

    <ul class="az-list group">
        <?php
        if (isset($A_to_Z)) {
            foreach($A_to_Z as $letter) {
                $cls = ((isset($_REQUEST['letter']) && strtoupper($_REQUEST['letter']) == $letter['letter'])
                    || (!isset($_REQUEST['letter']) && $letter['letter'] == 'A'))? 'class="current"':'';
                print '<li '.$cls.'>'. (($letter['page_exist'])? (((isset($_REQUEST['letter']) && strtoupper($_REQUEST['letter']) == $letter['letter'])
                        || (!isset($_REQUEST['letter']) && $letter['letter'] == 'A'))? $letter['letter'] : '<a class="atoz_letter" href="/'.$dir_path.'/'. strtolower($letter['letter']) .'">' . $letter['letter'] . '</a>') : $letter['letter']) . '</li>';
            }
        }
        ?>
    </ul>

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

    // Decide which search form to print
    /*
    if( $siteIsUSA ){
        print '<!-- SEARCH TAGS ARE HERE -->
                <div class="ui-widget">
                  <form name="search_form" id="searchForm" accept-charset="UTF-8">
                    <label for="agencySearch"><h2>Type a Government Agency Name: </h2></label>
                    <div class="search-input-container">
                      <div class="search-input-txt-container">
                        <input type="text" id="agencySearch" aria-autocomplete="list" aria-haspopup="true">
                        <div class="search-input-btn-container">
                          <input type="submit" class="search-button" value="Find" style="background-color: rgb(27, 80, 160);">
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                ';
    } elseif ( $siteIsGobierno ){
        print '<!-- SEARCH TAGS ARE HERE -->
                <div class="ui-widget">
                  <form name="search_form" id="searchForm" accept-charset="UTF-8">
                    <label for="agencySearch"><h2>Ingrese el nombre de la agencia del Gobierno: </h2></label>
                    <div class="search-input-container">
                      <div class="search-input-txt-container">
                        <input type="text" id="agencySearch" aria-autocomplete="list" aria-haspopup="true">
                        <div class="search-input-btn-container">
                          <input type="submit" class="search-button" value="Encontrar" style="background-color: rgb(27, 80, 160);">
                        </div>
                      </div>
                    </div>
                  </form>
                </div>';
    }
    */
    ?>
    <?php
    if (isset($page_list)) {
        foreach($page_list as $k => $v) {
            ?>
            <?php
            if ((isset($_REQUEST['letter']) && strtoupper($_REQUEST['letter']) == $k) || (!isset($_REQUEST['letter']) && $k == 'A') ) {
                $link_count = 0;
                print '<header><h2>' . $k . '</h2></header>';
                ?>
                <ul class="one_column_bullet">
                    <?php
                    for($i=0; $i < count($v); $i++){
                        $link_count++;
                        ?>
                        <li> <?php print '<a class="url" href="' . $v[$i]['page_url'] . '">' . $v[$i]['page_title'] . '</a>'; ?> </li>
                    <?php
                    }
                    ?>
                </ul>
            <?php } ?>
        <?php
        }
    }
    // rule #33.A

    if (isset($link_count) && $link_count > 10) {

        ?>


        <ul class="az-list group">
            <?php
            if (isset($A_to_Z)) {
                foreach($A_to_Z as $letter) {
                    $cls = ((isset($_REQUEST['letter']) && strtoupper($_REQUEST['letter']) == $letter['letter'] )
                        || (!isset($_REQUEST['letter']) && $letter['letter']  == 'A'))? 'class="current"':'';
                    print '<li '.$cls.'>'. (($letter['page_exist'])? (((isset($_REQUEST['letter']) && strtoupper($_REQUEST['letter']) == $letter['letter'])
                            || (!isset($_REQUEST['letter']) && $letter['letter'] == 'A'))? $letter['letter'] : '<a class="atoz_letter" href="/'.$dir_path.'/'. strtolower($letter['letter']) .'">' . $letter['letter'] . '</a>') : $letter['letter']) . '</li>';
                }
            }
            ?>
        </ul>
    <?php } ?>

    <?php
    print _print_social_media();
    ?>
    <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
</div>

