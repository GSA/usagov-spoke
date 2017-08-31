<?php

// Determin which site we are running
$siteName = variable_get('site_name', '');
$siteIsUSA = false;
$siteIsGobierno = false;

$args = arg();
$is_landing = false;

if ( strpos(strtolower($siteName), 'gobierno') !== false ) {
    $siteIsGobierno = true;
}
elseif(strpos(strtolower($siteName), 'kids') !== false) {
    $siteIsKids = true;
}
else {
    $siteIsUSA = true;
}

if ($siteIsUSA) {
    $path = 'site-index';
    $title = "Site Index";
    $intro = "This is an alphabetical list of all the pages on USA.gov that are not listings in our agency directories.";
    $toggleHTML = "
				<li class=\"engtoggle\">

					<a href=\"" . ($_SERVER['HTTP_HOST'] != "//gobierno.usa.gov"? "//gobierno.usa.gov" : "https://www.usa.gov/gobiernousa")."/sitio-indice" . "\" lang=\"es\" xml:lang=\"es\">
						Espa&ntilde;ol
					</a>
				</li>
			";
    if (isset($args[0]) == $path && !isset($args[1])) {
        $is_landing = true;
    }
}

if ($siteIsGobierno) {
    $path = 'sitio-indice';
    $title = "Índice del sitio";
    $intro = "Este es el listado en orden alfabético de todas las páginas en el sitio web de Gobierno.USA.gov que no están incluídas en nuestro directorio de agencias.";
    $toggleHTML = "
				<li class=\"engtoggle\">
					<a href=\"" . ( ($_SERVER['HTTP_HOST'] != "//usa.gov/" && $_SERVER['HTTP_HOST'] != "//www.usa.gov/") ? "//www.usa.gov/" : "https://www.usa.gov")."/site-index" . "\" lang=\"en\" xml:lang=\"en\">
						English
					</a>
				</li>
			";
    if (isset($args[0]) == $path && !isset($args[1])) {
        $is_landing = true;
    }
}

if (!empty($siteIsKids)) {
$path = 'about-us/site-map/index.shtml';
$title = "Site Index";
}
?>


<!-- begin toggle -->
<div id="#skiptarget" class="hptoggles clearfix">
    <div class="container">
        <ul>
<?php if (!empty($toggleHTML)) { ?>

            <?php print $toggleHTML; ?>

<?php } ?>
        </ul>
    </div>
</div>
<!-- end toggle -->

<header>
    <?php

        print '<h1>' . $title . '</h1>';
        print '<p>' . $intro . '</p>';

    ?>
</header>
<ul class="az-list group">
    <?php
    if (isset($A_to_Z)) {
        foreach($A_to_Z as $letter) {
            $cls = ((isset($_REQUEST['letter']) && strtoupper($_REQUEST['letter']) == $letter['letter']) || ($is_landing && $letter['letter'] == 'A'))? 'class="current"':'';
            print '<li '.$cls.'>'. (($letter['page_exist'])? (((isset($_REQUEST['letter']) && strtoupper($_REQUEST['letter']) == $letter['letter'])
                    || ($is_landing && $letter['letter'] == 'A'))? $letter['letter'] : '<a class="atoz_letter" href="/'.$path.'/'. strtolower($letter['letter']) .'">' . $letter['letter'] . '</a>') : $letter['letter']) . '</li>';
        }
    }
    ?>
</ul>

<div class="col-md-9 col-sm-12 rightnav">


<?php
if (isset($page_list)) {
    foreach($page_list as $k => $v) {
        ?>
        <?php
        if ((isset($_REQUEST['letter']) && strtoupper($_REQUEST['letter']) == $k) || ($is_landing && $k == 'A') ) {
            $link_count = 0;
            print '<h2>' . $k . '</h2>';
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
            $cls = ((isset($_REQUEST['letter']) && strtoupper($_REQUEST['letter']) == $letter['letter'] ) || ($is_landing && $letter['letter']  == 'A'))? 'class="current"':'';
            print '<li '.$cls.'>'. (($letter['page_exist'])? (((isset($_REQUEST['letter']) && strtoupper($_REQUEST['letter']) == $letter['letter'])
                    || ($is_landing && $letter['letter'] == 'A'))? $letter['letter'] : '<a class="atoz_letter" href="/'.$path.'/'. strtolower($letter['letter']) .'">' . $letter['letter'] . '</a>') : $letter['letter']) . '</li>';
        }
    }
    ?>
</ul>
<?php } ?>

    <p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl"><?php print t('Back to Top'); ?></span></a></p>
</div>
