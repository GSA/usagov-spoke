// Togglify is a function that can be added to any usa-accordion from the
// US Web Design Standards. It requires the class 'usa-accordion-toggle'
// to be added to the accordion element. It also requires a button with 
// the class 'usa-accordion-toggle-all' and data attribute, 'data-toggledText'
// (the text for the toggled state) to be added within the accordion.
jQuery.fn.togglify = function() {
	var toggle=jQuery(this);
	var accordion=jQuery('#' + toggle.attr("aria-controls"));
	var isToggled=toggle.attr("aria-expanded");
	var initialText=toggle.text();
	var toggledText=toggle.attr("data-toggledText");


	toggle.on('click', function() {
		// 'Toggle All' button has been clicked
		accordion.find('.usa-accordion-button').each(function(){
			var accordionButton=jQuery(this);
			
			if(isToggled){
				//Open All Dropdowns
				accordionButton.attr('aria-expanded', 'true');
				jQuery('#' + accordionButton.attr('aria-controls')).attr('aria-hidden', 'false');
			}else{
				//Close All Dropdowns
				accordionButton.attr('aria-expanded', 'false');
				jQuery('#' + accordionButton.attr('aria-controls')).attr('aria-hidden', 'true');
			}
		});
		//Update 'Toggle All' button
		if(isToggled){
			toggle.text(toggledText);
			toggle.attr("aria-expanded",true);
		}else{
			toggle.text(initialText);
			toggle.attr("aria-expanded",false);
		}
		isToggled=!isToggled;
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

jQuery(function(){
	if(jQuery('.usa-accordion-toggle-all').length>0){
		jQuery('.usa-accordion-toggle-all').togglify();
	}
	
	jQuery('#FacetedSearchReset').on('click', function() {
	// 	jQuery('#business-search').val("");
	// 	jQuery('#stateselect').val("");
	// 	jQuery('#monthselect').val("");
	// 	jQuery('#dayselect').val("");
	// 	jQuery('#yearselect').val("");
	// 	jQuery('#filter4').find('[type="checkbox"]').prop('checked', true);
	// 	jQuery('#addition').removeAttr('checked');
		setTimeout(function(){
	    validateForm(false);
			jQuery('#filter4').find('[type="checkbox"]').prop('checked', false);
		}, 10);
		
	});
});


function validateForm(scroll){
	//if(!document.business_search_form.query.value.includes('business'))document.business_search_form.query.value+=' business'

	var month = jQuery('#monthselect');
	var monthVal = month.val();
	var day = jQuery('#dayselect');
	var dayVal = day.val();
	var year = jQuery('#yearselect');
	var yearVal = year.val();

	var submit = jQuery('[name="facetedSearchForm"] [type="submit"]');

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
      month.attr("aria-describedby", "month-error-message");//TODO: Should this attr be changed in js, or should the error message container be reused for both error messages?
			errorExists=true;
			errorList+="<li><a href=\"#monthselect\">To search by posted date, you must select a month</li>";
		}
		if(!dayVal){
			day.parents(".usa-input-error").removeClass("no-error");
			submit.parents(".usa-input-error").removeClass("no-error").removeClass("no-date-error");
      day.attr("aria-describedby", "day-error-message");
			errorExists=true;
			errorList+="<li><a href=\"#dayselect\">To search by posted date, you must select a day</li>";
		}
		if(!yearVal){
			year.parents(".usa-input-error").removeClass("no-error");
			submit.parents(".usa-input-error").removeClass("no-error").removeClass("no-date-error");
      year.attr("aria-describedby", "year-error-message");
			errorExists=true;
			errorList+="<li><a href=\"#yearselect\">To search by posted date, you must select a year</li>";
		}
		if(errorExists){
			//There is at least one value missing, show error.
			//When user changes something, revalidate without rescrolling.

			month.change(function() {
				validateForm(false);
			});
			day.change(function() {
			  validateForm(false);
			});
			year.change(function() {
			  validateForm(false);
			});
			
			//if panel is not opened, open it
			//TODO: Create function for opening panels
			var datePanel=jQuery('#filter3');
			if(datePanel.attr('aria-hidden')){
				datePanel.attr('aria-hidden','false');
				jQuery('[aria-controls="filter3"]').attr('aria-expanded','true');
			}
			
			//if(scroll) goToByScroll("#filter3");
			//return false;
		}else{
			//All date values are set
			var dateToday = new Date();
			var date = new Date(monthVal+" "+dayVal+", "+ yearVal);

			if(date.getTime()>dateToday.getTime()){
				//The Date is in the future, show error.
				//When user changes something, revalidate without rescrolling.
				
				submit.parents(".usa-input-error").removeClass("no-error").removeClass("no-future-date-error");
				jQuery('#filter3').removeClass("no-error").removeClass("no-future-date-error");
        
        month.attr("aria-describedby", "future-date-error-message");
        day.attr("aria-describedby", "future-date-error-message");
        year.attr("aria-describedby", "future-date-error-message");

				errorList+="<li><a href=\"#monthselect\">You must select a date in the past to search by posted date.</li>";

				year.change(function() {
				  validateForm(false);
				});
				month.change(function() {
				  validateForm(false);
				});
				day.change(function() {
				  validateForm(false);
				});
				
				//if panel is not opened, open it
				//TODO: Create function for opening panels
				var datePanel=jQuery('#filter3');
				if(datePanel.attr('aria-hidden')){
					datePanel.attr('aria-hidden','false');
					jQuery('[aria-controls="filter3"]').attr('aria-expanded','true');
				}
				
				//if(scroll) goToByScroll("#filter3");
			}else{
				// All fields set and valid. Unbind change action to prevent abnoxious error messages on change.
				month.unbind( "change" );
				day.unbind( "change" );
				year.unbind( "change" );
        
        month.removeAttr("aria-describedby");
        day.removeAttr("aria-describedby");
        year.removeAttr("aria-describedby");
				//if(scroll) goToByScroll("#SearchResultsHeading");
			}
			
		}
		//return false; //TODO: return true when we are ready to handle form submits.
	}else{
		// No fields set. Valid. Unbind change action to prevent error messages on change.
		month.unbind( "change" );
		day.unbind( "change" );
		year.unbind( "change" );
    
    month.removeAttr("aria-describedby");
    day.removeAttr("aria-describedby");
    year.removeAttr("aria-describedby");
    
		//submit.parents(".usa-input-error").addClass("no-error");//todo:need this line?
		//if(scroll) goToByScroll("#SearchResultsHeading");
	}

	jQuery('#filter4').addClass('no-error');
	if(noSetasideSelected()){ //TODO
		//no setasides are selected, show error message
		jQuery('#filter4').removeClass('no-error');
		errorList+="<li><a href=\"#8a\">Attention. At least one Special Business Label (Set-Aside) box must be checked in order to possibly get results.</li>";
		jQuery('#filter4 input[type="checkbox"]').attr("aria-describedby", "setaside-error-message");
		
		jQuery('#filter4 input[type="checkbox"]').change(function() {
		 	validateForm(false);
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
		var errorList = $("<div id=\"errorList\" tabindex=\"-1\"><header><h2>There are errors with your inputs</h2></header><ul>"+errorList+"</ul></div>");
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
    	goToByScroll("#errorList");
    	jQuery('#errorList').focus();
    }
	}

	return false;
}

function noSetasideSelected(){
    return jQuery('#filter4 input[type="checkbox"]:checked').length==0;
}

function goToByScroll(id){
    jQuery('html,body').animate({
        scrollTop: jQuery(id).offset().top});
    return false;
}

