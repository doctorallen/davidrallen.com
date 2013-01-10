<?php
	$to = 'trooper898@gmail.com';
	$content = $_POST['URI'];
	$headers = 'FROM: no-reply' . "\r\n".
		'Reply-To: trooper898@gmail.com' . "\r\n" .
	    	'X-Mailer: PHP/' . phpversion();
	mail($to, 'Report Link', $content, $headers);
?>
