<?php
/*
Template Name: Archive Pages
*/

/*
Remember to edit search.php - it's similar except for the headline
*/

get_header();

monolit_print_container('b');

if (have_posts()) :
	// Hack. Set $post so that the_date() works.
	$post = $posts[0]; 

	// build and output title
	$headline = MSG_ARCHIVE_HEADLINE . " &#8216;";
		
	if (is_category()) : // If this is a category archive
		$headline .= single_cat_title(null, false);
	elseif (is_day()) : // If this is a daily archive
		$headline .= get_the_time('F jS, Y');
	elseif (is_month()) : // If this is a monthly archive
		$headline .= get_the_time('F, Y');
	elseif (is_year()) : // If this is a yearly archive
		$headline .= get_the_time('Y');
	elseif (is_author()) :  // If this is an author archive
		$headline .= MSG_AUTHOR;
	elseif (isset($_GET['paged']) && !empty($_GET['paged'])) :  // If this is a paged archive
		$headline .= "blog";
	endif;

	$headline .= "&#8217;";
	headline(2, $headline);

	monolit_print_archivenavigation();

	print "<div class=\"archives\">\n";
	$number_of_thumbs = 0;
	while (have_posts()) : the_post();
		monolit_print_thumb();
		$number_of_thumbs++;
		if ($number_of_thumbs % MONOLIT_SET_THUMBS_PER_LINE == 0) 
			print "<br />\n";
	endwhile;
	print "</div>\n";

	monolit_print_archivenavigation();
else :
	headline(2, MSG_PAGE_NOT_FOUND);
	include (TEMPLATEPATH . '/searchform.php');
endif;

monolit_print_container('e');

get_footer();
?>
