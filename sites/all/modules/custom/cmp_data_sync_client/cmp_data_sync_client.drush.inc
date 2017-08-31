<?php

function cmp_data_sync_client_drush_command()
{

  $items = array();
  $items['cds-process-queue'] = array(
    'description' => 'Process any queued items.',
    'aliases' => array('cdsp'),
    'callback' => '_cdsc_process_queue',
  );
  $items['cds-queue-full'] = array(
    'description' => 'Queue all entites for syncing.',
    'aliases' => array('cdsqf'),
    'callback' => '_cdsc_full_queue',
  );
  $items['cds-queue-partial'] = array(
    'description' => 'Queue recent changes for syncing.',
    'aliases' => array('cdsqp'),
    'callback' => '_cdsc_partial_queue',
  );
  $items['cds-queue-clear'] = array(
    'description' => 'Clear all items from Queue.',
    'aliases' => array('cdsqc'),
    'callback' => '_cdsc_clear_queue',
  );
  $items['cds-queue-status'] = array(
    'description' => 'Queue status count.',
    'aliases' => array('cdsqs'),
    'callback' => '_cdsc_drush_queue_status',
  );
  $items['cds-schema-sync'] = array(
    'description' => 'Update Schema .',
    'aliases' => array('cdsss'),
    'callback' => '_cdsc_sync_schema',
    'arguments' => array(true)
  );
  $items['cds-full-sync'] = array(
    'description' => 'Full Site Sync.',
    'aliases' => array('cdsf'),
    'callback' => '_cdsc_full_sync',
  );
  $items['cds-partial-sync'] = array(
    'description' => 'Recent Changes Sync.',
    'aliases' => array('cdsp'),
    'callback' => '_cdsc_partial_sync',
  );

  return $items;
}

function _cdsc_drush_queue_status()
{
    $queue = DrupalQueue::get('cmp_data_sync');
    echo 'queued_item_count => '. !empty($queue) ? (int)$queue->numberOfItems() : 'unknown';
    echo "\n";
}
