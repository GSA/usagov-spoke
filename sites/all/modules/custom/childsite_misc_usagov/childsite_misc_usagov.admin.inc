<?php


/**
 * @file
 * Administrative page for childsite misc usagov module
 *
 */

/**
 * Callback function for administration menu item
 */
function childsite_misc_usagov_admin_settings($form, &$form_state) {
    $form['emailpage_use_HTML_asset'] = array(
        '#type' => 'checkbox',
        '#title' => t('Use CMP HTML Asset'),
        '#return_value' => 1,
        '#default_value' => variable_get('emailpage_use_HTML_asset', TRUE),
    );
    $form['HTML_asset_node_id'] = array(
        '#type' => 'textfield',
        '#size' => 40,
        '#title' => t('HTML Asset Node Nid'),
        '#default_value' => variable_get('HTML_asset_node_id', ''),
        '#description' => t('If you are using HTML ASSET, provide node id.'),
    );
    $form['forward_sender_address'] = array(
        '#type' => 'textfield',
        '#size' => 40,
        '#title' => t('From address'),
        '#default_value' => variable_get('forward_sender_address', variable_get('site_mail', '')),
        '#description' => t('If left blank, the from address entered in the form will be used as the from address for the email.  Enter a valid email address here to override that.  The sender\'s email will still appear in the body of the message.'),
    );

    $options = array(
        'en' => t('English'),
        'es' => t('Spanish'),
    );

    $form['language_setting'] = array(
        '#type' => 'radios',
        '#title' => t('Language'),
        '#options' => $options,
        '#default_value' => variable_get("language_setting", 'en'),
    );

    return system_settings_form($form);
}
