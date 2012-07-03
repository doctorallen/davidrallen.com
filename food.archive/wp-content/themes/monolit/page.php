<?php
/*
Template Name: Pages Template
*/

get_header();

if (have_posts()):
	while (have_posts()) : the_post();
		monolit_print_container('b');

		// get about page information, if it exists
		$aboutpage = get_page_by_title(MONOLIT_SET_ABOUT_WP_TITLE);
		$about_id = $aboutpage->ID;

		// output the title, author, date, and content of the post
		// the about_id is used for special about page configuration
		monolit_print_postoutput($about_id);

		// if this is the about page print out information about monolit if configured
		if ($about_id == $post->ID) 
			if (MONOLIT_SET_SHOW_ABOUT_CONTENT == 1)
				monolit_print_about();

		wp_link_pages('before=<p>'.MSG_PAGES.':&after=</p>&nextpagelink='.MSG_NEXT_PAGE.'&previouspagelink='.MSG_PREV_PAGE);

		monolit_print_container('e');

		// 0 = return null if comments are disabled, else wrap link in content box
		$comments_link = monolit_get_comments_link(0,'wrap');
		print "<strong>$comments_link</strong>";
		monolit_print_info();
	endwhile;
else:
endif;

get_footer();
?>
