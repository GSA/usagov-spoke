<?php /*

    [--] PURPOSE [--]
    
    This script assists in the ordering of the following Views:
        general_content_page
        general_content_page_sticky
        general_content_page_jump
        general_content_page_single_item

    [--] TECHNICAL NOTES [--]

    This script will look at the 1st argument past to the Views, which should be a list 
    of asset (node) IDs, and force the Views to output in the order the nodes were supplied.

*/


/**
 * Implements HOOK_menu().
 */
hooks_reaction_add("hook_views_query_alter",
    function (&$view, &$query) {

        // We only want to fire this code on the following Views
        $viewTargets = array(
            'general_content_page', 
            'general_content_page_sticky', 
            'general_content_page_jump',
            'general_content_page_single_item'
        );
        if ( !in_array($view->name, $viewTargets) ) {
            return;
        }

        // We expect to be given an argument
        if ( empty($view->args[0]) ) {
            return;
        }

        // Enforce View sorting 
        $nidList = str_replace('+', ',', $view->args[0]);
        $query->orderby = array(
            array(
                'field' => "FIELD(node.nid, {$nidList})",
                'direction' => 'ASC'
            )
        );
    }
);
