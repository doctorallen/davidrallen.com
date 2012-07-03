<?php
/*
Template Name: Comments
*/

// Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die (MSG_COMMENTS_DONT_LOAD);

if (!empty($post->post_password)) : // if there's a password
	if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) :  // and it doesn't match the cookie
		print "<p>" . MSG_COMMENTS_POST_PASSWORD_PROTECTED . "</p>\n";
		return;
	endif;
endif;

if ($comments) :
	print "<h3>";
		comments_number(MSG_COMMENTS_NO_RESPONSES, MSG_COMMENTS_ONE_RESPONSE, MSG_COMMENTS_RESPONSES);
		the_title('&nbsp;' . MSG_TO . ' &#8220;', '&#8221;');
	print "</h3>\n";

	print "<ol>\n";
	foreach ($comments as $comment) :
		monolit_print_comment();
	endforeach;
	print "</ol>\n";
else : 
	if ('open' == $post->comment_status) : // no comments posted yet but still open
		headline(3, MSG_COMMENTS_NO_COMMENTS_POSTED);
	else : // comments are closed
		headline(3, MSG_COMMENTS_DISABLED);
	endif;
endif;


// The "leave comment" form
if ('open' == $post->comment_status) :
	headline(3, MSG_COMMENT_HEADLINE);

	if ( get_option('comment_registration') && !$user_ID ) :
		$loginurl = buildLink(get_option('siteurl').'/wp-login.php?redirect_to='.get_permalink(), MSG_COMMENT_LOGINURL);
		$mustlogin = MSG_COMMENT_MUST_LOGIN;
		$mustlogin = str_replace('%LOGINURL', $loginurl, $mustlogin);
		print "<p>$mustlogin</p>\n";
	else :
		monolit_print_comments_form();
	endif; 
endif; 
?>
