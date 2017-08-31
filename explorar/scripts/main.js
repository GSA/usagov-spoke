'use strict';
$(document).ready(function() {
	var pauseControl = $('.usa-video-control'),
	lang = $('html').attr('lang');

	function a(a) {
		var b = a;
		$.ajax({
			url: 'translation.xml',
			success: function(a) {
				$(a).find('translation').each(function() {
					var a = $(this).attr('id'),
						c = $(this).find(b).text();
					$('.' + a).html(c);
				});
			}
		});
	}

	// Hero video
	// ===================================================================
	$(function(){

		var heroVideoLabel = '',
				heroVideoHtml = '',
				videoContainer = $('#usa-video-hero-container');

		if(lang === 'es'){
			heroVideoLabel = 'Video de escenas de la vida en Estados Unidos: Un hombre paseando con su perro por la noche; un autobús escolar pasando por la calle de un pueblo; un hombre y una mujer guardando su equipaje en un vehículo antes de ir de viaje; un tractor arando un campo de trigo; una madre leyéndole a su hijo; gente caminando por una ciudad.';
		}else{
			heroVideoLabel = 'Video montage of scenes from American life: A man walking his dog at night; a school bus driving through town; a man and woman packing their car for a trip; a tractor plowing a field of wheat; a mother reading to her young son; people walking down a crowded city street.';
		}

		heroVideoHtml = '<video class="usa-video-hero-video hidden-sm fade" id="usa-video-hero-video" preload="none" autoplay loop="loop" muted aria-label="'+heroVideoLabel+'" tabindex="-1"><source src="video/usagov_hero_loop_2_480p.mp4" type="video/mp4"></video>';

		// Only load video in desktop
		if(!bowser.mobile && !bowser.tablet){
			videoContainer.append(heroVideoHtml);
			setTimeout(function(){
				$('#usa-video-hero-video').addClass('in');
			}, 200);
		}
	});


	// Video controls
	function pausePlay() {
		if ($('.usa-video-hero-video').get(0).paused) {
			$('.usa-video-hero-video').get(0).play();
			pauseControl.removeClass('fa-play');
			pauseControl.addClass('fa-pause');
		} else {
			$('.usa-video-hero-video').get(0).pause();
			pauseControl.removeClass('fa-pause');
			pauseControl.addClass('fa-play');
		}
	}

	$('.usa-video-control').keypress(function(event) {
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if (keycode === 13) {
			pausePlay();
		}
	});

	pauseControl.on('click', pausePlay);

// Language Translator
// ======================================================================
	$(function(){
		if( $('#spanish').hasClass('lang-active') ){
			a('es');
			$(document).trigger('translate-esp');
		}
	});

	$('#english').on('click', function() {
		$('html').attr('lang', 'en');
		$('#english').addClass('lang-active');
		$('#spanish').removeClass('lang-active');
		a('en');
		$(document).trigger('translate-eng');
	});

	$('#spanish').on('click', function() {
		$('html').attr('lang', 'es');
		$('#spanish').addClass('lang-active');
		$('#english').removeClass('lang-active');
		a('es');
		$(document).trigger('translate-esp');
	});
});

//Smooth Scroll to Top/Anchor
// ======================================================================
$(function() {
	$('a[href*="#"]:not([href="#"])').click(function() {
		if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				$('html,body').animate({
					scrollTop: target.offset().top
				}, 800);
				return false;
			}
		}
	});
});


// RSS Feed
// ======================================================================
$(function() {
	if (document.getElementById('spanish-feed')){
		var feed = 'https://gobierno.usa.gov/rss/actualizaciones-articulos.xml';
	} else {
		var feed = 'https://www.usa.gov/rss/updates.xml';
	}
	$.get(feed, function (data) {

		// var rssContainer = $('.rss-feed__wrapper');
		var rssContainer = $('.rss-feed__list');

		$(data).find("item").each(function (index) {
				if(index > 2){
						return false
				}else{
					var el = $(this);

					rssContainer.append('<li><a href="' + el.find("link").text() + '">' + el.find("title").text() + '</a></li>');

				}
		});

	});
});




// Youtube Player
// ======================================================================

// 1. Setup YouTube Player
var player;

function onYouTubeIframeAPIReady() {

	if( $('#lang-toggle-english').hasClass('lang-active') ){
		player = new YT.Player('player', {
			height: '390',
			width: '640',
			videoId: 'SdlVbBllr9I',
			playerVars: {
				showinfo: 0,
				loop: 1,
				rel: 0,
				hl: 'en',
			},
			events: {
				'onReady': onPlayerReady,
				'onStateChange': onPlayerStateChange,
			}
		});
	}else if( $('#lang-toggle-spanish').hasClass('lang-active') ){
		player = new YT.Player('player', {
			height: "390",
			width: "640",
			videoId: "Fho7-YcFZ6o",
			playerVars: {
				listType: "playlist",
				list: "PLkepuznYQFHoAql6nyn9O1K3QZe4Oty1l",
				rel: 0,
				hl: 'es',
			},
			events: {
				onReady: onPlayerReady,
				onStateChange: onPlayerStateChange
			}
		});
	}
}


// The API will call this function when the video player is ready.
function onPlayerReady(event) {
	var video_data = player.getVideoData(),
			video_title = video_data['title'],
			video_lang = player.f.lang;

	if(video_lang === 'es'){
		video_title = video_title + ': reproductor de video';
	}else{
		video_title = video_title + ': video player';
	}

	$('#usa-feature-video-wrapper').addClass('video-ready');
	$('.usa-feature-video-player').fadeIn();
	$('#player').attr('title', video_title);
}

// The API calls this function when the player's state changes.
// The function indicates that when playing a video (state=1),
// the player should play for six seconds and then stop.
var done = false;

function videoEnded(){
	if(done === true) {
		// Did the state change while we delayed 5 seconds
		// Whatever you wanted to do at the end of the playlist here.
		$('#feature-video-play-btn').fadeIn();
	}
}

function onPlayerStateChange(event) {
	var video_data = player.getVideoData();
	var video_Id = video_data['video_id'];

	if (event.data === -1 || 1){
    $('#usa-feature-video-wrapper').addClass('active');
		done = false;
		$('#player').attr('tabindex', 0);

  }

  if ( event.data === 0 ) {
		done = true;
		setTimeout(function(){
			if(done === true){
				$('#usa-feature-video-wrapper').removeClass('active');
				$('#player').attr('tabindex', -1);
				$('#feature-video-play-btn').fadeIn();
			}
		}, 200);
  }

}

function stopVideo() {
	player.stopVideo();
}

$(function(){
	// $(document).on('ready', function(){
		var playBtn = $('#feature-video-play-btn');

		playBtn.click(function(e){
			player.playVideo();
			$(this).fadeOut();
		});

		playBtn.keypress(function(e){
			if(e.which === 13){//Enter key pressed
				$(this).click();//Trigger click event
			}
		})
	// });
});

$(document).on('translate-eng', function(){
	player.cueVideoById('SdlVbBllr9I');
});

$(document).on('translate-esp', function(){
	player.cuePlaylist({list:'PLkepuznYQFHoAql6nyn9O1K3QZe4Oty1l', listType:'playlist'});
});


// Equal height for channels
// ======================================================================


var equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
		 currentDiv,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPosition = $el.position().top;

   if (currentRowStart != topPosition) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPosition;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

$(window).on('load', function() {
  equalheight('.usa-channel');
});


$(window).resize(function(){
  equalheight('.usa-channel');
});
