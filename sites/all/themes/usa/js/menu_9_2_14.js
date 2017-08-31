$(function(){
$('#nav-toggle').click(function(){
  $(this).toggleClass('current');
  if($(this).hasClass('current')){
    $('#header').addClass('show-nav');
  }else{
    $('#header').removeClass('show-nav');
  }
  $('#header').removeClass('show-search');
  $('#search-toggle').removeClass('current');
});
$('#search-toggle').click(function(){
  $(this).toggleClass('current');
  if($(this).hasClass('current')){
    $('#header').addClass('show-search');
  }else{
    $('#header').removeClass('show-search');
  }
  $('#header').removeClass('show-nav');
  $('#nav-toggle').removeClass('current');
});
});

//Set click function for accordion element
$('.button h3 span').bind('click', function(){acordionNav2(this);}); //Video Transcript

function acordionNav2(this){
	$(this).parent().parent().parent().find('.transcript').slideToggle(300, function(){
		if($(this).attr('class')=='arrowUp'){
			$(this).removeClass('arrowUp');
			$(this).find('div').text($('html').attr('lang')=="en" ? "Show Video Transcript" : "Mostrar la transcripci\u00F3n del video");
		}else{
			$(this).addClass('arrowUp');
			$(this).find('div').text($('html').attr('lang')=="en" ? "Hide Video Transcript" : "Ocultar la transcripci\u00F3n del video");
		}
	});
}