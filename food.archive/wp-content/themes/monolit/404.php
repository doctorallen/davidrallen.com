<?php
/*
Template Name: 404 Page
*/

get_header();

monolit_print_container('b');

headline(2, MSG_404);
include (TEMPLATEPATH . '/searchform.php');

monolit_print_container('e');
get_footer();
?>
