var tabletBreakpoint = 991; // width where the page switches between mobile/desktop
var width, prevWidth; // width and prevWidth determine current breakpoint and if a change is needed

var LEFT=37,
    UP=38,
    RIGHT=39,
    DOWN=40,
    SPACE=32,
    TAB=9,
    SHIFT=16;

$(function(){
  width=prevWidth=viewportWidth();
  if(width<tabletBreakpoint){
    goMobileHP();
  }else{
    goDesktopHP();
  }
  
  // $('.slick').slick({
  //   arrows: false,
  //   fade: true,
  //   speed: 500
  // });
  // $('.slick-list').removeAttr('tabindex');

  $('#trending a').attr('tabindex','-1');
  $('#trending .expanded a').removeAttr('tabindex');
  
  $('#trending button').click(function(){
    if($(this).parent().parent().hasClass('expanded')){
      $('#trending .inner').removeClass('expanded');
      $('#trending .topic').removeClass('expanded');
      $('#trending a').attr('tabindex','-1');
    }else{
      $('#trending .inner').removeClass('expanded');
      $('#trending .topic').removeClass('expanded');
      $('#trending a').attr('tabindex','-1');
      $(this).parent().parent().addClass('expanded');
      $(this).parent().parent().parent().addClass('expanded');
      $(this).parent().parent().find('a').removeAttr('tabindex');

      $('#trending .fade').attr('data-bg',$('#trending .background').attr('data-bg')).fadeOut( 500, function() {
        $('#trending .fade').removeAttr("style").removeAttr('data-bg');
      });
      $('#trending .background').attr('data-bg',$(this).parent().parent().parent().parent().index()).addClass('forceiepaint').removeClass('forceiepaint');
    }
  });

  $("#trending button").keydown(function(e) {
    var s=e.which;
    switch(s){
      case LEFT:
      case UP:
        $(this).parent().parent().parent().parent().prev().find('button').focus();
        e.preventDefault();
        break;
      case RIGHT:
      case DOWN:
        $(this).parent().parent().parent().parent().next().find('button').focus();
        e.preventDefault();
        break;    }
    return;
  });

  $( "#officials, #agencies, #state-local" ).click(function() {
    $(this).focus();
  }).focusin(function() {
    $(this).addClass('active');
    $( "#officials, #agencies, #state-local" ).focusout(function() {
      $(this).removeClass('active');
    });
  });
  
  

});

function viewportWidth() {
  return window.innerWidth || document.body.clientWidth;//Must use document.body.clientWidth for browser support.
}