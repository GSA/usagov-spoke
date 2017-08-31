<?php

function cmp_data_sync_client_config_form()
{

    $form = array();

    $form['cdsc_syncing_enabled'] = array(
        '#type' => 'checkbox',
        '#title' => 'Syncing Enabled',
        '#default_value' => variable_get('cdsc_syncing_enabled', 0)
    );


    $form['elasticsearch'] = array(
      '#type' => 'fieldset',
      '#title' => t('Elasticsearch'),
      '#collapsible' => TRUE,
      '#collapsed'   => FALSE,
    );

    $form['elasticsearch']['cdsc_elasticsearch_server'] = array(
      '#type' => 'textfield',
      '#title' => 'Elasticsearch Server:',
      '#default_value' => variable_get('cdsc_elasticsearch_server', ''),
      '#size' => '75',
      '#description' => 'Include schema and port ex. <i>http://elasticsearch_server:9200</i>'
	);


    $form['elasticsearch']['cdsc_ajax_validate_elasticsearch'] = array(
        '#type' => 'item',
        '#title' => 'Validate Elasticsearch',
        '#markup' => '
        <script>
          function ajax_validate_elasticsearch()
          {
            jQuery("#cdsc_ajax_validate_elasticsearch_response").stop(true,true).fadeTo(1000,1).html("loading");
            jQuery.ajax({
              url: "/admin/content/cmp-data-sync-client/api/validate_elasticsearch",
              success:function(data) {
                console.log(data);
                status  = " server:"+ (data.server?"<span style=\"color:green\">good</span>":"<span style=\"color:red\">bad</span>");
                status += " schema-index:"+ (data.schema_index?"<span style=\"color:green\">good</span>":"<span style=\"color:red\">bad</span>");
                status += " content-index:"+ (data.content_index?"<span style=\"color:green\">good</span>":"<span style=\"color:red\">bad</span>");
                jQuery("#cdsc_ajax_validate_elasticsearch_response").html(status);
              },
              error:function(data) {
                status  = " server:<span style=\"color:orange\">unknown</span>";
                status += " schema-index:<span style=\"color:orange\">unknown</span>";
                status += " content-index:<span style=\"color:orange\">unknown</span>";
                jQuery("#cdsc_ajax_validate_elasticsearch_response").html(status);
              },
              complete:function(data,status) {
                  jQuery("#cdsc_ajax_validate_elasticsearch_response").fadeOut(5000);
              }
            });
          }
        </script><div class="form-item form-type-button form-item-cdsc-ajax-validate-elasticsearch">
        <input type="button" onclick="ajax_validate_elasticsearch();" value="Validate Elasticsearch" class="form-submit"/>
        <div id="cdsc_ajax_validate_elasticsearch_response" style="display:inline;"></div></div>'
    );


    $form['sync'] = array(
      '#type' => 'fieldset',
      '#title' => t('Sync Actions'),
      '#collapsible' => TRUE,
      '#collapsed'   => FALSE,
    );

    	$form['sync']['cdsc_site_name_filter'] = array(
            '#type' => 'textfield',
            '#title' => 'For-Use-By filter',
            '#default_value' => variable_get('cdsc_site_name_filter', '')
        );


        $last_sync_time = variable_get('cdsc_last_sync_time',0);
        $last_sync_date = $last_sync_time ? date('Y-m-d H:i:s',$last_sync_time) : 'never';
        $form['sync']['cdsc_ajax_last_sync_date'] = array(
          '#type' => 'item',
          '#title' => 'Last Sync Date',
          '#markup' => '
            <div id="cdsc_ajax_last_sync_date_response" style="display:inline;">'.$last_sync_date.'</div>
          '
        );

    	$form['sync']['cdsc_ajax_partial_sync'] = array(
            '#type' => 'item',
            '#title' => 'Partial Sync',
            '#markup' => '
                <script>
                  jQuery("#cdsc_ajax_partial_sync_response").stop(true,true).fadeTo(1000,1).html("loading");
                  function ajax_partial_sync()
                  {
                    ajax_monitor_queue_status();
                    jQuery.ajax({
                      url: "/admin/content/cmp-data-sync-client/api/partial_sync",
                      success:function(data) {
                        jQuery("#cdsc_ajax_partial_sync_response").html("syncing");
                        jQuery("#cdsc_ajax_last_sync_date_response").html(data.last_sync_date);
                      },
                      error:function(data) {
                        jQuery("#cdsc_ajax_partial_sync_response").html("failure");
                      },
                      complete:function(data,status) {
                          jQuery("#cdsc_ajax_partial_sync_response").fadeOut(5000);
                      }
                    });
                  }
                </script>
                <div class="form-item form-type-button form-item-cdsc-ajax-partial-sync">
                <input type="button" onclick="ajax_partial_sync();" value="Sync Recent Changes" class="form-submit"/>
                <span id="cdsc_ajax_partial_sync_response">&nbsp;</span></div>'
        );

        $form['sync']['cdsc_ajax_full_sync'] = array(
            '#type' => 'item',
            '#title' => 'Full Site Sync',
            '#markup' => '
                <script>
                  jQuery("#cdsc_ajax_full_sync_response").stop(true,true).fadeTo(1000,1).html("loading");
                  function ajax_full_sync()
                  {
                    ajax_monitor_queue_status();
                    jQuery.ajax({
                      url: "/admin/content/cmp-data-sync-client/api/full_sync",
                      success:function(data) {
                        jQuery("#cdsc_ajax_full_sync_response").html("syncing");
                        jQuery("#cdsc_ajax_last_sync_date_response").html(data.last_sync_date);
                      },
                      error:function(data) {
                        jQuery("#cdsc_ajax_full_sync_response").html("failure");
                      },
                      complete:function(data,status) {
                          jQuery("#cdsc_ajax_full_sync_response").fadeOut(5000);
                      }
                    });
                  }
                </script>
                <div class="form-item form-type-button form-item-cdsc-ajax-full-sync">
                <input type="button" onclick="ajax_full_sync();" value="Sync Everything" class="form-submit"/>
                <span id="cdsc_ajax_full_sync_response">&nbsp;</span></div>'
        );

    	$form['sync']['cdsc_ajax_schema_sync'] = array(
            '#type' => 'item',
            '#title' => 'Schema Sync',
            '#markup' => '
                <script>
                  jQuery("#cdsc_ajax_schema_sync_response").stop(true,true).fadeTo(1000,1).html("loading");
                  function ajax_schema_sync()
                  {
                    jQuery.ajax({
                      url: "/admin/content/cmp-data-sync-client/api/schema_sync",
                      success:function(data) {
                        jQuery("#cdsc_ajax_schema_sync_response").html("syncing");
                      },
                      error:function(data) {
                        jQuery("#cdsc_ajax_schema_sync_response").html("failure");
                      },
                      complete:function(data,status) {
                          jQuery("#cdsc_ajax_full_sync_response").fadeOut(5000);
                      }
                    });
                  }
                </script>
                <div class="form-item form-type-button form-item-cdsc-ajax-schema-sync">
                <input type="button" onclick="ajax_schema_sync();" value="Sync Schema" class="form-submit"/>
                <span id="cdsc_ajax_schema_sync_response">&nbsp;</span></div>'
        );


    $form['queue'] = array(
      '#type' => 'fieldset',
      '#title' => t('Queue'),
      '#collapsible' => TRUE,
      '#collapsed'   => FALSE,
    );

    $queue = DrupalQueue::get('cmp_data_sync');
    $queued_item_count = (int)$queue->numberOfItems();
    $form['queue']['cdsc_queue_status'] = array(
      '#type' => 'item',
      '#title' => 'Items in Queue',
      '#markup' => '
        <div id="cdsc_ajax_queue_status" style="display:inline;">'.$queued_item_count.'</div>
      '
    );
    $form['queue']['cdsc_ajax_check_queue_status'] = array(
      '#type' => 'item',
      '#title' => 'Queue Status',
      '#markup' => '
      <script>
        function ajax_check_queue_status()
        {
          jQuery("#cdsc_ajax_check_queue_status_response").stop(true,true).fadeTo(1000,1).html("loading");
          jQuery.ajax({
            url: "/admin/content/cmp-data-sync-client/api/check_queue_status",
            success:function(data) {
              jQuery("#cdsc_ajax_queue_status").html(data.queued_item_count);
              jQuery("#cdsc_ajax_check_queue_status_response").html("success");
            },
            error:function(data) {
              jQuery("#cdsc_ajax_check_queue_status_response").html("failure");
            },
            complete:function(data,status) {
                jQuery("#cdsc_ajax_check_queue_status_response").fadeOut(5000);
            }
          });
        }
        var queue_status_timer     = null;
        var queue_status_same      = 0;
        var last_queued_item_count = 0;
        function ajax_monitor_queue_status()
        {
            let monitor = function()
            {
                jQuery("#cdsc_ajax_check_queue_status_response").stop(true,true).fadeTo(1000,1).html("loading");
                jQuery.ajax({
                  url: "/admin/content/cmp-data-sync-client/api/check_queue_status",
                  success:function(data) {
                    jQuery("#cdsc_ajax_queue_status").html(data.queued_item_count);
                    jQuery("#cdsc_ajax_check_queue_status_response").html(data.message);
                    if ( last_queued_item_count === data.queued_item_count )
                    {
                        queue_status_same++;
                    } else {
                        queue_status_same=0;
                    }
                    last_queued_item_count = data.queued_item_count
                  },
                  error:function(data) {
                    jQuery("#cdsc_ajax_check_queue_status_response").html("failure");
                    if ( last_queued_item_count === false )
                    {
                        queue_status_same++;
                    }
                    last_queued_item_count = false;
                  },
                  complete:function(data,status) {
                      if ( queue_status_same < 3 )
                      {
                          queue_status_timer = setTimeout(monitor,5000);
                      } else {
                          jQuery("#cdsc_ajax_check_queue_status_response").fadeOut(5000);
                          clearTimeout(queue_status_timer);
                          queue_status_timer = null;
                      }
                  }
                });
            }

            ajax_check_queue_status();
            if ( queue_status_timer===null )
            {
                queue_status_timer = setTimeout(monitor,5000);
            }
        }
      </script>
      <div class="form-item form-type-button form-item-cdsc-ajax-check-queue-status">
      <input type="button" onclick="ajax_check_queue_status();" value="Check Queue Status" class="form-submit"/>
      <div id="cdsc_ajax_check_queue_status_response" style="display:inline;"></div></div>'
    );


      $form['queue']['cdsc_ajax_partial_queue'] = array(
        '#type' => 'item',
        '#title' => 'Partial Site Queue',
        '#markup' => '
        <script>
          function ajax_partial_queue()
          {
            ajax_monitor_queue_status();
            jQuery("#cdsc_ajax_partial_queue_response").stop(true,true).fadeTo(1000,1).html("loading");
            jQuery.ajax({
              url: "/admin/content/cmp-data-sync-client/api/partial_queue",
              success:function(data) {
                jQuery("#cdsc_ajax_partial_queue_response").html("queueing");
              },
              error:function(data) {
                jQuery("#cdsc_ajax_partial_queue_response").html("failure");
              },
              complete:function(data,status) {
                  jQuery("#cdsc_ajax_partial_queue_response").fadeOut(5000);
              }
            });
          }
        </script><div class="form-item form-type-button form-item-cdsc-ajax-partial-queue">
        <input type="button" onclick="ajax_partial_queue();" value="Queue Recent Changes" class="form-submit"/>
        <div id="cdsc_ajax_partial_queue_response" style="display:inline;"></div></div>'
      );


        $form['queue']['cdsc_ajax_full_queue'] = array(
          '#type' => 'item',
          '#title' => 'Full Site Queue',
          '#markup' => '
          <script>
            function ajax_full_queue()
            {
              ajax_monitor_queue_status();
              jQuery("#cdsc_ajax_full_queue_response").stop(true,true).fadeTo(1000,1).html("loading");
              jQuery.ajax({
                url: "/admin/content/cmp-data-sync-client/api/full_queue",
                success:function(data) {
                  jQuery("#cdsc_ajax_full_queue_response").html("queueing");
                },
                error:function(data) {
                  jQuery("#cdsc_ajax_full_queue_response").html("failure");
                },
                complete:function(data,status) {
                    jQuery("#cdsc_ajax_full_queue_response").fadeOut(5000);
                }
              });
            }
          </script><div class="form-item form-type-button form-item-cdsc-ajax-full-queue">
          <input type="button" onclick="ajax_full_queue();" value="Queue Everything" class="form-submit"/>
          <div id="cdsc_ajax_full_queue_response" style="display:inline;"></div></div>'
        );

        $form['queue']['cdsc_ajax_process_queue'] = array(
          '#type' => 'item',
          '#title' => 'Process Entire Queue',
          '#markup' => '
          <script>
            function ajax_process_queue()
            {
              ajax_monitor_queue_status();
              jQuery("#cdsc_ajax_process_queue_response").stop(true,true).fadeTo(1000,1).html("loading");
              jQuery.ajax({
                url: "/admin/content/cmp-data-sync-client/api/process_queue",
                success:function(data) {
                  jQuery("#cdsc_ajax_process_queue_response").html("processing");
                },
                error:function(data) {
                  jQuery("#cdsc_ajax_process_queue_response").html("failure");
                },
                complete:function(data,status) {
                    jQuery("#cdsc_ajax_process_queue_response").fadeOut(5000);
                }
              });
            }
          </script><div class="form-item form-type-button form-item-cdsc-ajax-process-queue">
          <input type="button" onclick="ajax_process_queue();" value="Process Queue" class="form-submit"/>
          <div id="cdsc_ajax_process_queue_response" style="display:inline;"></div></div>'
        );

    return system_settings_form($form);
}

