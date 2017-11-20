// Togglify is a function that can be added to any usa-accordion from the
// US Web Design Standards. It requires the class 'usa-accordion-toggle'
// to be added to the accordion element. It also requires a button with
// the class 'usa-accordion-toggle-all' and data attribute, 'data-toggledText'
// (the text for the toggled state) to be added within the accordion.
jQuery(document).ready(function() {

    jQuery.fn.togglify = function() {
        var toggle=jQuery(this);
        //alert(jQuery(this).prop('id'));

        var accordion=jQuery('#' + toggle.attr("aria-controls"));
        var isToggled=toggle.attr("aria-expanded");
        var initialText=toggle.text();
        var toggledText=toggle.attr("data-toggledText");


        toggle.on('click', function() {

            // 'Toggle All' button has been clicked
            accordion.find('.usa-accordion-button').each(function () {
                var accordionButton = jQuery(this);

                if (isToggled) {
                    //Open All Dropdowns
                    accordionButton.attr('aria-expanded', 'true');
                    jQuery('#' + accordionButton.attr('aria-controls')).attr('aria-hidden', 'false');
                } else {
                    //Close All Dropdowns
                    accordionButton.attr('aria-expanded', 'false');
                    jQuery('#' + accordionButton.attr('aria-controls')).attr('aria-hidden', 'true');
                }
            });

            //Update 'Toggle All' button
            if (isToggled) {
                toggle.text(toggledText);
                toggle.attr("aria-expanded", true);
            } else {
                toggle.text(initialText);
                toggle.attr("aria-expanded", false);
            }
            isToggled = !isToggled;
        });


        accordion.find('.usa-accordion-button').on('click', function(e){
            //An accordion button has been clicked
            accordion.find('.usa-accordion-button').each(function(){
                //Capture the state of each dropdown before WDS changes the state.
                var acb=jQuery(this);
                var aexp=acb.attr('aria-expanded');
                var ah='true';
                if(aexp=='true'){
                    ah='false';
                }
                //Delay until after WDS changes the state. Then return to the state we captured.
                setTimeout(function(){
                    acb.attr('aria-expanded', aexp);
                    jQuery('#' + acb.attr('aria-controls')).attr('aria-hidden', ah);
                }, 1);

            });
            //Capture the state of the clicked button's dropdown before WDS changes the state.
            var accordionButton=jQuery(this);
            var ariaExpanded=accordionButton.attr('aria-expanded');
            var ariaHidden='true';
            if(ariaExpanded=='true'){
                ariaHidden='false';
            }
            //Delay until after we return all dropdowns to initial state. Then toggle the clicked dropdown.
            setTimeout(function(){
                accordionButton.attr('aria-expanded', ariaHidden);
                jQuery('#' + accordionButton.attr('aria-controls')).attr('aria-hidden', ariaExpanded);

                //Change the toggle all button
                var allOpen=true;
                accordion.find('.usa-accordion-button').each(function(){
                    if(jQuery(this).attr('aria-expanded')=='false'){
                        allOpen=false;
                    }
                });
                if(!allOpen){
                    toggle.text(initialText);
                    toggle.attr("aria-expanded",false);
                    isToggled=true;
                }else{
                    toggle.text(toggledText);
                    toggle.attr("aria-expanded",true);
                    isToggled=false;
                }
            }, 2);
        });
    };


    if(jQuery('.usa-accordion-toggle-all').length>0)
        jQuery('.usa-accordion-toggle-all').togglify();

    jQuery('#FacetedSearchReset').on('click', function() {
        jQuery('#errorList').remove();
        jQuery('#business-search').val("");
        jQuery('#stateselect').val("");
        jQuery('#monthselect').val("");
        jQuery('#dayselect').val("");
        jQuery('#yearselect').val("");
        jQuery('#addition').removeAttr('checked');
        jQuery('#errorList').remove();

        if (!jQuery('#filter3').hasClass("no-error")){
            jQuery('#filter3').addClass("no-error").addClass("no-future-date-error");
        }

        if (!jQuery('#filter4').hasClass('no-error')) {
            jQuery('#filter4').addClass("no-error").addClass("no-future-date-error");
        }
        setTimeout(function(){
            jQuery('#filter4').find('[type="checkbox"]').prop('checked', false);
        }, 10);

    });

    inFocus = false;
    jQuery('#apply-selected-filter').click(function() {
        inFocus = true;
    });

    jQuery(".kpdd").on('keydown',function(event){
        if(event.keyCode == 13) {

            validateForm();

            if (jQuery('form[name="facetedSearchForm"]').hasClass('form-validated')) {
                jQuery('#cind').val(1);
                var pagination_default = 0;
                _sendajaxreq(pagination_default, 1, 0, 0);
            }
            event.preventDefault();
        }
    });
    jQuery('#filter4 input[type="checkbox"]').on('keydown',function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return;
        }
    });

    jQuery('#cind').val(1);
    // after load
    _sendajaxreq(0, 0, 0, 2);

}); /*Document ready closes*/

