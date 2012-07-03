<?php
/*
Template Name: Functions
*/

// load_config ()
// loads custom settings from config file
function load_monolit_config () {
	$config_file = TEMPLATEPATH . '/config/config.php';
	require_once( $config_file );
}
add_Action('init', 'load_monolit_config');


// load_locale ()
// ADAPTED FROM GRAIN
// loads language specific strings
// this far only the default lang.php is supported
function load_locale () {
	$lang_file = TEMPLATEPATH . '/lang/lang.php';
	require_once( $lang_file );
}
add_action('init', 'load_locale');


// headline ($level, $text)
// prints a HTML headline (h1, h2, etc.)
function headline ($level, $text) {
	if ((!is_int($level)) || (empty($text)) )
		return;
	if (($level > 6) || ($level < 1))
		return;
	$headline = "<h$level>$text</h$level>\n";
	print $headline;
}


// monolit_print_about ()
// prints out information about monolit
function monolit_print_about () {
	print MONOLIT_HEADER_ABOUT_MONOLIT;
	print MONOLIT_CONTENT_ABOUT;
}


// buildLink ($url, $text)
// returns an <a href="url">text</a> structure
function buildLink ($url, $text) {
	$link = '<a href="' . $url . '">' . $text . '</a>';
	return $link;
}


// monolit_get_container ($section, $text, $content_opts, $inside_opts)
// returns container beginning (b) or end (e) with optional text and options to the two divs
function monolit_get_container ($section, $text = null, $content_opts = null, $inside_opts = null) {
	$begin  = '<div class="content" '.$content_opts.'>'."\n";
	$begin .= "\t".'<div class="inside" '.$inside_opts.'>'."\n";
	$end  = "\t".'</div> <!-- class="inside" -->'."\n";
	$end .= '</div> <!-- class="content" -->'."\n";
	if ($section == 'b') {
		return $begin.$text;
	} elseif ($section == 'e') {
		return $text.$end;
	} else {
		return $begin.$text.$end;
	}
}


// monolit_print_container ($section, $text, $content_opts, $inside_opts)
// prints container beginning (b) or end (e) with optional text and options to the two divs
function monolit_print_container ($section, $text = null, $content_opts = null, $inside_opts = null) {
	print monolit_get_container($section, $text, $content_opts, $inside_opts);
}


// monolit_get_postoutput ($about_id)
// returns formattet output with the text of a single post
// $about_id is supplied to print timestamp on about page, but only
// works if MONOLIT_SET_SHOW_ABOUT_TIMESTAMP is 1
function monolit_get_postoutput ($about_id = null) {
	global $post;
	$out  = the_title('<h2>', '</h2>', false);
	// print timestamp if no about_id is supplied or if it's supplied and configured
	if (($about_id == null) or (MONOLIT_SET_SHOW_ABOUT_TIMESTAMP == 1) and ($about_id != null)) 
		$out .= the_date(null, '<p>' . MSG_PUBLISHED . ' ', '</p>', false);
	$out .= str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content()));
	return $out;
}


// monolit_print_postoutput ($about_id)
// prints formattet output with the text of a single post
function monolit_print_postoutput ($about_id = null) {
	print monolit_get_postoutput($about_id);
}


// monolit_get_comments_link ($show_if_disabled, $wrap_content)
// returns an <a href="url">text</a> structure with a link to the comments page
// or a text if comments are disabled (feature is off when show_if_disabled=0)
function monolit_get_comments_link ($show_if_disabled = 1, $wrap_content = null) {
	global $post;
	if( $post->comment_status == "open" ):
		$comments_show = str_replace( "%", $post->comment_count, MSG_COMMENTS_SHOW );
		$comments_hide = str_replace( "%", $post->comment_count, MSG_COMMENTS_HIDE );
		$text = (isset($_SESSION['monolit:info']) && $_SESSION['monolit:info'] == 'on') ? $comments_hide : $comments_show;
		$infomode = (isset($_SESSION['monolit:info']) && $_SESSION['monolit:info'] == 'on') ? 'off' : 'on#info';
		$permalink = strstr(get_permalink($post->ID), '?') !== FALSE ? get_permalink($post->ID).'&info='.$infomode : get_permalink($post->ID).'?info='.$infomode;
		$comments_link = buildLink($permalink, $text);
	else:
		if ($show_if_disabled == 0)
			return null;
        	$comments_link = NAV_COMMENTS_DISABLED;
	endif;

	if ($wrap_content == 'wrap') {
		return monolit_get_container(null, $comments_link);
	} else {
		return $comments_link;
	}
}


