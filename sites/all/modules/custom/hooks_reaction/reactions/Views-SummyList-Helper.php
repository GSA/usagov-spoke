<?php /*

    [--] WEBSITE [--]

    This script is used with the Blog.USA.Gov site.
    This script is not needed on any of the other CMP-ChildSites.

    [--] PURPOSE [--]

    This script will look at the argument(s) past to the summary_list View, and make needed
    changes the to View query.

*/


/**
 * Implements HOOK_menu().
 *
 * This script will look at the 2 arguments past to the summary_list/bymonth View, which should be
 * a month number and a year number, and force the Views to output filtering the month/year.
 *
 * This script will look at the argument past to the summary_list/bytopic View, which should be
 * a [URL-friendly] title of a taxonomy-term - this script will replace the title with the associated
 * term-ID (in the View query).
 */
hooks_reaction_add("hook_views_query_alter",
    function (&$view, &$query) {

        // We need to touch up the "summary_list" View's "bymonth" display
        if ( $view->name === 'summary_list' && $view->current_display === 'bymonth' ) {

            // We expect to be given 2 arguments here
            if ( empty($view->args[0]) || empty($view->args[1]) ) {
                return;
            }

            // Determine the dates to filter in unix-time
            $postsFromDate = mktime(0, 0, 0, $view->args[0], 1, $view->args[1]);
            $postsToDate = strtotime('+1 month', $postsFromDate);

            // Enforce date-filtration
            $query->where[1]['conditions'][] = array(
                'field' => "field_blog_pub_date_value BETWEEN {$postsFromDate} AND {$postsToDate}",
                'value' => array(),
                'operator' => 'formula',
            );
        }

    }
);
