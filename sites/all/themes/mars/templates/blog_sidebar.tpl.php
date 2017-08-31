<section class="region region-sidebar-first column sidebar">


    <!-- START: "About USAGov" block -->
    <div id="block-block-2" class="block block-block contextual-links-region first odd">
        <nav class="leftnav">
            <section>
                <div class="shade">
                    <header>
                        <h2 class="block__title block-title">About USAGov</h2>
                    </header>
                    <p>
                        USAGov is working to create the digital front door for the United States government.
                        Follow our progress and help us learn as we go!
                    </p>
                </div>
            </section>
        </nav>
    </div>
    <!-- END: "About USAGov" block -->


    <!-- START: "Topics" block -->
    <div id="block-menu-menu-topics" class="block block-menu contextual-links-region even" role="navigation">
        <nav class="leftnav">
            <section>
                <div class="shade">
                    <header>
                        <h2 class="block__title block-title">Topics</h2>
                    </header>
                    <ul class="menu">
                        <?php if ( empty($topics) ): ?>
                            Error - $topics variable is empty in <?php print __FILE__; ?><br/>
                            Is the mars_preprocess_blog_sidebar() preproccessor function working correctly?
                        <?php elseif ( !is_array($topics) ): ?>
                            <?php print $topics; ?>
                        <?php elseif ( is_array($topics) && count($topics) == 0 ): ?>
                            <i>No in-use topics available at this time.</i>
                        <?php else: ?>
                            <?php foreach ( $topics as $topic ): ?>
                                <li>
                                    <a href="<?php print $topic['url']; ?>" class="menu__link">
                                        <?php print $topic['title']; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </section>
        </nav>
    </div>
    <!-- END: "Topics" block -->


    <!-- START: "Posts by Date" block -->
    <div id="block-block-1" class="block block-block contextual-links-region odd">
        <nav class="leftnav">
            <section>
                <div class="shade">
                    <header>
                        <h2 class="block__title block-title"><label for="postsByDate">Posts by Date</label></h2>
                    </header>

                    <?php if ( empty($postDateOptions) ): ?>
                        <option value="volvo">
                            Error - $postDateOptions variable is empty in <?php print __FILE__; ?><br/>
                            Is the mars_preprocess_blog_sidebar() preproccessor function working correctly?
                        </option>
                    <?php elseif ( !is_array($postDateOptions) ): ?>
                        <?php print $postDateOptions; ?>
                    <?php elseif ( is_array($postDateOptions) && count($postDateOptions) == 0 ): ?>
                        <i>There are no post-dates available at this time.</i>
                    <?php else: ?>
                        <select name="postsByDate" id="postsByDate">
                            <option value="nodate" selected="selected">
                                Select Date
                            </option>
                            <?php foreach ( $postDateOptions as $postDateValue => $postDateLabel ): ?>
                                <option value="<?php print $postDateValue; ?>">
                                    <?php print $postDateLabel; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>

                    <p>
                        <script>
                            function seePosts() {
                                var param = jQuery('#postsByDate').val();
                                if ( param == 'nodate' ) {
                                    jQuery('#postsByDate').fadeOut().fadeIn()
                                } else {
                                    document.location = '/' + param;
                                }
                            }
                        </script>
                        <button onclick="seePosts();">
                            See Posts
                        </button>
                    </p>
                </div>
            </section>
        </nav>
    </div>
    <!-- END: "Posts by Date" block -->


    <!-- START: "Sign Up For Updates" block -->
    <div id="block-menu-menu-sign-up-for-updates" class="block block-menu contextual-links-region last even">
        <nav class="leftnav">
            <section>
                <div class="shade">
                    <header>
                        <h2 class="block__title block-title">Sign Up for Updates</h2>
                    </header>
                    <ul class="menu">
                        <li>
                            <a href="http://connect.usa.gov/blog-email-sign-up-page" class="menu__link" onmousedown="_sendEvent('Outbound','blog.usa.gov','/',0);">
                                Get E-mail Updates
                            </a>
                        </li>
                        <li>
                            <a href="/updates.rss" class="menu__link" onmousedown="_sendEvent('Outbound','blog.usa.gov','/updates.rss',0);">
                                RSS Feed
                            </a>
                        </li>
                    </ul>
                </div>
            </section>
        </nav>
    </div>
    <!-- END: "Sign Up For Updates" block -->


</section>
