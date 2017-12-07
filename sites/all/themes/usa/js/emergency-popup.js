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

function closeEmergencyPopup() {
  //User has clicked close. Hide the Modal.
  //Create a cookie so we remember that this modal has been closed.
  var modal=jQuery(".modal");
  modal.removeClass('active');
  createCookie(modal.attr('id'),0,7);
  jQuery('.modal .close').unbind("keydown");
  jQuery('html').removeClass('modal-open');
  //$( "#foo").unbind( "click" );
}

function getAllUrlParams(url) {

  // get query string from url (optional) or window
  var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

  // we'll store the parameters here
  var obj = {};

  // if query string exists
  if (queryString) {

    // stuff after # is not part of query string, so get rid of it
    queryString = queryString.split('#')[0];

    // split our query string into its component parts
    var arr = queryString.split('&');

    for (var i=0; i<arr.length; i++) {
      // separate the keys and the values
      var a = arr[i].split('=');

      // in case params look like: list[]=thing1&list[]=thing2
      var paramNum = undefined;
      var paramName = a[0].replace(/\[\d*\]/, function(v) {
        paramNum = v.slice(1,-1);
        return '';
      });

      // set parameter value (use 'true' if empty)
      var paramValue = typeof(a[1])==='undefined' ? true : a[1];

      // (optional) keep case consistent
      paramName = paramName.toLowerCase();
      paramValue = paramValue.toLowerCase();

      // if parameter name already exists
      if (obj[paramName]) {
        // convert value to array (if still string)
        if (typeof obj[paramName] === 'string') {
          obj[paramName] = [obj[paramName]];
        }
        // if no array index number specified...
        if (typeof paramNum === 'undefined') {
          // put the value on the end of the array
          obj[paramName].push(paramValue);
        }
        // if array index number specified...
        else {
          // put the value at that index number
          obj[paramName][paramNum] = paramValue;
        }
      }
      // if param name doesn't exist yet, set it
      else {
        obj[paramName] = paramValue;
      }
    }
  }

  return obj;
}


jQuery(function(){
  
  if(jQuery('#emergency').length!=0){
    //The emergency modal exists
    var cookieID = readCookie('emergency-popup');
    if(cookieID) {
      //The cookie exists
      var emergencyID=jQuery('#emergency').attr('data-id');
      if(cookieID!=emergencyID){
        //The IDs do not match. Show the modal.
        jQuery('#emergency').addClass('active');
        jQuery('#emergency .close').first().focus();
        jQuery('html').addClass('modal-open');
      }
    }else{
      //The cookie does not exist. Show the modal.
      jQuery('#emergency').addClass('active');
      jQuery('#emergency .close').first().focus();
      jQuery('html').addClass('modal-open');
    }
  }else{
    //Emergency Modal is not present. Check for other modals
    switch (getAllUrlParams().source) {
      case "busa":
        var title="Welcome to USA.gov"
        var button="Continue"
        
        var content=[
          "<p>The website BusinessUSA has been discontinued. Instead, you have been redirected to the small business section of USA.gov.</p>",
          "<p>Here, you can continue your search for official government information that can help your business grow.</p>"
        ].join("\n");
        
        showModal("busa",title,content,button);
        break;
      case "kids":
        var title="Welcome to USA.gov"
        var button="Continue"
        
        var content=[
          "<p>After 16  years of serving kids, their parents, and educators, the Kids.gov website has been retired.</p>",
          "<p>But you can still find great educational resources from the government for your kids and your classroom. Visit the Education section of USA.gov.</p>"
        ].join("\n");
        
        showModal("kids",title,content,button);
        break;
      default:
        break;
    }
    
  }
  
  
  
  
  jQuery('.modal .close').keydown(function(e) {
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
  
});


function showModal(id, title, content, button) {
  var cookieID = readCookie(id+'-modal');
  if(cookieID) {
    //The cookie exists. The modal has been shown before. Do not show now.
    
  }else{
    //The cookie does not exist. Show the modal.
    var modal = $([
      "<div id=\""+id+"-modal\" class=\"modal active\" >",
      "  <div class=\"usa-grid\">",
      "    <div>",
      "      <button class=\"close top\" onclick=\"closeEmergencyPopup()\">",
      "        Close",
      "      </button>",
      "      <div class=\"icon\"></div>",
      "      <h2>"+title+"</h2>",
      content,
      "      <button class=\"close\"  onclick=\"closeEmergencyPopup()\">",
      button,
      "      </button>",
      "      <div class=\"logo\"></div>",
      "    </div>",
      "  </div>"
    ].join("\n"));
    $("body").append(modal);
    //createCookie(id+'-modal',0,7);
  }
  modal.addClass('active');
  modal.find('.close').first().focus();
  
  
  
  var modal=jQuery('#'+id+'-modal');
  if(modal.length!=0){
    //A modal exists
    var cookieID = readCookie(id+'-modal');
    if(cookieID) {
      //The cookie exists
      var dataID=modal.attr('data-id');
      if(cookieID!=dataID){
        //The IDs do not match. Show the Modal.
        modal.addClass('active');
        jQuery('html').addClass('modal-open');
        
        modal.find('.close').first().focus();
      }
    }else{
      //The cookie does not exist. Show the Modal.
      modal.addClass('active');
      jQuery('html').addClass('modal-open');
      
      modal.find('.close').first().focus();
    }
  }
}