<?php /*

    [--] WEBSITE [--]

    This script is used with the Blog.USA.Gov site.
    This script is not needed on any of the other CMP-ChildSites.

    [--] PURPOSE [--]

    This is a helper script to satisy the requierments where:
      - A request-path of "/9/2015" must trigger the Summary View passing 9 and 2015 as arguments
      - A request-path of "/title-of-a-asset-topic" must trigger the Summary View passing "title-of-a-asset-topic" as an argument

*/


// This reaction shall be active only on the Blog.USA.Gov project
$siteName = variable_get('site_name');
if ( stripos($siteName, 'blog') === false ) {

    // A return at the global scope in a PHP file ceases processing on this script
    return; // No further (executable) lines in this script should be processed by PHP
}


/**
 * Implements HOOK_url_inbound_alter().
 *
 * This function is responsible for rewriting the incoming request-url, such
 * that a request for:
 *     "/9/2015" would request "/by-month/9/2015"
 *     "/title-of-a-asset-topic" would request "/by-topic/title-of-a-asset-topic"
 *
 * This is necessary in order to trigger the correct views and pass the immediate
 * URL-portion(s) to the Views as arguments.
 */
hooks_reaction_add("HOOK_url_inbound_alter",
    function (&$path, $original_path, $path_language) {

    	// Check to see if this is a #/# path (as in 9/2015)
    	$pathParts = explode('/', $original_path);
    	if ( count($pathParts) === 2 && intval($pathParts[0]) !== 0 && intval($pathParts[1]) !== 0 ) {
    		// and if so, treat it as if the user is going to i.e. /by-month/9/2015
    		$path = 'by-month/'.$original_path;
    		return;
    	}

    	// Check to see if this is a /title-of-a-asset-topic path
      $key = array_search($original_path, _blogViewPathHelper_getTopics());
    	if ( $key !== false ) {
    		// and if so, treat it as if the user is going to i.e. /by-topic/title-of-a-asset-topic
        $path = 'by-topic/'.$key;
    		return;
    	}

    }
);


/**
 * array _blogViewPathHelper_getTopics()
 *
 * Returns an array of all names, of asset Topics in this system, in a URL-friendly form.
 */
function _blogViewPathHelper_getTopics() {  // Get all terms under the Asset-Topic vocab, which are usd as "Blog Topics" on this site

  $vocab = taxonomy_vocabulary_machine_name_load('asset_topic_taxonomy');
  $terms = taxonomy_get_tree($vocab->vid);

  // Supply this information to the blog_sidebar.tpl.php
  $topics = array();
  foreach ( $terms as $term ) {

    if ( intval($term->depth) > 0 ) { // ignore the root-term ("Blog.USA.Gov")

      $urlFriendlyName = trim( strtolower($term->name) );
      $urlFriendlyName = str_replace(array('_',' ','.','/'), '-', $urlFriendlyName);
      $topics[$term->tid] = $urlFriendlyName;
    }
  }

  return $topics;
}
