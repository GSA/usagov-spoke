var setp_num = 1;

var today = new Date();

var days = [];
for (var x=1; x<32; x++){
	days.push(x.toString());
}

var years = [];
var x = Number(today.getFullYear());
for (var i= x-10; i <= x+2; i++){
	years.push(i.toString());
}

var widget_init = 1;

var iphone = false;

var resolutionList = [["Select a Resolution", ""],
											["Repair", "I would like you to repair the product."],
											["Replace", "I would like you to replace the product."],
											["Full refund", "I would like a full refund."],
											["Partial refund", "I would like you to give me a partial refund of [fill in amount requested]."],
											["Discount/Credit/Other", "Please issue a coupon or gift card to use on a future purchase."]];

var months = [ "January", "February", "March", "April", "May", "June",
							"July", "August", "September", "October", "November", "December" ];

var todays_date_string = months[today.getMonth()] + " " + today.getDate() + ", " + today.getFullYear();

var htmlMain = ""
	htmlMain += "<div class='main' id='main'>";
	htmlMain += "<ul class='steps' id='steps'>";
	htmlMain += "<li><button id='step1_button'>Step 1</button>></li>";
	htmlMain += "<li><button id='step2_button'>Step 2</button>></li>";
	htmlMain += "<li><button id='step3_button'>Step 3</button>></li>";
	htmlMain += "<li><button id='step4_button'>Step 4</button>></li>";
	htmlMain += "<li><button id='step5_button'>Step 5</button></li>";
	htmlMain += "</ul>";
	htmlMain += "<div id='step1_div'>";
	htmlMain += "<p>Do you have a consumer problem and want to write a complaint letter? This tool can help you write one. Follow these five steps, and you will have a letter that you can mail to a company. USA.gov does not collect or save information that you enter in the tool. We only use this information to help you write your letter. For more information, see our <a href='http://www.usa.gov/About/Privacy-Security.shtml'>Privacy Policy</a>.</p>";
	htmlMain += "<h2>Step 1: Information About the Product or Service</h2>";
	htmlMain += "<p>";
	htmlMain += "<label for='product_description'>";
	htmlMain += "What did you purchase from the company? Describe the product or service that you purchased in the text box.<br>";
	htmlMain += "<span class='helptext'>Include any important details: product name, serial number, service to be performed, order number, invoice number, price, discounts used, confirmation number, or name of the customer service representative. For example,  &#34;I bought a radio produced by Great Sounds Manufacturers, serial number 123456 on receipt #415 for $150. &#34;</span>";
	htmlMain += "</label>";
	htmlMain += "</p>";
	htmlMain += "<textarea id='product_description'></textarea>";
	htmlMain += "<p class='clear'><br>When did the transaction happen? (Use the dropdowns to select the date when you made your purchase)</br>";
	htmlMain += "<span class='helptext'>If you don't know the exact date of your purchase or service, use the dropdowns to choose an approximate date.</span></p>";
	htmlMain += "<div id='transactionDateErrorContainer'><p id='transactionDateError' class='dateError'></p></div>";
	htmlMain += "<fieldset>";
	htmlMain += "<div class='dropDownUnit'><label for='transactionMonthSelect' class='dropDownLabel'>Month</label><select class='monthDropDown' id='transactionMonthSelect'></select></div>";
	htmlMain += "<div class='dropDownUnit'><label for='transactionDaySelect' class='dropDownLabel'>Day</label><select class='dayDropDown' id='transactionDaySelect'></select></div>";
	htmlMain += "<div class='dropDownUnit'><label for='transactionYearSelect' class='dropDownLabel'>Year</label><select class='yearDropDown' id='transactionYearSelect'></select></div>";
	htmlMain += "</fieldset>";
	htmlMain += "<fieldset>";
	htmlMain += "<p>";
	htmlMain += "<legend>";
	htmlMain += "Where will you be sending the complaint?<br>";
	htmlMain += "<span class='helptext'>It's best to send your complaint letter directly to the local seller or service provider. But if they can't resolve the complaint, you may want to send it to the customer service department at corporate headquarters.</span>";
	htmlMain += "</legend>";
	htmlMain += "</p>";
	htmlMain += "<div class='radio_buttons'>";
	htmlMain += "<input type='radio' name='complaint_destination' id='complaint_local' value='local_business' checked>";
	htmlMain += "<label for='complaint_local'>Local business where the transaction occurred</label><br>";
	htmlMain += "<input type='radio' name='complaint_destination' id='complaint_hq' value='hq'>";
	htmlMain += "<label for='complaint_hq'>Corporate headquarters (you'll be able to search our list of customer service offices in the next step)</label><br>";
	htmlMain += "</div>";
	htmlMain += "</fieldset>";
	htmlMain += "<fieldset>";
	htmlMain += "<p>";
	htmlMain += "<legend>";
	htmlMain += "Are you going to send copies of supporting documents (receipts, work orders, photos) with your letter?</b>";
	htmlMain += "<span class='helptext'>Including this evidence can improve the chances of getting your problem resolved, but is not required.</span>";
	htmlMain += "</legend>";
	htmlMain += "</p>";
	htmlMain += "<div class='radio_buttons'>";
	htmlMain += "<input type='radio' name='include_support_docs' id='support-yes' value='yes'>";
	htmlMain += "<label for='support-yes'>Yes, I will send supporting documents</label><br>";
	htmlMain += "<input type='radio' name='include_support_docs' id='support-no' value='no'>";
	htmlMain += "<label for='support-no'>No, I will not send supporting documents</label><br>";
	htmlMain += "</div>";
	htmlMain += "</fieldset>";
	htmlMain += "</div>";
	htmlMain += "<div id='step2_div'>";
	htmlMain += "<div id='local'>";
	htmlMain += "<h2>Step 2: Local Business</h2>";
	htmlMain += "<p>Where did you purchase the product or service?</p>";
	htmlMain += "<div class=' clear seller_address_container'>";
	htmlMain += "<div class='seller_address' id='seller_name_div'>";
	htmlMain += "<label for='seller_name'>Company</label>";
	htmlMain += "<input type='text' id='seller_name'>";
	htmlMain += "</div>";
	htmlMain += "<div class='seller_address' id='seller_street_address_div'>";
	htmlMain += "<label for='seller_street_address'>Street</label>";
	htmlMain += "<input type='text' id='seller_street_address'>";
	htmlMain += "</div>";
	htmlMain += "<div class='seller_address' id='seller_city_div'>";
	htmlMain += "<label for='seller_city'>City</label>";
	htmlMain += "<input type='text' id='seller_city'>";
	htmlMain += "</div>";
	htmlMain += "<div class='seller_address' id='seller_state_div'>";
	htmlMain += "<label for='seller_state'>State</label>";
	htmlMain += "<input type='text' id='seller_state'>";
	htmlMain += "</div>";
	htmlMain += "<div class='seller_address' id='seller_zip_div'>";
	htmlMain += "<label for='seller_zip'>ZIP Code</label>";
	htmlMain += "<input type='text' id='seller_zip'>";
	htmlMain += "</div>";
	htmlMain += "</div>";
	htmlMain += "</div>";
	htmlMain += "<div id='hq'>";
	htmlMain += "<h2>Step 2: Corporate Headquarters</h2>";
	htmlMain += "<p id='organization_lookup_unavailable_text'>The corporation lookup feature was not available. You can refresh the page to try and load it again or enter the organization name and address manually.</p>";
	htmlMain += "<p id='organization_lookup_available_text'>Start typing the name of the company in the Organization Name search box below, and choose your selection. This will automatically fill out the address boxes using our database of customer service departments at corporate headquarters. You may also enter the information manually, if the organization you're looking for isn't listed.</p>";
	htmlMain += "<p>";
	htmlMain += "<label for='organization_name'>Organization Name</label><br>";
	htmlMain += "<input type='text' id='organization_name'>";
	htmlMain += "</p>";
	htmlMain += "<p>";
	htmlMain += "<label for='organization_street_address'>Organization Street Address</label><br>";
	htmlMain += "<input type='text' id='organization_street_address'>";
	htmlMain += "</p>";
	htmlMain += "<p>";
	htmlMain += "<label for='organization_city_state_zip'>Organization City, State, and ZIP Code</label><br>";
	htmlMain += "<input type='text' id='organization_city_state_zip'>";
	htmlMain += "</p>";
	htmlMain += "</div>";
	htmlMain += "</div>";
	htmlMain += "<div id='step3_div'>";
	htmlMain += "<h2>Step 3: Describe the Problem</h2>";
	htmlMain += "<p>";
	htmlMain += "<label for='problem_description'>";
	htmlMain += "Unfortunately, I was dissatisfied for the following reason(s):<br>";
	htmlMain += "Type in a detailed explanation about your problem, your purchase, or service.<br>";
	htmlMain += "<span class='helptext'>You can be dissatisfied for several reasons: due to malfunction, bad customer service, incorrect billing, or delayed delivery. For example,  &#34;I was dissatisfied with my purchase because the volume knob fell off the radio the day I bought it. I tried to return it with my receipt, but the customer service representative at your store, Susan Smith, would not accept the return or give me a refund. &#34;</span>";
	htmlMain += "</label>";
	htmlMain += "</p>";
	htmlMain += "<textarea id='problem_description'></textarea>";
	htmlMain += "</div>";
	htmlMain += "<div id='step4_div'>";
	htmlMain += "<h2>Step 4: Request Resolution</h2>";
	htmlMain += "<label for='resolution_select'><p>You can select a resolution from the menu below. This will automatically fill the text box below with a resolution. If you want to make a different request, you may enter it manually into the text area.</p></label>";
	htmlMain += "<select id='resolution_select'></select>";
	htmlMain += "<p>";
	htmlMain += "<label for='resolution_text'>To resolve this problem, I would appreciate:</label><br>";
	htmlMain += "<textarea id='resolution_text'></textarea>";
	htmlMain += "</p>";
	htmlMain += "<p class='clear'>Set a due date for the company to resolve the problem. (Use the dropdowns below to select the date.)<br>";
	htmlMain += "<span class='helptext'>Typically, you want to give companies a minimum of two weeks from the date of your letter to respond.</span></p>";
	htmlMain += "<div id='resolution_date'>"
	htmlMain += "<fieldset>"
	htmlMain += "<div id='resolutionDateErrorContainer'><p id='resolutionDateError' class='dateError'></p></div>"
	htmlMain += "<div class='dropDownUnit'><label for='resolutionMonthSelect' class='dropDownLabel'>Month</label><select class='monthDropDown' id='resolutionMonthSelect'></select></div>";
	htmlMain += "<div class='dropDownUnit'><label for='resolutionDaySelect' class='dropDownLabel'>Day</label><select class='dayDropDown' id='resolutionDaySelect'></select></div>";
	htmlMain += "<div class='dropDownUnit'><label for='resolutionYearSelect' class='dropDownLabel'>Year</label><select class='yearDropDown' id='resolutionYearSelect'></select></div>";
	htmlMain += "</fieldset>"
	htmlMain += "</div>";
	htmlMain += "</div>";
	htmlMain += "<div id='step5_div'>";
	htmlMain += "<h2>Step 5: Preview</h2>";
	htmlMain += "<p class='helptext'>The text that you will need to edit on your actual letter is highlighted and enclosed in brackets. When you download the letter, the text won't be highlighted, and you can fill in the information that is surrounded by [&nbsp]. After you download, be sure to add your name, address, subject, and phone number. You can also edit your letter.</p><br>";
	htmlMain += "<div class='letter_container' id='letter_container'></div>";
	htmlMain += "</div>";
	htmlMain += "<div class='cah-bottom-buttons clearfix'>";
	htmlMain += "<button id='back_button'>Back</button>";
	htmlMain += "<button id='next_button'>Next</button>";
	htmlMain += "<button id='download_rtf_button'>DOWNLOAD (.rtf) LETTER</button>";
	htmlMain += "<p id='download_help' class='helptext'>";
	htmlMain += "Are you having trouble viewing the letter? You can download a <a id='download_plain_button' href='#'>plain text version (.txt)</a> of the letter instead.";
	htmlMain += "</p>";
	htmlMain += "</div>";
	htmlMain += "</div>";


  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28227333-1']);
  //_gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
