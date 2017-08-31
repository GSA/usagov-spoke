initializeSearchWidget();

/**
 * void initializeSearchWidget()
 *
 * Implements an auto-complete functionality on the search input box on
 * the /federal-agencies/ page
 *
 * This function is dependent on the jQuery.fn.autocomplete() function,
 * and will wait for jQuery.fn.autocomplete to be declared before
 * continuing with its functionality.
 */
function initializeSearchWidget() {

  if ( typeof jQuery !== 'function' || typeof jQuery("#agencySearch").autocomplete !== 'function' ) {

    // if ( console.log ) {
    //   console.log('app.js/initializeSearchWidget() is waiting for jQuery.fn.autocomplete to be declared...');
    // }

    setTimeout(initializeSearchWidget, 250);
    return;
  }

  // if ( console.log ) {
  //   console.log('initializeSearchWidget() in app.js is now firing');
  // }

  var SearchWidget = SearchWidget || {};
  SearchWidget.version = '0.0.1';

  SearchWidget.myarr;
  SearchWidget.options = {
    caseSensitive: false,
    includeScore: false,
    shouldSort: true,
    threshold: 0.7,
    location: 0,
    distance: 150,
    keys: ["title"]
  };
  SearchWidget.searchOpen = false;
  SearchWidget.url;

  SearchWidget.enableSearch = function(){

  jQuery( "#agencySearch" ).autocomplete({
      source: function(request, response){
        var f = new Fuse(SearchWidget.myarr, SearchWidget.options);
        var rArray = [];
        var results = f.search(request.term);

        jQuery.each(results.slice(0,5), function(index) {
          rArray.push(results[index]);
        });

        response(rArray);
      },
      minLength: 2,
      autoFocus: false,
      focus: function( event,ui){
        jQuery('#agencySearch').val(ui.item.title);
        SearchWidget.url = jQuery('.ui-state-focus a').attr('href');
        return false;
      },
      close: function( event, ui ){
        jQuery('#agencySearch').val('');
      },
      open: function( event, ui ){
        SearchWidget.searchOpen = true;
      },
      select: function( event, ui ){
        jQuery('#agencySearch').val('');
        window.location = jQuery('.ui-state-focus a').attr('href');
        SearchWidget.searchOpen = false;
      },
      change: function(item){
        jQuery('#agencySearch').val('');
        window.location = jQuery('.ui-state-focus a').attr('href');
        SearchWidget.searchOpen = false;
      }

    })
    .autocomplete('instance')._renderItem = function(ul,item){
      var click = '<a href="'+item.source_url+'">'+item.title+'</a>';

      return jQuery( "<li>" )
      .append( click )
      .appendTo( ul );
    };
    jQuery('.ui-helper-hidden-accessible').attr('aria-live', 'polite');

    jQuery(document).on('keydown',function(e){
      if(e.keyCode === 13  && SearchWidget.searchOpen){
        e.preventDefault();
        jQuery('.search-button').trigger('click');
      }

    });

    jQuery('.search-button').on('click',function(e){
      e.preventDefault();
      if(SearchWidget.searchOpen){
        jQuery('#agencySearch').val('');
        if(SearchWidget.url === undefined || SearchWidget.url === null || SearchWidget.url === ""){
          SearchWidget.url = jQuery('.ui-autocomplete > li').find('a').attr('href');
          window.location = SearchWidget.url;
          return;
        }
        SearchWidget.searchOpen = false;
        window.location = SearchWidget.url;
      }
    });

  }

  SearchWidget.initSearchWidget = function(){
   jQuery.ajax({
      url: '/ajax/federal-agencies/autocomplete',
      dataType: 'json',
      success: function(data){
        SearchWidget.myarr = data.results;

        SearchWidget.waitForIt = setInterval( function () {

          if ( typeof jQuery !== 'function' || typeof jQuery("#agencySearch").autocomplete !== 'function' ) {
            return;
          } else {
            SearchWidget.enableSearch();
            clearInterval(SearchWidget.waitForIt);
          }
        }, 250);
      }
    });
  }

  jQuery(document).ready( function () {
    SearchWidget.initSearchWidget();
  });

}
