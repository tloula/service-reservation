// Attach a submit handler to the form
jQuery( ".request-form" ).submit(function( event ) {
 
    // Stop form from submitting normally
    event.preventDefault();
   
    // Get some values from elements on the page:
    var form = jQuery( this ),
      service = form.find( "select[name='service']" ).val(),
      first = form.find( "input[name='first']" ).val(),
      last = form.find( "input[name='last']" ).val(),
      email = form.find( "input[name='email']" ).val(),
      seats = form.find( "input[name='seats']" ).val(),
      honeypot = form.find( "input[name='website']" ).val(),
      url = form.attr( "action" );

    // Check honeypot
    if (honeypot == "") {
        // Send the data using post
        var posting = jQuery.post( url, { service: service, first: first, last: last, email: email, seats: seats }, function( data ) {
            var id = "#form-message";
            jQuery(id).empty().append( data.message );
            if(data.status == 0){
                jQuery(id).attr('class', 'fusion-alert alert error alert-danger fusion-alert-center fusion-default-alert-style error fusion-alert-capitalize alert-dismissable alert-shadow');
            } else {
                jQuery(id).attr('class', 'fusion-alert alert success alert-success fusion-alert-center fusion-default-alert-style success fusion-alert-capitalize alert-dismissable alert-shadow');
            }
        }, "json");
    } else {
        id = "#form-message";
        jQuery(id).empty().append("Suspicious activity detected. Please try without an auto form filler.");
        jQuery(id).attr('class', 'fusion-alert alert error alert-danger fusion-alert-center fusion-default-alert-style error fusion-alert-capitalize alert-dismissable alert-shadow');
    }
  });

  // Get URL Parameters
  var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

if(getUrlParameter("ref") == "bulletin"){
    var id = "#ref";
    jQuery(id).empty().append("As a regular attender, please consider attending one of the first two services<br>so the Sunday 10:45 AM service is available for guests.");
    jQuery(id).attr('class', 'fusion-alert alert custom alert-custom fusion-alert-center fusion-default-alert-style notice fusion-alert-capitalize alert-dismissable alert-shadow');
    jQuery(id).attr('style', 'background-color:#fcf8e3;color:#d9b917;border-color:#d9b917;border-width:1px;');
}