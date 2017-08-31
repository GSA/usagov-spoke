<?php

/**
 * Implement hook_rules_action_info().
 */
function usasearch_rules_action_info() {
    return array(
        'usasearch_rules_action_add_to_index' => array(
            'label' => t('Add to index'),
            'group' => t('DigitalGov Search'),
            'parameter' => array(
                'string' => array(
                    'type' => 'text',
                    'label' => t('Node to be indexed'),
                    'description' => t('Pass the nid of the content to be indexed.'),
                ),
            ),
        ),
        'usasearch_rules_action_update_index' => array(
            'label' => t('Update index'),
            'group' => t('DigitalGov Search'),
            'parameter' => array(
                'string' => array(
                    'type' => 'text',
                    'label' => t('Node to be indexed'),
                    'description' => t('Pass the nid of the content to be updated in the index.'),
                ),
            ),
        ),
        'usasearch_rules_action_remove_from_index' => array(
            'label' => t('Remove from index'),
            'group' => t('DigitalGov Search'),
            'parameter' => array(
                'string' => array(
                    'type' => 'text',
                    'label' => t('Node to be removed from index'),
                    'description' => t('Pass the nid of the content to be indexed.'),
                ),
            ),
        ),
    );
}

// This callback creates the hashed string by using the parameters provided through rules' UI
function usasearch_rules_action_add_to_index($nid) {
    $node = node_load($nid);
    usasearch_api_index_document($node, 'insert');
}
function usasearch_rules_action_update_index($nid) {
    $node = node_load($nid);
    usasearch_api_index_document($node, 'update');
}
function usasearch_rules_action_remove_from_index($nid) {
    $node = node_load($nid);
    usasearch_api_index_document($node, 'delete');
}