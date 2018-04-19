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
                'node' => array(
                    'type' => 'node',
                    'label' => t('Node to be indexed'),
                ),
            ),
        ),
        'usasearch_rules_action_update_index' => array(
            'label' => t('Update index'),
            'group' => t('DigitalGov Search'),
            'parameter' => array(
                'node' => array(
                    'type' => 'node',
                    'label' => t('Node to be indexed'),
                ),
            ),
        ),
        'usasearch_rules_action_remove_from_index' => array(
            'label' => t('Remove from index'),
            'group' => t('DigitalGov Search'),
            'parameter' => array(
                'node' => array(
                    'type' => 'node',
                    'label' => t('Node to be removed from index'),
                ),
            ),
        ),
    );
}

/**
 * Implements hook_rules_condition_info().
 */
function usasearch_rules_condition_info() {
  $conditions['usasearch_rules_condition_is_indexed'] = array(
    'label' => t('Node has been added to the DigitalGov Search index'),
    'description' => t('Returns true if the node has been added to the DigitalGov Search index.'),
    'parameter' => array(
      'node' => array('type' => 'node', 'label' => t('Content')),
    ),
    'group' => t('DigitalGov Search'),
  );

  return $conditions;
}

// This callback creates the hashed string by using the parameters provided through rules' UI
function usasearch_rules_action_add_to_index($node) {
    usasearch_api_index_document($node, 'insert');
}
function usasearch_rules_action_update_index($node) {
    usasearch_api_index_document($node, 'update');
}
function usasearch_rules_action_remove_from_index($node) {
    usasearch_api_index_document($node, 'delete');
}

/**
 * Rules condition callback to determine if node currently appears in the index.
 *
 * @param $node
 *   The node to check.
 *
 * @return bool
 *   Returns TRUE if the node's index status exists and is set to 1.
 */
function usasearch_rules_condition_is_indexed($node) {
  $values = usasearch_getIndexStatus($node);
  return $values && $values['index_status'] == 1;
}
