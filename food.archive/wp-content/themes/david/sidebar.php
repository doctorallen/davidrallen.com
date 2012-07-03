<div id="side">
	<p id="subscribe"><a href="<?php bloginfo('rss2_url'); ?>">Subscribe</a></p>

	<ul id="pages">
		<?php wp_list_pages('title_li='); ?>
	</ul>

	<h3>Search</h3>
	<form id="search" method="get" action-"<?php get_option('home'); ?>">
		<fieldset>
			<input type="text" class="search-bar" name="s" id="s">
			<input type="submit" value="Search" class="search-btn" >
		</fieldset>
	</form>
</div>
