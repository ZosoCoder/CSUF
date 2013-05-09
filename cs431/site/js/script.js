//
//	Prepared by David Cochran.
//  Code can be found at: http://alittlecode.com/jquery-form-validation-with-styles-from-twitter-bootstrap/
//	Modified by Anthony Gonzalez.
//

$(document).ready(function(){

		$('#contact-form').validate({
	    rules: {
	      fullname: {
	        minlength: 2,
	        maxlength: 50,
	        required: true
	      },
	      username: {
	      	minlength: 2,
	      	maxlength: 15,
	        required: true
	      },
	      password: {
	      	minlength: 2,
	      	maxlength: 15,
	        required: true
	      },
	      confpass: {
	        minlength: 2,
	        maxlength: 15,
	        required: true,
	        equalTo: password
	      }
	    },
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });

}); // end document.ready