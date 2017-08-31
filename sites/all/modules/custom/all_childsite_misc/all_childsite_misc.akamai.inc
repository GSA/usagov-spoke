<?php
/*
function all_childsite_misc_form_alter(&$form, &$form_state, $form_id)
{
        if ( $form_id == 'akamai_settings' )
        {
                /// add cpcode setting
                array_unshift( $form['#validate'], 'all_childsite_misc_akamai_settings_validate' );
                $form['akamai_cpcode'] = array(
                        '#type' => 'textfield',
                        '#title' => 'CP Code',
                        '#default_value' => variable_get( 'akamai_cpcode' )
                );
                return;
        } else if ( $form_id == 'akamai_cache_control' ) {
                /// add "entire site" option
                $form['#submit_og'] = $form['#submit'];
                $form['#submit'] = ['all_childsite_misc_akamai_cache_control_submit'];
                return;
        }
}
*/
function all_childsite_misc_akamai_settings_validate($form, &$form_state)
{
        $cpcode = !empty($form_state['values']['akamai_cpcode']) ? $form_state['values']['akamai_cpcode'] : null;
        variable_set( 'akamai_cpcode', $cpcode );
}

function all_childsite_misc_akamai_cache_control_submit($form, &$form_state)
{
        if ( !empty($form_state['values']['paths']) &&
             in_array(trim($form_state['values']['paths']),['*']) )
        {
                if( akamai_clear_site(variable_get('akamai_cpcode')) )
                {
                    drupal_set_message(t('Akamai Full-Site Cache-Clearing request has been sent.'));
                } else {
                    drupal_set_message(t('Akamai Full-Site Cache-Clearing request not sent.'),'error');
                }
        } else {
                foreach ( $form['#submit_og'] as $k => $func )
                {
                        call_user_func( $func, $form, $form_state );
                }
        }
}
/*
function all_childsite_misc_usa_data_migration_synched($entityType, $entityIds, $cmpContentUpdatedSince)
{
    if ( $cmpContentUpdatedSince === 0 )
    {
        if ( $cpcode=variable_get('akamai_cpcode') )
        {
               akamai_clear_site($cpcode);
        }
    } else if ( $cmpContentUpdatedSince > 0 && $entityType=='terms' && !empty($entityIds) ) {
        $friendlyUrlSql = "
            SELECT DISTINCT
        		u.field_friendly_url_value
        	FROM
                field_data_field_friendly_url u
            WHERE
                u.entity_id IN (". implode(',',$entityIds) .")
        ";
        $results = db_query($friendlyUrlSql);
        if ( $results->rowCount() )
        {
            $friendlyUrls = $results->fetchCol();
            $urlPaths = array_map(function($url){
                $parsedUrl = parse_url($url);
                $path     = isset($parsedUrl['path'])     ?       $parsedUrl['path']     : '';
                $query    = isset($parsedUrl['query'])    ? '?' . $parsedUrl['query']    : '';
                $fragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';
                return "$path$query$fragment";
            },$friendlyUrls);
            akamai_clear_url($urlPaths);
        }
    } else if ( $cmpContentUpdatedSince > 0 && $entityType=='nodes' && !empty($entityIds) ) {
        $friendlyUrlSql = "
            SELECT DISTINCT
        		u.field_friendly_url_value
        	FROM
        		(SELECT DISTINCT entity_id FROM(
        			SELECT entity_id, field_asset_order_carousel_target_id as target_id
                    FROM   field_data_field_asset_order_carousel
                        UNION
        			SELECT entity_id, field_asset_order_content_target_id as target_id
                    FROM   field_data_field_asset_order_content
        			    UNION
        			SELECT entity_id, field_asset_order_sidebar_target_id as target_id
                    FROM   field_data_field_asset_order_sidebar
                        UNION
        			SELECT entity_id, field_asset_order_bottom_target_id as target_id
                    FROM   field_data_field_asset_order_bottom
        		) o WHERE o.target_id IN (". implode(',',$entityIds) .") ) c
        	JOIN field_data_field_friendly_url u
		          ON ( u.entity_id = c.entity_id )
        ";
        $results = db_query($friendlyUrlSql);
        if ( $results->rowCount() )
        {
            $friendlyUrls = $results->fetchCol();
            $urlPaths = array_map(function($url){
                $parsedUrl = parse_url($url);
                $path     = isset($parsedUrl['path'])     ?       $parsedUrl['path']     : '';
                $query    = isset($parsedUrl['query'])    ? '?' . $parsedUrl['query']    : '';
                $fragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';
                return "$path$query$fragment";
            },$friendlyUrls);
            akamai_clear_url($urlPaths);
        }
    }
}
*/

