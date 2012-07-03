<?php
/*
Template Name: Header
*/

/* If the index page is called, redirect to the newest entry */
if( is_home() ) :
	$myposts = get_posts('numberposts=1&orderby=ID&order=DESC');
	foreach ($myposts as $posts):
		header("HTTP/1.0 302 Moved Temporary");
		header("Location: " . get_permalink($post->ID));
		die();
	endforeach;
endif;

session_start();
if( isset($_REQUEST['info']) && !empty($_REQUEST['info']) ) 
	$_SESSION['monolit:info'] = $_REQUEST['info'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
	<meta name="title" content="<?php wp_title(); ?>" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Comments RSS Feed" href="<?php bloginfo('comments_rss2_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
   
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>

	<?php wp_head(); ?>
</head>   

<body>
	<div class="whitebg">
		<div id="header-container" class="inside">
			<div id="header-headline"><?php bloginfo('name'); ?></div>
			<div id="header-navigation">
			<?php monolit_print_menuitems(); ?>
			</div> <!-- id="header-navigation" -->
		</div> <!-- id="header-container" -->
		<div class="cf">
