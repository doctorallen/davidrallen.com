<noscript>
	<div class="alert alert-error">
		<p>Javascript must be enabled to use this contact form.</p>
	</div>
</noscript>
<form id="contact-form" name="contact-form" method ="POST" class="form-horizontal" action="contact-validate.php">
	<div class="control-group">
		<label class="control-label" for="inputName">Name</label>
		<div class="controls">
			<input type="text" id="inputName" placeholder="Name" class="error">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputEmail">Email</label>
		<div class="controls">
			<input type="text" id="inputEmail" placeholder="Email" class="error">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputMessage">Message</label>
		<div class="controls">
			<textarea rows="5" id="inputMessage" placeholder="Type your message here.." class="error" ></textarea>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button disabled = "true" type="submit" id="submit" class="btn-3d btn-3d-small btn-3d-green disabled" name="submit">Submit</button>
		</div>
	</div>
</form>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript" src="js/elastic.js"></script>
<script>
$(document).ready( function (){
	$('#inputMessage').elastic();
	$('#submit').click( function(e){
		e.preventDefault();
		var dataString = 'name=' + $('#inputName').val() + '&email=' + $('#inputEmail').val() + '&message=' + $('#inputMessage').val();
		$.ajax({
			type: "POST",
			url: "contact-validate.php",
			data: dataString,
			success: function(){
				$('#contact-form').html("<div id ='message' class='message-success'></div>");
				$('#message').hide();
				$('#message').html("<h2>Contact Form Submitted Successfully!</h2><p>We will be in contact with you shortly. Thank you.</p>");
				$('#message').fadeIn(500);
			}
		});
		return false;
	});
});
</script>


