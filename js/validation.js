$(document).ready( function (){
	var form = $('#contact-form');
	var name = $('#inputName');
	var email = $('#inputEmail');
	var message = $('#inputMessage');
	var submit = $('#submit');

	name.blur(validateName, validateForm);
	email.blur(validateEmail, validateForm);
	message.blur(validateMessage, validateForm);

	name.keyup(validateName, validateForm);
	email.keyup(validateEmail, validateForm);
	message.keyup(validateMessage, validateForm);
	
	function validateForm(){
		if( validateName() & validateEmail() & validateMessage() ){
			submit.removeClass('btn-danger');
			submit.removeClass('disabled');
			submit.addClass('btn-success');
			submit.prop('disabled', false);
			return true;
		}else{
			submit.addClass('btn-danger');
			submit.addClass('disabled');
			submit.removeClass('btn-success');
			submit.prop('disabled', true);
			return false;
		}	
	}
	function validateName(){
		if( name.val().length < 4){
			name.addClass('error');
			name.removeClass('success');
			return false;
		}else{
			name.removeClass('error');
			name.addClass('success');
			return true;
		}
	}

	function validateEmail(){
		var a = email.val();
		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		if( filter.test(a) ){
			email.removeClass('error');
			email.addClass('success');
			return true;
		}else{
			email.addClass('error');
			email.removeClass('success');
			return false;
		}
	}

	function validateMessage(){
		if( message.val().length < 1 ){
			message.addClass('error');
			message.removeClass('success');
			return false;
		}else{
			message.removeClass('error');
			message.addClass('success');
			return true;
		}
	}
});
