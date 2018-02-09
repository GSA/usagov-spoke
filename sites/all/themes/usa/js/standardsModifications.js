//console.log("OMG");


var navBreakpoint = 950; // width where the page switches between mobile/desktop
var width, uprevWidth, mobile; // width and uprevWidth determine current breakpoint and if a change is needed
var wasdesktop=false;

jQuery(function(){
	//console.log('OMG LOADED');
	width=uprevWidth=viewportWidth();
  mobile=false;
  if(width <= navBreakpoint){
		mobile=true;
    mobileNav();
  }else{
    desktopNav();
  }
	
	jQuery('.hptoggles').focusin(function(){
		jQuery('.usa-accordion-button').attr('aria-expanded', 'false');
		jQuery('.usa-nav-submenu').attr('aria-hidden', 'true');
		jQuery('.usa-nav').removeClass('is-visible');
		jQuery('.usa-overlay').removeClass('is-visible');
		if(mobile){
			untabbable();
		}
	});
	jQuery('.usa-nav-close').click(function(){
		jQuery('.usa-menu-btn').focus();
	});
});

function viewportWidth() {
  return window.innerWidth || document.body.clientWidth;//Must use document.body.clientWidth for browser support.
}
jQuery(window).resize(function() {
  width=viewportWidth();
  if(width<=navBreakpoint
		 && uprevWidth>navBreakpoint
	){
    mobile=true;
    mobileNav();
  }else if(width>navBreakpoint 
		 && uprevWidth<=navBreakpoint
	){
    mobile=false;
    desktopNav();
  }

  uprevWidth=width;
});

function tabbable() {
	//console.log('OMG TABBABLE');
	jQuery('.usa-nav a, .usa-nav button, .usa-nav input').removeAttr('tabindex');
}
function untabbable() {
	//console.log('OMG UNTABBABLE');
	jQuery('.usa-nav a, .usa-nav button, .usa-nav input').attr('tabindex', -1);
}
function mobileNav() {
	//console.log('OMG MOBILE');
	if(jQuery('.usa-nav').hasClass('is-visible')){
		tabbable();
	}else{
		untabbable();
	}
	jQuery('.usa-menu-btn, .usa-nav-close').unbind( "click" );
	jQuery('.usa-menu-btn, .usa-nav-close').on('click', function(){
		if(jQuery('.usa-nav').hasClass('is-visible')){
			if(wasdesktop){
				tabbable();
			}else{
				untabbable();
				setTimeout(function() { jQuery('.usa-menu-btn').focus(); }, 20);
			}
		}else{
			if(wasdesktop){
				untabbable();
			}else{
				tabbable();
			}
		}
	});
}

function desktopNav() {
	//console.log('OMG DESKTOP');
	jQuery('.usa-menu-btn, .usa-nav-close').unbind( "click" );
	tabbable();
	wasdesktop=true;
}

// Togglify is a function that can be added to any usa-accordion from the
// US Web Design Standards. It requires the class 'usa-accordion-toggle'
// to be added to the accordion element. It also requires a button with 
// the class 'usa-accordion-toggle-all' and data attribute, 'data-toggledText'
// (the text for the toggled state) to be added within the accordion.
jQuery.fn.togglify = function() {
	this.find('.usa-accordion-toggle-all').each(function(){
		var toggle=jQuery(this);
		var isToggled=toggle.attr("data-isToggled");
		var initialText=toggle.text();
		var toggledText=toggle.attr("data-toggledText");
		toggle.on('click', function() {
			var accordion=toggle.parent('.usa-accordion, .usa-accordion-bordered');
			accordion.find('.usa-accordion-button').each(function(){
				var accordionButton=jQuery(this);
				if(isToggled){
					accordionButton.attr('aria-expanded', 'true');
					jQuery('#' + accordionButton.attr('aria-controls')).attr('aria-hidden', 'false');
				}else{
					accordionButton.attr('aria-expanded', 'false');
					jQuery('#' + accordionButton.attr('aria-controls')).attr('aria-hidden', 'true');
				}
			});
			if(isToggled){
				toggle.text(toggledText);
			}else{
				toggle.text(initialText);
			}
			isToggled=!isToggled;
	  });
	});
};

jQuery(function(){
	if(jQuery('.usa-accordion-toggle').length>0)
		jQuery('.usa-accordion-toggle').togglify();
});