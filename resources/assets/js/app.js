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




/*------------------------------------------------------------------------------
 | Form Validation
 | @param selector - the element selector(s)
 | @return error object
 |----------------------------------------------------------------------------*/
 function formValidation(selector) {
    // Hide errors that are already showing, prevents duplicates
    $('.required-error').hide();
    var errors = {};
    // Get all inputs and selects with the required field
    $( selector ).each(function(index) {
        var elementId = $(this).attr('id');
        // Validate elements
        if( $.trim( $(this).val() ) == '' && $(this).data('type') != 'password-optional' && $(this).data('type') != 'select' && $(this).data('type') != 'confirm-password-optional' ) {
            console.log('length');
            if($(this).data('error')) {
                errors[elementId] = $(this).data('error');
            } else {
                errors[elementId] = 'Required';
            }  
        } else if( $(this).data('type') == 'email' ) {
            console.log('email');
            if(! isValidEmailAddress( $(this).val() ) ) {
                errors[elementId] = 'Invalid email'
            }
        } else if( $(this).data('type') == 'select' && $(this).val() == null ) {
            if($(this).data('error')) {
                errors[elementId] = $(this).data('error');
            } else {
                errors[elementId] = 'You must select an option'
            }
        } else if($(this).data('type') == 'confirm-password-optional' && $('input[data-type="password-optional"]').val() != '' && $('input[data-type="confirm-password-optional"]').val() == '' ) {
            errors[elementId] = 'Required';
        } else if( $(this).data('type') == 'password' && $(this).val().length < 6 || $(this).data('type') == 'password-optional' && $(this).val() != '' && $(this).val().length < 6 ) {
            console.log('password');
            errors[elementId] = 'Password must be at least 6 characters';
        } else if( $(this).data('type') == 'confirm-password' || $(this).data('type') == 'confirm-password-optional' && $('input[data-type="password-optional"]').val() != '' ) {
            if( $('#password').val() != $(this).val() ) {
                errors[elementId] = 'Passwords do not match';
            }
        }
        // Remove the error class if error is corrected
        if( $.trim( $(this).val() ) != '' ) {
            $(this).removeClass('error');
        }
    });
    return errors;
}



function showFormErrors(errors) {
    // Loop through errors and display them
    $('.element-spinner').fadeOut();
    for (var key in errors) {
        $('label[for="'+key+'"]').addClass('error');
        $('input#' + key).addClass('error');
        $('select#' + key).addClass('error');
        $('input#' + key).after('<span id="' + key + '" class="required-error uk-text-meta">' + errors[key] + '</span>');
        $('select#' + key).after('<span id="' + key + '" class="required-error uk-text-meta">' + errors[key] + '</span>');
        $('textarea#' + key).after('<span id="' + key + '" class="required-error uk-text-meta">' + errors[key] + '</span>');
    }
}



function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}







function passwordStrength(selector) {
    // strength validation on keyup-event
    $(selector).on("keyup", function() {
        var val = $(this).val(),
            color = testPasswordStrength(val);

        styleStrengthLine(color, val);
    });

    // check password strength
    function testPasswordStrength(value) {
        var strongRegex = new RegExp(
            "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})"
        ),
            mediumRegex = new RegExp(
                "^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})"
            );


        if (strongRegex.test(value)) {
            $('.strength-text').html(': Strong');
            return "green";
        } else if (mediumRegex.test(value)) {
            $('.strength-text').html(': Medium');
            return "orange";
        } else {
            $('.strength-text').html(': Weak');
            return "red";
        }
    }

    function styleStrengthLine(color, value) {
        $(".line")
            .removeClass("bg-red bg-orange bg-green")
            .addClass("bg-transparent");
        
        if (value) {
            
            if (color === "red") {
                $(".line:nth-child(1)")
                    .removeClass("bg-transparent")
                    .addClass("bg-red");
            } else if (color === "orange") {
                $(".line:not(:last-of-type)")
                    .removeClass("bg-transparent")
                    .addClass("bg-orange");
            } else if (color === "green") {
                $(".line")
                    .removeClass("bg-transparent")
                    .addClass("bg-green");
            }
        }
    }


    // Show password checkbox event listener
    $('input#show_password:checkbox').change(function() {
        if ($(this).is(':checked')) {
            $('input#password').attr('type', 'text')
        } else {
            $('input#password').attr('type', 'password')
        }
    });

}






