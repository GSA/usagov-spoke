$(function(){
  $('#nav-toggle').click(function(){
    $(this).toggleClass('current');
    if($(this).hasClass('current')){
      $('#header').addClass('show-nav');
      $('#nav').attr( "aria-expanded", "true" );
      $(this).attr( "aria-expanded", "true" );
    }else{
      $('#header').removeClass('show-nav');
      $('#nav').attr( "aria-expanded", "false" );
      $(this).attr( "aria-expanded", "false" );
    }
    $('#header').removeClass('show-search');
    $('#search').attr( "aria-expanded", "false" );
    $('#search-toggle').attr( "aria-expanded", "false" );
    $('#search-toggle').removeClass('current');
  });
  $('#search-toggle').click(function(){
    $(this).toggleClass('current');
    if($(this).hasClass('current')){
      $('#header').addClass('show-search');
      $('#search').attr( "aria-expanded", "true" );
      $(this).attr( "aria-expanded", "true" );
    }else{
      $('#header').removeClass('show-search');
      $('#search').attr( "aria-expanded", "false" );
      $(this).attr( "aria-expanded", "false" );
    }
    $('#header').removeClass('show-nav');
    $('#nav').attr( "aria-expanded", "false" );
    $('#nav-toggle').attr( "aria-expanded", "false" );
    $('#nav-toggle').removeClass('current');
  });
  //
   $('#fea-container h3').bind('click', function(){acordionNav2(this);}); //Video Transcript Box
  function acordionNav2(este){
	$('.transcript').slideToggle(300, function(){
		var transcriptIcon = $(this).prev().find('span');
		if(transcriptIcon.attr('class')=='arrowUp'){
			transcriptIcon.removeClass('arrowUp');
			transcriptIcon.text($('html').attr('lang')=="en" ? "Show Video Transcript" : "Mostrar la transcripci\u00F3n del video");
		}else{
			transcriptIcon.addClass('arrowUp');
			transcriptIcon.text($('html').attr('lang')=="en" ? "Hide Video Transcript" : "Ocultar la transcripci\u00F3n del video");
		}
	});
  }
});