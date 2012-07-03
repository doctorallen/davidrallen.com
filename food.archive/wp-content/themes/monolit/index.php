<?php
/*
Template Name: Index Template
*/

get_header();

if (have_posts()): 
	while (have_posts()) : the_post();
		if( $post->image ) :
			// Build navigation links, image and imagemap
			// This is mostly adapted stuff from the grain theme
			$next = get_next_post();
			$previous = get_previous_post();

			// decide navigational messages and links
			$navigation_state = 0;

			if( $previous != null ) :
				$message_prev = NAV_PREVIOUS;
				$title_prev = TITLE_PREVIOUS;
				$link_prev = get_permalink($previous->ID);
				$navlink_prev = buildLink($link_prev, $message_prev);
			else:
				$message_prev = NAV_NO_PREVIOUS;
				$title_prev = TITLE_NO_PREVIOUS;
				$link_prev = '#';
				$navlink_prev = $message_prev;
				$navigation_state = -1;
			endif;

			if( $next != null ) :
				$message_next = NAV_NEXT;
				$title_next = TITLE_NEXT;
				$link_next = get_permalink($next->ID);
				$navlink_next = buildLink($link_next, $message_next);
			else:
				$message_next = NAV_NO_NEXT;
				$title_next = TITLE_NO_NEXT;
				$link_next = '#';
				$navlink_next = $message_next;
				$navigation_state = 1;
			endif;

			$navlink_center = monolit_get_comments_link();

			// decide which dimensions the image shall have
			$dimensions = getimagesize($post->image->systemFilePath());
			$width = $dimensions[0];
			$height = $dimensions[1];

			// recude image width to 900
			if ( $width > 900 ) :
				$height = $height * 900 / $width;
				$width = 900;
			endif;

			// recude image height to configure value
			if ( $height > MONOLIT_SET_MAX_HEIGHT ) :
				$width = $width * MONOLIT_SET_MAX_HEIGHT / $height;
				$height = MONOLIT_SET_MAX_HEIGHT;
			endif;

			// calculate half the image with for use with imagemap
			$width2 = (int)($width / 2);

			// correct odd image widths
			$right_width = $width2;
			if ( 2*$width2 < $width )
				$right_width++;

			// decide which title to output
			$title_attr = '';
			if ( $navigation_state != 0 )
				$title_attr = ($navigation_state > 0) ? $title_next : $title_prev;

			// build and output photo
 			$thephoto  = '<div id="image">';
			$thephoto .= '<img class="photo" ';
			$thephoto .= 	'title="' . $title_attr . '" ';
			$thephoto .= 	'alt="' . $post->post_title . '" ';
			$thephoto .= 	'style="width: ' . $width . 'px; height: ' . $height . 'px;" ';
			$thephoto .= 	'width="' . $width . '" height="' . $height . '" ';
			$thephoto .= 	'src="' . $post->image->uri . '" ';
			$thephoto .= 	'usemap="#bloglinks" ';
			$thephoto .= '/>';
			$thephoto .= '</div>' . "\n";
			print $thephoto;

			// build and output imagemap
			$imagemap  = '<map name="bloglinks" id="bloglinks">'."\n";

			if ( $previous != null ) :
				$imagemap .= '<area shape="rect" ';
				$imagemap .= 	'coords="0,0,' . $width2 . ',' . $height . '" ';
				$imagemap .= 	'title="' . $message_prev . '" ';
				$imagemap .= 	'alt="' . $message_prev . '" ';
				$imagemap .= 	'href="' . get_permalink($previous->ID) . '" ';
				$imagemap .= '/>' . "\n";
			endif;

			if ( $next != null ) :
				$imagemap .= '<area shape="rect" ';
				$imagemap .= 	'coords="' . $width2 . ',0,' . ($right_width+$width2) . ',' . $height . '" ';
				$imagemap .= 	'title="' . $message_next . '" ';
				$imagemap .= 	'alt="' . $message_next . '" ';
				$imagemap .= 	'href="' . get_permalink($next->ID) . '" ';
				$imagemap .= '/>' . "\n";
			endif;

			$imagemap .= '</map>' . "\n";
			print $imagemap;

			// output image navigation bar
			monolit_print_imagenavigation($navlink_prev, $navlink_center, $navlink_next);
		else:
		endif;

		// output the title, author, date, and content of the post in a container
		monolit_print_container(null, monolit_get_postoutput());
		// output the comments and comment form
		monolit_print_info();
	endwhile;
else:
endif;

get_footer();
?>
