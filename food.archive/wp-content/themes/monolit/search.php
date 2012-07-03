<?php
/*
Template Name: Search Results
*/

/*
Remember to edit archive.php - it's similar except for the headline
*/

get_header();

monolit_print_container('b');

if (have_posts()) :
	headline(2, MSG_SEARCH_RESULTS);

	monolit_print_archivenavigation();

	while (have_posts()) : the_post();
		monolit_print_thumb();
	endwhile;

	monolit_print_archivenavigation();
else :
	headline(2, MSG_SEARCH_NOT_FOUND);
	include (TEMPLATEPATH . '/searchform.php');
endif;

monolit_print_container('e');

get_footer();
?>

