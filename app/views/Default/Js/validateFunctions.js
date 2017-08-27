
//Function to validate the user name and password fields
$(document).ready(function(){
	$("#login_form").validate({
		rules:{
			user_name: {
				required: true
			},
			password:{
				required: true
			} 
		},
		messages: {
			user_name: {
				required: "<center><td colspan='2'><font color='red'>A valid username is required</font></td></center>",
			},
			password: {
				required: "<center><td colspan='2'><font color='red'>A valid password is required</font></td></center>",
			}
		}
		
	});
	$("#user_name").focus();
	/*$("#password").rules( "add", {
  		required: true,
  		minlength: 6,
  		messages: {
  			required: "A valid password is required",
  			minlength: jQuery.validator.format("Please, at least {6} characters are necessary")
  		}
	});
	$("#user_name").rules("add",{
		required: true,
		messages: {
			required: "A valid username is required"
		}
	});

	$("#user_name").focus();*/


});