// monolit_print_info ()
// prints comments and comments form
function monolit_print_info () {
	global $post, $id, $comments, $comment;
	if ( (isset($_SESSION['monolit:info']) && ($_SESSION['monolit:info'] == 'on')) ) {
		if ( MONOLIT_SET_SHOW_EXIF == 1 ):
			// EXIF-info
			monolit_print_container('b',null, 'style="z-index: 9;"');
			if ($exif = yapb_get_exif()):
				headline(3, MSG_EXIF_HEADLINE);
				foreach ($exif as $key => $value):
					print "$key => $value<br />\n";
				endforeach;
			else:
				headline(3, MSG_EXIF_NO_DATA);
			endif;
			monolit_print_container('e');
		endif;

		// comments
		monolit_print_container('b',null, 'style="z-index: 10;"');
		print '<a name="info" style="text-decoration: none; background-color: none; color: black;"></a>' . "\n";
		$comments = get_approved_comments($id);
		include (TEMPLATEPATH . '/comments.php');
		monolit_print_container('e');
	}
}


// monolit_print_imagenavagation ($left, $center, $right)
// prints navigation section for images
function monolit_print_imagenavigation ($left, $center, $right) {
	$out  = '<div id="image-navigate-container" class="inside">' . "\n";
	$out .= "\t" . '<div class="image-navigate-left">' . $left . '</div>' . "\n";
	$out .= "\t" . '<div class="image-navigate-center">' . $center . '</div>' . "\n";
	$out .= "\t" . '<div class="image-navigate-right">' . $right . '</div>' . "\n";
	$out .= '</div> <!-- id="image-navigate-container" class="inside" -->' . "\n";
	print $out;
}


// monolit_print_archivenavigation ()
// prints 'previous entries' and 'next entries' type navigation links
// used in archive.php and search.php
function monolit_print_archivenavigation () {
	$out  = '<div class="archive-navigate-container">' . "\n";
        $out .= "\t" . '<div class="image-navigate-left">';
	print $out;

	next_posts_link('&laquo; '.MSG_ARCHIVES_PREV_ENTRIES);
	$out  = '</div>' . "\n";
	$out .= "\t" . '<div class="image-navigate-right">';
	print $out;

	previous_posts_link(MSG_ARCHIVES_NEXT_ENTRIES.' &raquo;');
	$out  = '</div>' . "\n";
	$out .= '</div> <!-- class="archive-navigate-container" -->' . "\n";
	print $out;
}


// monolit_print_thumb ()
// prints a thumbnail
// used inside a have_posts() loop
function monolit_print_thumb () {
	global $post;
	print '<div class="archive-post">' . "\n";
	if (!is_null($image = YapbImage::getInstanceFromDb($post->ID))) :
		print '<div class="archive-photo">' . "\n";
		if ($post->image):
			$thethumbnail  = '<a href="' . apply_filters('the_permalink', get_permalink()) . '">';
			$thethumbnail .= '<img width="'. MONOLIT_SET_THUMB_WIDTH .'" height="'. MONOLIT_SET_THUMB_HEIGHT .'" class="archive-thumb" ';
			$thethumbnail .= 'src="' . $post->image->getThumbnailHref(array('w='. MONOLIT_SET_THUMB_WIDTH .'&amp;h='. MONOLIT_SET_THUMB_HEIGHT .'&amp;zc=1','')) . '" ';
			$thethumbnail .= 'alt="' . the_title(null, null, false) . '" ';
			$thethumbmail .= 'title="' . MSG_CLICK_TO_VIEW . '" ';
			$thethumbnail .= '/></a>' . "\n";
			print $thethumbnail;
		endif;
		print '</div> <!-- class="archive-photo" -->' . "\n";
	endif; 
	print '</div> <!-- class="archive-post" -->' . "\n";
}


// monolit_print_comment ()
// prints a single comment
// used inside a comments loop
function monolit_print_comment () {
	$out  = '<li id="comment-' . get_comment_ID() . '">' . "\n";
	$out .= '<cite>' . MSG_COMMENT_FROM . ': ' . get_comment_author_link() . "</cite>\n";
	if ($comment->comment_approved == '0') 
		$out .= "<em>" . MSG_COMMENT_NOT_MODERATED . "</em>\n";
	$out .= "<br />\n";
	print $out;
	print "<small>";
		$timestamp .= '<a href="#comment-';
		$timestamp .= get_comment_ID();
		$timestamp .= '" title="">';
		$timestamp .= get_comment_date('F jS, Y');
		$timestamp .= '&nbsp;' . MSG_AT . '&nbsp;';
		$timestamp .= get_comment_time();
		$timestamp .= '</a>';
		print $timestamp;
		edit_comment_link(MSG_COMMENT_EDIT,'&nbsp;&nbsp;','');
	print "</small>\n";
	comment_text();
	print "</li>\n";
}