function _cdsc_ajax_check_queue_status()
{
  $queue = DrupalQueue::get('cmp_data_sync');
  drupal_json_output([
    'called'=>__FUNCTION__,
    'queued_item_count'=> !empty($queue) ? (int)$queue->numberOfItems() : 'unknown'
  ]);
}
function _cdsc_ajax_validate_elasticsearch()
{
  drupal_json_output([
    'called'=>__FUNCTION__,
    'server'        => _cdsc_validate_elasticsearch_server(),
    'schema_index'  => _cdsc_validate_elasticsearch_schema_index(),
    'content_index' => _cdsc_validate_elasticsearch_content_index()
  ]);
}
function _cdsc_ajax_schema_sync()
{
    if ( _cdsc_syncing_disabled() )
    {
        drupal_json_output(['called'=>__FUNCTION__,'last_sync_date'=>variable_get('cdsc_last_sync_time',0)]);
        exit;
    }
    drupal_json_output(['called'=>__FUNCTION__,'last_sync_date'=>date('Y-m-d H:i:s')]);
	_cdsc_finish_request();
	_cdsc_sync_schema(true);
    exit;
}
function _cdsc_ajax_partial_sync()
{
    if ( _cdsc_syncing_disabled() )
    {
        drupal_json_output(['called'=>__FUNCTION__,'last_sync_date'=>variable_get('cdsc_last_sync_time',0)]);
        exit;
    }
	drupal_json_output(['called'=>__FUNCTION__,'last_sync_date'=>date('Y-m-d H:i:s')]);
	_cdsc_finish_request();
    _cdsc_partial_sync();
    exit;
}

