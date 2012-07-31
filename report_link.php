<?php
	$to = 'drallen1@plymouth.edu';
	$content = $_SERVER['REQUEST_URI'];
	$headers = 'FROM: davidrallen.com' . '\n';
	$send = mail($to, 'Report Link', $content, $headers);
	return $send;
	die( echo ($send));
?>
