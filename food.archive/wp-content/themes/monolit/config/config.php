<?php
/*
Template Name: Settings
*/

	// Wordpress page titles
	// ** IMPORTANT - CHANGE THESE **
	define('MONOLIT_SET_ABOUT_WP_TITLE', 'about');
	define('MONOLIT_SET_ARCHIVE_WP_TITLE','archives');

	// Copyright string
	// ** IMPORTANT - CHANGE THIS **
	define('MONOLIT_SET_COPYRIGHT', 'Copyright &copy; 2007 Kim N&oslash;rgaard');

	// Menu configuration (1 = yest, 0 = no)
	define('MONOLIT_SET_SHOW_LATEST', 1);
	define('MONOLIT_SET_SHOW_ARCHIVES', 0);
	define('MONOLIT_SET_SHOW_RSS', 1);
	define('MONOLIT_SET_SHOW_ABOUT', 0);

	// Display information about monolit in the about page (1 = yes, 0 = no)
	define('MONOLIT_SET_SHOW_ABOUT_CONTENT', 1);
	// Display post timestamp in the about page (1 = yes, 0 = no)
	define('MONOLIT_SET_SHOW_ABOUT_TIMESTAMP', 0);

	// Image and thumbnail size control
	define('MONOLIT_SET_MAX_HEIGHT', 600);
	define('MONOLIT_SET_THUMB_WIDTH', 120);
	define('MONOLIT_SET_THUMB_HEIGHT', 90);

	// Show EXIF values
	// ** NOTE SUPPORTED OR FINISHED YET - DON'T ENABLE ***
	define('MONOLIT_SET_SHOW_EXIF', 0);

	// Archives configuration
	define('MONOLIT_SET_THUMBS_PER_LINE', 6);
?>