function validateForm(form, event, scroll){
    //if(!document.business_search_form.query.value.includes('business'))document.business_search_form.query.value+=' business'

    var month = jQuery('#monthselect');
    var monthVal = parseInt(month.val());
    var day = jQuery('#dayselect');
    var dayVal = parseInt(day.val());
    var year = jQuery('#yearselect');
    var yearVal = parseInt(year.val());

    var submit = jQuery('[name="apply_selected_filters"]');

    if ( jQuery('form[name="facetedSearchForm"]').hasClass('form-validated')) {
        jQuery('form[name="facetedSearchForm"]').removeClass('form-validated');
    }

    month.parents(".usa-input-error").addClass("no-error");
    day.parents(".usa-input-error").addClass("no-error");
    year.parents(".usa-input-error").addClass("no-error");
    month.removeAttr("aria-describedby");
    day.removeAttr("aria-describedby");
    year.removeAttr("aria-describedby");

    submit.parents(".usa-input-error").addClass("no-error").addClass("no-date-error").addClass("no-future-date-error");
    jQuery('#filter3').addClass("no-error").addClass("no-future-date-error");

    var errorList="";
    jQuery('#errorList').remove();

    if(monthVal || dayVal || yearVal){
        // at least one date field is set. Show errors for any date field left blank.
        var errorExists=false;
        if(!monthVal){
            month.parents(".usa-input-error").removeClass("no-error");
            submit.parents(".usa-input-error").removeClass("no-error").removeClass("no-date-error");
            errorExists=true;
            errorList+="<li id='monthli'><a href=\"#monthselect\">To search by posted date, you must select a month</li>";
        }
        if(!dayVal){
            day.parents(".usa-input-error").removeClass("no-error");
            submit.parents(".usa-input-error").removeClass("no-error").removeClass("no-date-error");
            errorExists=true;
            errorList+="<li id='dayli'><a href=\"#dayselect\">To search by posted date, you must select a day</li>";
        }
        else if(dayVal == 31 && monthVal % 2 == 0 && monthVal != 2)
        {
            day.val(30);
        }
        else if (monthVal == 2){

            if (dayVal > 29 && yearVal % 4 ==0){
                day.val(29);
            }
            else if (dayVal > 28 && yearVal % 4 !=0) {
                day.val(28);
            }
        }

        if(!yearVal){
            year.parents(".usa-input-error").removeClass("no-error");
            submit.parents(".usa-input-error").removeClass("no-error").removeClass("no-date-error");
            errorExists=true;
            errorList+="<li id='yearli'><a href=\"#yearselect\">To search by posted date, you must select a year</li>";
        }
        if(errorExists){
            //There is at least one value missing, the errors are showing.
            //When user changes something, revalidate.
            month.change(function() {
                //validateForm(form, event, false);
                jQuery('#filter3').addClass("no-error").addClass("no-future-date-error");
                jQuery('#monthli').remove();
                if (jQuery( "#errul li" ).size() == 0){
                    jQuery('#errorList').remove();
                }
            });
            day.change(function() {
                //validateForm(form, event, false);
                jQuery('#filter3').addClass("no-error").addClass("no-future-date-error");
                jQuery('#dayli').remove();
                if (jQuery( "#errul li" ).size() == 0){
                    jQuery('#errorList').remove();
                }
            });
            year.change(function() {
                //validateForm(form, event, false);
                jQuery('#filter3').addClass("no-error").addClass("no-future-date-error");
                jQuery('#yearli').remove();
                if (jQuery( "#errul li" ).size() == 0){
                    jQuery('#errorList').remove();
                }
            });

            //if panel is not opened, open it
            //TODO: Create function for opening panels
            var datePanel=jQuery('#filter3');
            if(datePanel.attr('aria-hidden')){
                datePanel.attr('aria-hidden','false');
                jQuery('[aria-controls="filter3"]').attr('aria-expanded','true');
            }

        }else{
            //All date values are set
            var dateToday = new Date();
            var date = new Date(monthVal+" "+dayVal+", "+ yearVal);

            if(date.getTime()>dateToday.getTime()){
                //The Date is in the future, the errors are showing.
                //When user changes something, revalidate.
                submit.parents(".usa-input-error").removeClass("no-error").removeClass("no-future-date-error");
                jQuery('#filter3').removeClass("no-error").removeClass("no-future-date-error");

                month.attr("aria-describedby", "future-date-error-message");
                day.attr("aria-describedby", "future-date-error-message");
                year.attr("aria-describedby", "future-date-error-message");

                errorList+="<li><a href=\"#monthselect\">You must select a date in the past to search by posted date.</li>";

                year.change(function() {
                    //validateForm();
                });
                month.change(function() {
                    //validateForm();
                });
                day.change(function() {
                    //validateForm();
                });

                //if panel is not opened, open it
                //TODO: Create function for opening panels
                var datePanel=jQuery('#filter3');
                if(datePanel.attr('aria-hidden')){
                    datePanel.attr('aria-hidden','false');
                    jQuery('[aria-controls="filter3"]').attr('aria-expanded','true');
                }
            }else{
                // All fields set. Valid. Unbind change action to prevent abnoxious error messages on change.
                month.unbind( "change" );
                day.unbind( "change" );
                year.unbind( "change" );
                month.removeAttr("aria-describedby");
                day.removeAttr("aria-describedby");
                year.removeAttr("aria-describedby");
            }
            jQuery('form[name="facetedSearchForm"]').addClass('form-validated'); //TODO: return true when the form submit action is ready.
        }
    }else{
        // No fields set. Valid. Unbind change action to prevent abnoxious error messages on change.
        month.unbind( "change" );
        day.unbind( "change" );
        year.unbind( "change" );
        month.removeAttr("aria-describedby");
        day.removeAttr("aria-describedby");
        year.removeAttr("aria-describedby");

        submit.parents(".usa-input-error").addClass("no-error");//todo:need this line?
        jQuery('form[name="facetedSearchForm"]').addClass('form-validated');
    }

    jQuery('#filter4').addClass('no-error');
    if(noSetasideSelected()){ //TODO
        jQuery('form[name="facetedSearchForm"]').removeClass('form-validated');
        //no setasides are selected, show error message
        jQuery('#filter4').removeClass('no-error');
        errorList+="<li><a href=\"#8a\">At least one Special Business Label (Set-Aside Type) box must be checked in order to possibly get results.</li>";
        jQuery('#filter4 input[type="checkbox"]').attr("aria-describedby", "setaside-error-message");

        jQuery('#filter4 input[type="checkbox"]').change(function() {
            //validateForm(form, event, false);
        });

        //if panel is not opened, open it
        //TODO: Create function for opening panels
        var datePanel=jQuery('#filter4');
        if(datePanel.attr('aria-hidden')){
            datePanel.attr('aria-hidden','false');
            jQuery('[aria-controls="filter4"]').attr('aria-expanded','true');
        }
    }else{
        //at least one setaside selected, unbind change action to prevent error messages on change
        jQuery('#filter4 input[type="checkbox"]').unbind( "change" );
        jQuery('#filter4 input[type="checkbox"]').removeAttr("aria-describedby");
    }

    if(errorList!=""){
        var errorList = jQuery("<div id=\"errorList\" tabindex=\"-1\"><header ><h2>Attention: Your request has the following error(s)</h2></header><ul id='errul'>"+errorList+"</ul></div>");
        jQuery('[name="facetedSearchForm"]').prepend(errorList);

        //if panel is not opened, open it
        //TODO: Create function for opening panels
        jQuery('#errorList [href="#monthselect"], #errorList [href="#dayselect"], #errorList [href="#dayselect"]').click(function() {
            var datePanel=jQuery('#filter3');
            if(datePanel.attr('aria-hidden')){
                datePanel.attr('aria-hidden','false');
                jQuery('[aria-controls="filter3"]').attr('aria-expanded','true');
            }
        });
        //if panel is not opened, open it
        //TODO: Create function for opening panels
        jQuery('#errorList [href="#8a"]').click(function() {
            var datePanel=jQuery('#filter4');
            if(datePanel.attr('aria-hidden')){
                datePanel.attr('aria-hidden','false');
                jQuery('[aria-controls="filter4"]').attr('aria-expanded','true');
            }
        });

        if(scroll){
            goToByScroll("#secondpara");
            jQuery('#errorList').focus();
        }
        // if it has error
        if (jQuery('form[name="facetedSearchForm"]').hasClass('form-validated')){
            jQuery('form[name="facetedSearchForm"]').removeClass('form-validated');
        }
        dataLayer.push({'event' : 'formSubmitInvalid'});
    }
    else{
        dataLayer.push({'event' : 'formSubmitted'});
    }

    if (jQuery('form[name="facetedSearchForm"]').hasClass('form-validated') && inFocus){
        jQuery('#cind').val(1);
        jQuery('#storeuserinput').val(1);
        var pagination_default = 0;

        _sendajaxreq(pagination_default,1, 0, 0);
    }
    return false;
}
function goToByScroll(id){
    if (jQuery(id).length > 0 ) {
        jQuery('html,body').animate({
            scrollTop: jQuery(id).offset().top
        });
        return false;
    }
}

