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
  //User has clicked close. Hide the popup.
  //Create a cookie so we remember that this popup has been closed.
  jQuery('#emergency').removeClass('active');
  var emergencyID=jQuery('#emergency').attr('data-id');
  createCookie('emergency-popup',emergencyID,7);
}

jQuery(function(){
  if(jQuery('#emergency').length!=0){
    //The emergency popup exists
    var cookieID = readCookie('emergency-popup');
    if(cookieID) {
      //The cookie exists
      var emergencyID=jQuery('#emergency').attr('data-id');
      if(cookieID!=emergencyID){
        //The IDs do not match. Show the Popup.
        jQuery('#emergency').addClass('active');
        jQuery('#emergency .close').first().focus();
      }
    }else{
      //The cookie does not exist. Show the popup.
      jQuery('#emergency').addClass('active');
      jQuery('#emergency .close').first().focus();
    }
  }
  
  jQuery('#emergency .close').keydown(function(e) {
    var code = e.keyCode || e.which;
    
    if (code === 9) {
      if(e.shiftKey){
        if(jQuery(this).hasClass('top')) {
          //Shift-Tab from top close button will set focus to bottom close button
          e.preventDefault();
          jQuery('#emergency .close:not(.top)').focus();
        }
      }else{
        if(!(jQuery(this).hasClass('top'))){
          //Tab from bottom close button will set focus to top close button
          e.preventDefault();
          jQuery('#emergency .close.top').focus();
        }
      }
    }
  });
  
});