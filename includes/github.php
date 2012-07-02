<?php
//This gets the content from github
function get_content_from_github($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,1);
	$content = curl_exec($ch);
	curl_close($ch);
	return $content;
}
echo get_content_from_github('http://github.com/api/v2/json/repos/show/drallen1/');

