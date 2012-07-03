<?php
/*
Template Name: Archives
*/

get_header();

monolit_print_container('b', null, 'class="bullet"');

headline(2, MSG_ARCHIVES_HEADLINE);

headline(3, MSG_ARCHIVES_BY_YEAR);

print "<ul>\n"; wp_get_archives('type=yearly'); print "</ul>\n";

headline(3, MSG_ARCHIVES_BY_MONTH);
print "<ul>\n"; wp_get_archives('type=monthly'); print "</ul>\n";

headline(3, MSG_ARCHIVES_BY_CATEGORIES);
print "<ul>\n"; wp_list_categories('title_li='); print "</ul>\n";

headline(3, MSG_PAGES_HEADLINE);
print "<ul>\n"; wp_list_pages('title_li='); print "</ul>\n";

include (TEMPLATEPATH . '/searchform.php');

monolit_print_container('e');

get_footer();
?>
