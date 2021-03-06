var tabletBreakpoint = 991; // width where the page switches between mobile/desktop
var mobileBreakpoint = 786;
var width, prevWidth, mobile; // width and prevWidth determine current breakpoint and if a change is needed
var toggles;

function viewportWidth() {
  return window.innerWidth || document.body.clientWidth;//Must use document.body.clientWidth for browser support.
}
/***********************
Initialize
***********************/
$( document ).ready(function(){
  //add menu toggles
  $('#header>.container').append('<div id="toggles">'+
      '<button id="search-toggle" role="button" aria-haspopup="true" aria-controls="search" aria-expanded="false">'+
      '<span class="icon-search searcher">Search</span>'+
      '<span class="icon-close closer">Close</span>'+
      '</button>'+
      '<button id="nav-toggle" role="button" aria-haspopup="true" aria-controls="mnnav" aria-expanded="false">'+
      '<span class="menuer">Menu</span>'+
      '<span class="icon-close closer">Close</span>'+
    '</button>'+
  '</div>');

  width=prevWidth=viewportWidth();
  mobile=false;
  if(width <= tabletBreakpoint){
    if(width<mobileBreakpoint)
      mobile=true;
    goMobile();
  }else{
    goDesktop();
  }

});
/***********************
Window resize
***********************/
$(window).resize(function() {
  width=viewportWidth();

  if(width<=mobileBreakpoint && prevWidth>mobileBreakpoint){
    mobile=true;
    goMobile();
  }else if(width<=tabletBreakpoint && prevWidth>tabletBreakpoint ||
           width>mobileBreakpoint && prevWidth<=mobileBreakpoint){
    mobile=false;
    goMobile();
  }else if(width>tabletBreakpoint && prevWidth<=tabletBreakpoint){ //screen is now wide
    mobile=false;
    goDesktop();
  }

  prevWidth=width;
});
function goMobile() {
  $('#header .container.group').append(toggles);
  initializeToggles();
  var navOpen=$('#nav-toggle').hasClass('current');
  var searchOpen=$('#search-toggle').hasClass('current');

  $('#nav-toggle').attr('aria-expanded', navOpen);
  $('#search-toggle').attr('aria-expanded', searchOpen);
  $('#search').attr('aria-expanded', (searchOpen && !mobile) || (navOpen && mobile));
  $('#search').attr('aria-hidden', !((searchOpen && !mobile) || (navOpen && mobile)));
  $('#mnnav').attr('aria-hidden', !navOpen);
  $('#mnnav').removeAttr('aria-label');
  $('.navItems').attr('aria-hidden', !navOpen);
  $('.navItems').attr('aria-expanded', navOpen);
  $('.navItems').attr('role', 'menu');
  $('.navItems').attr('aria-live', 'polite');
  $('.navItems').removeClass('group');
  $('.navItems li a').attr('role', 'menuitem');
}
function goDesktop() {
  toggles=$('#toggles').remove();
  $('#search').removeAttr('aria-expanded');
  $('#search').removeAttr('aria-hidden');
  $('#nav-toggle').removeAttr('aria-expanded');
  $('#search-toggle').removeAttr('aria-expanded');
  $('#mnnav').removeAttr('aria-hidden');
  $('#mnnav').attr('role', 'navigation');
  $('#mnnav').attr('aria-label', 'Site-wide');
  $('.navItems').removeAttr('aria-hidden');
  $('.navItems').removeAttr('aria-expanded');
  $('.navItems').removeAttr('role');
  $('.navItems').removeAttr('aria-live');
  $('.navItems').addClass('group');
  $('.navItems li a').removeAttr('role');
}
function initializeToggles() {
  $( "#nav-toggle").unbind( "click" );
  $('#nav-toggle').click(function(){
    $(this).toggleClass('current');
    if($(this).hasClass('current')){
      $('#header').addClass('show-nav');
      $('.navItems').attr( "aria-expanded", "true" );
      $('.navItems').attr( "aria-hidden", "false" );
      $('#mnnav').attr( "aria-hidden", "false" );
      $(this).attr( "aria-expanded", "true" );
      $('#search').attr( "aria-expanded", mobile );
      $('#search').attr( "aria-hidden", !mobile );
    }else{
      $('#header').removeClass('show-nav');
      $('.navItems').attr( "aria-expanded", "false" );
      $('.navItems').attr( "aria-hidden", "true" );
      $('#mnnav').attr( "aria-hidden", "true" );
      $(this).attr( "aria-expanded", "false" );
      $('#search').attr( "aria-expanded", false );
      $('#search').attr( "aria-hidden", true );
    }
    $('#header').removeClass('show-search');
    $('#search-toggle').attr( "aria-expanded", "false" );
    $('#search-toggle').removeClass('current');
  });
  $( "#search-toggle").unbind( "click" );
  $('#search-toggle').click(function(){
    $(this).toggleClass('current');
    if($(this).hasClass('current')){
      $('#header').addClass('show-search');
      $('#search').attr( "aria-expanded", "true" );
      $('#search').attr( "aria-hidden", "false" );
      $(this).attr( "aria-expanded", "true" );
    }else{
      $('#header').removeClass('show-search');
      $('#search').attr( "aria-expanded", "false" );
      $('#search').attr( "aria-hidden", "true" );
      $(this).attr( "aria-expanded", "false" );
    }
    $('#header').removeClass('show-nav');
    $('.navItems').attr( "aria-expanded", "false" );
    $('.navItems').attr( "aria-hidden", "true" );
    $('#mnnav').attr( "aria-hidden", "true" );
    $('#nav-toggle').attr( "aria-expanded", "false" );
    $('#nav-toggle').removeClass('current');
  });
} 




