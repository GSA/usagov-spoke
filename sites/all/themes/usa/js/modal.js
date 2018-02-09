/*
This script handles the logic for The emergency modal and the redirect modals.
It first checks the DOM for the emergency modal, then checks the URL for redirect parameters.
Before displaying a modal, it checks cookies to see if the user has already closed this particular modal.
After displaying a modal, focus is set to the close button and tabbing is restricted to the modal's focusable elements.
*/

/* Stage Update Test */


jQuery(function(){
  // On page page load, check the DOM for the emergency modal.
  if(jQuery('#emergency-modal').length!=0){
    //The emergency modal is present
    var cookieID = readCookie('emergency-modal');
    if(cookieID) {
      //The cookie is present
      var emergencyID=jQuery('#emergency-modal').attr('data-id');
      if(cookieID!=emergencyID){
        //The IDs do not match. Show the modal.
        showModal(jQuery('#emergency-modal'));
      }
    }else{
      //The cookie is not present. Show the modal.
      showModal(jQuery('#emergency-modal'));
    }
  }else{
    //Emergency Modal is not present. Check for other modals
    switch (getAllUrlParams().source) {
      case "busa":
        if(readCookie('busa-modal')==null){
          var content=[
            "<p>The website BusinessUSA has been discontinued. Instead, you have been redirected to the small business section of USA.gov.</p>",
            "<p>Here, you can continue your search for official government information that can help your business grow.</p>"
          ].join("\n");
          
          showModal(buildModal("busa","Welcome to USA.gov",content,"Continue"));
        }
        break;
      case "kids":
        if(readCookie('kids-modal')==null){
          var content=[
            "<p>After 16  years of serving kids, their parents, and educators, the Kids.gov website has been retired.</p>",
            "<p>But you can still find great educational resources from the government for your kids and your classroom. Visit the Education section of USA.gov.</p>"
          ].join("\n");
          
          showModal(buildModal("kids","Welcome to USA.gov",content,"Continue"));
        }
        break;
      default:
        break;
    }
  }
});

function buildModal(id, title, content, button) {
  var modal = jQuery([
    "<div id=\""+id+"-modal\" class=\"modal active\" >",
    "  <div class=\"usa-grid\">",
    "    <div>",
    "      <button class=\"close top\">",
    "        Close",
    "      </button>",
    "      <div class=\"icon\"></div>",
    "      <h2>"+title+"</h2>",
    content,
    "      <button class=\"close\">",
    button,
    "      </button>",
    "      <div class=\"logo\"></div>",
    "    </div>",
    "  </div>"
  ].join("\n"));
  jQuery("body").append(modal);
  
  return(modal);
}

function showModal(modal) {
  modal.addClass('active'); //Makes the modal visible
  jQuery('html').addClass('modal-open'); //Prevents page from scrolling behind the modal
  var closeButton = modal.find('.close');
  closeButton.first().focus(); //Set focus to top close button
  closeButton.click(function(e) {
    closeModal(modal);
  });
  closeButton.keydown(function(e) { //Prevent user from tabbing out of the modal
    var code = e.keyCode || e.which;
    if (code === 9) {
      if(e.shiftKey){
        if(jQuery(this).hasClass('top')) {
          //Shift-Tab from top close button will set focus to bottom close button
          e.preventDefault();
          jQuery('.modal .close:not(.top)').focus();
        }
      }else{
        if(!(jQuery(this).hasClass('top'))){
          //Tab from bottom close button will set focus to top close button
          e.preventDefault();
          jQuery('.modal .close.top').focus();
        }
      }
    }
  });
}

function closeModal(modal) {
  createCookie(modal.attr('id'), modal.attr('data-id') || 0, 7); //Set a cookie as a record that the user has closed this particular modal
  jQuery('html').removeClass('modal-open'); //remove the class that prevents the page from scrolling behind the modal
  modal.remove();
}

function createCookie(name,value,days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days*24*60*60*1000));
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ')
      c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0)
      return c.substring(nameEQ.length,c.length);
  }
  return null;
}

function eraseCookie(name) {
  createCookie(name,"",-1);
}

function getAllUrlParams(url) {
  var queryString = url ? url.split('?')[1] : window.location.search.slice(1); // get query string from url (optional) or window
  var obj = {};
  
  if (queryString) {
    queryString = queryString.split('#')[0]; // stuff after # is not part of query string, so get rid of it
    var arr = queryString.split('&');
    for (var i=0; i<arr.length; i++) {
      var a = arr[i].split('='); // separate the keys and the values
      
      // in case params look like: list[]=thing1&list[]=thing2
      var paramNum = undefined;
      var paramName = a[0].replace(/\[\d*\]/, function(v) {
        paramNum = v.slice(1,-1);
        return '';
      });
      
      var paramValue = typeof(a[1])==='undefined' ? true : a[1]; // set parameter value (use 'true' if empty)
      paramName = paramName.toLowerCase(); // (optional) keep case consistent
      paramValue = paramValue.toLowerCase();
      
      if (obj[paramName]) { // if parameter name already exists
        if (typeof obj[paramName] === 'string') {
          obj[paramName] = [obj[paramName]]; // convert value to array (if still string)
        }
        if (typeof paramNum === 'undefined') {
          obj[paramName].push(paramValue); // if no array index number specified, put the value on the end of the array
        } else {
          obj[paramName][paramNum] = paramValue; // else, put the value at that index number
        }
      } else {
        obj[paramName] = paramValue; // if param name doesn't exist yet, set it
      }
    }
  }
  return obj;
}

