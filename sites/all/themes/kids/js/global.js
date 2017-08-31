(function($){
	$(document).ready(function(){

		// carousel
		$(function() {
		    $('.jcarousel').jcarousel({
		        // Core configuration goes here
		    });

		    $('.jcarousel-prev').jcarouselControl({
		        target: '-=1'
		    });

		    $('.jcarousel-next').jcarouselControl({
		        target: '+=1'
		    });
		});

		//checking which second menu you are under
		// if($('.menu-block-1 li.active-trail').text() == 'Kids Grade K-5'){
		// 	var trailName = $('.menu-block-2  li.active-trail').text();
		// 	switch(trailName) {
		// 	    case 'Learn Stuff':
		// 	        $('#block-system-main').addClass('learn-stuff');
		// 	        break;
		// 	    case 'Play Games':
		// 	        $('#block-system-main').addClass('play-games');
		// 	        break;
		// 	    case 'Watch Videos':
		// 	        $('#block-system-main').addClass('watch-videos');
		// 	        break;
		// 	}
		// }


		// Carousel - helper script - control weather or not the left/right buttons should be visible
		var carouselControleHelperScript = function () {
			if(jQuery('.jcarousel').length > 0){
				var carouselContainerOffsetLeft = jQuery('.jcarousel').offset().left;
				var carouselContainerOffsetRight = jQuery('.jcarousel').offset().left + jQuery('.jcarousel').get(0).offsetWidth;
				var carouselFirstItemOffsetRight = jQuery('.jcarousel li').first().offset().left + jQuery('.jcarousel li').first().get(0).offsetWidth;
				var carouselLastItemOffsetLeft = jQuery('.jcarousel li').last().offset().left;
				if ( carouselFirstItemOffsetRight < carouselContainerOffsetLeft ) {
					jQuery('.jcarousel-prev').show();
				} else {
					jQuery('.jcarousel-prev').hide();
				}
				if ( carouselContainerOffsetRight < carouselLastItemOffsetLeft ) {
					jQuery('.jcarousel-next').show();
				} else {
					jQuery('.jcarousel-next').hide();
				}
			}
		};
		$('.jcarousel').parent().bind('click', function () {
			setTimeout(carouselControleHelperScript, 500);
		});
		carouselControleHelperScript();


		// FIX THIS LATER: doing bad things for the greater good!
		if ($('.content-block iframe').length > 0){

			//bad way to fix the wrong order hop links on video pages
  			$('.frth_columnbox_container_content ul').css('width', '212px');
  			$('.frth_columnbox_container_content ul li').css('padding', '4px 0px 4px 0px');

  			//bad way to fix the video info area not pushing sidebar down
  			var videoInfoCheck = $('.content-block .rxbodyfield').eq(0).find('p > strong').eq(0).text();

  			if(videoInfoCheck == "Date:" || videoInfoCheck == "Place:" || videoInfoCheck == "Interview:" ){
	  			$('.content-block .rxbodyfield').eq(0).removeClass('rxbodyfield').addClass('videoInfo').insertAfter('.breadcrumb + h1');
	  			$('.videoInfo').css('float', 'left');
	  			$('.videoInfo').css('width', '100%');
	  			$('.videoInfo p').css('padding', '0 10px 10px 12px');
  			}
		}

		// FIX THIS LATER: removing double cases of feed links.
		if($('.feeds.clearfix').length > 1){
			$('.feeds.clearfix').eq(1).remove();
		}

       /* if (is_pdf_link_exist()) {
            $('.reader').show();
        }
        else {
            $('.reader').hide();
        }

        function is_pdf_link_exist(){

            $('a').each(function() {
                var value = $(this).attr('href');

                if (value && value.length > 0  ) {
                    console.log(value + value.toLowerCase().indexOf(".pdf"));
                    if (value.toLowerCase().indexOf(".pdf") > 0) {
                        return true;
                    }
                }
            });
            return false;
        }*/

	});
})(jQuery);
