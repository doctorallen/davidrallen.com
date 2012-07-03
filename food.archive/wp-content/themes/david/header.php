<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equic="Content-Type" content="text/html; charset=UTF-8">
<title> <?php wp_title('&laguo;',true,'right'); ?> <?php bloginfo('name'); ?> </title>
<link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" media="screen">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/scripts.js"></script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" >

<?php wp_head(); ?>
</head>

<body>
	<div id="container">
		<div id="header">
			<h1><a href="<?php echo get_option('home'); ?>">Return to home</a></h1>
			<ul id="categories">
				<?php wp_list_categories('show_count=0$title_li=$hide_empty=0&exclude=1'); ?>
			</ul>
		</div>
		<div id="content">