function _cdsc_ajax_full_sync()
{
    if ( _cdsc_syncing_disabled() )
    {
        drupal_json_output(['called'=>__FUNCTION__,'last_sync_date'=>variable_get('cdsc_last_sync_time',0)]);
        exit;
    }
	drupal_json_output(['called'=>__FUNCTION__,'last_sync_date'=>date('Y-m-d H:i:s')]);
	_cdsc_finish_request();
    _cdsc_full_sync();
    exit;
}

function _cdsc_ajax_last_sync_date()
{
    $last_sync_time = variable_get('cdsc_last_sync_time',0);
    $last_sync_date = $last_sync_time ? date_format('Y-M-D H:i:s',$last_sync_time) : 'never';
	drupal_json_output(['called'=>__FUNCTION__,'last_sync_date'=>$last_sync_date]);
    exit;
}


function _cdsc_ajax_partial_queue()
{
    if ( _cdsc_syncing_disabled() )
    {
        drupal_json_output(['called'=>__FUNCTION__,'last_sync_date'=>variable_get('cdsc_last_sync_time',0)]);
        exit;
    }
    drupal_json_output(['called'=>__FUNCTION__,'last_sync_date'=>date('Y-m-d H:i:s')]);
    _cdsc_finish_request();
    _cdsc_partial_queue();
    exit;
}

