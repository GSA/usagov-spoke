<?php

hooks_reaction_add("HOOK_init",function()
{
  /// this could be set in a module somewhere and dynamically read
  $dynamicPaths = [
      'find-government-contracts',
      'searchFBOdatajax',
      'admin',
      'devel'
  ];
  $currentPath  = current_path();
  $currentParts = explode("/",$currentPath);
  $pathStart    = '';
  if ( !empty($currentParts) && !empty($currentParts[0]) ) {
    $pathStart = $currentParts[0];
  }
  foreach ( $dynamicPaths as $dynamicPath ) {
    if ( trim($dynamicPath,' /') == trim($pathStart,' /') ) {
      /// don't adjust headers for known dynamic content
      return;
    }
  }
  /// set a default cache time for all static content
  $maxAge = intval(variable_get('page_cache_maximum_age','300'));
  if ( $maxAge > 0 ) {
    drupal_add_http_header('Cache-Control', 'public, max-age='.$maxAge);
  }
});
