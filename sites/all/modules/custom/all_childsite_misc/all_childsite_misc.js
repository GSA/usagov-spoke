(function ($) {

    $(document).ready(function() {

        $('.page_list_wrapper').hide();
        var $base_url = window.location.href;

        // to check whether base_url has letter set or not
        var chosen_letter = $base_url.match(/letter=([^&]+)/);
        if (chosen_letter == null) {
            // no letter selected and show first
            history.pushState(null, null, $base_url + '?letter=' + $('.atoz_letter').first().attr('href'));
            $('.page_list_wrapper').first().show();
            $('.page_list_wrapper').first().addClass('shown');
            $('a[href="A"]').parent('li').addClass('current');

        }
        else {
            // letter selected and show chosen letter
            $('#letter_'+chosen_letter[1]).show();
            $('#letter_'+chosen_letter[1]).addClass('shown');
        }

        $('.atoz_letter').click(function(e) {
            e.preventDefault();
            $('.shown').hide();
            $('.current').removeClass('current');
            $('.shown').removeClass('shown');

            var letter = $(this).attr('href');
            var clicked_anchor = $('a[href="' + letter + '"]');
            clicked_anchor.parent('li').addClass('current');


            $('#letter_'+letter).addClass('shown');
            $('#letter_'+letter).fadeIn();
            var url_parts = $base_url.split('?');
            var main_url = url_parts[0];

            history.pushState(null, null, main_url + '?letter=' + letter);

        });
    });

})(jQuery);
