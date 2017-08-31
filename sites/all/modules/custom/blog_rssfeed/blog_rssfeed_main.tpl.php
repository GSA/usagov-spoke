<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Blog.USA.Gov updates</title>
        <link>
            http://<?php print $_SERVER['HTTP_HOST']; ?>/updates.rss
        </link>
        <description>A list of updates on Blog.US.Gov</description>
        <generator>Blog.USA.Gov</generator>
        <language>en-us</language>
        
        <?php if ( !empty($items[0]['pubdate']) ): ?>

            <lastBuildDate>
                <?php print date('D, d M Y H:i:s O', $items[0]['pubdate']); ?>

            </lastBuildDate>
        <?php endif; ?>

        <image>
            <url>http://<?php print $_SERVER['HTTP_HOST']; ?>/sites/all/themes/mars/usa_logo_white_with_bg.png</url>
            <link>http://<?php print $_SERVER['HTTP_HOST']; ?>/</link>
        </image>
        <atom:link href="<?php /* TODO */ ?>/updates.rss" rel="self" type="application/rss+xml" />
        <?php foreach ( $items as $item ): ?>
            <?php print ( is_array($item) ? theme('blog_rssfeed_item', $item) : $item ); ?>
        <?php endforeach; ?>
    </channel>
</rss>