function _cdsc_ajax_full_queue()
{
    if ( _cdsc_syncing_disabled() )
    {
        drupal_json_output(['called'=>__FUNCTION__,'last_sync_date'=>variable_get('cdsc_last_sync_time',0)]);
        exit;
    }
    drupal_json_output(['called'=>__FUNCTION__,'last_sync_date'=>date('Y-m-d H:i:s')]);
	_cdsc_finish_request();
    _cdsc_full_queue();
    exit;
}

function _cdsc_ajax_process_queue()
{
    drupal_json_output(['called'=>__FUNCTION__,'last_sync_date'=>variable_get('cdsc_last_sync_time',0)]);
    if ( _cdsc_syncing_disabled() )
    {
        exit;
    }
    _cdsc_finish_request();
    _cdsc_process_queue();
    _cdsc_clear_cdn_cache();
    exit;
}

$GLOBALS['_cdsc_finished_request'] = false;
function _cdsc_finish_request()
{
  if ( !empty($GLOBALS['_cdsc_finished_request']) )
  {
      return;
  }
  $GLOBALS['_cdsc_finished_request'] = true;
  $minutes_to_process = 10;
  ignore_user_abort(1);
  while(@ob_get_level() > 0) { @ob_end_flush(); }
  @ob_flush();
  @flush();
  if (session_id()) session_write_close();
  fastcgi_finish_request();
  set_time_limit($minutes_to_process*60);
  ini_set('max_execution_time',$minutes_to_process*60);
}
