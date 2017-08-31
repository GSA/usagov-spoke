
// On document ready, we may need to initialize this helper script
jQuery(document).ready( function () {
    $ = jQuery;
  /*  var default_text = $('#def_text').text();
    $('#def_text').hide();

    var txt_area = $('#edit-recipients');

    txt_area.focus(function(event){
        if($('#edit-recipients').val() == default_text) {
            $('#edit-recipients').val("");
        }
    });

    txt_area.blur(function(event) {
        if($('#edit-recipients').val() == '') {
            $('#edit-recipients').val(default_text);
        }
    });*/

    //$( "div:contains(' * Campo obligatorio')").hide();
   // $( "div:contains(' * Required field')").hide();
    $('.form-item-email').next().hide();

    fix_title('name');
    fix_title('email');

    function fix_title(str){
        $('.form-item-' + str + ' > label:first-child').after("<br />");
    }
});