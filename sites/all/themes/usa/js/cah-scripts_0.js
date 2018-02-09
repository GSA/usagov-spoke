(function() {
	if(typeof jQuery=='undefined') {
	    var headTag = document.getElementsByTagName("head")[0];
	    var jqTag = document.createElement('script');
	    jqTag.type = 'text/javascript';
	    jqTag.src = 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js';
	    jqTag.onload = main;
	    headTag.appendChild(jqTag);
	}
	else {
	  main();
	}
		
	var step1 = function (){
		_gaq.push(['_trackEvent','Complaint Wizard - Step1', 'Viewed']);
		jQuery('#step1_div').show();
		jQuery('#step2_div').hide();
		jQuery('#step3_div').hide();
		jQuery('#step4_div').hide();
		jQuery('#step5_div').hide();
		jQuery('#step1_button').addClass('active');
		jQuery('#step2_button').removeClass('active');
		jQuery('#step3_button').removeClass('active');
		jQuery('#step4_button').removeClass('active');
		jQuery('#step5_button').removeClass('active');
		jQuery('#next_button').show();
		jQuery('#back_button').hide();
		jQuery('#download_plain_button').hide();
		jQuery('#download_help').hide();
		jQuery('#download_rtf_button').hide();
		if (widget_init == 1) widget_init = 0;
		else document.getElementById("step1_button").focus();
		step_num=1;
		if(iphone == true){
			jQuery(document).ready(function(){
				jQuery(this).scrollTop(0);
			});
		}
	}
	
	var step2 = function (){
		_gaq.push(['_trackEvent','Complaint Wizard - Step2', 'Viewed']);
		jQuery('#step1_div').hide();
		jQuery('#step2_div').show();
		jQuery('#step3_div').hide();
		jQuery('#step4_div').hide();
		jQuery('#step5_div').hide();
		jQuery('#step1_button').removeClass('active');
		jQuery('#step2_button').addClass('active');
		jQuery('#step3_button').removeClass('active');
		jQuery('#step4_button').removeClass('active');
		jQuery('#step5_button').removeClass('active');
		jQuery('#next_button').show();
		jQuery('#back_button').show();
		jQuery('#download_plain_button').hide();
		jQuery('#download_help').hide();
		jQuery('#download_rtf_button').hide();
		if (jQuery( "input:radio[name=complaint_destination]:checked" ).val() == 'hq'){
			jQuery('#hq').show();
			jQuery('#local').hide();
		}
		else {
			jQuery('#hq').hide();
			jQuery('#local').show();
		}
		document.getElementById("step2_button").focus();
		step_num=2;
			
		jQuery('#organization_name').autocomplete({
			source:  function( request, response ) {
				var matches = $.map(corporationsArray, function(company){
					if (company.label.toUpperCase().indexOf(request.term.toUpperCase()) === 0 ) {
						return company;
		      }
		    });
		    response(matches);
		  },
	    select: function( event, ui ) {
        //add your own action on item select!
				jQuery('#organization_name').val(ui.item.label);
				jQuery('#organization_street_address').val(ui.item.street);
				jQuery('#organization_city_state_zip').val(ui.item.csz);
        return false;
	    }
		});
		
		if(iphone == true){
			jQuery(document).ready(function(){
				jQuery(this).scrollTop(0);
			});
		}
	}
	
	var step3 = function (){
		_gaq.push(['_trackEvent','Complaint Wizard - Step3', 'Viewed']);
		jQuery('#step1_div').hide();
		jQuery('#step2_div').hide();
		jQuery('#step3_div').show();
		jQuery('#step4_div').hide();
		jQuery('#step5_div').hide();
		jQuery('#step1_button').removeClass('active');
		jQuery('#step2_button').removeClass('active');
		jQuery('#step3_button').addClass('active');
		jQuery('#step4_button').removeClass('active');
		jQuery('#step5_button').removeClass('active');
		jQuery('#next_button').show();
		jQuery('#back_button').show();
		jQuery('#download_plain_button').hide();
		jQuery('#download_help').hide();
		jQuery('#download_rtf_button').hide();
		document.getElementById("step3_button").focus();
		step_num=3;
		if(iphone == true){
			jQuery(document).ready(function(){
				jQuery(this).scrollTop(0);
			});
		}
	}
	
	var step4 = function (){
		_gaq.push(['_trackEvent','Complaint Wizard - Step4', 'Viewed']);
		jQuery('#step1_div').hide();
		jQuery('#step2_div').hide();
		jQuery('#step3_div').hide();
		jQuery('#step4_div').show();
		jQuery('#step5_div').hide();
		jQuery('#step1_button').removeClass('active');
		jQuery('#step2_button').removeClass('active');
		jQuery('#step3_button').removeClass('active');
		jQuery('#step4_button').addClass('active');
		jQuery('#step5_button').removeClass('active');
		jQuery('#next_button').show();
		jQuery('#back_button').show();
		jQuery('#download_plain_button').hide();
		jQuery('#download_help').hide();
		jQuery('#download_rtf_button').hide();
		document.getElementById("step4_button").focus();
		step_num=4;
		if(iphone == true){
			jQuery(document).ready(function(){
				jQuery(this).scrollTop(0);
			});
		}
	}
	
	var step5 = function (){
		_gaq.push(['_trackEvent','Complaint Wizard - Step5', 'Viewed']);
		jQuery('#step1_div').hide();
		jQuery('#step2_div').hide();
		jQuery('#step3_div').hide();
		jQuery('#step4_div').hide();
		jQuery('#step5_div').show();
		jQuery('#step1_button').removeClass('active');
		jQuery('#step2_button').removeClass('active');
		jQuery('#step3_button').removeClass('active');
		jQuery('#step4_button').removeClass('active');
		jQuery('#step5_button').addClass('active');
		jQuery('#next_button').hide();
		jQuery('#back_button').show();
		jQuery('#download_plain_button').show();
		jQuery('#download_help').show();
		jQuery('#download_rtf_button').show();
		document.getElementById("step5_button").focus();
		step_num=5;
		if(iphone == true){
			jQuery(document).ready(function(){
				jQuery(this).scrollTop(0);
			});
		}
		
		var letter = ("<br><div class='sender-address highlight'>[YOUR FIRST AND LAST NAME]<br>");
		letter += ("[YOUR STREET ADDRESS]<br>");
		letter += ("[YOUR CITY, STATE, AND ZIP CODE]<br></div>");
		letter += ("<p>" + todays_date_string + "</p>");
		letter += ("<br/>");
		if (jQuery( "input:radio[name=complaint_destination]:checked" ).val() == 'hq'){
			var name = (jQuery('#organization_name').val().length > 0)? jQuery('#organization_name').val() : "<span class='highlight'>[COMPANY NAME]</span>";
			var street_address = (jQuery('#organization_street_address').val().length > 0)? jQuery('#organization_street_address').val() : "<span class='highlight'>[COMPANY STREET ADDRESS]</span>"	;
			var city_state_zip = (jQuery('#organization_city_state_zip').val().length > 0)? jQuery('#organization_city_state_zip').val() : "<span class='highlight'>[COMPANY CITY, STATE, AND ZIP CODE]</span>";
		}
		else{
			var name = (jQuery('#seller_name').val().length > 0)? jQuery('#seller_name').val() : "<span class='highlight'>[COMPANY NAME]</span>";
			var street_address = (jQuery('#seller_street_address').val().length > 0)? jQuery('#seller_street_address').val() : "<span class='highlight'>[COMPANY STREET ADDRESS]</span>";	
			var city_state_zip = (jQuery('#seller_city').val().length > 0)? jQuery('#seller_city').val() + ", " +  jQuery('#seller_state').val() +  " " + jQuery('#seller_zip').val() : "<span class='highlight'>[COMPANY CITY, STATE, AND ZIP CODE]</span>";			
		}
		letter += ("<p>" + name + "<br>");
		letter += "Consumer Complaint Division<br>"
		letter += (street_address + "<br>");
		letter += (city_state_zip + "</p><br><br>");
		
		letter += ("<p>Dear Madam or Sir:</p>");
		var transaction_date = transactionDate()
		letter += ("<p><span class='highlight'>Re: (Service/Purchase/Rental on</span>" + " " + transaction_date + "</p>");
		letter += ("<p>On " + transaction_date + ", I purchased the following product or service:</p>");
		var product_description = (jQuery('#product_description').val().length > 0)? jQuery('#product_description').val() : "<span class='highlight'>[PURCHASE INFO]</span>"
		letter += ("<p>" + product_description + "</p>");
		letter += ("<p>Unfortunately, I was dissatisfied for the following reason(s):</p>");
		var problem_description = (jQuery('#problem_description').val().length > 0)? jQuery('#problem_description').val() : "<span class='highlight'>[COMPLAINT]</span>"
		letter += ("<p>" + problem_description + "</p>");
		letter += ("<p>To resolve the problem, I would like the following to take place:</p>");
		var resolution_text = (jQuery('#resolution_text').val().length > 0)? jQuery('#resolution_text').val() : "<span class='highlight'>[RESOLUTION]</span>"
		letter += ("<p>" + resolution_text + "</p>");
		if (jQuery( "input:radio[name=include_support_docs]:checked" ).val() == 'yes')
			letter += ("<p>I have enclosed copies of my records related to this situation.</p>");
		var resolution_date = (resolutionDate() == "")? "<span class='highlight'>[Resolution Date]</span>" : resolutionDate();
		letter += ("<p>I look forward to your reply and a resolution to my problem, and will wait until " + resolution_date + " before seeking help from a consumer protection agency or the Better Business Bureau. Please contact me at the above address or by phone at <span class='highlight'>[YOUR PHONE NUMBER]</span>.");
		letter += ( "<br/><p>Sincerely,</p><br/><p><span class='highlight'>[YOUR NAME]</span></p>");
		if (jQuery( "input:radio[name=include_support_docs]:checked" ).val() == 'yes')
			letter += ("<br><p>Enclosure</p>");
		document.getElementById('letter_container').innerHTML = letter;
	}

	
	var corporationsArray = new Array();
	var getCorporations = function (){
		var url = "https://platform-api.usa.gov:443/api/v1/usagov/directory_records.json?terms_filter=directory_type%3Acorporations&page_size=1000";
		$.ajax({
			url: url,
			dataType: 'json',
			success: function(feed){
				var results = feed.results;
				if (results.length > 0){
					for (var i=0; i<=results.length-1; i++){
						var c = results[i];
						if (typeof c.street_one == 'undefined'
								|| typeof c.city == 'undefined' 
								|| typeof c.state == 'undefined' 
								|| typeof c.zip == 'undefined') continue;
						var hash = {
							label:c.title, 
							street:c.street_one, 
							csz:(c.city + ", " + c.state + " " + c.zip)};
						corporationsArray.push(hash);
					}
					//alert("Number of corporation names: " + corporationsArray.length);
					jQuery('#organization_lookup_available_text').show();
					jQuery('#organization_lookup_unavailable_text').hide();				
				}
			},
			error: function(error) {
				//alert("Error retriving Corporations");
			},
			timeout:20000
		});
	}
	
	var downloadLetter = function (format){
		var todays_date = months[today.getMonth()] + " " + today.getDate() + ", " + today.getFullYear();
		
		if (jQuery( "input:radio[name=complaint_destination]:checked" ).val() == 'hq'){
			var company_name = (jQuery('#organization_name').val().length > 0)? jQuery('#organization_name').val() : "";
			var company_street_address = (jQuery('#organization_street_address').val().length > 0)? jQuery('#organization_street_address').val() : "";
			var company_city_state_zip = (jQuery('#organization_city_state_zip').val().length > 0)? jQuery('#organization_city_state_zip').val() : "";
		}
		else{
			var company_name = (jQuery('#seller_name').val().length > 0)? jQuery('#seller_name').val() : "";
			var company_street_address = (jQuery('#seller_street_address').val().length > 0)? jQuery('#seller_street_address').val() : "";
			var company_city_state_zip = (jQuery('#seller_city').val().length > 0)? jQuery('#seller_city').val() + ", " +  jQuery('#seller_state').val() +  " " + jQuery('#seller_zip').val() : "";
		}
		
		var transaction_date = transactionDate();		
		var product_description = (jQuery('#product_description').val().length > 0)? jQuery('#product_description').val() : "";
		var problem_description = (jQuery('#problem_description').val().length > 0)? jQuery('#problem_description').val() : "";
		var resolution_text = (jQuery('#resolution_text').val().length > 0)? jQuery('#resolution_text').val() : "";		
		var resolution_date = (resolutionDate().length > 0)? resolutionDate() : ""; 		
		var records = (jQuery("input:radio[name=include_support_docs]:checked" ).val() == 'yes')? "I have enclosed copies of my records related to this situation." : "";
		
		//var url = "http://localhost:3000/letter/send_letter";
		//var url = "http://54.225.92.235/letter/send_letter"; //Mobomo test
		var url = "http://consumercomplaintletter.usa.gov/letter/send_letter";
		
		window.location = url + "?todays_date=" + escape(todays_date) + "&company_name=" + escape(company_name) + "&company_street_address=" + escape(company_street_address) + "&company_city_state_zip=" + escape(company_city_state_zip) + "&transaction_date=" + escape(transaction_date) + "&product_description=" + escape(product_description) + "&problem_description=" + escape(problem_description) + "&resolution_text=" + escape(resolution_text) + "&resolution_date=" + escape(resolution_date) + "&records=" + escape(records) + "&format=" + escape(format);
	}
	
	var transactionDate = function(){	
		var monthIndex = jQuery('#transactionMonthSelect').val();
		var dayIndex = jQuery('#transactionDaySelect').val();
		var yearIndex = jQuery('#transactionYearSelect').val();
		return months[monthIndex] + " " + days[dayIndex] + ", " + years[yearIndex];
	}
	
	var resolutionDate = function(){	
		var monthIndex = jQuery('#resolutionMonthSelect').val();
		var dayIndex = jQuery('#resolutionDaySelect').val();
		var yearIndex = jQuery('#resolutionYearSelect').val();
		var resolution_date = months[monthIndex] + " " + days[dayIndex] + ", " + years[yearIndex];
		if (resolution_date == todays_date_string) return "";
		else return resolution_date;
	}
	
	var isLeapYear = function (year) {
		if (year == ''){
			return false;
		}
		else return !((year % 4) || (!(year % 100) && (year % 400)));
	}
	
	var checkNumDays = function(month, day, year){
		var message = "";
		if (month == 1 && day > 27){
			if (isLeapYear(years[year]) && day > 28){
				message = "There are only 29 days in this month. Please choose a correct date.";
			}
			else if (isLeapYear(years[year]) == false){
				message = "There are only 28 days in this month. Please choose a correct date.";
			}
		}
		var months = [0,1,2,4,6,7,9,11];
		if ((months.indexOf(month)) == -1 && day > 29){
			message = "There are only 30 days in this month. Please choose a correct date.";
		}
		return message;
	}
	
	var checkTransactionDate = function(){
		var dateErrorMessage = 0;
		var day = Number(jQuery('#transactionDaySelect').val());
		var month = Number(jQuery('#transactionMonthSelect').val());
		var year = Number(jQuery('#transactionYearSelect').val());
		var dateErrorMessage = checkNumDays(month, day, year);

		var dateSelected = Date.parse(years[year].toString() + "/" + (month+1).toString() + "/" + (day+1).toString());
		if (dateSelected > today.getTime())
			dateErrorMessage = "The transaction date you have chosen is in the future. Please choose today's date or a date before today.";
		if (dateErrorMessage.length > 0 ){
			jQuery('#transactionDateError').html(dateErrorMessage);
			if (!jQuery('#transactionDateErrorContainer').is(':visible')) jQuery('#transactionDateErrorContainer').slideDown();
		}
		if (dateErrorMessage.length == 0  && jQuery('#transactionDateErrorContainer').is(':visible')) jQuery('#transactionDateErrorContainer').slideUp();
	}
	
	var checkResolutionDate = function(){
		var dateErrorMessage = 0;
		var day = Number(jQuery('#resolutionDaySelect').val());
		var month = Number(jQuery('#resolutionMonthSelect').val());
		var year = Number(jQuery('#resolutionYearSelect').val());
		var dateErrorMessage = checkNumDays(month, day, year);

		var dateSelected = Date.parse(years[year].toString() + "/" + (month+1).toString() + "/" + (day+1).toString());
		if (dateSelected < today.getTime())
			dateErrorMessage = "The due date you have chosen is today's date or in the past. Please choose a date after today's date.";
		if (dateErrorMessage.length > 0 ){
			jQuery('#resolutionDateError').html(dateErrorMessage);
			if (!jQuery('#resolutionDateErrorContainer').is(':visible')) jQuery('#resolutionDateErrorContainer').slideDown();
		}
		if (dateErrorMessage.length == 0  && jQuery('#resolutionDateErrorContainer').is(':visible')) jQuery('#resolutionDateErrorContainer').slideUp();
	}
	
	
	function main() {
			
    jQuery(document).ready(function($) {
			//First load the main html
			jQuery("#cah-container").html(htmlMain);
			
			//Then do all the intial setups
			step1();
			jQuery('#manufacturer_select').hide();
			jQuery('#problem_description_more_text').hide();
			jQuery('#complaint_destination_more_text').hide();
			jQuery('#supporting_doc_more_text').hide();
			jQuery('#organization_lookup_available_text').hide();
			jQuery('#transactionDateErrorContainer').hide();
			jQuery('#resolutionDateErrorContainer').hide();
			getCorporations();
			
			if(navigator.userAgent.match(/iPhone/i)){
				iphone = true;
				jQuery('.steps button').css("font-size", "90%");
			}
			
			$.each(resolutionList, function(val, array) {
	      jQuery('#resolution_select').append( jQuery('<option></option>').val(val).html(array[0]));
	    });

			$.each(months, function(val, text) {
	      jQuery('#transactionMonthSelect').append( jQuery('<option></option>').val(val).html(text));
				jQuery('#resolutionMonthSelect').append( jQuery('<option></option>').val(val).html(text));
				jQuery('#transactionMonthSelect').val(today.getMonth());
				jQuery('#resolutionMonthSelect').val(today.getMonth());
	    });
			$.each(days, function(val, text) {
	      jQuery('#transactionDaySelect').append( jQuery('<option></option>').val(val).html(text));
				jQuery('#resolutionDaySelect').append( jQuery('<option></option>').val(val).html(text));
				jQuery('#transactionDaySelect').val(today.getDate()-1);
				jQuery('#resolutionDaySelect').val(today.getDate()-1);
	    });
			$.each(years, function(val, text) {
	      jQuery('#transactionYearSelect').append( jQuery('<option></option>').val(val).html(text));
				jQuery('#resolutionYearSelect').append( jQuery('<option></option>').val(val).html(text));
				jQuery('#transactionYearSelect').val(years.indexOf(today.getFullYear().toString()));
				jQuery('#resolutionYearSelect').val(years.indexOf(today.getFullYear().toString()));
	    });

			//Then add link and button monitoring			
			jQuery('#transactionMonthSelect').on("change", function(){
				checkTransactionDate();							
			});
			jQuery('#transactionDaySelect').on("change", function(){
				checkTransactionDate();
			});
			jQuery('#transactionYearSelect').on("change", function(){
				checkTransactionDate();
			});
			
			jQuery('#resolutionMonthSelect').on("change", function(){
				checkResolutionDate();				
			});
			jQuery('#resolutionDaySelect').on("change", function(){
				checkResolutionDate();
			});
			jQuery('#resolutionYearSelect').on("change", function(){
				checkResolutionDate();
			});
				
			jQuery("#download_rtf_button").click(function(){
				_gaq.push(['_trackEvent','Complaint Wizard - DownloadLetter', 'RTF']);
				downloadLetter("rtf");
			});
		
			jQuery("#download_plain_button").click(function(){
				_gaq.push(['_trackEvent','Complaint Wizard - DownloadLetter', 'TXT']);
					downloadLetter("plain");
			});
	
			jQuery("#step1_button").click(function(){
				step1();
			});
			jQuery("#step2_button").click(function(){
				step2();
			});
			jQuery("#step3_button").click(function(){
				step3();
			});
			jQuery("#step4_button").click(function(){
				step4();
			});
			jQuery("#step5_button").click(function(){
				step5();
			});
	
			jQuery("#next_button").click(function(){
				switch (step_num){
					case 1:
						step2();							
						break;
					case 2:
						step3();
						break;
					case 3:
						step4();
						break;
					case 4:
						step5();
						break;
				}
			});
	
			jQuery("#back_button").click(function(){
				switch (step_num){
					case 2:
						step1();
						break;
					case 3:
						step2();							
						break;
					case 4:
						step3();
						break;
					case 5:
						step4();
						break;
				}
			});
	

			jQuery("#resolution_select").on("change", function(){
				var index = jQuery('#resolution_select').val();
				if (index == 0){
					alert("No selection has been chosen");
					jQuery('#resolution_text').val("");
					return;
				}
				else{
					var text = resolutionList[index][1];
					jQuery('#resolution_text').val(text);
				}
			});			

		});
	}
	
})();