function noSetasideSelected(){
    return jQuery('#filter4 input[type="checkbox"]:checked').length==0;
}

function _sendajaxreq(p, scrolll, paginated, init) {

    var maincontainer = jQuery('#main-list-container');
    var record_size = 5;
    var val = [];
    var k=0;
    jQuery(':checkbox:checked').each(function(i){
        if (jQuery(this).val()=="smbiz"){
            val[k] = 'Total Small Business';
            k++;
            val[k] = 'Partial Small Business';
            k++;
        }
        else if (jQuery(this).val()=="womensmbiz"){
            val[k] = 'Woman Owned Small Business';
            k++;
            val[k] = 'Economically Disadvantaged Women-Owned Small Business';
            k++;
        }
        else if (jQuery(this).val()=="indianeco"){
            val[k] = 'Indian Economic Enterprises';
            k++;
            val[k] = 'Indian Small Business Economic Enterprises';
            k++;
        }
        else {
            val[k] = jQuery(this).val();
            k++;
        }
    });


    var formData = {
        'keyword': jQuery('#business-search').val(),
        'state': jQuery('select[name=stateselect]').val(),
        'postdate': jQuery('select[name=yearselect]').val() + '-' + jQuery('select[name=monthselect]').val() + '-' + jQuery('select[name=dayselect]').val(),
        'setaside': val,
        'do_index': parseInt(jQuery('#storeuserinput').val()),
        'from':p
    };

    maincontainer.html('');
    maincontainer.addClass('loading');
    jQuery.ajax({
        url: "/searchFBOdatajax",
        data: formData,
        dataType: 'json',
        type: 'POST',
        success: function (data) {
            console.log(data.paramm);
            console.log(data.s);

            if (data.total > 0) {
                var html_list = '';
                var pagination = '';
                var start = p;
                var end = p + data.size;
                var html_pagination_li = '';
                var cls = '';
                var aa = '';
                var prev_btn = '';
                var sspan = '';
                var cur_ind = 1;

                if (p == 0) {
                    start = 1;
                }
                else {
                    jQuery('#cind').val(start/5);
                }

                if (data.total < data.size || end > data.total) {
                    end = data.total;
                }

                var pind = parseInt(data.total / data.size); // total pagination
                if (data.total % data.size  > 0){
                    pind = parseInt(data.total / data.size) + 1;
                }
                var si = 1;
                var ei = 5;

                //console.log('CIND: ' + jQuery('#cind').val() + ' SISISI:' + si + 'EIEIEI: ' + ei + ' PIND:' + pind );

                if (jQuery('#cind').val() > 2 && pind > 5){
                    // set new start and end based on current pagination
                    si = parseInt(jQuery('#cind').val()) - 1;
                    ei = parseInt(jQuery('#cind').val()) + 3;

                }
                if (si == 0) si = 1;

                if (ei >= pind || pind < 5 ) {
                    ei=pind;
                }

                //if (si != ei && si > 0) { // only one pagination
                for (var i = si; i <= ei; i++) {

                    if ((i == 1 && p == 0) || (p > 0 && (start / data.size + 1) == i)) {
                        cls = 'current';
                        cur_ind = i;
                        aa = '<span class="usa-sr-only">Curent page</span>'+i;
                        jQuery('#cind').val(i);
                    }
                    else {
                        var focusme = '';
                        if ((cur_ind+1) == i && cur_ind>1){
                            focusme = 'focusme';
                        }
                        cls = 'pager-item';
                        sspan = '<span class="usa-sr-only">Go to page </span>';
                        aa = '<a class="pagination_anchor '+focusme+'" id="pagination' + i + '" href="#">' + sspan + i + '</a>';
                    }
                    html_pagination_li += '<li class="' + cls + '">' + aa + '</li>';
                }
                //}

                // next button
                if ((parseInt(jQuery('#cind').val())) < Math.round(ei)){
                    html_pagination_li += '<li class="pager-ellipsis">…</li><li class="next last"><a href="#" role="button" title="Go to page '+(parseInt(jQuery('#cind').val())+1)+'" class="next">next<img src="./sites/all/themes/usa/images/arrow_next.png" alt=""></a></li>';
                }

                // previous button
                if (cur_ind > 1){
                    prev_btn = '<li class="previous first"><a title="Go to page ' + (cur_ind-1) + '" class="prev" role="button" href="#"><img src="./sites/all/themes/usa/images/arrow_previous.png" alt="">previous</a></li>';
                }

                var tmp508 = '';
                if (paginated){
                    tmp508 = 'role="alert"';
                }

                if (data.total != 0) {
                    var html_pagination = '<section><div class="usa-grid" ><div><header id="searchresultheader"><h2 class="searchresulttitle">Search Results</h2></header>' +
                        '<div class="item-list2" id="nav-page" aria-labelledby="nav-page-label"><span class="pager-dscrpt" id="nav-page-label" for="current_pagination" '+tmp508+' class="pager-dscrpt">Viewing '+start+'-'+end+' of '+data.total+' results</span><ul class="pagination">'+prev_btn+'<li class="pager-dscrpt2">Viewing '+start+'-'+end+' of '+data.total+' results</li>'+html_pagination_li+'</ul></div></div></div></section>';
                }
                var len = data.opps.length -1;
                for (opp in data.opps) {

                    ddate = data.opps[opp].postdate;
                    if (data.opps[opp].closedate != null){
                        ddate += ' to '+ data.opps[opp].closedate;
                    }

                    var opptypetooltip = '';
                    var setasidetypetooltip = '';

                    if (data.opps[opp].type == 'PRESOL') {
                        opptypetooltip = 'This is a notice about a future contract. It may ask interested businesses for information.';
                        data.opps[opp].type = 'Presolicitation';
                    }
                    else if(data.opps[opp].type == 'COMBINE' || data.opps[opp].type == 'SOL') {
                        opptypetooltip = 'This is a description of a currently open contract.';
                        data.opps[opp].type = 'Combined Synopsis/Solicitation';
                    }
                    else if(data.opps[opp].type == 'SRCSGT' || data.opps[opp].type == 'SOURCES SOUGHT') {
                        opptypetooltip = 'This is a request for information about a potential contract.';
                        data.opps[opp].type = 'Sources Sought';
                    }

                    if (data.opps[opp].setaside == 'Total Small Business' || data.opps[opp].setaside == 'Partial Small Business'){
                        setasidetypetooltip = 'For small businesses. Must meet SBA size standards.';
                    }
                    else if (data.opps[opp].setaside == 'Service-Disabled Veteran-Owned Small Business'){
                        setasidetypetooltip ='For small businesses owned by service-disabled veterans. Must be verified through VA.';
                    }
                    else if (data.opps[opp].setaside == 'Woman Owned Small Business'){
                        setasidetypetooltip ='For small businesses owned by women. Must be certified through SBA.';
                    }
                    else if (data.opps[opp].setaside == 'Veteran-Owned Small Business'){
                        setasidetypetooltip ='For small businesses owned by veterans. Must be verified through VA.';
                    }
                    else if (data.opps[opp].setaside == 'Indian Small Business Economic Enterprises'){
                        setasidetypetooltip ='For small businesses owned by American Indians. Must be member of federally recognized tribe or Native village.';
                    }
                    else if (data.opps[opp].setaside == 'Indian Economic Enterprises'){
                        setasidetypetooltip ='For businesses owned by American Indians. Must be member of federally recognized tribe or Native village.';
                    }
                    else if (data.opps[opp].setaside == 'HUBZone'){
                        setasidetypetooltip ='For small businesses in specific rural and urban communities. Must apply through SBA.';
                    }
                    else if (data.opps[opp].setaside == 'HBCU/MI'){
                        setasidetypetooltip ='For historically black or minority institutions. Must be identified by U.S. Dept. of Education.';
                    }
                    else if (data.opps[opp].setaside == 'Emerging Small Business'){
                        setasidetypetooltip ='For very small businesses. Must meet SBA size standards.';
                    }
                    else if (data.opps[opp].setaside == 'Economically Disadvantaged Women-Owned Small Business'){
                        setasidetypetooltip ='For small businesses owned by economically disadvantaged women. Must be certified through SBA.';
                    }
                    else if (data.opps[opp].setaside == 'Competitive 8(a)'){
                        setasidetypetooltip ='For small socially and economically disadvantaged businesses. Must apply through SBA.';
                    }
                    else if (data.opps[opp].setaside == 'N/A'){
                        setasidetypetooltip ='Opportunity does not have a set-aside type.';
                    }

                    if (data.opps[opp].zip == null){
                        data.opps[opp].zip = 'N/A';
                    }

                    html_list += '<section><div class="section-box">';

                    html_list += '<div class="result-details">';
                    html_list += '<div class="result-details-column"> <span><strong><a target="_blank" href="'+data.opps[opp].link+'" >'+data.opps[opp].subject+'</a></strong><br>'+data.opps[opp].solnbr+'</span> </div>';
                    html_list += '<div class="result-details-column"> <span><strong>Opportunity Type:</strong><br>'+data.opps[opp].type;
                    html_list += '<span class="tooltip" role="tooltip" tabindex="0"> <img class="tooltip-icon2" src="/sites/all/themes/usa/images/Icon_Tooltip.png" alt="tooltip" aria-hidden="true" ><span class="tooltiptext">'+opptypetooltip+'</span><span aria-label="Tooltip - '+opptypetooltip+'"></span></span> </span>';
                    html_list += '<div><strong>Set-Aside Type:</strong><br>'+data.opps[opp].setaside +'<span class="tooltip" role="tooltip" tabindex="0"> <img class="tooltip-icon2" src="/sites/all/themes/usa/images/Icon_Tooltip.png" alt="tooltip" aria-hidden="true" ><span class="tooltiptext">'+setasidetypetooltip+'</span><span aria-label="Tooltip - '+setasidetypetooltip+'"></span></span> </div>';
                    html_list += '<div><strong>Posted:</strong><br>'+ ddate +'<span class="tooltip" role="tooltip" tabindex="0"> <img class="tooltip-icon2" src="/sites/all/themes/usa/images/Icon_Tooltip.png" alt="tooltip" aria-hidden="true" ><span class="tooltiptext">The date range an opportunity is open. Some do not have closing dates.</span><span aria-label="Tooltip - The date range an opportunity is open. Some do not have closing dates."></span></span> </div>';
                    html_list += '</div>'; //result-details-column close

                    html_list += '<div class="result-details-column"><address><strong>Agency:</strong><br>'+data.opps[opp].agency+'<br>';
                    html_list += '<strong>Office:</strong><br>'+data.opps[opp].office+'<br>';
                    html_list += '<strong>ZIP Code:</strong><br>'+data.opps[opp].zip+'<br>';
                    html_list += '<strong>State:</strong><br>'+data.opps[opp].state+'</address> </div></div>'; // result-details-column and result-details

                    html_list += '<div class="usa-grid"><div class="usa-width-one-whole"> <div class="usa-accordion"><div class="filter-box">';
                    html_list += '<button class="usa-accordion-button ttt" aria-expanded="false" aria-controls="result'+opp+'"><span class="element-invisible">'+data.opps[opp].subject+'</span>Description of Opportunity</button>';
                    html_list += '<div id="result'+opp+'" class="usa-accordion-content" aria-hidden="true">';
                    html_list += '<p>' + data.opps[opp].desc + '</p>';
                    html_list += '<p><strong><a target="_blank" href="'+data.opps[opp].link+'"><span class="element-invisible">The view contact and bid information for opportunity will open in a new window.</span>View any uploaded documents, contact information, and bidding requirements <span class="element-invisible">'+data.opps[opp].subject+'</span></a></strong></p>';
                    html_list += '</div></div></div></div></div>';

                    html_list += '</div>';
                    html_list += '</section>';

                    if (len == opp) {
                        html_list +='<section ><div class="usa-grid" ><div>' +
                        '<div class="item-list2" id="nav-page2" aria-labelledby="nav-page-label2"><span class="pager-dscrpt" id="nav-page-label2">Viewing '+start+'-'+end+' of '+data.total+' results</span><ul class="pagination">'+prev_btn+'<li class="pager-dscrpt2">Viewing '+start+'-'+end+' of '+data.total+' results</li>'+html_pagination_li+'</ul></div></div></div></section>';
                    }

                    html_list += '<p class="volver clearfix"><a href="#skiptarget"><span class="icon-backtotop-dwnlvl">Back to Top</span></a></p>';
                }

                maincontainer.removeClass('loading');
                maincontainer.html( html_pagination +  html_list );

                jQuery('.ttt').click(function(){

                    if(jQuery(this).attr("aria-expanded") == 'false'){
                        jQuery(this).attr('aria-expanded', 'true');
                        jQuery('#' + jQuery(this).attr("aria-controls")).attr('aria-hidden', 'false');

                    }else{
                        jQuery(this).attr('aria-expanded', 'false');
                        jQuery('#' + jQuery(this).attr("aria-controls")).attr('aria-hidden', 'true');
                    }

                });

                // pagination click handler
                jQuery('.pagination_anchor').click(function (e) {
                    jQuery(this).find('span').remove();
                    lp = (jQuery(this).text() - 1) * record_size;
                    jQuery('#storeuserinput').val(0);
                    // about to send next ajax
                    _sendajaxreq(lp,1,1, 0);
                    e.preventDefault();
                })
                // next button
                jQuery('.next').click(function (e) {
                    lp = (jQuery('#cind').val()) * record_size;
                    jQuery('#storeuserinput').val(0);
                    // about to send next ajax
                    _sendajaxreq(lp,1,1, 0);
                    e.preventDefault();
                })
                // prev button
                jQuery('.prev').click(function (e) {
                    lp = (jQuery('#cind').val() - 2) * record_size;
                    jQuery('#storeuserinput').val(0);
                    // about to send next ajax
                    _sendajaxreq(lp, 1,1, 0);
                    e.preventDefault();
                })

                jQuery('.focusme').first().focus();

            }
            else {
                maincontainer.html("<section><div class='usa-grid' ><div><header id='searchresultheader'><h2 class='searchresulttitle'>Search Results</h2></header><div class='usa-input-error'>"
                +"<span class='usa-input-error-message'>Attention: We cannot find any opportunities that match your search. Try any of these options and search again:</span>"
                +"<ul><li>If you used the Keyword Search, enter a different keyword or phrase. Tip: Try entering a keyword or phrase that is shorter or less specific. </li>"
                +"<li>Select an earlier Posted Date</li>"
                +"<li>Try different Set-Aside Type selections</li>"
                +"<li>Use fewer filters or a different combination of filters</li></ul>"
                +"</div></div></div></section>");
                dataLayer.push({'event' : 'FBOzeroResults'});
                maincontainer.removeClass('loading');
                jQuery("#searchresultheader").attr('tabindex', -1);
                jQuery('#searchresultheader').focus();
                goToByScroll('#searchresultheader');
            }
            if(scrolll) {
                goToByScroll("#main-list-container");
            }

            if (init != 2) {
                jQuery("#searchresultheader").attr('tabindex', -1);
                jQuery('#searchresultheader').focus();
                goToByScroll('#searchresultheader');
            }

        },
        error: function (data) {
            maincontainer.html("<div class='usa-input-error'><h2>We're sorry, we cannot complete your search right now.</h2>"+
            "<span class='usa-input-error-message'>We're having an unexpected technical problem with the system. We\'re working to fix the issue. Please try your search again later. You can also try visiting <a href=\"https://www.fbo.gov/\">FedBizOpps.gov</a> to complete your search.</span></div>");
            maincontainer.removeClass('loading');
            if(scrolll) {
                goToByScroll("#main-list-container");
            }
        }
    });
}




