/*------------------------------------------------------------------------------
 | Animated Success Checkmark
 |
 |----------------------------------------------------------------------------*/
function animateCheckmark() {
    $('svg.checkmark').addClass('checkmark_animate');
    $('svg.checkmark circle').addClass('checkmark_circle');
    $('svg.checkmark path').addClass('checkmark_check');
};





/*------------------------------------------------------------------------------
 | Date Picker
 |
 | @param id - the id of the target input element
 |----------------------------------------------------------------------------*/
function dateSelect(id, boolean) {
	if(boolean) {
		$( id ).datepicker({
			dateFormat: 'M dd, yy',
			showButtonPanel: true,
			changeMonth: true,
			changeYear: true,
			defaultDate: +0
		});
	} else {
		$( id ).datepicker( "destroy" );
	}
};




/*------------------------------------------------------------------------------
 | Get URL Parameters
 | @return returns the value of url parameter
 |----------------------------------------------------------------------------*/
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};