// monolit_print_comments_form ()
// prints the comments form
function monolit_print_comments_form () {
	global $post, $comment, $user_ID, $user_identity;
	$commenter = wp_get_current_commenter();
	extract($commenter);
	print '<form action="'. get_option('siteurl') . '/wp-comments-post.php" method="post" id="commentform">' . "\n";

	if ( $user_ID ) :
		$out  = '<p>' . MSG_COMMENT_LOGGED_IN_AS . '&nbsp;';
		$out .= '<a href="' . get_option('siteurl') . '/wp-admin/profile.php">' . $user_identity . '</a>&nbsp;';
		$out .= '<a href="' . get_option('siteurl') . '/wp-login.php?action=logout" ';
		$out .= 'title="' . MSG_COMMENT_LOGOUT_TITLE . '"> (' . MSG_COMMENT_LOGOUT . ')</a>';
		$out .= "</p>\n";
	else :
		$out  = '<p><input type="text" name="author" id="author" value="' . $comment_author . '" size="22" tabindex="1" />' . "\n";
		$out .= '<label for="author"><small>' . MSG_COMMENT_NAME;
		if ($req) $out .= '('.MSG_REQUIRED.')';
		$out .= "</small></label></p>\n";

		$out .= '<p><input type="text" name="email" id="email" value="' . $comment_author_email . '" size="22" tabindex="2" />' . "\n";
		$out .= '<label for="email"><small>' . MSG_COMMENT_EMAIL;
		if ($req) $out .= '('.MSG_REQUIRED.')';
		$out .= "</small></label></p>\n";

		$out .= '<p><input type="text" name="url" id="url" value="' . $comment_author_url . '" size="22" tabindex="3" />' . "\n";
		$out .= '<label for="url"><small>' . MSG_COMMENT_WEBSITE . "</small></label></p>\n";
	endif;

	$out .= '<p>' . MSG_COMMENT_TAGS . ':<br /><code>' . allowed_tags() . "</code></p>\n";
	$out .= '<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>' . "\n";

	$out .= "<p>\n";
	$out .= '<input name="submit" type="submit" id="submit" tabindex="5" value="' . MSG_COMMENT_SUBMIT . '" />' . "\n";
	$out .= '<input type="hidden" name="comment_post_ID" value="' . $post->ID . '" />' . "\n";
	$out .= '<input type="hidden" name="redirect_to" value="' . wp_specialchars($_SERVER["REQUEST_URI"]) . '" />' ."\n";
	$out .= "</p>\n";
	print $out;
	do_action('comment_form', $post->ID);
	print "</form>\n";
}


// monolit_get_menuitems ()
// returns a string of links to the menu
function monolit_get_menuitems () {
	$menuitems = array();

	// Generate links for the menu
	if (MONOLIT_SET_SHOW_LATEST == 1) :
		$latest_photo_url = get_bloginfo('url');
		$latest_photo_link = buildLink($latest_photo_url, MSG_MENUITEM_LATEST);
		array_push($menuitems, $latest_photo_link);
	endif;

	if (MONOLIT_SET_SHOW_ARCHIVES == 1) :
		$archive_id = get_page_by_title(MONOLIT_SET_ARCHIVE_WP_TITLE,null);
		$archive_url = get_permalink($archive_id);
		$archive_link = buildLink($archive_url, MSG_MENUITEM_ARCHIVE);
		array_push($menuitems, $archive_link);
	endif;

	if (MONOLIT_SET_SHOW_RSS == 1) :
		$rss_url = get_bloginfo('rss2_url');
		$rss_link = buildLink($rss_url, MSG_MENUITEM_RSS);
		array_push($menuitems, $rss_link);
	endif;

	if (MONOLIT_SET_SHOW_ABOUT == 1) :
		$about_id = get_page_by_title(MONOLIT_SET_ABOUT_WP_TITLE,null);
		$about_url = get_permalink($about_id);
		$about_link = buildLink($about_url, MSG_MENUITEM_ABOUT);
		array_push($menuitems, $about_link);
	endif;

	return implode($menuitems, ' &nbsp; | &nbsp; ');
}


// monolit_print_menuitems ()
// prints a string of links to the menu
function monolit_print_menuitems () {
	print monolit_get_menuitems();
}

?>
