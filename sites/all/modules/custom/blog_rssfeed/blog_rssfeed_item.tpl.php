
    <item>
        <title>
            <?php print $title; ?>

        </title>
        <link>
            http://<?php print $_SERVER['HTTP_HOST'].'/'.drupal_get_path_alias('node/'.$nid); ?>

        </link>
        <pubDate>
            <?php print date('D, d M Y H:i:s O', $pubdate); ?>

        </pubDate>
        <author>
            <?php print $author; ?>

        </author>
        <guid>
            http://<?php print $_SERVER['HTTP_HOST'].'/'.drupal_get_path_alias('node/'.$nid); ?>

        </guid>
        <description>
            <![CDATA[
                <?php if ($image): ?>
                    <img src="https:<?php print $image; ?>" />

                <?php endif; ?>
                <?php print trim($description); ?>

            ]]>
        </description>
        
    </item>