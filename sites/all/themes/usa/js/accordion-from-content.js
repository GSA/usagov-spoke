
/*
Questions what will the content structure be?
What are the various expectations?
Will there ever be content that is not part of the accordion, but is between 2 accordion dropdowns? Ex: Back to Top Links

Ideal Targets:
* An element which contains the entire accordion - This would help determine where an accordion begins and ends
* Header elements that become the accordion buttons - These are easiest to guess.
* An element paired with each header which contains the dropdown content - Without this, it is tricky to guess which content to include in each dropdown

*/

function accordionify(){
	if(arguments[0]){
		var id=arguments[0].id;
		var headingLevel=arguments[0].headingLevel || "h3";
		var uaid;
		console.log(id+", "+headingLevel);
		
		//find Targets
		//find content between
		//determine if there are gaps
		
		//Accordion container div with 'usa-accordion-from-content' class
		var accordion,ul;

		//counter to create a unique ID for each dropdown
		var unique=0, accordionCount=0;
		jQuery(id).parent().parent().find(headingLevel).each(function(){ //TODO: something better than parent.parent
			uaid='unique-accordion-id-'+id+'-'+accordionCount+'-'+unique;
			var buttonBase=jQuery(this);
			var buttonContent=buttonBase.text();
			if(buttonBase.parent("header").length){
				buttonBase=buttonBase.parent("header");
			}
			var li=jQuery("<li></li>");
			var button=jQuery('<button class="usa-accordion-button" aria-expanded="false" aria-controls="'+uaid+'">'+buttonContent+'</button>');
			if(unique==0){
				accordion=jQuery('<div class="usa-accordion-bordered usa-accordion-from-content"></div>');
				ul=jQuery('<ul></ul>');
				buttonBase.before(accordion);
				accordion.append(ul);
			}
			ul.append(li);
			li.append(button);
			
			var content=jQuery('<div id="'+uaid+'" class="usa-accordion-content" aria-hidden="true"></div>');
			li.append(content);
			
			var headingLevelOrLower="h4, h3, h2, h1";
			if(headingLevel=="h3") headingLevelOrLower="h3, h2, h1"; //TODO: This but better
			var next=buttonBase.next();
			//Loop until no-next or backtotop or share or headingLevelOrLower or headeing>headingLevelOrLower
			while(next.length && !( next.is('.volver, #sm-share, '+headingLevelOrLower) || (next.is('header') && next.find(headingLevelOrLower).length) ) ){
				content.append(next.remove());
				next=buttonBase.next();
			}
			//If next is another part of the same accordion increment unique. Otherwise reset unique to start a new accordion.
			if(next.length && next.is('header') && next.find(headingLevel).length){
				unique++;
			}else{
				unique=0; accordionCount++;
			}
			buttonBase.remove();
		});
		
	}else{
		
	}
}
/*

uaid='unique-accordion-id-'+id+'-'+accordionCount+'-'+unique;

$(document).ready(function(){

//Accordion container div with 'usa-accordion-from-content' class
var accordion=jQuery('<div class="usa-accordion-bordered usa-accordion-from-content"></div>');
var ul=jQuery('<ul></ul>');

//counter to create a unique ID for each dropdown
var unique=0;
//loop through dropdown targets. Can be h2, h3, .dwnlvl, article, section....
//*
jQuery(".downlvl").each(function(){
	var buttonBase=jQuery(this);
	var buttonContent=buttonBase.text();
	if(buttonBase.parent("header")){
		buttonBase=buttonBase.parent("header");
	}
	var baseContent=buttonBase.next("p");
	var li=jQuery("<li></li>");
	var button=jQuery('<button class="usa-accordion-button" aria-expanded="false" aria-controls="unique-accordion-id-'+unique+'">'+buttonContent+'</button>');
	if(unique==0){
		buttonBase.before(accordion);
		accordion.append(ul);
	}
	ul.append(li);
	li.append(button);
	buttonBase.remove();
	var content=jQuery('<div id="unique-accordion-id-'+unique+'" class="usa-accordion-content" aria-hidden="true"></div>');
	li.append(content);
	baseContent.remove();
	content.append(baseContent);
	unique++;
});

//loop through dropdown targets. Can be h2, h3, .dwnlvl, article, section....
jQuery("article>header>h2, article>div>header>h2").each(function(){
	var buttonBase=jQuery(this);
	var buttonContent=buttonBase.text();
	var contentBase=buttonBase.parents('article');
	buttonBase.parent().remove();
	var contentContent=contentBase.html();
	
	var li=jQuery("<li></li>");
	var button=jQuery('<button class="usa-accordion-button" aria-expanded="false" aria-controls="unique-accordion-id-'+unique+'">'+buttonContent+'</button>');
	if(unique==0){
		contentBase.before(accordion);
		accordion.append(ul);
	}
	contentBase.remove();
	ul.append(li);
	li.append(button);
	var content=jQuery('<div id="unique-accordion-id-'+unique+'" class="usa-accordion-content" aria-hidden="true"></div>');
	li.append(content);
	content.append(contentContent);
	unique++;
});


});
*/
