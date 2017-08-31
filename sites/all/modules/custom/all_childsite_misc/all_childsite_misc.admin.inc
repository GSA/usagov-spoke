<?php



/**
 * @file
 * Administrative page for childsite misc usagov module
 *
 */

/**
 * Callback function for administration menu item
 */
function all_childsite_misc_admin_settings($form, &$form_state) {

    $form['use_by'] = array(
        '#type' => 'textfield',
        '#size' => 40,
        '#title' => t('Use By'),
        '#default_value' => variable_get('use_by', 'USA.gov'),
        '#description' => t('Use By Field value'),
    );

    $form['usagov_api_source'] = array(
        '#type' => 'textfield',
        '#size' => 255,
        '#title' => t('USA.gov API Source'),
        '#default_value' => variable_get('usagov_api_source', 'http://platform-api.usa.gov'),
    );

    return system_settings_form($form);
}