function akamai_clear_site($cpcode)
{
        if ( empty($cpcode) )
        {
            watchdog('Akamai', "Akamai cpcode not found, Full-Site Cache-Clearing not executed",
                    array(),
                    WATCHDOG_NOTICE
            );
            drupal_set_message(t('Akamai cpcode not found, Full-Site Cache-Clearing not executed'),'error');
            return FALSE;
        }
        if ( !empty(variable_get('akamai_disabled')) )
        {
            watchdog('Akamai', "Akamai disabled, Full-Site Cache-Clearing not executed",
                    array(),
                    WATCHDOG_NOTICE
            );
            drupal_set_message(t('Akamai disabled, Full-Site Cache-Clearing not executed'),'error');
            return FALSE;
        }
        try
        {
            $akamai = akamai_get_class();
            // Grab params.
            extract($akamai->parameters);
            $uris = ['*'];

            // whole cache
            $data = array("type" => "cpcode", "action" => "$action", "domain" => "$domain", "objects" => [$cpcode]); //165906
            $data_string = json_encode($data);
            $data_string = str_replace("\\/", '/', $data_string);
            $url_parsed = parse_url($restapi);
            $url = $url_parsed['scheme'] . '://' . $name . ':' . $pwd . '@' . $url_parsed['host'] . $url_parsed['path'];
            $response = drupal_http_request($url, array(
                    'method' => 'POST',
                    'data' => $data_string,
                    'timeout' => $timeout,
                    'headers' => array(
                            'Content-Type' => 'application/json',
                            'Content-Length' => strlen($data_string),
                    ),
                    )
            );

            // We expect Akamai to respond with code 201 if the purge request was
            // successfully created.
            if ($response->code != 201) {
                    $message = format_string('Akamai RestAPI failed !action for !uris with code !code and response: !response',
                    array(
                            '!uris' => implode(' ', $uris),
                            '!action' => $action,
                            '!code' => $response->code,
                            '!response' => var_export($response, TRUE),
                    )
                    );
                    throw new AkamaiException($message);
            }

            if (empty($response->data)) {
                    $message = format_string('Received no response data. Akamai RestAPI !action for !uris: Response: !response',
                    array(
                            '!uris' => implode(' ', $uris),
                            '!action' => $action,
                            '!response' => var_export($response, TRUE),
                    )
                    );
                    throw new AkamaiException($message);
            }

            $response_data = json_decode($response->data);
            if ($response_data === null && json_last_error() !== JSON_ERROR_NONE) {
                    $message = format_string('Failed to decode JSON data. Akamai RestAPI !action for !uris: Response: !response',
                    array(
                            '!uris' => implode(' ', $uris),
                            '!action' => $action,
                            '!response' => var_export($response, TRUE),
                    )
                    );
                    throw new AkamaiException($message);
            }

            watchdog('Akamai', "Akamai RestAPI %action for %uris on %domain: Response: %response",
                    array('%uris' => implode(' ', $uris), '%action' => $action, '%domain' => $domain, '%response' => print_r($response_data, TRUE)),
                    WATCHDOG_NOTICE
            );

            if (is_object($response)) {
              $response->client = $akamai;
            }
            return $response;
        } catch (AkamaiException $e) {
                watchdog_exception('akamai', $e);
                drupal_set_message(t('Akamai exception'),'error');
                return FALSE;
        }
}
